<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create User
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Name</label>
                    <input type="text" name="name" required
                           class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Email</label>
                    <input type="email" name="email" required
                           class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Role</label>
                    <select name="role" required
                            class="w-full border rounded p-2">
                        <option value="">-- Role --</option>
                        <option value="admin">Admin</option>
                        <option value="operator">Operator</option>
                    </select>
                </div>

                <button class="bg-green-600 text-white px-4 py-2 rounded">
                    Save
                </button>

            </form>

        </div>

    </div>

</x-app-layout>