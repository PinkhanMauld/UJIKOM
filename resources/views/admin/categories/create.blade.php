<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Category
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="bg-white p-6 rounded shadow">
            @if ($errors->any())
                <div class="bg-red-100 p-3 mb-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Name</label>
                    <input type="text" name="name" class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Division PJ</label>
                    <select name="division_id" class="w-full border rounded p-2">
                        <option value="">-- pilih division --</option>
                        @foreach ($divisions as $division)
                            <option value="{{ $division->id }}">
                                {{ $division->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="bg-green-600 text-white px-4 py-2 rounded">
                    Save
                </button>

            </form>

        </div>
    </div>
</x-app-layout>