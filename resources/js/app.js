import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue'; // Ana Vue component'iniz (oluşturmanız gerekecek)
import Home from './components/Home.vue'; // Ana Vue component'iniz (oluşturmanız gerekecek)

const currentUrl = window.location.pathname;

if (currentUrl === '/home') {
    const app = createApp(Home);
    app.mount('#app-home');
}else{
    const app = createApp(App);
    app.mount('#app-message');
    // Laravel Echo yapılandırması (aşağıdaki kodunuz kalabilir)
    Echo.channel('chat.' + window.Laravel.userId)
        .listen('.message.sent', (event) => {
            // Yeni gelen mesajı sayfada eklemek için işlemleri yapın
            let messageHtml = `
                <div class="card">
                    <div class="card-body">
                        <strong>${event.message.sender.name}:</strong> ${event.message.message}
                    </div>
                </div>
            `;
            document.getElementById('messages').innerHTML += messageHtml;
        });
}

