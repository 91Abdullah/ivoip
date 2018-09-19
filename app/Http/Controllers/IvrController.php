<?php

namespace App\Http\Controllers;

use App\Ivr;
use App\SystemRecording;
use Illuminate\Http\Request;

class IvrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ivrs = Ivr::all();
        return view('ivr.index', compact('ivrs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $recordings = SystemRecording::pluck('name', 'name');
        $array1 = ['none' => 'None', 'default' => 'Default'];
        $new = array_change_key_case(array_merge(SystemRecording::pluck('name', 'name')->toArray(), ['none' => 'None', 'default' => 'Default']), CASE_LOWER);
        return view('ivr.create');
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
     * @param  \App\Ivr  $ivr
     * @return \Illuminate\Http\Response
     */
    public function show(Ivr $ivr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ivr  $ivr
     * @return \Illuminate\Http\Response
     */
    public function edit(Ivr $ivr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ivr  $ivr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ivr $ivr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ivr  $ivr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ivr $ivr)
    {
        //
    }
}
