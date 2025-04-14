import Echo from 'laravel-echo';
import Pusher from 'pusher-js'; // Doğru import şekli

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY, // process.env yerine import.meta.env kullanın
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // process.env yerine import.meta.env kullanın
    encrypted: true
});