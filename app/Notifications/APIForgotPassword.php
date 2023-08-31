<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class APIForgotPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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

        // $url = url('/reset/password/'.$this->user->password_reset_token);

        // return (new MailMessage)
        //     ->subject('Reset Password Notification. - '.config('app.name'))
        //     ->greeting('Hello '.$notifiable->first_name)
        //     ->line('You are receiving this email because we received a password reset request for your account.')
        //     ->line('Please click on bellow link to reset password')
        //     // ->line('OTP : '.$notifiable->password_reset_token)
        //     // ->markdown('vendor.mail.forgotpassword.index', ['password_reset_token' => $notifiable->password_reset_token,'firstname' => $notifiable->first_name])
        //     // ->greeting('Hello, '.$this->user->first_name)
        //     ->action('Reset Password', $url)
        //     ->line('Thank you for using our application!');

        $url = url('/reset/password/'.$this->user->password_reset_token);

        return (new MailMessage)
            ->subject('Reset Password Notification. - '.config('app.name'))
            ->view('emails.forgotPassword', ['url' => $url,'notifiable'=>$notifiable]);
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
