<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Mail\NotifyCommentMail;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();

        // $userid = auth()->user()->id;

        /** @var App\Models\User $user  */
        $user = Auth::user();

        $data['user_id'] = $user->id;



        // Send Email to post owner


        $comment = Comment::create($data);

        if ($comment) {

            $post = Post::with('user')->where('id', $request->post_id)->first();

            $owner_email = $post->user->email;

            Mail::to($owner_email)->send(new NotifyCommentMail($post, $user->name, $request->comment));


            return $this->json_response(['comment' => CommentResource::make($comment)], 'Your comment posted successfully');
        }

        return $this->json_error();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
