<?php

namespace App\Http\Controllers;

use App\Voicemail;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use DataTables;

class VoicemailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('voicemail.nindex');
    }
	
	public function getMails(Request $request)
	{
		$files = Storage::disk('voicemails')->files();
        $processed = new Collection;
        $nArray = [];
		
		foreach($files as $key => $file) {
			$ext = explode(".", $file);
			$details = [];
			if($ext[1] == "txt") {
				
			}
			if($ext[1] == "WAV") { 
				$processed->push([
					"name" => $ext[0],
					"play" => $file
				]);
			}
		}

        //return dd(array_reverse($files));
		return DataTables::of($processed)->toJson();
	}
	
	public function playFile($file)
    {
        return Storage::disk('voicemails')->download($file);
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
