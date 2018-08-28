<?php

namespace App\Http\Controllers;

use App\AgentBreak;
use Illuminate\Http\Request;

class AgentBreakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breaks = AgentBreak::all();
        return view('breaks.index', compact('breaks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('breaks.create');
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

        $break = AgentBreak::create($request->all());
        return redirect()->route('breaks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AgentBreak  $agentBreak
     * @return \Illuminate\Http\Response
     */
    public function show(AgentBreak $agentBreak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AgentBreak  $agentBreak
     * @return \Illuminate\Http\Response
     */
    public function edit(AgentBreak $agentBreak)
    {
        return view('breaks.edit', compact('agentBreak'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AgentBreak  $agentBreak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgentBreak $agentBreak)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $agentBreak->update($request->all());
        return redirect()->route('breaks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AgentBreak  $agentBreak
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgentBreak $agentBreak)
    {
        $agentBreak->destroy();
        return redirect()->route('breaks.index');
    }
}
