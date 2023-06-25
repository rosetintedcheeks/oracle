<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkRoot;
use App\Models\Series;
use BitTorrent\Decoder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class TorrentController extends Controller
{

    public function getFileName(string $path): array {
        $decoder = new Decoder;
        $file = Storage::get($path);
        $dict = $decoder->decodeDictionary($file);
        $file_names = [];
        if($dict['info']['files']) {
            foreach($dict['info']['files'] as $file) {
                $file_names[] = implode('/', $file['path']);
            }
        } else {
            $file_names = [$dict['info']['name']];
        }
        return $file_names;
    }

    public function uploadAction(Request $request): Response {
        $path = $request->file('torrentFile')[0]->store('torrents');
        // link root id
        $linkRoot = $request->input('linkRoot');
        // series id or 'new'
        $seriesId = $request->input('series');
        // new name
        $seriesName = $request->input('seriesName');
        // get a list of file names from the torrent file
        $file_names = $this->getFileName($path);

        $links = [];
        foreach($file_names as $name) {
            $link = new Link;
            $link->path = $name;
            // get the name of the file
            $file = explode('/', $name);
            $link->file_name = end($file);
            $series = Series::findOr($seriesId, function() use ($seriesName, $linkRoot) {
                $s = new Series;
                $s->name = $seriesName;
                $s->path = preg_replace('/[^[:alnum:] -]/', '', $seriesName);
                $s->root()->associate(LinkRoot::find($linkRoot));
                $s->save();
                return $s;
            });
            $seriesId = $series->id;
            $link->series()->associate($series);
            $link->save();
            $links[$link->id] = $link;
        }
        $request->session()->put('links', $links);
        // go to choose page
        return Inertia::render('TorrentChooseFiles', [
            'links' => $links
        ]);
    }

    public function chooseAction(Request $request): RedirectResponse {
        $choices = $request->input('choices');
        $links = $request->session()->pull('links');
        foreach($links as $link) {
            if(!array_search($link->id, $choices)) {
                $link->delete();
            }
        }

        return to_route('torrents.index');
    }
}
