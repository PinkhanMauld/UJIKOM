<x-app-layout>

<div class="flex min-h-screen bg-gray-50">

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6">

        {{-- WELCOME --}}
        <div class="mb-6 bg-white p-5 rounded-2xl shadow-sm">
            <h1 class="text-2xl font-semibold text-gray-700">
                👋 Selamat datang, {{ $user->name }}
            </h1>
            <p class="text-gray-500">
                Dashboard {{ ucfirst($user->role) }}
            </p>
        </div>

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <div class="p-5 rounded-2xl bg-orange-100 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600">Total Items</p>
                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $totalItems ?? 0 }}
                        </h2>
                    </div>
                    <div class="text-orange-500 text-xl">📦</div>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-blue-100 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600">Active Lending</p>
                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $activeLendings ?? 0 }}
                        </h2>
                    </div>
                    <div class="text-blue-500 text-xl">📋</div>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-green-100 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600">Returned</p>
                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $returnedLendings ?? 0 }}
                        </h2>
                    </div>
                    <div class="text-green-500 text-xl">✅</div>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-red-100 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600">Total Damage</p>
                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $totalDamaged ?? 0 }}
                        </h2>
                    </div>
                    <div class="text-red-500 text-xl">⚠️</div>
                </div>
            </div>

        </div>
        {{-- ADMIN ONLY CONTENT --}}
        @if($user->role === 'admin')

        {{-- LATEST LENDING --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm mb-6">
            <h3 class="font-semibold mb-4">Latest Lending</h3>

            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2">User</th>
                        <th>Item</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($latestLendings as $lending)
                    <tr class="border-b">
                        <td class="py-2">{{ $lending->name }}</td>
                        <td>
                            @foreach ($lending->details as $d)
                                {{ $d->item->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @if($lending->return_date)
                                <span class="text-green-600">Returned</span>
                            @else
                                <span class="text-red-500">Not Returned</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- LATEST REPAIR --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm">
            <h3 class="font-semibold mb-4">Latest Repair</h3>

            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2">Item</th>
                        <th>Total Damage</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($latestRepairs as $repair)
                    <tr class="border-b">
                        <td class="py-2">{{ $repair->item->name ?? '-' }}</td>
                        <td>{{ $repair->total }}</td>
                        <td>{{ $repair->date }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @endif

    </main>
</div>

</x-app-layout>