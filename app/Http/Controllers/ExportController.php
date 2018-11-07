<?php

namespace App\Http\Controllers;

use App\Exports\ContactsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportContacts()
    {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }
}
