<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageGalleryResource;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\ImageGallery;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->get();
        return response()->json( BlogResource::collection($blogs));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function images()
    {
       $images = ImageGallery::all();
       return response()->json(ImageGalleryResource::collection($images));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {

        return response()->json(BlogResource::make($blog));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
