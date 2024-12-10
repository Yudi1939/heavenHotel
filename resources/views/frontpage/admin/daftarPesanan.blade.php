<x-admin-layout>
    <div id="daftarPesanan" class="rounded-lg flex flex-col w-full">
        <div class="flex flex-row justify-between">
            <h2 class="text-2xl font-bold text-purple-700 m-2 ">Daftar Pesanan</h2>
            <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded m-2 hover:bg-blue-600">Tambah</button>
        </div>
        <table class="border border-black border-collapse w-full">
            <thead>
                <tr>
                    <th class="border border-black p-2">No</th>
                    <th class="border border-black p-2">Nama Pemesan</th>
                    <th class="border border-black p-2">Hotel</th>
                    <th class="border border-black p-2">Check In</th>
                    <th class="border border-black p-2">Check Out</th>
                    <th class="border border-black p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $idx = 0; ?>
                @foreach ($datas as $item)
                    <tr class="border border-black">
                        <td class="border border-black p-2">{{ ++$idx }}</td>
                        <td class="border border-black p-2">{{ $item->user->name }}</td>
                        <td class="border border-black p-2">{{ $item->hotel->cabang_hotel }}</td>
                        <td class="border border-black p-2">{{ $item->check_in }}</td>
                        <td class="border border-black p-2">{{ $item->check_out }}</td>
                        <td class="p-2 flex flex-row gap-2">
                            <button class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">Konfirmasi</button>
                            <button class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600">Tolak</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>