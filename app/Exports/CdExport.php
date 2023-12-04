<?php

namespace App\Exports;

use App\Models\cdStatistic;
use Maatwebsite\Excel\Concerns\FromCollection;

class CdExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'deviceid',
            'people count',
            'date',
            'time',
        ];
    }

    public function collection()
    {
        return cdStatistic::all();
    }
}
