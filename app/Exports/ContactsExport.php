<?php

namespace App\Exports;

use App\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contact::all(['id', 'name', 'number', 'created_at']);
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Number',
            'Created At'
        ];
    }
}
