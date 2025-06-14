<?php

declare(strict_types=1);

namespace Tinoecom\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class AdminSendCredentials extends Notification
{
    public function __construct(public string $password) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Welcome to Tinoecom'))
            ->greeting("Hello {$notifiable->full_name}")
            ->line(__('An account has been created for you as Administrator on the website ') . config('app.url'))
            ->line("Email: {$notifiable->email} - Password: {$this->password}")
            ->line(__('You can use the following link to login:'))
            ->action('Login', route('tinoecom.login'))
            ->line(__('After logging in you need to change your password by clicking on your name in the upper right corner of the admin area'));
    }
}
