<?php

namespace App\Http\Controllers;

use App\Models\ReactionType;
use App\Http\Requests\StoreReactionTypeRequest;
use App\Http\Requests\UpdateReactionTypeRequest;
use App\Http\Resources\ReactionTypeResource;

class ReactionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reactionTypes = ReactionType::all();

        return ReactionTypeResource::collection($reactionTypes);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReactionTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ReactionType $reactionType)
    {
        return $reactionType;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReactionTypeRequest $request, ReactionType $reactionType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReactionType $reactionType)
    {
        //
    }
}
