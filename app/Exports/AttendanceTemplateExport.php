<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceTemplateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Returning an empty collection as we are just exporting a template
        return collect([]);
    }

    public function headings(): array
    {
        // Define your template headings here
        return [
            'Year & Section',
            'Last Name',
            'First Name',
        ];
    }
}
