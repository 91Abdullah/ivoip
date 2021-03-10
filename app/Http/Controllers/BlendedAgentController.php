<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BlendedAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = Role::where('name', 'Blended')->first()->users;
        return view('blended.index', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $queues = Queue::pluck('name', 'name');
        return view('blended.create', compact('queues'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'extension' => 'required|string|unique:users,extension',
            'secret' => 'required|string',
            'queue' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'extension' => $request->extension,
            'secret' => $request->secret
        ]);

        $role_id = Role::where('name', 'Blended')->first();

        $user->roles()->attach($role_id);
        $user->queues()->attach($request->queue);

        // Insert SIP details into PJSIP realtime table

        DB::table('ps_aors')->insert([
            'id' => $user->extension,
            'max_contacts' => 1,
            'remove_existing' => 'yes'
        ]);

        DB::table('ps_auths')->insert([
            'id' => $user->extension,
            'auth_type' => 'userpass',
            'password' => $user->secret,
            'username' => $user->extension
        ]); 

        DB::table('ps_endpoints')->insert([
            'id' => $user->extension,
            'transport' => 'transport-wss',
            'aors' => $user->extension,
            'auth' => $user->extension,
            'context' => 'default',
            'disallow' => 'all',
            'allow' => 'alaw,ulaw,opus',
            'direct_media' => 'no'
        ]);

        return redirect()->action('BlendedAgentController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $blended)
    {
        $queues = Queue::pluck('name', 'name');
        return view('blended.edit', compact('blended', 'queues'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $blended)
    {
        if(!empty($request->password)) {
            $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'extension' => 'string|unique:users,extension',
                'secret' => 'string'
            ]);

            $user = $blended->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'extension' => $request->extension,
                'secret' => $request->secret
            ]);
        } else {
            $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|email|max:255|unique:users,email,' . $blended->id,
                'extension' => 'string|unique:users,extension,' . $blended->id,
                'secret' => 'string'
            ]);

            $user = $blended->update([
                'name' => $request->name,
                'email' => $request->email,
                'extension' => $request->extension,
                'secret' => $request->secret
            ]);
        }

        return redirect()->action('BlendedAgentController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $blended)
    {
        $blended->delete();
        $blended->queues()->detach();
        DB::table('ps_auths')->where('id', $blended->extension)->delete();
        DB::table('ps_aors')->where('id', $blended->extension)->delete();
        DB::table('ps_endpoints')->where('id', $blended->extension)->delete();
        return redirect()->action('BlendedAgentController@index');
    }
}
