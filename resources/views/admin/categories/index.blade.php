<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Categories
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="bg-white p-6 rounded shadow">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Category List (Admin)</h2>

                <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Add Category
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Division PJ</th>
                        <th class="border p-2">Total Items</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categories as $no => $category)
                        <tr>
                            <td class="border p-2">{{ $no + 1 }}</td>
                            <td class="border p-2">{{ $category->name }}</td>
                            <td class="border p-2">{{ $category->division->name }}</td>
                            <td class="border p-2">{{ $category->items_count }}</td>
                            <td class="border p-2 flex gap-2">
                                
                                <a href="{{ route('categories.edit', $category->id) }}"
                                   class="bg-yellow-500 text-black px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded"
                                            onclick="return confirm('Hapus category ini?')">
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
</x-app-layout>