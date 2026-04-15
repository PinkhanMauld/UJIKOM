<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Items
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <div class="bg-white p-6 rounded shadow">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 mb-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex gap-3 mb-4">

                <a href="{{ route('items.export') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded">
                    Export Excel
                </a>

                <a href="{{ route('items.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded">
                    + Tambah Item
                </a>

            </div>

            <table class="w-full border text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Category</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Total</th>
                        <th class="border p-2">Repair</th>
                        <th class="border p-2">Lending</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($items as $index => $item)
                        <tr>
                            <td class="border p-2">{{ $index + 1 }}</td>
                            <td class="border p-2">{{ $item->category->name ?? '-' }}</td>
                            <td class="border p-2">{{ $item->name }}</td>
                            <td class="border p-2">{{ $item->real_stock }}</td>
                            <td class="border p-2">{{ $item->repair_total ?? 0 }}</td>
                            <td class="border p-2">
                                @if ($item->lending_count > 0)
                                    <a href="{{ route('item.lendings', $item->id) }}"
                                       class="text-blue-600 underline">
                                        {{ $item->lending_count }}
                                    </a>
                                @else
                                    0
                                @endif
                            </td>
                            <td class="border p-2 flex gap-2">

                                <a href="{{ route('items.edit', $item->id) }}"
                                   class="bg-yellow-500 text-black px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded"
                                            onclick="return confirm('Hapus item ini?')">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-3">
                                No items found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>

</x-app-layout>