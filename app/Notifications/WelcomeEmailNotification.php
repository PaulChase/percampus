<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
            ->subject('Welcome to Percampus.com')
            ->greeting('Hey there,')
            ->from('percampus@gmail.com', 'Percampus')
            ->line('Welcome to Percampus.com ')
            ->line('The is a welcome message from Paul, the founder. If you are ready to start selling? your profile is fully set up for you to get sarted.')
            ->line("But first, check the next email from us for you to verify your email and enjoy the full benefits of our webite. Don't worry, it just takes a second to do the verification ")
            ->action('View your profile', url('/dashboard'))
            ->line('We have  created exclusive groups and channels for our members to connect and get help, below are the links;')
            ->line('whatsapp group - https://chat.whatsapp.com/IMgxpeH4gYj6tgKFCod6ts')
            ->line('Faceboook group - https://facebook.com/groups/671905473756091/')
            ->line('twitter profile - https://twitter.com/percampus_com')
            ->line("Thank you for joining us, we can't wait to see what you have to post.");
            
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
