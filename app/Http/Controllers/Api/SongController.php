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

    public function searchSong(Request $request)
    {
        $query = $request->get('query');
        $results = Song::where('title', 'like', "%$query%")
            ->limit(10)
            ->get();
        return response()->json([
            "results" => $results
        ]);
    }

    public function save(Request $request)
    {
        return response()->json($request->all());
    }
}
