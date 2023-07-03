<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Series;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return to_route('series.show', Series::orderBy('id')->first());
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Series', [
            'links' => Series::find($id)->links()->get(),
            'seriesId' => $id,
            'series' => fn () => Series::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
