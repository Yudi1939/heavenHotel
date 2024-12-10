<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: Karla; }
        .bg-sidebar { background: #6b21a8; } /* purple-700 */
        .hover-bg { background: #5a189a; } /* darker purple for hover */
        .cta-btn { color: #6b21a8; }
        .cta-btn:hover { background: #5a189a; color: #fff; }
        .nav-item:hover, .active-nav-link { background: #5a189a; }
        .account-link:hover { background: #6b21a8; color: #fff; }
        .dropdown-menu { display: none; position: absolute; right: 0; top: 100%; background: #fff; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15); z-index: 1000; }
        .dropdown-menu a { color: #6b21a8; padding: 10px 15px; display: block; text-decoration: none; }
        .dropdown-menu a:hover { background: #f1f1f1; color: #5a189a; }
    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">
    <x-admin-layout>
        <form action="{{ route('deleteMultiple') }}" method="POST">
            @csrf
            <div id="daftarHotel" class="rounded-lg flex flex-col bg-white shadow-lg p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-purple-700">Daftar Hotel</h2>
                    <div class="flex space-x-2">
                        <button 
                            type="submit" 
                            class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600" 
                            id="deleteAllBtn">
                            Hapus
                        </button>
                        <a 
                            href="{{ route('create') }}" 
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                            Tambah
                        </a>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-300 rounded-lg shadow-md">
                        <thead class="bg-purple-700 text-white">
                            <tr>
                                <th class="p-3">
                                    <input type="checkbox" id="selectAll" class="rounded focus:ring-purple-500">
                                </th>
                                <th class="p-3">Cabang Hotel</th>
                                <th class="p-3">Harga Sewa</th>
                                <th class="p-3">Deskripsi</th>
                                <th class="p-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $item)
                                <tr class="odd:bg-gray-100 even:bg-white border-b">
                                    <td class="p-3 text-center">
                                        <input type="checkbox" name="selected[]" value="{{ $item->id_hotel }}" class="rounded focus:ring-purple-500">
                                    </td>
                                    <td class="p-3">{{ $item->cabang_hotel }}</td>
                                    <td class="p-3">{{ 'Rp '.number_format($item->price) }}</td>
                                    <td class="p-3">{{ $item->desc_hotel }}</td>
                                    <td class="p-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a 
                                                href="{{ route('edit', $item->id_hotel) }}" 
                                                class="bg-yellow-500 text-white font-bold py-2 px-4 rounded hover:bg-yellow-600">
                                                Edit
                                            </a>
                                            <a 
                                                href="{{ route('destroy', $item->id_hotel) }}" 
                                                class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600 delete-btn">
                                                Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-end mt-4">
                    <div class="inline-flex space-x-2 bg-gray-100 p-2 rounded-lg shadow-md">
                        {{ $datas->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </form>
    </x-admin-layout>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.js"></script>

    <script>
        // Select All Checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Ganti konfirmasi tradisional dengan SweetAlert2 untuk Hapus
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Mencegah aksi default (mengarahkan ke link)
                const form = this.closest('form'); // Mendapatkan form tempat tombol berada

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Jika dikonfirmasi, kirim form
                    }
                });
            });
        });

        // Ganti konfirmasi untuk tombol Hapus Semua
        document.getElementById('deleteAllBtn').addEventListener('click', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus Semua',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit(); // Kirim form jika dikonfirmasi
                }
            });
        });
    </script>
</body>
</html>