<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MarkAbsent extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $userId;
    private $title;
    private $body;

    public function __construct($userId, $title, $body)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
    }

    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'model_id' => $this->userId,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }
}
