<?php

namespace App\Http\Controllers\Api;

use App\Song;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SongController extends Controller
{

    public function getSong(Song $record)
    {
        return response()->json($record);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function searchSong(Request $request)
    {
        $this->validate($request, [
            "query" => "required"
        ]);

        $results = Song::where('title', 'like', "%{$request->get('query')}%")
            ->limit(5)
            ->get();

        return response()->json([
            "results" => $results
        ]);
    }

    public function store(Request $request)
    {
        $song = Song::create($request->all());
        return response()->json($song);
    }

    public function update(Request $request, Song $song)
    {
        $song->update($request->all());
        return response()->json($song);
    }
}
