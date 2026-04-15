<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Item
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <div class="max-w-3xl mx-auto">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Item</h3>

                <a href="{{ route('items.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded">
                    Back
                </a>
            </div>

            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('items.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Name</label>
                        <input type="text" name="name" value="{{ $item->name }}"
                               class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Category</label>
                        <select name="category_id" class="w-full border rounded p-2" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Total Stock</label>
                        <input type="number" value="{{ $item->total }}"
                               class="w-full border rounded p-2 bg-gray-100" readonly>
                    </div>

                    @php
                        $currentRepair = $item->repairs->sum('total');
                    @endphp

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">
                            New Broke Item
                            <span class="text-yellow-500">(current: {{ $currentRepair }})</span>
                        </label>
                        <input type="number" name="new_broke_item" value="0"
                               class="w-full border rounded p-2">
                    </div>

                    <button class="bg-yellow-500 text-black px-4 py-2 rounded">
                        Update Item
                    </button>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>