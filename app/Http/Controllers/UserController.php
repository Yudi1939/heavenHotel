<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hotel;
use App\Models\Pesanan;
use App\Models\chart;
use DateTime;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function landing()
    {
        return view('frontpage.user.landingpage');
    }

    function home()
    {
        $datas=Hotel::paginate(6);
        return view('frontpage.user.home', compact('datas'));
    }
    function booking($id_hotel) {
        $datas=Hotel::where('id_hotel', $id_hotel)->paginate(4);
        return view('frontpage.user.booking', compact('datas'));
    }
    function orders() {
        $datas=Pesanan::where('id', Auth::user()->id_user)->paginate(5);
        return view('frontpage.user.orders', compact('datas'));
    }

    public function search(Request $request)
    {
        $searchName = $request->input('search'); // Ambil input pencarian
        
        // Jika ada kata kunci pencarian, cari data hotel yang sesuai
        $datas = Hotel::where('cabang_hotel', 'like', '%'.$searchName.'%')->paginate(1); // Paginate hasil pencarian
        
        // Kirim hasil pencarian ke view
        return view('frontpage.user.home', compact('datas'));
    }
    
    public function filter(Request $request)
    {
        // Membuat query dasar
        $query = Hotel::query();
        
        // Mendapatkan nilai filter yang dipilih dan mengonversinya menjadi integer
        $filterValue = (int)$request->input('filter');
        
        // Menggunakan kondisi filter
        if ($filterValue == 5) {
            // Menambahkan kondisi untuk hotel dengan bintang 5
            $query->where('bintang', 5);
        } elseif ($filterValue == 4) {
            // Menambahkan kondisi untuk hotel dengan bintang 4
            $query->where('bintang', 4);
        } elseif ($filterValue == 3) {
            // Menambahkan kondisi untuk hotel dengan bintang 3
            $query->where('bintang', 3);
        }
        
        // Menjalankan query dengan paginasi
        $datas = $query->paginate(3);
        
        // Mengembalikan data ke tampilan
        return view('frontpage.user.home', compact('datas'));
    }

    public function store(Request $request, $id)
    {
        $message = [
            'required' => ':attribute wajib diisi',
        ];

        // Validasi input
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ], $message);

        $datas = Hotel::findOrFail($id);
        $userId = Auth::id();
        $check_in = new DateTime($request->check_in);
        $check_out = new DateTime($request->check_out);
        $interval = $check_in->diff($check_out);
        $days = $interval->days;
        $total = $days * $datas->price;

        // Cek aksi berdasarkan tombol yang ditekan
        if ($request->action === 'chart') {
            chart::create([
                'id_hotel' => $datas->id_hotel,
                'id' => $userId,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'total' => $total,
            ]);
        } elseif ($request->action === 'order') {
            // Proses pemesanan atau reservasi
            Pesanan::create([
                'id_hotel' => $datas->id_hotel,
                'id' => $userId,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'total' => $total,
            ]);
        }

        return redirect()->route('homeUser')->with(['success' => 'Pemesanan Berhasil!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
