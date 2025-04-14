<template>
  <div>
    <div v-for="message in messages" :key="message.id">
      <p>{{ message.user.name }}: {{ message.message }}</p>
    </div>
    <input v-model="newMessage" @keyup.enter="sendMessage">
  </div>
</template>

<script>
export default {
  data() {
    return {
      messages: [],
      newMessage: '',
    };
  },
  mounted() {
    Echo.channel('chat-room.' + this.roomId)
      .listen('MessageSent', (event) => {
        this.messages.push(event.message);
      });
  },
  methods: {
    sendMessage() {
      axios.post('/api/messages', { message: this.newMessage, room_id: this.roomId })
        .then(response => {
          this.newMessage = '';
        });
    }
  }
};
</script>
