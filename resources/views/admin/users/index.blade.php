<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <div class="bg-white p-6 rounded shadow">

            <div class="flex gap-3 mb-4">

                <a href="{{ route('users.export.admin') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded">
                    Export Excel
                </a>

                <a href="{{ route('users.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded">
                    + Add User
                </a>

            </div>
            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <table class="w-full border text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $i => $user)
                        <tr>
                            <td class="border p-2">{{ $i + 1 }}</td>
                            <td class="border p-2">{{ $user->name }}</td>
                            <td class="border p-2">{{ $user->email }}</td>

                            <td class="border p-2 flex gap-2">

                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="bg-yellow-500 text-black px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded"
                                            onclick="return confirm('Hapus user ini?')">
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