<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Lending
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <div class="bg-white p-6 rounded shadow">

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 p-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 text-red-600">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('lendings.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Name (Peminjam)</label>
                    <input type="text" name="name" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <select name="borrower_type" class="w-full border rounded p-2" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="guru">Guru</option>
                        <option value="murid">Murid</option>
                        <option value="tamu">Tamu</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Keterangan</label>
                    <textarea name="note" class="w-full border rounded p-2"></textarea>
                </div>

                <hr class="my-4">

                <div id="items-wrapper">

                    <div class="item-row flex gap-2 mb-3">

                        <select name="items[]" class="w-1/2 border rounded p-2" required>
                            <option value="">-- Pilih Item --</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }} (Available: {{ $item->real_stock }})
                                </option>
                            @endforeach
                        </select>

                        <input type="number" name="totals[]" min="1"
                               class="w-1/4 border rounded p-2"
                               placeholder="Total" required>

                        <button type="button"
                                class="remove-btn bg-red-500 text-white px-3 rounded">
                            X
                        </button>

                    </div>

                </div>

                <button type="button"
                        id="add-more"
                        class="bg-blue-600 text-white px-4 py-2 rounded mb-4">
                    + More
                </button>

                <div>
                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Save Lending
                    </button>
                </div>

            </form>

        </div>

    </div>

    <script>
        document.getElementById('add-more').addEventListener('click', function () {
            let wrapper = document.getElementById('items-wrapper');
            let row = document.querySelector('.item-row').cloneNode(true);

            row.querySelector('select').value = "";
            row.querySelector('input').value = "";

            wrapper.appendChild(row);
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-btn')) {
                if (document.querySelectorAll('.item-row').length > 1) {
                    e.target.parentElement.remove();
                }
            }
        });
    </script>

</x-app-layout>