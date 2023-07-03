<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Series;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Links', [
            'links' => Link::all(),
            'series' => Series::all(),
        ]);
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
    public function store(Request $request): RedirectResponse
    {
        // @var array $linkFileNames
        $linkFileNames = $request->input('linkFileNames'); // holds paths to be updated in an array [ id => path]

        // @var array $deletedLinks
        $deletedLinks = $request->input('deletedLinks'); // holds ids to be deleted in an array

        $seriesId = $request->input('seriesId');

        foreach ($linkFileNames as $id => $fileName) {
            $link = Link::find($id);
            $link->file_name = $fileName;
            $link->save();
        }

        foreach ($deletedLinks as $link) {
            Link::destroy($link);
        }

        return to_route('series.show', $seriesId);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
