<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Like;
use Illuminate\Notifications\Notifiable;

class PostModel extends Model
{
    use HasFactory, Notifiable;

    protected $table = "posts";

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'img_path',
        'video_path',
        'doc_path',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, "post_id");
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->morphMany(Like::class, "likeable");
    }

    public function isLikedBy(User $user) {
        return $this->likes()->where("user_id", $user->id)->exists();
    }

    public function getMorphClass()
    {
        return "post";
    }
}