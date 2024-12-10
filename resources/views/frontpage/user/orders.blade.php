<x-user-layout>
    <div class="border-black m-3 rounded-lg">
        <h1 class="text-3xl font-bold text-purple-700 mb-3">Orders</h1>
        <table>
            <thead>
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Cabang Hotel</th>
                    <th class="px-4 py-2">Check In</th>
                    <th class="px-4 py-2">Check Out</th>
                </tr>
            </thead>
            <tbody>
                <?php $idx = 0; ?>
                @foreach ($datas as $item)
                    @if ($item->status == 'Waiting')
                        <tr>
                            <td class="border px-4 py-2">{{ ++$idx }}</td>
                            <td class="border px-4 py-2">{{ $item->hotel->cabang_hotel }}</td>
                            <td class="border px-4 py-2">{{ $item->check_in }}</td>
                            <td class="border px-4 py-2">{{ $item->check_out }}</td>
                        </tr>
                    @endif
                @endforeach                
            </tbody>
        </table>
    </div>
</x-user-layout>