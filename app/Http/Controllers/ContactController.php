<?php

namespace App\Http\Controllers;

use App\Contact;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::paginate(10);
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $keyword = $request->key;
            $contacts = DB::table('contacts')->where('number', 'LIKE', '%' . $keyword . '%')->get();
            if($contacts) {
                return response()->json($contacts->toJson(), 200);
            } else
                return response()->json("No record found.", 404);
        }

        return response()->json("Invalid request.", 500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()) {
//            $request->validate([
//                'name' => 'string|required',
//                'number' => 'numeric|required',
//                'user' => 'required|exists:users,id'
//            ]);

            $user = User::findOrFail($request->user);

            try {
                $contact = Contact::create($request->all());
                $user->contacts()->save($contact);
                return response()->json("Contact has been added.", 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 400);
            }

        } else {
            $request->validate([
                'name' => 'string|required',
                'number' => 'numeric|required'
            ]);
            $user = Auth::user();
            $user->contacts()->create($request->all());
            return redirect()->action('ContactController@index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'string|required',
            'number' => 'numeric|required'
        ]);

        $contact->update($request->all());
        return redirect()->route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
        return redirect()->route('contacts.index');
    }
}
