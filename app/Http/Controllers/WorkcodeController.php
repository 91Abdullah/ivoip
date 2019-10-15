<?php

namespace App\Http\Controllers;

use App\Workcode;
use Illuminate\Http\Request;

class WorkcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workcodes = Workcode::all();
        return view('workcodes.index', compact('workcodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('workcodes.create');
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
            'name' => 'required|string'
        ]);

        $workcode = Workcode::create($request->all());
        return redirect()->route('workcodes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Workcode  $workcode
     * @return \Illuminate\Http\Response
     */
    public function show(Workcode $workcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Workcode  $workcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Workcode $workcode)
    {
        return view('workcodes.edit', compact('workcode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Workcode  $workcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workcode $workcode)
    {
        $request->validate([
            'name' => 'required|string'
        ]);
        $workcode->update($request->all());
        return redirect()->route('workcodes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Workcode  $workcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workcode $workcode)
    {
        $workcode->delete();
        return redirect()->route('workcodes.index');
    }
}
