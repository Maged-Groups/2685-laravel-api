<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::withCount('posts')->get();
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
    public function store(StoreUserRequest $request)
    {

        $user = User::create($request->all());

        $id = $user->id;

        $photo = $request->file('photo')->store('profile_photos');

        $nid_f = $request->file('nid_front')->storeAs('nid_faces', "$id.jpg", 'local');
        $nid_b = $request->file('nid_back')->storeAs('nid_backs', "$id.jpg", 'local');
        $military_report = $request->file('military_report')->storeAs('military_reports', "$id.jpg", 'local');
        $criminal_record = $request->file('criminal_record')->storeAs('criminal_record', "$id.pdf", 'local');
        $certificate = $request->file('certificate')->storeAs('certificate', "$id.jpg", 'local');

        $user_files = [
            'user_id' => $id,
            'nid_f' => $nid_f,
            'nid_b' => $nid_b,
            'military_report' => $military_report,
            'criminal_record' => $criminal_record,
            'certificate' => $certificate,
        ];

        Upload::create($user_files);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // return $user;
        // return $user->mobile;
        return User::where('id', '=', $user->id)->with('replies')->first();
        // return count($user->posts);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
