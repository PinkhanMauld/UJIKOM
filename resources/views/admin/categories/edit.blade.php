<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Category
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="bg-white p-6 rounded shadow">

            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ $category->name }}" 
                        class="w-full border rounded p-2"
                    >
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Division PJ</label>
                    <select name="division_id" class="w-full border rounded p-2">
                        @foreach ($divisions as $division)
                            <option value="{{ $division->id }}"
                                {{ $category->division_id == $division->id ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="bg-green-600 text-white px-4 py-2 rounded">
                    Update
                </button>

            </form>

        </div>
    </div>
</x-app-layout>