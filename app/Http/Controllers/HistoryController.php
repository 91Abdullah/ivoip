<?php

namespace App\Http\Controllers;

use App\Cdr;
use App\Contact;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HistoryController extends Controller
{
    public function getCalls(Request $request)
    {
        try {
            $user = User::findOrFail($request->userId);
            $extn = $user->extension;
            $calls = Cdr::whereDate('start', Carbon::now()->format('Y-m-d'))->where('channel', 'LIKE', "%$extn%")->orderBy('start', 'desc')->get(['src', 'dst', 'start', 'answer', 'end', 'duration', 'billsec', 'disposition', 'duration', 'billsec', 'uniqueid']);
            return DataTables::of($calls)->make(true);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getContacts()
    {
        try {
            $contacts = Contact::all(['name', 'number']);
            return DataTables::of($contacts)->make(true);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
