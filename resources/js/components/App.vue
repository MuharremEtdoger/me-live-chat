<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><i class="bi bi-chat-dots icon-color"></i>Sohbet Detayı
            <a href="/home" 
               class="btn btn-link float-end logout-link"
              >
              Geri Dön
            </a>          
          </div>
          <div class="card-body">
            <div id="messages" ref="messagesContainer" class="send-message-list messagesContainer">
              <div v-for="message in messages" :key="message.id" class="card" :class="{ 'sent-message': message.sender_id === userId, 'received-message': message.sender_id !== userId }">
                <div class="card-body">
                  <strong>{{ message.sender.name ? message.sender.name : 'Bilinmeyen Gönderen' }}:</strong> {{ message.message }}
                </div>
              </div>
            </div> 
            <form @submit.prevent="sendMessage">
              <div class="form-group invisible">
                <label for="receiver_id">Alıcı</label>
                <input
                  type="hidden"
                  v-model="receiverId"
                  class="form-control"
                  value="{{sendMessageUserID}}"
                  placeholder="Alıcının kullanıcı ID'sini girin"
                />
              </div>
              <div class="form-group">
                <hr></hr>
                <textarea
                  v-model="newMessage"
                  class="form-control opacity-70"
                  rows="4"
                ></textarea>
              </div>
              <button type="submit" class="btn btn-primary mt-2 me-dark-button w-100 p-2" :disabled="isSending">{{ isSending ? 'Gönderiliyor...' : 'Gönder' }}</button>
            </form>                       
          </div>                
        </div>
      </div>
    </div>
  </div>
</template>      
<script>
import axios from 'axios';

export default {
  data() {
    return {
      messages: [],
      newMessage: '',
      receiverId: window.Laravel.sendMessageUserID,
      userId: window.Laravel.userId, // Laravel'den gelen oturum açmış kullanıcı ID'sini alıyoruz
      isSending: false,
    };
  },
  mounted() {
    this.fetchMessages();
    this.listenForMessages();
  },
  methods: {
    async fetchMessages() {
      try {
        const response = await axios.get(`/api/messages/${window.Laravel.sendMessageUserID}`);
        this.messages = response.data;
        this.$nextTick(() => this.scrollToBottom());
      } catch (error) {
        console.error('Mesajları alırken bir hata oluştu:', error);
      }
    },
    listenForMessages() {
      // Laravel Echo ile chat kanalına abone olun
      Echo.channel(`chat.${this.userId}`)
        .listen('MessageSent', (event) => {
          this.messages.push(event.message); // Yeni gelen mesajı messages dizisine ekle
          this.$nextTick(() => this.scrollToBottom());
        });
    },
    async sendMessage() {
      this.isSending = true;
      try {
        const response = await axios.post('/messages/send', {
          receiver_id: this.receiverId,
          message: this.newMessage,
        });
        this.newMessage = '';
        
        await this.fetchMessages(); // async olduğu için await ile beklenmeli
      } catch (error) {
        console.error('Mesaj gönderirken bir hata oluştu:', error);
      } finally {
        this.isSending = false;
        this.$nextTick(() => this.scrollToBottom());
      }
    },
    scrollToBottom() {
      this.$nextTick(() => {
        const container = this.$refs.messagesContainer;
        if (container) {
          container.scrollTop = container.scrollHeight;
        }
      });
    },    
  },
};
</script>

<style scoped>
/* Stil dosyalarınızı buraya ekleyebilirsiniz */
</style>
