<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\PostModel;
use App\Models\User;
use App\Notifications\UserFollowNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function view(Request $request): View
    {
        // Pegando o usuário logado
        $user = $request->user();

        // Filtrando os posts para mostrar apenas os do usuário logado
        $posts = PostModel::with("user")
        ->where('user_id', $user->id)
        ->orderBy("created_at", "desc")
        ->get();

        return view('profile.my_profile', [
            'user' => $request->user(),
            "posts" => $posts
        ]);
    }

    public function author_profile($id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Filtrando os posts para mostrar apenas os do usuário logado
        $posts = PostModel::with("user")
        ->where('user_id', $user->id)
        ->orderBy("created_at", "desc")
        ->get();

        return view('profile.author_profile', [
            'user' => $user,
            "posts" => $posts
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {        
        $request->user()->fill($request->validated());
        

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->hasFile('profile_photo')) {
            if ($request->user()->profile_photo && Storage::disk("public")->exists($request->user()->profile_photo)) {
                Storage::disk("public")->delete($request->user()->profile_photo);
            }

            $file = $request->file('profile_photo');
            $path = $file->store('user', 'public');
            $request->user()->profile_photo = $path; // salva só o caminho relativo (ex: posts/arquivo.jpg)
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function update_back(Request $request)
    {
        $user = auth()->user();

        // Validação para garantir que o arquivo seja uma imagem
        $request->validate([
            'cover_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        // Se uma nova foto de capa for enviada
        if ($request->hasFile('cover_photo')) {
            // Se o usuário já tem uma foto de capa, apaga o arquivo anterior
            if ($user->cover_photo) {
                Storage::delete('public/' . $user->cover_photo);
            }

            $path = $request->file('cover_photo')->store('profile_covers', 'public');
            
            $user->cover_photo = $path;
            $request->user()->save();
            
            return response()->json([
                'success' => true,
                'new_cover_url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['success' => false]);
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
