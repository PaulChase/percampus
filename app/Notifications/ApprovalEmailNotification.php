<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public $post = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post)
    {

        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Congrats, your post have been accepted'")
            ->greeting(" hello {$this->post->user->name},")
            ->line("This is Paul, I want to inform you that the post you made on our website about '{$this->post->title}' has being accepted.")
            ->line('You can click the link below to view it and share with your friends.')
            ->action('view post', url("/{$this->post->user->campus->nick_name}/{$this->post->subcategory->slug}/{$this->post->slug}"))
            ->line('Thank you for using our service');
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
            //
        ];
    }
}
