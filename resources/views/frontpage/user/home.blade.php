<x-user-layout>
    <div class="w-full items-center justify-center text-center">
        <h1 class="text-3xl font-bold text-purple-700 mb-3">Welcome to Heaven Hotel</h1>
        <p class="text-gray-700 mb-6">The Best Hotels in History</p>
    </div>
    <div class="flex flex-wrap w-full items-center justify-center mx-auto p-6 gap-4">
        @foreach ($datas as $item)
            <div class="flex flex-col justify-between w-1/4 h-72 bg-white border border-black rounded-lg shadow-lg p-6 text-center">
                <div>
                    <img src="{{ asset($item->path.$item->img_hotel) }}" alt="gambar_hotel" class="w-full h-32">
                    <h2 class="text-xl font-bold text-purple-700">{{$item->cabang_hotel}}</h2>
                </div>
                <div>
                    <?php for ($star = 1; $star <= $item->bintang; $star++) { ?>
                        <i class="bi bi-star-fill" style="color: gold"></i>
                    <?php } ?>
                </div>
                <a href="{{route('bookingUser',$item->id_hotel)}}" class="bg-purple-500 text-white py-3 px-5 rounded-lg hover:bg-purple-600">
                    Reserve Now
                </a>
            </div>
        @endforeach
    </div>
    <!-- Pagination -->
    <div class="flex justify-center mt-4">
        <div class="inline-flex space-x-2 bg-gray-100 p-2 rounded-lg shadow-md">
            {{ $datas->links() }}
        </div>
    </div>
</x-user-layout>