<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimelineController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard'); // ou outro lugar
    }

    return view('welcome');
});


Route::get('/welcome', function () {
    return view('welcome'); // ou qualquer view que você queira exibir
})->name('welcome');

Route::get('/lang/{lang}', function ($lang) {
    if (in_array($lang, ['pt-br', 'en'])) {
        session(['locale' => $lang]);
        App::setLocale($lang);
    }
    return redirect()->back();
})->name('change.lang');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [TimelineController::class, 'dashboard'])->name('dashboard');
    Route::get('/notifications', function () {
        $user = auth()->user();
    
        // Marcar todas como lidas ao entrar na página
        $user->unreadNotifications->markAsRead();
    
        return view('notifications', [
            'notifications' => $user->notifications, // Agora todas, lidas e não lidas
        ]);
    })->middleware('auth')->name('notifications');
    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/my-profile', [ProfileController::class, 'view'])->name('profile.my_profile');
    Route::get('/profile/{id}', [ProfileController::class, 'author_profile'])->name('profile.author_profile');

    Route::patch('/profile/update-cover', [ProfileController::class, 'update_back'])->name('profile.update_back');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/dashboard', [TimelineController::class, 'new_post_submit'])->name('new_post_submit');
    Route::delete('/delete_post_submit/{id}', [TimelineController::class, 'delete_post_submit'])->name('delete_post_submit');
    
    Route::post('/likes/toggle', [LikeController::class, 'toggle'])->middleware('auth')->name('likes.toggle');

    Route::get('/comments/{postId}', [CommentsController::class, 'comments'])->name('comments');
    Route::post('/comments', [CommentsController::class, 'new_comment_submit'])->name('new_comment_submit');
    Route::delete('/delete_comment_submit/{id}', [CommentsController::class, 'delete_comment_submit'])->name('delete_comment_submit');

    Route::post('/follow/{id}', [FollowController::class, 'toggle'])->name('follow.toggle');
    Route::get('/following', [TimelineController::class, 'following'])->name('following')->middleware('auth');
});

require __DIR__.'/auth.php';
