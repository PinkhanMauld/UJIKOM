<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Repair;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('admin.repairs.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'total' => 'required|integer|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $item = Item::find($request->item_id);

        if (!$item) {
            return back()->with('error', 'Item tidak ditemukan');
        }

        Repair::create([
            'item_id' => $request->item_id,
            'total' => $request->total,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect()->route('items.index')
            ->with('success', 'Repair berhasil ditambahkan');
    }
}