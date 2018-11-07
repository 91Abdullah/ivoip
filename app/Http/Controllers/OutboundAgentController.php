<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OutboundAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = Role::where('name', 'Outbound')->first()->users;
        return view('outbounds.index', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('outbounds.create');
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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'extension' => $request->extension,
            'secret' => $request->secret
        ]);

        $role_id = Role::where('name', 'Outbound')->first();

        $user->roles()->attach($role_id);

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
            'context' => 'outbound-dial',
            'disallow' => 'all',
            'allow' => 'alaw,ulaw,opus',
            'direct_media' => 'no'
        ]);

        return redirect()->action('OutboundAgentController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $outbound
     * @return \Illuminate\Http\Response
     */
    public function show(User $outbound)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $outbound
     * @return \Illuminate\Http\Response
     */
    public function edit(User $outbound)
    {
        return view('outbounds.edit', compact('outbound'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $outbound
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $outbound)
    {
        if($request->has('password')) {
            $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'extension' => 'string|unique:users,extension',
                'secret' => 'string'
            ]);

            $user = $outbound->update([
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

            $user = $outbound->update([
                'name' => $request->name,
                'email' => $request->email,
                'extension' => $request->extension,
                'secret' => $request->secret
            ]);
        }

        return redirect()->action('OutboundAgentController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $outbound
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $outbound)
    {
        $outbound->delete();
        return redirect()->action('OutboundAgentController@index');
    }
}
