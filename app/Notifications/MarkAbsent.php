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
    public function __construct(public $modelId,public $title,public $body)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'model_id'=>$this->modelId,
            'title'=>$this->title,
            'body'=>$this->body,
        ];
    }
}
