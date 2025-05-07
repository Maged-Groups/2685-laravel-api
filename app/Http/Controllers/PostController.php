<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $posts = Cache::remember('all_posts', 60 * 120, function () {
            return Post::with(['user', 'post_status'])->limit(10)->get();
        });


        // $posts = DB::table('posts')->join('users', 'users.id', 'posts.user_id')->get();

        // return $posts;

        $post_data = PostResource::collection($posts);

        return $this->json_response(['post_data' => $post_data]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $data = $request->validated();

        $user_id = auth()->user()->id;

        $data['user_id'] = $user_id;

        // Save the photo to the default driver(storage)
        $filePath = $request->file('photo')->store('posts');
        // $filePath = Storage::put('new_ids', $request->file('photo'), 'public');


        // Save the photo to the another driver(storage)
        // $filePath = $request->file('photo')->storeAS('ids', "$user_id.jpg", 'local');


        if ($filePath)
            $data['photo'] = $filePath;


        $new_post = Post::create($data);

        // Clear cache
        if ($new_post)
            Cache::forget('all_posts');


        return PostResource::make($new_post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        $post = PostResource::make($post);

        return $this->json_response(compact('post'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $updated = $post->update($request->validated());

        if ($updated) {
            Cache::forget('all_posts');
            return PostResource::make($post);
        }

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


        if ($post->delete()) {
            Cache::forget('all_posts');
            return $this->json_response(status: 202);
        }

        return $this->json_response(status: 401, message: 'Unable to delete the post');
    }
}
