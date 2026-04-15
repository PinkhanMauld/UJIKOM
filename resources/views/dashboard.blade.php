{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                @if(auth()->user()->role === 'admin')

                    <h3 class="text-lg font-bold mb-4">Admin Dashboard</h3>

                    <p class="mb-4">
                        Selamat datang, {{ auth()->user()->name }}!
                    </p>

                    <ul class="list-disc ml-6 space-y-1">
                        <li><a href="{{ route('categories.index') }}">Categories</a></li>
                        <li><a href="{{ route('items.index') }}">Items</a></li>
                        <li><a href="{{ route('users.index') }}">Admin Users</a></li>
                        <li><a href="{{ route('users.operators') }}">Operator Users</a></li>
                    </ul>

                @else

                    <h3 class="text-lg font-bold mb-4">Operator Dashboard</h3>

                    <p class="mb-4">
                        Halo, {{ auth()->user()->name }}!
                    </p>

                    <ul class="list-disc ml-6 space-y-1">
                        <li><a href="{{ route('lendings.index') }}">Lending</a></li>
                        <li><a href="{{ route('operator.items.index') }}">Items</a></li>
                        <li><a href="{{ route('operator.users.edit') }}">Update Profile</a></li>
                    </ul>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>