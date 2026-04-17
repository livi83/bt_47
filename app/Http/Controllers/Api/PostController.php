<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;
class PostController
{
    public function index()
    {
        // Pridané stránkovanie, v API je lepšie ako .get()
        $posts = Post::with(['author', 'categories'])->latest()->paginate(15);

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'required|string|max:255|unique:posts,slug',
            'content'      => 'required|string',
            'image_path'   => 'nullable|string|max:255',
            'is_published' => 'boolean', // stačí boolean
            'published_at' => 'nullable|date',
            'categories'   => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $validated['author_id'] = $request->user()->id;
        
        $post = DB::transaction(function () use ($validated) {
            $post = Post::create($validated);

            if (!empty($validated['categories'])) {
                $post->categories()->sync($validated['categories']);
            }

            return $post;
        });

        return response()->json($post->load(['author', 'categories']), 201);
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
            'title'        => 'sometimes|required|string|max:255',
            'slug'         => [
                'sometimes', 'required', 'string', 'max:255',
                Rule::unique('posts', 'slug')->ignore($post->id),
            ],
            'content'      => 'sometimes|required|string',
            'image_path'   => 'nullable|string|max:255',
            'is_published' => 'sometimes|required|boolean',
            'published_at' => 'nullable|date',
            'categories'   => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $validated['author_id'] = $request->user()->id;
        
        DB::transaction(function () use ($validated, $post, $request) {
            $post->update($validated);

            if ($request->has('categories')) {
                $post->categories()->sync($request->input('categories', []));
            }
        });

        return response()->json($post->load(['author', 'categories']));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully.'], 204); // 204 No Content je tiež častá voľba
    }
}