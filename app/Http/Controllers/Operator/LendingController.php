<?php

namespace App\Http\Controllers\Operator;

use App\Exports\LendingsExport;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Lending;
use App\Models\LendingDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

use function Symfony\Component\Clock\now;

class LendingController extends Controller
{
   public function index(Request $request)
    {
        $query = Lending::with(['details.item', 'editor']);

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $lendings = $query->latest()->get();

        return view('operator.lendings.index', compact('lendings'));
    }
    public function lendings($id)
    {
        $item = Item::findOrFail($id);

        $lendings = LendingDetail::with(['lending.editor'])
            ->where('item_id', $id)
            ->whereRelation('lending', 'return_date', null)
            ->get();

        return view('admin.items.lendings', compact('lendings', 'item'));
    }

    public function create()
{
    $items = \App\Models\Item::with('lendingDetails', 'repairs')->get();

    foreach ($items as $item) {

        $item->real_stock =
            $item->total
            - $item->lendingDetails()
                ->whereHas('lending', function ($q) {
                    $q->whereNull('return_date');
                })
                ->sum('total')
            - $item->repairs()->sum('total');
    }

    return view('operator.lendings.create', compact('items'));
}

        public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'note' => 'nullable',
            'borrower_type' => 'required|in:guru,murid,tamu',
            'items' => 'required|array',
            'totals' => 'required|array',
            'totals.*' => 'required|integer|min:1',
        ]);

        $checkTotals = [];

        foreach ($request->items as $i => $itemId) {
            $checkTotals[$itemId] = ($checkTotals[$itemId] ?? 0) + $request->totals[$i];
        }

        foreach ($checkTotals as $itemId => $sumTotal) {
            $barang = Item::find($itemId);

            if (!$barang) {
                return back()->with('error', 'Item tidak ditemukan');
            }

            $realStock =
                $barang->total
                - $barang->lendingDetails()
                    ->whereHas('lending', function ($q) {
                        $q->whereNull('return_date');
                    })
                    ->sum('total')
                - $barang->repairs()->sum('total');

            if ($sumTotal > $realStock) {
                return back()->with('error', 'Stock tidak cukup');
            }
        }

        $lending = Lending::create([
            'name' => $request->name,
            'borrower_type' => $request->borrower_type,
            'note' => $request->note,
            'date' => Carbon::now(),
            'edited_by' => Auth::id(),
        ]);

        foreach ($request->items as $index => $itemId) {
            LendingDetail::create([
                'lending_id' => $lending->id,
                'item_id' => $itemId,
                'total' => $request->totals[$index],
            ]);
        }

        return redirect()->route('lendings.index')
            ->with('success', 'Lending berhasil!');
    }

     public function returnForm(Lending $lending)
    {
        $lending->load('details.item');

        return view('operator.lendings.return', compact('lending'));
    }

    public function processReturn(Request $request, Lending $lending)
    {
        $request->validate([
            'good_total' => 'required|array',
            'damaged_total' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $lending) {

            foreach ($lending->details as $detail) {

                $good = (int) ($request->good_total[$detail->id] ?? 0);
                $bad  = (int) ($request->damaged_total[$detail->id] ?? 0);

                // VALIDASI TOTAL
                if ($good + $bad != $detail->total) {
                throw ValidationException::withMessages([
                    'error' => 'Total good + rusak harus sama untuk item: ' . $detail->item->name
                ]);
            }


                $detail->update([
                    'good_total' => $good,
                    'damaged_total' => $bad,
                ]);

                $item = Item::find($detail->item_id);

                // GOOD → balik ke stock
                if ($good > 0) {
                    $item->increment('total', $good);
                }

                // DAMAGED → masuk repair
                if ($bad > 0) {
                    $item->repairs()->create([
                        'total' => $bad,
                        'date' => now(),
                    ]);
                }
            }

            $lending->update([
                'return_date' => now()
            ]);
        });

        return redirect()->route('lendings.index')
            ->with('success', 'Return berhasil diproses');
    }

    public function destroy(Lending $lending)
    {
        DB::transaction(function () use ($lending) {

            $lending->details()->delete();
            $lending->delete();
        });

        return back()->with('success', 'Lending deleted');
    }

    public function export(Request $request)
    {
        return Excel::download(
            new LendingsExport($request),
            'lendings.xlsx'
        );
    }
}