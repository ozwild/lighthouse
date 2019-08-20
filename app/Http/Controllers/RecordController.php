<?php

namespace App\Http\Controllers;

use App\Record;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $records = Record::all();

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
        $record = new Record();
        $record->fill($request->all());
        $record->save();
        return redirect()->route('records.show', $record->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Record $record
     * @return Response
     */
    public function show(Record $record)
    {
        $available_records = Record::all();
        return view('models.records.show', compact('record', 'available_records'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Record $record
     * @return Response
     */
    public function edit(Record $record)
    {
        return view('models.records.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Record $record
     * @return Response
     */
    public function update(Request $request, Record $record)
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
     * @param Record $record
     * @return Response
     */
    public function destroy(Record $record)
    {
        //
    }

    /**
     * @param Record $record
     * @return Factory|View
     */
    public function getSync(Record $record)
    {
        return view('models.records.lyrics-sync', compact('record'));
    }

}
