<?php

namespace App\Http\Controllers;

use App\SystemRecording;
use Illuminate\Http\Request;

class SystemRecordingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recordings = SystemRecording::all();
        return view('system_recordings.index', compact('recordings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system_recordings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|unique:system_recordings,name',
            'file' => 'file|mimes:wav',
        ]);

        $path = $request->file->storeAs('custom', $request->name . ".wav", 'system_recording');
        $recording = SystemRecording::create([
            'name' => $request->name,
            'path' => $path
        ]);

        return redirect()->action('SystemRecordingController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SystemRecording  $systemRecording
     * @return \Illuminate\Http\Response
     */
    public function show(SystemRecording $systemRecording)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SystemRecording  $systemRecording
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemRecording $systemRecording)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SystemRecording  $systemRecording
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemRecording $systemRecording)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SystemRecording  $systemRecording
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemRecording $systemRecording)
    {
        //
    }
}
