<?php

namespace App\Events;

use App\Http\Resources\ReplyResource;
use App\Model\Reply;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewReplyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $path;
    public $user;
    public $reply;
    public $notification;
    
    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'broadcastQueue';
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($path, User $user, Reply $reply)
    {
        $this->path = $path;
        $this->user = $user;
        $this->reply = new ReplyResource($reply);
        $this->notification = $reply;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('newReplyChannel');
    }
}
