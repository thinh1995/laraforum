<?php

namespace App\Notifications;

use App\Http\Resources\ReplyResource;
use App\Model\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail', 'slack'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'replyBy' => $this->reply->user->name,
            'question' => $this->reply->question->title,
            'path' => $this->reply->question->path,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return (new BroadcastMessage([
            'replyBy' => $this->reply->user->name,
            'question' => $this->reply->question->title,
            'path' => $this->reply->question->path,
            'reply' => new ReplyResource($this->reply)
        ]))->onConnection('redis')->onQueue('broadcastQueue');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url($this->reply->question->path);

        return (new MailMessage)
            ->greeting('Hello!')
            ->line('Someone replied on your questions')
            ->action('View', $url)
            ->line('Thank you for using our application!');
    }

    public function toSlack($notifiable)
    {
        $message = "Someone replied on your question";
        
        return (new SlackMessage)
                ->from('Lucifer', ':ghost:')
                ->to('#general')
                ->content('Fix service request by '.$message);
    }
}
