<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomVerifyEmail extends VerifyEmail
{
    use Queueable;
    protected mixed $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($userData = [])
    {
        $this->user = $userData;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
          $verifyUrl = $this->verificationUrl($notifiable);
          return (new MailMessage)
                ->subject('Verify Your Email Address')
                ->view('emails.verify-email', [
                      'user' => $this->user, 'verifyUrl' => $verifyUrl]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
