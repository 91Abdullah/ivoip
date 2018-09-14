<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supervisors = Role::with('users')->whereName('Supervisor')->first()->users;
        // return dd($supervisors);
        return view('supervisors.index', compact('supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supervisors.create');
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
            'queue' => 'required|exists:queues,name'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'extension' => $request->extension,
            'secret' => $request->secret
        ]);

        $role_id = Role::where('name', 'Supervisor')->first();

        $user->roles()->attach($role_id);
        $user->queues()->attach($request->queue);

        // Insert SIP details into PJSIP realtime table

        DB::table('ps_aors')->insert([
            'id' => $user->extension,
            'max_contacts' => 1
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

        return redirect()->action('SupervisorController@index');
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
    public function edit(User $supervisor)
    {
        return view('supervisors.edit', compact('supervisor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $supervisor)
    {
        if($request->has('password')) {
            $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'extension' => 'string|unique:users,extension',
                'secret' => 'string'
            ]);

            $user = $supervisor->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'extension' => $request->extension,
                'secret' => $request->secret
            ]);
        } else {
            $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|email|max:255|unique:users,email',
                'extension' => 'string|unique:users,extension',
                'secret' => 'string'
            ]);

            $user = $supervisor->update([
                'name' => $request->name,
                'email' => $request->email,
                'extension' => $request->extension,
                'secret' => $request->secret
            ]);
        }

        return redirect()->action('SupervisorController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $supervisor)
    {
        $supervisor->destroy();
        return redirect()->action('SupervisorController@index');
    }
}
