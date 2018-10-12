<?php

namespace App\Http\Controllers;

use App\Queue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $queues = Queue::all();
        return view('queues.index', compact('queues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('queues.create');
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
            'name' => 'required|unique:queues,name',
            'musiconhold' => 'string',
            'announce' => 'string|nullable',
            'context' => 'string',
            'timeout' => 'integer',
            'ringinuse' => 'in:yes,no',
            'setinterfacevar' => 'string|in:yes,no',
            'setqueuevar' => 'string|in:yes,no',
            'setqueueentryvar' => 'string|in:yes,no',
            'monitor_format' => 'string|in:wav,gsm,wav49',
            'membermacro' => 'string|nullable',
            'membergosub' => 'string|nullable',
            'queue_youarenext' => 'string',
            'queue_thereare' => 'string',
            'queue_callswaiting' => 'string',
            'queue_quantity1' => 'string|nullable',
            'queue_quantity2' => 'string|nullable',
            'queue_holdtime' => 'string',
            'queue_minutes' => 'string',
            'queue_minute' => 'string',
            'queue_seconds' => 'string',
            'queue_thankyou' => 'string',
            'queue_callerannounce' => 'string|nullable',
            'queue_reporthold' => 'string',
            'announce_frequency' => 'integer',
            'announce_to_first_user' => 'string|in:yes,no',
            'min_announce_frequency' => 'integer',
            'announce_round_seconds' => 'integer',
            'announce_holdtime' => 'string',
            'announce_position' => 'string',
            'announce_position_limit' => 'integer',
            'periodic_announce' => 'string',
            'periodic_announce_frequency' => 'integer',
            'relative_periodic_announce' => 'string|in:yes,no',
            'random_periodic_announce' => 'string|in:yes,no',
            'retry' => 'integer',
            'wrapuptime' => 'integer',
            'penaltymemberslimit' => 'integer',
            'autofill' => 'string|in:yes,no',
            'monitor_type' => 'string|in:MixMonitor',
            'autopause' => 'string|in:yes,no,all',
            'autopausedelay' => 'integer',
            'autopausebusy' => 'string|in:yes,no',
            'autopauseunavail' => 'string|in:yes,no',
            'maxlen' => 'integer',
            'servicelevel' => 'integer',
            'strategy' => 'string|in:ringall,leastrecent,fewestcalls,random,rrmemory,linear,wrandom,rrordered',
            'joinempty' => 'string',
            'leavewhenempty' => 'string',
            'reportholdtime' => 'string|in:yes,no',
            'memberdelay' => 'integer',
            'weight' => 'integer',
            'timeoutrestart' => 'string|in:yes,no',
            'defaultrule' => 'string|nullable',
            'timeoutpriority' => 'string|nullable'
        ]);

        $queue = Queue::create($request->all());

        return redirect()->route('queues.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function show(Queue $queue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function edit(Queue $queue)
    {
        return view('queues.edit', compact('queue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Queue $queue)
    {
        $request->validate([
            'name' => ['required', Rule::unique('queues')->ignore($queue->name, 'name')],
            'musiconhold' => 'string',
            'announce' => 'string|nullable',
            'context' => 'string',
            'timeout' => 'integer',
            'ringinuse' => 'in:yes,no',
            'setinterfacevar' => 'string|in:yes,no',
            'setqueuevar' => 'string|in:yes,no',
            'setqueueentryvar' => 'string|in:yes,no',
            'monitor_format' => 'string|in:wav,gsm,wav49',
            'membermacro' => 'string|nullable',
            'membergosub' => 'string|nullable',
            'queue_youarenext' => 'string',
            'queue_thereare' => 'string',
            'queue_callswaiting' => 'string',
            'queue_quantity1' => 'string|nullable',
            'queue_quantity2' => 'string|nullable',
            'queue_holdtime' => 'string',
            'queue_minutes' => 'string',
            'queue_minute' => 'string',
            'queue_seconds' => 'string',
            'queue_thankyou' => 'string',
            'queue_callerannounce' => 'string|nullable',
            'queue_reporthold' => 'string',
            'announce_frequency' => 'integer',
            'announce_to_first_user' => 'string|in:yes,no',
            'min_announce_frequency' => 'integer',
            'announce_round_seconds' => 'integer',
            'announce_holdtime' => 'string',
            'announce_position' => 'string',
            'announce_position_limit' => 'integer',
            'periodic_announce' => 'string',
            'periodic_announce_frequency' => 'integer',
            'relative_periodic_announce' => 'string|in:yes,no',
            'random_periodic_announce' => 'string|in:yes,no',
            'retry' => 'integer',
            'wrapuptime' => 'integer',
            'penaltymemberslimit' => 'integer',
            'autofill' => 'string|in:yes,no',
            'monitor_type' => 'string|in:MixMonitor',
            'autopause' => 'string|in:yes,no,all',
            'autopausedelay' => 'integer',
            'autopausebusy' => 'string|in:yes,no',
            'autopauseunavail' => 'string|in:yes,no',
            'maxlen' => 'integer',
            'servicelevel' => 'integer',
            'strategy' => 'string|in:ringall,leastrecent,fewestcalls,random,rrmemory,linear,wrandom,rrordered',
            'joinempty' => 'string',
            'leavewhenempty' => 'string',
            'reportholdtime' => 'string|in:yes,no',
            'memberdelay' => 'integer',
            'weight' => 'integer',
            'timeoutrestart' => 'string|in:yes,no',
            'defaultrule' => 'string|nullable',
            'timeoutpriority' => 'string|nullable'
        ]);

        $queue->update($request->all());

        return redirect()->action('QueueController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Queue $queue)
    {
        try {
            $queue->delete();
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
        return redirect()->action('QueueController@index');
    }
}
