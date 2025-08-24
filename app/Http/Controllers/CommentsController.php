<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\PostModel;
use Illuminate\Support\Facades\Storage;

class CommentsController extends Controller
{
    function comments($postId) {
        $post = PostModel::with(['comments' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'comments.user'])->findOrFail($postId);

        $data = [
            "post" => $post
        ];

        return view("comments", $data);
    }

    public function new_comment_submit(Request $request) 
    {
        $post = PostModel::findOrFail($request->input('post_id'));

        $request->validate([
            'input_text_comment' => 'required|string|max:1000',
            'input_media' => 'nullable|file|mimes:jpg,jpeg,png,jfif,gif,mp4,webm,mov,avi|max:10240',
            'input_doc' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:5120',
            'post_id' => 'required|exists:posts,id'
        ]);
        $comment = new Comment();
        $comment->body = $request->input('input_text_comment');
        
        // Imagem ou vídeo
        if ($request->hasFile('input_media')) {
            $file = $request->file('input_media');
            $extension = strtolower($file->getClientOriginalExtension());
    
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif'])) {
                $path = $file->store('comments/images', 'public');
                $comment->img_path = $path;
                $comment->video_path = null;
            } elseif (in_array($extension, ['mp4', 'webm', 'mov', 'avi'])) {
                $path = $file->store('comments/videos', 'public');
                $comment->video_path = $path;
                $comment->img_path = null;
            }
        } else {
            $comment->img_path = null;
            $comment->video_path = null;
        }
    
        // Documento
        if ($request->hasFile('input_doc')) {
            $file = $request->file('input_doc');
            $path = $file->store('posts/docs', 'public');
            $comment->doc_path = $path;
        } else {
            $comment->doc_path = null;
        }
        $comment->post_id = $post->id;    
        $comment->user_id = auth()->id();
        
        $comment->save();
    
        return redirect()->route("comments", ['postId' => $comment->post_id]);
    }

    public function delete_with_image_comment() {
        $model = new Comment();
        $image_path = public_path($model->img_path);

        if(file_exists($image_path)) {
            unlink($image_path);
        }

        $model->delete();
    }

    public function delete_comment_submit($id) {
        $comment = Comment::find($id);
    
        if ($comment) {
            $postId = $comment->post_id;
    
            if ($comment->img_path && Storage::disk('public')->exists($comment->img_path)) {
                Storage::disk('public')->delete($comment->img_path);
            }
            if ($comment->video_path && Storage::disk('public')->exists($comment->video_path)) {
                Storage::disk('public')->delete($comment->video_path);
            }
            if ($comment->doc_path && Storage::disk('public')->exists($comment->doc_path)) {
                Storage::disk('public')->delete($comment->doc_path);
            }
            $comment->likes()->delete();
    
            $comment->delete();

    
            return redirect()->route("comments", ['postId' => $postId]);
        }
    
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
