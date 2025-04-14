<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><i class="bi bi-chat icon-color"></i>{{ blockTitle }}
            <a :href="logoutLink" 
               class="btn btn-link float-end logout-link"
               @click.prevent="logout">
              Çıkış Yap
            </a>          
          </div>
          <div class="card-body">
            <p><i class="bi bi-globe2 icon-color"></i>Merhaba {{ userName }}, {{ statusMessage }}</p>
            <div id="messages">
                <div v-for="message in messagesUsers" :key="message.sender.id" class="card card-pad-zero">
                    <div class="card-body">
<strong v-html="message.sender_id === userId 
  ? '<i class=\'bi bi-box-arrow-in-right icon-color\'></i> ' + message.receiver.name 
  : '<i class=\'bi bi-box-arrow-in-left icon-color\'></i> ' + message.sender.name">
</strong>
                      <p class="message-content">{{ message.message.substring(0, 30) }}</p>
                        <a :href="`/messages/${getOtherUserID(message)}`" class="btn btn-sm btn-outline-primary float-end me-dark-button">
                            Sohbeti Görüntüle
                        </a>
                    </div>
                </div>
            </div>
            <hr></hr>
            <p><i class="bi bi-people icon-color"></i>Üye Listesi</p>
            <div id="messages-users">
                <div v-for="messageusers in userLists" :key="messageusers.id" class="card card-pad-zero">
                    <div class="card-body">
                        <strong><i class="bi bi-caret-right-fill icon-color"></i>{{ messageusers.name }}</strong> 
                        <a :href="`/messages/${messageusers.id}`" class="btn btn-sm btn-outline-primary float-end me-dark-button">
                            Sohbet Et
                        </a>
                    </div>
                </div>
            </div>            
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'Home',  
  data() {
    return {
      messagesUsers: [], 
      userLists: [],  
      statusMessage: window.Laravel.statusMessage, // Laravel'den gelen veriyi burada kullanıyoruz
      blockTitle: window.Laravel.blocktitle,   
      logoutLink:  window.Laravel.logoutLink,
      userId:  window.Laravel.userId,
      userName:  window.Laravel.userName,  
    };
  },
mounted() {
  this.fetchMessageUsers();
  this.fetchUsersLists();

  Echo.channel(`chat.${this.userId}`)
    .listen('MessageSent', (event) => {
      this.fetchMessageUsers(); // Listeyi güncelle
    });
},  
  methods: {    
    async fetchMessageUsers() {
      try {
        const response = await axios.get(`/api/message-lists`); // Laravel API'den mesajları alıyoruz
        this.messagesUsers = response.data;
      } catch (error) {
        console.error('Mesajları alırken bir hata oluştu:', error);
      }
    }, 
    async fetchUsersLists() {
      try {
        const response = await axios.get(`/api/users`); // Laravel API'den mesajları alıyoruz
        this.userLists = response.data.data;
      } catch (error) {
        console.error('Mesajları alırken bir hata oluştu:', error);
      }
    },     
    getOtherUserID(message) {
        return message.sender_id === this.userId
        ? message.receiver.id
        : message.sender.id;
    }       
  }
};
</script>

<style scoped>
/* İhtiyacınıza göre stil ekleyebilirsiniz */
</style>
