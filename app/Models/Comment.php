<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Like;

class Comment extends Model
{
    use HasFactory;

    // Modelo Comment.php
    public function post()
    {
        return $this->belongsTo(PostModel::class); // Um comentário pertence a um post
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
        return "comment";
    }

}
