<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rennokki\Larafy\Larafy;

class SpotifyAPIController extends Controller
{
    public $query;
    public $limit = 10;
    public $offset = 0;
    private $service;

    public function __construct(Larafy $service)
    {
        $this->service = $service;
    }

    private function extractDataFromRequest(Request $request)
    {
        $this->query = $request->get('q');
        $this->offset = $request->get('offset', $this->offset);
        $this->limit = $request->get('limit', $this->limit);

        if (empty($this->query)) {
            abort(400, "reasons");
        }

    }

    private function wrapSearchResult($response)
    {
        return response()->json([
            'results' => $response,
            'offset' => $this->offset
        ]);
    }

    function searchSong(Request $request)
    {
        try {
            $this->extractDataFromRequest($request);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "A [query] is expected and required",
            ], 400);
        }
        $response = $this->service->searchTracks($this->query);
        return $this->wrapSearchResult($response);
    }

    function searchArtist(Request $request)
    {
        try {
            $this->extractDataFromRequest($request);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "A [query] is expected and required",
            ], 400);
        }
        $response = $this->service->searchArtists($this->query, $this->limit, $this->offset);
        return $this->wrapSearchResult($response);
    }

    function searchAlbum(Request $request)
    {
        try {
            $this->extractDataFromRequest($request);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "A [query] is expected and required",
            ], 400);
        }
        $response = $this->service->searchAlbums($this->query, $this->limit, $this->offset);
        return $this->wrapSearchResult($response);
    }

}
