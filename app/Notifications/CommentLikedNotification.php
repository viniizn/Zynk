<?php

// app/Notifications/CommentLikedNotification.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommentLikedNotification extends Notification
{
    use Queueable;

    public $user;
    public $comment;

    public function __construct($user, $comment)
    {
        $this->user = $user;
        $this->comment = $comment;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            "user_id" => $this->user->id,
            "name" => $this->user->name,
            "comment_id" => $this->comment->id,
            "comment_excerpt" => substr($this->comment->body, 0, 30),
            "post_id" => $this->comment->post_id, // <-- adicione isso
        ];
    }
    
}
