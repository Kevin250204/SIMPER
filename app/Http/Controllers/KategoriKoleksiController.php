<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriKoleksi;
use App\Models\JenisKoleksi;

class KategoriKoleksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KategoriKoleksi::with('jenis');

        if ($request->filled('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        $kategori = $query->paginate(10);

        return view('admin.kategori-koleksi.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenis = JenisKoleksi::orderBy('nama_jenis')->get();

        return view('admin.kategori-koleksi.create', compact('jenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_jenis' => 'required|exists:jenis_koleksi,id_jenis',
            'nama_kategori' => 'required|max:100',
        ], [
            'id_jenis.required' => 'Jenis koleksi wajib dipilih.',
            'id_jenis.exists' => 'Jenis koleksi tidak ditemukan.',

            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        KategoriKoleksi::create([
            'id_jenis' => $request->id_jenis,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()
            ->route('kategori-koleksi.index')
            ->with('success', 'Kategori koleksi berhasil ditambahkan.');
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
    public function edit($id)
    {
        $kategori = KategoriKoleksi::findOrFail($id);

        $jenis = JenisKoleksi::orderBy('nama_jenis')->get();

        return view(
            'admin.kategori-koleksi.edit',
            compact('kategori', 'jenis')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_jenis' => 'required|exists:jenis_koleksi,id_jenis',
            'nama_kategori' => 'required|max:100',
        ], [
            'id_jenis.required' => 'Jenis koleksi wajib dipilih.',
            'id_jenis.exists' => 'Jenis koleksi tidak ditemukan.',

            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        $kategori = KategoriKoleksi::findOrFail($id);

        $kategori->update([
            'id_jenis' => $request->id_jenis,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()
            ->route('kategori-koleksi.index')
            ->with('success', 'Kategori koleksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = KategoriKoleksi::findOrFail($id);

        // Cek apakah kategori masih dipakai
        if ($kategori->koleksi()->count() > 0) {

            return redirect()
                ->route('kategori-koleksi.index')
                ->with('error', 'Kategori koleksi tidak dapat dihapus karena masih digunakan oleh data koleksi.');

        }

        $kategori->delete();

        return redirect()
            ->route('kategori-koleksi.index')
            ->with('success', 'Kategori koleksi berhasil dihapus.');
    }
}