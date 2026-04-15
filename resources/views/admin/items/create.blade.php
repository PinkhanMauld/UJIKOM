<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Item
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('items.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Name</label>
                        <input type="text" name="name" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Category</label>
                        <select name="category_id" class="w-full border rounded p-2" required>
                            <option value="">-- select category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Total Stock</label>
                        <input type="number" name="total" min="0" class="w-full border rounded p-2" required>
                    </div>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded">
                        Submit
                    </button>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>