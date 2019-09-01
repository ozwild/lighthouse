<?php

namespace App\Http\Controllers;

use App\Song;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $records = Song::all();

        return view('models.records.index', compact('records', 'loadedRecord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('models.records.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $record = new Song();
        $record->fill($request->all());
        $record->save();
        return redirect()->route('records.edit', $record->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Song $record
     * @return Response
     */
    public function show(Song $record)
    {
        $available_records = Song::all();
        return view('models.records.show', compact('record', 'available_records'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Song $record
     * @return Response
     */
    public function edit(Song $record)
    {
        return view('models.records.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Song $record
     * @return Response
     */
    public function update(Request $request, Song $record)
    {
        $record->update($request->all());

        if ($request->wantsJson()) {
            return response()->json();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Song $record
     * @return Response
     */
    public function destroy(Song $record)
    {
        //
    }

    /**
     * @param Song $record
     * @return Factory|View
     */
    public function getSync(Song $record)
    {
        return view('models.records.lyrics-sync', compact('record'));
    }

}
