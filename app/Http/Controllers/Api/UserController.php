<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController
{
    public function index()
    {
        $users = User::withCount('posts')->latest()->get();

        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'nullable|string|in:admin,editor,author',
        ]);

        $user = User::create(array_merge(
            $validated,
            ['role' => $validated['role'] ?? 'author']
        ));

        return (new UserResource($user->loadCount('posts')))
            ->response()
            ->setStatusCode(201);
    }

    public function show(User $user)
    {
        return new UserResource(
            $user->loadCount('posts')
        );
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:6',
            'role' => 'sometimes|required|in:admin,editor,author',
        ]);

        $data = $validated;

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return new UserResource(
            $user->fresh()->loadCount('posts')
        );
    }

    public function destroy(User $user)
    {
        $user->delete();
        // 204
        return response()->noContent();
    }
}