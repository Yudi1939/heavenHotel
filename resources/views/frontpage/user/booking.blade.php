<x-user-layout>
    @foreach ($datas as $item)
        <div class="flex flex-col justify-center max-w-3xl mx-auto bg-white shadow-lg shadow-sm-5 rounded-lg border border-black p-6 gap-2">
            <div class="flex flex-row w-full gap-2">
                <img src="{{ asset($item->path . $item->img_hotel) }}" alt="gambar hotel" class="w-1/3 border border-black h-full">
                <div class="w-2/3 flex flex-col">
                    <h1 class="text-3xl font-bold text-black mb-3">{{ $item->cabang_hotel }}</h1>
                    <p class="text-gray-700 mb-6">{{ $item->desc_hotel }}</p>
                    <p class="text-purple-700 text-xl mb-6">Rental price: Rp {{ number_format($item->price) }}</p>
                </div>
            </div>

            <!-- Form untuk kedua aksi -->
            <form action="{{ route('storeUser', ['id' => $item->id_hotel]) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="text-purple-700 font-semibold mb-2">Check-in Date</label>
                    <input type="date" name="check_in" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                </div>
                <div class="mb-4">
                    <label class="text-purple-700 font-semibold mb-2">Check-out Date</label>
                    <input type="date" name="check_out" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                </div>
                <div class="w-full gap-2 m-2 flex flex-row">
                    <!-- Tombol Add to Chart -->
                    <button type="submit" name="action" value="chart" class="bg-yellow-500 text-white py-3 px-4 rounded-lg w-full hover:bg-yellow-600">Add to Chart</button>
                    <!-- Tombol Reserve -->
                    <button type="submit" name="action" value="order" class="bg-purple-500 text-white py-3 px-4 rounded-lg w-full hover:bg-purple-600">Reserve</button>
                </div>
            </form>
        </div>
    @endforeach      
</x-user-layout>