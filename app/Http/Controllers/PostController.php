<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Response;


class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        $post_data = PostResource::collection($posts);

        return $this->json_response(['post_data' => $post_data]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $data = $request->validated();

        $data['user_id'] = 1;

        $new_post = Post::create($data);

        return PostResource::make($new_post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        $post =  PostResource::make($post);

        return $this->json_response(compact('post'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $updated = $post->update($request->validated());

        if ($updated)
            return PostResource::make($post);

        return response()->json(status: 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $post = Post::find($id);

        if (!$post)
            return $this->json_not_found();


        if ($post->delete())
            return $this->json_response(status: 202);


        return $this->json_response(status: 401, message: 'Unable to delete the post');
    }
}
