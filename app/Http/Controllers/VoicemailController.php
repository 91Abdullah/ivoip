<?php

namespace App\Http\Controllers;

use App\Voicemail;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class VoicemailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Storage::disk('voicemails')->files();
        $processed = new Collection;
        $nArray = [];

        foreach ($files as $file) {
            $ext = explode(".", $file);
            if($ext[1] == "txt") {
                $nFile = Storage::disk('voicemails')->get($file);
                foreach (explode("\n", $nFile) as $key => $line) {
                    if(str_contains($line, "=")) {
                        $nValue = explode("=", $line);
                        $nArray[$nValue[0]] = $nValue[1];
                    }
                }
            }
        }

        return dd($nArray);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voicemail  $voicemail
     * @return \Illuminate\Http\Response
     */
    public function show(Voicemail $voicemail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Voicemail  $voicemail
     * @return \Illuminate\Http\Response
     */
    public function edit(Voicemail $voicemail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voicemail  $voicemail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voicemail $voicemail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voicemail  $voicemail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voicemail $voicemail)
    {
        //
    }
}
