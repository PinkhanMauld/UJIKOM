<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')
            ->withSum('repairs as repair_total', 'total')
            ->withSum(['lendingDetails as lending_out_total' => function ($q) {
                $q->whereHas('lending', function ($l) {
                    $l->whereNull('return_date');
                });
            }], 'total')
            ->get()
            ->map(function ($item) {

                $item->real_stock =
                    $item->total
                    - ($item->repair_total ?? 0)
                    - ($item->lending_out_total ?? 0);

                return $item;
            });

        return view('operator.items.index', compact('items'));
    }
}