<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Items
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <div class="bg-white p-6 rounded shadow">

            <table class="w-full border text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Category</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Total</th>
                        <th class="border p-2">Available</th>
                        <th class="border p-2">Lending</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($items as $i => $item)
                        <tr>
                            <td class="border p-2">{{ $i + 1 }}</td>
                            <td class="border p-2">{{ $item->category->name }}</td>
                            <td class="border p-2">{{ $item->name }}</td>
                            <td class="border p-2">{{ $item->total }}</td>
                            <td class="border p-2">{{ $item->real_stock }}</td>
                            <td class="border p-2">{{ $item->lending_out_total ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

</x-app-layout>