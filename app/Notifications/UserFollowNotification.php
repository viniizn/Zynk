<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserFollowNotification extends Notification
{
    use Queueable;

    public $user;
    public $posts;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $posts)
    {
        $this->user = $user;
        $this->posts = $posts;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            "user_id" => $this->user->id,
            "name" => $this->user->name,
            "email" => $this->user->email,
            "post_id" => $this->posts->id,
            "name_post" => $this->posts->user->name, // O nome do autor do post
            "post_user_id" => $this->posts->user->id,
            "post_title" => $this->posts->title,
        ];
    }

}
