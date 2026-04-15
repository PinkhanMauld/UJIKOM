<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" required
                           class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required
                           class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">New Password (optional)</label>
                    <input type="text" name="new_password"
                           placeholder="Enter new password"
                           class="w-full border rounded p-2">
                </div>

                <button class="bg-yellow-500 text-black px-4 py-2 rounded">
                    Update
                </button>

            </form>

        </div>

    </div>

</x-app-layout>