<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lending Table - {{ $item->name }}
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <div class="bg-white p-6 rounded shadow">

            <a href="{{ route('items.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
                Back
            </a>

            <div class="mt-4 overflow-x-auto">

                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">No</th>
                            <th class="border p-2">Item</th>
                            <th class="border p-2">Total</th>
                            <th class="border p-2">Name</th>
                            <th class="border p-2">Note</th>
                            <th class="border p-2">Date</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Edited By</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($lendings as $d)
                            <tr>
                                <td class="border p-2">{{ $loop->iteration }}</td>
                                <td class="border p-2">{{ $item->name }}</td>
                                <td class="border p-2">{{ $d->total }}</td>
                                <td class="border p-2">{{ $d->lending->name }}</td>
                                <td class="border p-2">{{ $d->lending->note }}</td>
                                <td class="border p-2">{{ $d->lending->date }}</td>

                                <td class="border p-2">
                                    <span class="text-red-600 font-semibold">
                                        Not Returned
                                    </span>
                                </td>

                                <td class="border p-2">
                                    {{ $d->lending->editor->name ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center p-3">
                                    No active lending found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>

    </div>

</x-app-layout>