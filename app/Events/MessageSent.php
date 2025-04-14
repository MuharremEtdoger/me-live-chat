<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Mesaj gönderildiğinde event'i tetikleyen constructor
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Event'in hangi kanala yayınlanacağını belirtir.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\PresenceChannel
     */
    public function broadcastOn()
    {
        return new Channel('chat.' . $this->message->receiver_id); // Receiver'a özel kanal
    }

    /**
     * Event verilerini nasıl yayınlayacağımızı belirler.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $user = User::find($this->message->sender_id);

        return [
            'message'=>[
                'id' => $this->message->id,
                'sender' => [
                    'ID'=>$this->message->sender,
                    'name'=>$user->name,
                ], 
                'receiver_id' => $this->message->receiver_id,
                'message' => $this->message->message,
                'created_at' => $this->message->created_at,
            ]
        ];
    }
}
