<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class PostController
{
    /**
     * Display a listing of the resource.
     */
    private array $posts = [
        [
            'id' => 1,
            'title' => 'Laravel API zaklady',
            'content' => 'Toto je ukazkovy clanok o Laravel API.',
            'category_id' => 2,
            'author_id' => 1,
        ],
        [
            'id' => 2,
            'title' => 'Co je MVC',
            'content' => 'MVC je architektonicky vzor.',
            'category_id' => 2,
            'author_id' => 2,
        ],
    ];

    public function index()
    {
        return response()->json($this->posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Post bol vytvoreny',
            'received_data' => $request->all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        foreach ($this->posts as $post) {
            if ($post['id'] == $id) {
                return response()->json($post);
            }
        }

        return response()->json([
            'message' => 'Post nebol najdeny'
        ], 404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json([
            'message' => "Post s ID $id bol aktualizovany",
            'updated_data' => $request->all(),
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json([
            'message' => "Post s ID $id bol zmazany"
        ]);

    }
}
