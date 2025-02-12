<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use App\Http\Requests\StoreTechnicianRequest;
use App\Http\Requests\UpdateTechnicianRequest;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTechnicianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Technician $technician)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTechnicianRequest $request, Technician $technician)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician)
    {
        //
    }
}
