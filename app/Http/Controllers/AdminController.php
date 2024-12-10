<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Hotel;
use App\Models\Pesanan;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        $datas=Hotel::paginate(3);
        return view('frontpage.admin.home', compact('datas'));
    }

    public function user()
    {
        $datas=User::paginate(10);
        return view('frontpage.admin.daftarUser', compact( 'datas'));
    }

    public function pesanan()
    {
        $datas=Pesanan::paginate(50);
        return view('frontpage.admin.daftarPesanan', compact( 'datas'));
    }
    
    public function search(Request $request)
    {
        $searchName = $request->input('search'); // Ambil input pencarian
        
        // Jika ada kata kunci pencarian, cari data hotel yang sesuai
        $datas = Hotel::where('cabang_hotel', 'like', '%'.$searchName.'%')->paginate(1); // Paginate hasil pencarian
        
        // Kirim hasil pencarian ke view
        return view('frontpage.admin.home', compact('datas'));
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
        return view('frontpage.admin.home', compact('datas'));
    }
    
    /**
     * Show the form for creating a new resource. 
     */
    public function create()
    {
        $action='Tambah';
        $rute=route('store');
        return view('frontpage.admin.formHotel', compact('action', 'rute'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'required' => ':attribute wajib diisi',
            'numeric' => ':attribute harus berupa angka',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa file dengan ekstensi jpg, png, atau jpeg',
            'max' => ':attribute tidak boleh lebih dari :max kilobytes',
        ];

        // Validate the incoming request
        $request->validate([
            'cabang_hotel' => 'required',
            'desc_hotel' => 'required',
            'price' => 'required|numeric',
            'img_hotel' => 'required|image|mimes:jpeg,jpg,png|max:3048',
            'bintang' => 'required|numeric|min:1|max:5', // Validasi untuk bintang
        ], $message);

        //upload image
        $image = $request->file('img_hotel');
        $nameImage = time() . $request->file('img_hotel')->getClientOriginalName();
        $image->storeAs('hotel', $nameImage, 'public');

        //create hotel
        Hotel::create([
            'cabang_hotel' => $request->cabang_hotel,
            'desc_hotel' => $request->desc_hotel,
            'price' => $request->price,
            'bintang' => $request->bintang, // Simpan bintang
            'img_hotel' => $nameImage,
        ]);

        return redirect()->route('homeAdmin')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hotel=Hotel::findOrFail($id);
        return view('frontpage.admin.detailHotel', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hotel=Hotel::findOrFail($id);
        $action='Edit';
        $rute=route('update', $id);
        return view('frontpage.admin.formHotel', compact('hotel', 'action', 'rute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'cabang_hotel' => 'required',
            'desc_hotel' => 'required',
            'price' => 'required|numeric',
            'bintang' => 'required|numeric|min:1|max:5', // Validasi untuk bintang
            'img_hotel' => 'image|mimes:jpeg,jpg,png|max:3048',
        ]);
    
        $hotel = Hotel::findOrFail($id);
    
        if ($request->hasFile('img_hotel')) {
            $image = $request->file('img_hotel');
            $image->storeAs('hotel', $image->getClientOriginalName(), 'public');
            Storage::disk('public')->delete('hotel/' . $hotel->img_hotel);
        
            $hotel->update([
                'cabang_hotel' => $request->cabang_hotel,
                'desc_hotel' => $request->desc_hotel,
                'price' => $request->price,
                'bintang' => $request->bintang, // Update bintang
                'img_hotel' => $image->getClientOriginalName(),
            ]);
        } else {
            $hotel->update([
                'cabang_hotel' => $request->cabang_hotel,
                'desc_hotel' => $request->desc_hotel,
                'price' => $request->price,
                'bintang' => $request->bintang, // Update bintang
            ]);
        }
    
        return redirect()->route('homeAdmin')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Hotel::find($id);
            $data->delete();
            return redirect('admin/home');
        } catch (\Throwable $th) {
            return redirect('admin/home');
        }
    }

    public function deleteMultiple(Request $request)
    {
        try {
            // Ambil semua ID yang dipilih
            $ids = $request->input('selected');

            // Validasi jika tidak ada yang dipilih
            if (empty($ids)) {
                return redirect('admin/home')->with('error', 'Tidak ada data yang dipilih.');
            }

            // Hapus data berdasarkan ID
            Hotel::whereIn('id_hotel', $ids)->delete();

            return redirect('admin/home')->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect('admin/home')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}