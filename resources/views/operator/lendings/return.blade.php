<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Return Lending - {{ $lending->name }}
    </h2>
</x-slot>

<div class="py-6 px-6">
    <div class="bg-white p-6 rounded shadow">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- INFO --}}
        <div class="mb-4 text-sm text-gray-600">
            Isi jumlah barang yang <b>baik</b> dan <b>rusak</b>. Total harus sesuai dengan jumlah pinjam.
        </div>

        <form method="POST" action="{{ route('lendings.return.process', $lending->id) }}">
            @csrf

            <table class="w-full border text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Item</th>
                        <th class="border p-2">Total Pinjam</th>
                        <th class="border p-2">Good</th>
                        <th class="border p-2">Damaged</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($lending->details as $detail)
                        <tr>

                            {{-- ITEM --}}
                            <td class="border p-2">
                                {{ $detail->item->name }}
                            </td>

                            {{-- TOTAL PINJAM --}}
                            <td class="border p-2 text-center font-semibold">
                                {{ $detail->total }}
                            </td>

                            {{-- GOOD INPUT --}}
                            <td class="border p-2">
                                <input type="number"
                                       name="good_total[{{ $detail->id }}]"
                                       min="0"
                                       max="{{ $detail->total }}"
                                       value="0"
                                       class="w-full border rounded px-2 py-1">
                            </td>

                            {{-- DAMAGED INPUT --}}
                            <td class="border p-2">
                                <input type="number"
                                       name="damaged_total[{{ $detail->id }}]"
                                       min="0"
                                       max="{{ $detail->total }}"
                                       value="0"
                                       class="w-full border rounded px-2 py-1">
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- BUTTON --}}
            <div class="mt-4 flex gap-2">
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded">
                    Submit Return
                </button>

                <a href="{{ route('lendings.index') }}"
                   class="bg-gray-400 text-black px-4 py-2 rounded">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</div>

</x-app-layout>