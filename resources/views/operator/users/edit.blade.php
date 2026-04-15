<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Profile
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 mb-4 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('operator.users.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Name</label>
                    <input type="text"
                           name="name"
                           value="{{ $user->name }}"
                           class="w-full border rounded p-2"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ $user->email }}"
                           class="w-full border rounded p-2"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">New Password (optional)</label>
                    <input type="password"
                           name="new_password"
                           class="w-full border rounded p-2"
                           placeholder="Kosongkan jika tidak ingin mengganti password">
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update
                </button>

            </form>

        </div>

    </div>

</x-app-layout>