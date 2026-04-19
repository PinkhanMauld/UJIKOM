<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Lending
    </h2>
</x-slot>

<div class="py-6 px-6">
    <div class="bg-white p-6 rounded shadow">

        {{-- ACTION BAR --}}
        <div class="flex gap-3 mb-4">
            <a href="{{ route('lendings.export', request()->all()) }}"
               class="bg-green-600 text-white px-4 py-2 rounded">
                Export Excel
            </a>

            <a href="{{ route('lendings.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                + Add
            </a>
        </div>

        {{-- FILTER --}}
        <form method="GET" action="{{ route('lendings.index') }}" class="mb-4 flex gap-2">

            <input type="date"
                   name="date"
                   value="{{ request('date') }}"
                   class="border px-2 py-1 rounded">

            <button class="bg-blue-500 text-white px-3 py-1 rounded">
                Filter
            </button>

            <a href="{{ route('lendings.index') }}"
               class="bg-gray-400 text-white px-3 py-1 rounded">
                Reset
            </a>

        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full border text-sm">

                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Item</th>
                        <th class="border p-2">Total</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Note</th>
                        <th class="border p-2">Date</th>
                        <th class="border p-2">Returned</th>
                        <th class="border p-2">Edited By</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($lendings as $lending)
                        <tr>

                            <td class="border p-2 text-center">
                                {{ $loop->iteration }}
                            </td>

                            {{-- ITEM --}}
                            <td class="border p-2">
                                @foreach ($lending->details as $d)
                                    • {{ $d->item->name }}<br>
                                @endforeach
                            </td>

                            {{-- TOTAL --}}
                            <td class="border p-2 text-center">
                                @foreach ($lending->details as $d)
                                    {{ $d->total }}<br>
                                @endforeach
                            </td>

                            <td class="border p-2">
                                {{ $lending->name }}
                            </td>

                            <td class="border p-2">
                                {{ ucfirst($lending->borrower_type) }}
                            </td>

                            <td class="border p-2">
                                {{ $lending->note ?? '-' }}
                            </td>

                            <td class="border p-2">
                                {{ $lending->date }}
                            </td>

                            <td class="border p-2">
                                @if ($lending->return_date)
                                    <span class="text-green-600 font-semibold">
                                        {{ $lending->return_date }}
                                    </span>
                                @else
                                    <span class="text-red-600 font-semibold">
                                        Not returned
                                    </span>
                                @endif
                            </td>

                            <td class="border p-2">
                                {{ $lending->editor->name ?? '-' }}
                            </td>

                            {{-- ACTION --}}
                            <td class="border p-2 flex gap-2">

                                {{-- RETURN (NEW SYSTEM) --}}
                                @if (!$lending->return_date)
                                    <a href="{{ route('lendings.return.form', $lending->id) }}"
                                       class="bg-green-600 text-white px-3 py-1 rounded">
                                        Return
                                    </a>
                                @endif

                                {{-- DELETE --}}
                                <form action="{{ route('lendings.destroy', $lending->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-600 text-white px-3 py-1 rounded">
                                        Delete
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

</x-app-layout>