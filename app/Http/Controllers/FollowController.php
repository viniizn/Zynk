<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewFollowNotification;
use App\Notifications\UserFollowNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function toggle($id) {
        $targetUser = User::findOrFail($id);
        $authUser = Auth::user();

        if ($authUser->id == $id) {
            return back()->with('warning', 'Você não pode seguir a si mesmo.');
        }

        if ($authUser->isFollowing($targetUser)) {
            $authUser->unfollow($targetUser);
        } else {
            $authUser->follow($targetUser);

            if ($authUser) 
            {
                $targetUser->notify(new NewFollowNotification($authUser));
            } 
        }

        return back();
    }
}
