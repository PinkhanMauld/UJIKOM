<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LendingsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Lending::with(['details.item', 'editor'])->get()->flatMap(function ($lending) {

                return $lending->details->map(function ($d) use ($lending) {
                    return [
                        'item'        => $d->item->name,
                        'total'       => $d->total,
                        'name'        => $lending->name,
                        'ket'         => $lending->note,
                        'date'        => $lending->date,
                        'return_date' => $lending->return_date ?? '-',
                        'edited_by'   => $lending->editor->name ?? '-',
                    ];
                });

            });
    }

    public function headings(): array
    {
        return [
            'Item',
            'Total',
            'Name',
            'Ket',
            'Date',
            'Return Date',
            'Edited By',
        ];
    }
}