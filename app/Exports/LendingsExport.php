<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LendingsExport implements FromCollection, WithHeadings
{
    public function __construct(private $request) {}

    public function collection()
    {
        $query = Lending::with(['details.item', 'editor']);

        if ($this->request->filled('date')) {
            $query->whereDate('date', $this->request->date);
        }

        return $query->get()->flatMap(function ($lending) {

            return $lending->details->map(function ($d) use ($lending) {
                return [
                    'item'        => $d->item->name,
                    'total'       => $d->total,
                    'name'        => $lending->name,
                    'borrower_type' => $lending->borrower_type,
                    'note'        => $lending->note,
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
            'Status Peminjam',
            'Ket',
            'Date',
            'Return Date',
            'Edited By',
        ];
    }
}