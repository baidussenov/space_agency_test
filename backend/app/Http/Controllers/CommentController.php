<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        try {
            // validating request body
            $validatedData = $request->validate([
                'post_id' => 'required|exists:post,id',
                'username' => 'required|string|max:255',
                'content' => 'required|string'
            ]);

            Comment::create($validatedData);

            return response()->json(['success' => true], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->validator->error()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Ошибка из CommentController::create: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Произошла ошибка при добавлении комментариев.'
            ], 500);
        }
    }

    public function getByPost($postId)
    {
        try {
            $comments = Comment::where('post_id', $postId)->get();

            return response()->json([
                'success' => true,
                'comments' => $comments
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->validator->error()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Ошибка из CommentController::getByPost: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Произошла ошибка при поиске комментариев.'
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();

            return response()->json(['success' => true]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->validator->error()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Ошибка из CommentController::delete: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Произошла ошибка при удалении комментария.'
            ], 500);
        }
    }
}
