<?php

namespace App\Listeners;

use App\Events\NewReplyEvent;
use App\Notifications\NewReplyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewReplyEventListener implements ShouldQueue
{
     /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'redis';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'broadcastQueue';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 5;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewReplyEvent  $event
     * @return void
     */
    public function handle(NewReplyEvent $event)
    {
        if ($event->user->id !== $event->notification->user_id) {
            $event->user->notify(new NewReplyNotification($event->notification));
        }
    }
}
