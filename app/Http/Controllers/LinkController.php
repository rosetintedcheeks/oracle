<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response {
        return Inertia::render('Links', [
            'links' => Link::all()
        ]);
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
    public function store(Request $request): RedirectResponse {
        /* @var array $linkPaths */
        $linkPaths = $request->input('linkPaths'); // holds paths to be updated in an array [ id => path]

        /* @var array $deletedLinks */
        $deletedLinks = $request->input('deletedLinks'); // holds ids to be deleted in an array

        foreach($linkPaths as $id => $path) {
            $link = Link::find($id);
            $link->path = $path;
            $link->save();
        }

        foreach ($deletedLinks as $link) {
            Link::destroy($link);
        }
        return to_route('links.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
