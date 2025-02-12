<?php

namespace App\Http\Controllers;

use App\Models\Provinces;
use App\Http\Requests\StoreProvincesRequest;
use App\Http\Requests\UpdateProvincesRequest;

class ProvincesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Provinces::all();
        return response()->json($provinces);
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
    public function store(StoreProvincesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Provinces $provinces)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provinces $provinces)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProvincesRequest $request, Provinces $provinces)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provinces $provinces)
    {
        //
    }
}
