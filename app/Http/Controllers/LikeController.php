<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use App\Notifications\CommentLikedNotification;
use App\Notifications\UserFollowNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'likeable_type' => 'required|string',
            'likeable_id' => 'required|integer',
        ]);

        $allowedTypes = [
            'post' => \App\Models\PostModel::class,
            'comment' => \App\Models\Comment::class,
        ];

        $type = $request->likeable_type;

        if (!array_key_exists($type, $allowedTypes)) {
            return response()->json(['error' => 'Tipo inválido'], 400);
        }

        $modelClass = $allowedTypes[$type];
        $model = $modelClass::findOrFail($request->likeable_id);

        $user = auth()->user();

        $like = $model->likes()->where('user_id', $user->id)->first();
        $author = $model->user;

        if ($like) {
            $like->delete();
            return response()->json([
                'liked' => false,
                'likes_count' => $model->likes()->count()
            ]);
        } else {
            // Caso contrário, cria um novo like com o tipo "post"
            $model->likes()->create([
                'user_id' => $user->id,
                'likeable_type' => $type,  // Agora vai armazenar 'post' como string
                'likeable_id' => $model->id,
                
            ]);
            
            if ($author && $author->id !== $user->id) {
                if ($type === 'post') {
                    $author->notify(new UserFollowNotification($user, $model));
                } elseif ($type === 'comment') {
                    $author->notify(new CommentLikedNotification($user, $model));
                }
            }

            //dd($user);
            return response()->json([
                'liked' => true,
                'likes_count' => $model->likes()->count()
            ]);
        }
    }

}

