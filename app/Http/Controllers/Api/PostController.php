<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PostController
{
    public function index()
    {
        $posts = Post::with(['author', 'categories'])
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(15);

        return PostResource::collection($posts);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'content' => 'required|string',
            'image_path' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
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

        return (new PostResource($post->load(['author', 'categories'])))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Post $post)
    {
        $isPublic = $post->is_published &&
                    $post->published_at &&
                    $post->published_at <= now();

        if (!$isPublic) {
            abort(404);
        }

        return new PostResource($post->load(['author', 'categories']));
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

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
            'is_published' => 'sometimes|required|boolean',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        DB::transaction(function () use ($validated, $post, $request) {
            $post->update($validated);

            if ($request->has('categories')) {
                $post->categories()->sync($request->input('categories', []));
            }
        });

        return new PostResource($post->load(['author', 'categories']));
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return response()->noContent();
    }

    public function myPosts(Request $request)
    {
        $user = $request->user();
        $query = Post::with(['author', 'categories']);

        if ($user->role === 'author') {
            $query->where('author_id', $user->id);
        }

        return PostResource::collection(
            $query->latest()->paginate(15)
        );
    }

    public function showMyPost(Post $post)
    {
        Gate::authorize('view', $post);

        return new PostResource($post->load(['author', 'categories']));
    }
}