<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ItemsExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\LendingDetail;
use App\Models\Repair;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
   public function index()
{
    $items = Item::with('category')
    ->withSum('repairs as repair_total', 'total')
    ->withCount(['lendingDetails as lending_count' => function ($q) {
        $q->whereHas('lending', function ($l) {
            $l->whereNull('return_date');
        });
    }])
    ->get();

    foreach ($items as $item) {

        $item->real_stock =
            $item->total
            - ($item->lending_out_total ?? 0)
            - ($item->repair_total ?? 0);
    }

    return view('admin.items.index', compact('items'));
}   

    public function create()
    {
        $categories = Category::all();
        return view('admin.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'total' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        Item::create([
            'name' => $request->name,
            'total' => $request->total,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();

        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'new_broke_item' => 'nullable|integer|min:0',
        ]);

        // hanya update data penting
        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        // repair log
        if ($request->new_broke_item > 0) {
            Repair::create([
                'item_id' => $item->id,
                'total' => $request->new_broke_item,
                'date' => now(),
            ]);
        }

        return redirect()->route('items.index')
            ->with('success', 'Item Berhasil Diupdate');
    }

    public function destroy(string $id)
    {
        Item::destroy($id);

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil dihapus');
    }

    public function lendings($id)
    {
        $item = Item::findOrFail($id);

        $lendings = LendingDetail::with('lending.editor')
            ->where('item_id', $id)
            ->whereHas('lending', function ($q) {
                $q->whereNull('return_date');
            })
            ->get();

        return view('admin.items.lendings', compact('lendings', 'item'));
    }

    public function export()
{
    return Excel::download(new ItemsExport, 'items.xlsx');
}
}