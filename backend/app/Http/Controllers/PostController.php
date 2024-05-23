<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function get($id)
    {
        try {
            $post = Post::with('user')->findOrFail($id);

            // incrementing views count
            $post->increment('views');

            $comments = Comment::where('post_id', $id)->get();
            $post->comments = $comments;

            return response()->json([
                'success' => true,
                'post' => $post
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->validator->error()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Ошибка из PostController::get: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Произошла ошибка при поиске поста.'
            ], 500);
        }
    }
    public function getAll(Request $request)
    {
        $query = Post::latest()->select(
            'title',
            'id',
            'description',
            'thumbnail',
            'created_at',
            'views',
            'likes'
        );

        if ($request->has('category_id') && $request->category_id != 0) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->get();

        $categories = Category::latest()->select(
            'id',
            'title'
        )->get();

        return response()->json([
            'success' => true,
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    public function create(Request $request)
    {
        try {
            // validating request body
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'content' => 'required|string',
                'author' => 'required|string|max:255'
            ]);

            // handling thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnailname = time() . '.' . $request->file('thumbnail')->getClientOriginalExtension();
                $request->file('thumbnail')->move('postimages', $thumbnailname);
                $validatedData['thumbnail'] = $thumbnailname;
            }

            Post::create($validatedData);

            return response()->json(['success' => true], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->validator->error()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Ошибка из PostController::create: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Произошла ошибка при добавлении поста.'
            ], 500);
        }
    }

    public function like($id)
    {
        try {
            $post = Post::findOrFail($id);

            // incrementing likes count
            $post->increment('likes');

            return response()->json([
                'success' => true,
                'likes' => $post->likes
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->validator->error()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Ошибка из PostController::like: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Произошла ошибка при лайке поста.'
            ], 500);
        }
    }

    public function unlike($id)
    {
        try {
            $post = Post::findOrFail($id);

            // decrementing likes count
            $post->decrement('likes');

            return response()->json([
                'success' => true,
                'likes' => $post->likes
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->validator->error()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Ошибка из PostController::like: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Произошла ошибка при лайке поста.'
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();

            return response()->json(['success' => true]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->validator->error()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Ошибка из PostController::delete: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Произошла ошибка при удалении поста.'
            ], 500);
        }
    }
}
