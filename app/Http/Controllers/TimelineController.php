<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use App\Models\User;
use App\Notifications\UserFollowNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimelineController extends Controller
{
    public function dashboard() {
        $posts = PostModel::with("user")
        ->orderBy("created_at", "desc")
        ->get();

        $data = [
            "posts" => $posts
        ];

        return view("dashboard", $data); 
    }

    public function following()
    {
        $user = auth()->user();

        $title = __('texts.seguindo');  // Ou qualquer outra tradução ou título que você queira

        // Busca posts dos usuários que o usuário está seguindo
        $posts = PostModel::whereIn('user_id', $user->following()->pluck('user_id'))->latest()->paginate(10);

        return view('dashboard', compact('posts', "title"));
    }

    public function new_post_submit(Request $request) 
    {
        $request->validate([
            'input_title' => 'required|string|max:60',
            'input_text' => 'nullable|string|max:1000',
            'input_media' => 'nullable|file|mimes:jpg,jpeg,jfif,png,gif,mp4,webm,mov,avi|max:10240',
            'input_doc' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:10240', // 5MB
        ]);

        $model = new PostModel();
        $model->user_id = auth()->user()->id;
        $model->title = $request->input("input_title");
        $model->description = $request->input("input_text");
    
        // Imagem ou vídeo
        if ($request->hasFile('input_media')) {
            $file = $request->file('input_media');
            $extension = strtolower($file->getClientOriginalExtension());
    
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif'])) {
                $path = $file->store('posts/images', 'public');
                $model->img_path = $path;
                $model->video_path = null;
            } elseif (in_array($extension, ['mp4', 'webm', 'mov', 'avi'])) {
                $path = $file->store('posts/videos', 'public');
                $model->video_path = $path;
                $model->img_path = null;
            }
        } else {
            $model->img_path = null;
            $model->video_path = null;
        }
    
        // Documento
        if ($request->hasFile('input_doc')) {
            $file = $request->file('input_doc');
            $path = $file->store('posts/docs', 'public');
            $model->doc_path = $path;
        } else {
            $model->doc_path = null;
        }
    
        $model->save();
    
        return redirect()->route("dashboard");
    }
    

    public function delete_with_image_post() {
        $model = new PostModel();
        $image_path = public_path($model->img_path);

        if(file_exists($image_path)) {
            unlink($image_path);
        }

        $model->delete();
    }

    public function delete_post_submit($id) {
    $post = PostModel::find($id);

    if ($post) {
        // Se houver imagem, apaga do disco
        if ($post->img_path && Storage::disk('public')->exists($post->img_path)) {
            Storage::disk('public')->delete($post->img_path);
        }
        // Se houver imagem, apaga do disco
        if ($post->video_path && Storage::disk('public')->exists($post->video_path)) {
            Storage::disk('public')->delete($post->video_path);
        }
        // Se houver imagem, apaga do disco
        if ($post->doc_path && Storage::disk('public')->exists($post->doc_path)) {
            Storage::disk('public')->delete($post->doc_path);
        }

        // Apaga o post do banco
        $post->delete();
    }

        return redirect()->route("dashboard");
    }

    public function toggleLike(Request $request)
    {
        $user = $request->user();
        $type = $request->input('type');
        $id = $request->input('id');
    
        $modelClass = "App\\Models\\" . ucfirst($type);
        $model = $modelClass::findOrFail($id);
    
        $like = $model->likes()->where('user_id', $user->id)->first();
    
        if ($like) {
            $like->delete();
            return response()->json(['message' => "$type descurtido!", 'liked' => false]);
        } else {
            $model->likes()->create(['user_id' => $user->id]);
            return response()->json(['message' => "$type curtido!", 'liked' => true]);
        }
    }
    
    
}
