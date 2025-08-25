<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $payload;

    public function __construct(Message $message)
    {
        // preload relations to send minimal clean payload
        $message->load('sender:id,full_name,username');

        $this->payload = [
            'id'          => $message->id,
            'message'     => $message->message,
            'sender'      => $message->sender,
            'receiver_id' => $message->receiver_id,
            'created_at'  => $message->created_at->toDateTimeString(),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        // Deliver to the receiver's private inbox channel
        return new PrivateChannel('chat.' . $this->payload['receiver_id']);
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }

    public function broadcastWith()
    {
        return $this->payload;
    }
}
