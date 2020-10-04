<?php

namespace App\Http\Controllers;

use App\Ticker;
use Illuminate\Http\Request;

class TickerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $tickers = Ticker::all();
        return view('ticker.index', compact('tickers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('ticker.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $ticker = new Ticker;
            $ticker->content = $request->get('content');
            $ticker->save();
            return redirect()->route('ticker.index')->with('success', "Ticker has been created");
        } catch (\Exception $exception) {
            return redirect()->route('ticker.index')->with('danger', "Creating ticker failed with error: " . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticker  $ticker
     * @return \Illuminate\Http\Response
     */
    public function show(Ticker $ticker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticker  $ticker
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Ticker $ticker)
    {
        return view('ticker.edit', compact('ticker'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticker  $ticker
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Ticker $ticker)
    {
        try {
            $ticker->content = $request->get('content');
            $ticker->save();
            return redirect()->route('ticker.index')->with('success', "Ticker has been created");
        } catch (\Exception $exception) {
            return redirect()->route('ticker.index')->with('danger', "Updating ticker failed with error: " . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticker  $ticker
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Ticker $ticker)
    {
        try {
            $ticker->delete();
            return redirect()->route('ticker.index')->with('success', 'Ticker has been deleted.');
        } catch (\Exception $e) {
            return redirect()->route('ticker.index')->with('danger', "Deleting ticker failed with error: " . $e->getMessage());
        }
    }
}
