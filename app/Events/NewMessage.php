<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $username;
    public $message;
    public $created_at;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id,$username,$message,$created_at)
    {
        $this->id = $id;
        $this->username = $username;
        $this->message = $message;
        $this->created_at = $created_at;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('messages');
    }

    public function broadcastWith(){
        return [
            "id"=>$this->id,
            "username"=>$this->username,
            "message"=>$this->message,
            "created_at"=>$this->created_at,
        ];
    }
}
