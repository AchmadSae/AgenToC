<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ResetPasswordCustom extends Notification
{
    use Queueable;



      /**
     * Create a new notification instance.
     */
      public function __construct(
            public string $token,
            public ?string $email = null
      ) {}


      /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
          // generate url reset password manual
          $url = URL::route('password.reset', [
                'token' => $this->token,
                'email' => $this->email ?? $notifiable->getEmailForPasswordReset(),
          ]);

          return (new MailMessage)
                ->subject('Reset Password')
                ->view('emails.reset-password', [
                      'url' => $url,
                      'notifiable' => $notifiable
                ]);
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
