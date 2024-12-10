<x-admin-layout>
    <div class="max-w-4xl mx-auto py-8">
        <div class="text-center flex flex-row justify-between mb-6">
            <h1 class="text-3xl font-bold text-purple-900" method="POST">{{ $action }} Data Hotel</h1>
        </div>
        <form enctype="multipart/form-data" action="{{ $rute }}" class="bg-white p-6 rounded-lg shadow-lg" method="POST">
            @csrf
            <!-- Hotel Branch -->
            <div class="mb-4">
                <label for="hotel-branch" class="block text-lg font-semibold text-purple-900">Cabang Hotel</label>
                <input type="text" id="hotel-branch" name="cabang_hotel" value="{{ old('cabang_hotel', $hotel->cabang_hotel ?? '') }}" placeholder="Masukkan Nama Hotel" class="w-full mt-2 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 form-control @error('cabang_hotel') is-invalid @enderror">
            </div>
            @error('cabang_hotel')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-lg font-semibold text-purple-900">Harga</label>
                <input type="number" id="price" name="price" value="{{ old('price', $hotel->price ?? '') }}" placeholder="Masukkan Harga Hotel" class="w-full mt-2 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 form-control @error('price') is-invalid @enderror">
            </div>
            @error('price')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-lg font-semibold text-purple-900">Deskripsi</label>
                <textarea id="description" name="desc_hotel" placeholder="Masukkan Deskripsi Hotel" rows="4" class="w-full mt-2 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 form-control @error('desc_hotel') is-invalid @enderror">{{ old('desc_hotel', $hotel->desc_hotel ?? '') }}</textarea>
            </div>
            @error('desc_hotel')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror

            <!-- Image -->
            <div class="mb-4">
                <label for="image" class="block text-lg font-semibold text-purple-900">Gambar Hotel</label>
                <input type="file" id="image" name="img_hotel" class="w-full mt-2 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 form-control @error('img_hotel') is-invalid @enderror">
            </div>
            @error('img_hotel')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror

            <!-- Bintang -->
            <div class="mb-4">
                <label for="bintang" class="block text-lg font-semibold text-purple-900">Bintang</label>
                <div class="flex items-center space-x-2 mt-2">
                    <div id="stars" class="flex space-x-1 text-yellow-500">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star-fill cursor-pointer" data-value="{{ $i }}"></i>
                        @endfor
                    </div>
                    <input type="hidden" id="bintang" name="bintang" value="{{ old('bintang', $hotel->bintang ?? 0) }}">
                </div>
            </div>
            @error('bintang')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-600">{{ $action }} Data</button>
            </div>
        </form>
    </div>

    <!-- JavaScript untuk Input bintang -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const stars = document.querySelectorAll("#stars .bi-star-fill");
            const bintangInput = document.getElementById("bintang");

            stars.forEach((star, index) => {
                star.addEventListener("click", function () {
                    const bintang = index + 1; // Nilai bintang dari 1 hingga 5
                    bintangInput.value = bintang;

                    // Highlight bintang berdasarkan bintang yang dipilih
                    stars.forEach((s, i) => {
                        s.classList.toggle("text-yellow-500", i < bintang);
                        s.classList.toggle("text-gray-300", i >= bintang);
                    });
                });
            });
        });
    </script>
</x-admin-layout>