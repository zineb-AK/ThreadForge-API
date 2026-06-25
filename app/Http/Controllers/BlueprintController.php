<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlueprintResource;
use App\Models\Blueprint;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBlueprintRequest;

class BlueprintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blueprints=Blueprint::where('user_id', auth()->id())->get();
        return BlueprintResource::collection($blueprints);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlueprintRequest $request)
    {
        $blueprint=Blueprint::create(
            [
                ...$request->validated(),
                'user_id' => auth()->id()
            ]
        );
        return response() ->json([
            'message' => 'Blueprint created successfully',
            'data' => new BlueprintResource($blueprint)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blueprint $blueprint)
    {
        return new BlueprintResource($blueprint);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blueprint $blueprint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blueprint $blueprint)
    {
        $blueprint->update($request->validated());
        return new BlueprintResource($blueprint);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blueprint $blueprint)
    {
        //
    }
}
