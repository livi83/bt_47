<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['author', 'categories'])->latest()->get();

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'content' => 'required|string',
            'image_path' => 'nullable|string|max:255',
            'author_id' => 'required|exists:users,id',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'image_path' => $validated['image_path'] ?? null,
            'author_id' => $validated['author_id'],
            'is_published' => $validated['is_published'] ?? false,
            'published_at' => $validated['published_at'] ?? null,
        ]);

        if (!empty($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        return response()->json(
            $post->load(['author', 'categories']),
            201
        );
    }

    public function show(Post $post)
    {
        return response()->json(
            $post->load(['author', 'categories'])
        );
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('posts', 'slug')->ignore($post->id),
            ],
            'content' => 'sometimes|required|string',
            'image_path' => 'nullable|string|max:255',
            'author_id' => 'sometimes|required|exists:users,id',
            'is_published' => 'sometimes|required|boolean',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $post->update([
            'title' => $validated['title'] ?? $post->title,
            'slug' => $validated['slug'] ?? $post->slug,
            'content' => $validated['content'] ?? $post->content,
            'image_path' => array_key_exists('image_path', $validated) ? $validated['image_path'] : $post->image_path,
            'author_id' => $validated['author_id'] ?? $post->author_id,
            'is_published' => $validated['is_published'] ?? $post->is_published,
            'published_at' => array_key_exists('published_at', $validated) ? $validated['published_at'] : $post->published_at,
        ]);

        if (array_key_exists('categories', $validated)) {
            $post->categories()->sync($validated['categories'] ?? []);
        }

        return response()->json(
            $post->load(['author', 'categories'])
        );
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully.'
        ]);
    }
}