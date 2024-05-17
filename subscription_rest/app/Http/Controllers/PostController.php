<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $validateData = $request->validate([
            'website_id' => 'int|required|exists:websites,id',
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $post = Post::create($validateData);

            DB::commit();

            return $this->success($post, 'Post created successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('PostController | create | error : ', [$e->getMessage()]);
            
            return $this->failed($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'title' => 'sometimes|max:255',
            'content' => 'sometimes'
        ]);

        try {
            DB::beginTransaction();

            $post = Post::findOrFail($id);
            $post->update($validateData);

            DB::commit();

            return $this->success($post, 'Post updated successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('PostController | update | error : ', [$e->getMessage()]);
            
            return $this->failed('Post updated failed');
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $post = Post::findOrFail($id);
            $post->delete();

            DB::commit();

            return $this->success(null, 'Post deleted successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('PostController | delete | error : ', [$e->getMessage()]);
            
            return $this->failed('Post deleted failed');
        }
    }
}
