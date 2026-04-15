<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Item::with('category')->withSum('repairs as repair_total', 'total')->get()->map(function ($item) {
                return [
                    'Category'      => $item->category->name,
                    'Name Item'     => $item->name,
                    'Total'         => $item->total,
                    'Repair Total'  => $item->repair_total == 0 ? '-' : $item->repair_total,
                    'Last Updated'  => $item->updated_at->translatedFormat('F d, Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Category',
            'Name Item',
            'Total',
            'Repair Total',
            'Last Updated',
        ];
    }
}