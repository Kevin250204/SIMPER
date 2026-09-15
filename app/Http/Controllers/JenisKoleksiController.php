<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\JenisKoleksi;
use App\Models\KategoriKoleksi;

class JenisKoleksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $jenis = JenisKoleksi::when($search, function ($query) use ($search) {
            $query->where('nama_jenis', 'like', "%{$search}%");
        })
            ->orderBy('nama_jenis')
            ->paginate(10);

        return view('admin.jenis-koleksi.index', compact('jenis'));
    }

    public function create()
    {
        return view('admin.jenis-koleksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|unique:jenis_koleksi,nama_jenis|max:100'
        ], [
            'nama_jenis.required' => 'Nama jenis koleksi wajib diisi.',
            'nama_jenis.unique' => 'Nama jenis koleksi sudah ada.',
            'nama_jenis.max' => 'Nama jenis koleksi maksimal 100 karakter.'
        ]);

        JenisKoleksi::create([
            'nama_jenis' => $request->nama_jenis
        ]);

        return redirect()
            ->route('jenis-koleksi.index')
            ->with('success', 'Jenis koleksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenis = JenisKoleksi::findOrFail($id);

        return view(
            'admin.jenis-koleksi.edit',
            compact('jenis')
        );
    }

    public function update(Request $request, $id)
    {
        $jenis = JenisKoleksi::findOrFail($id);

        $request->validate([
            'nama_jenis' => 'required|max:100|unique:jenis_koleksi,nama_jenis,' . $id . ',id_jenis'
        ], [
            'nama_jenis.required' => 'Nama jenis koleksi wajib diisi.',
            'nama_jenis.unique' => 'Nama jenis koleksi sudah digunakan.',
            'nama_jenis.max' => 'Nama jenis koleksi maksimal 100 karakter.'
        ]);

        $jenis->update([
            'nama_jenis' => trim($request->nama_jenis)
        ]);

        return redirect()
            ->route('jenis-koleksi.index')
            ->with('success', 'Jenis koleksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenis = JenisKoleksi::findOrFail($id);

        if ($jenis->kategori()->count() > 0) {

            return redirect()
                ->route('jenis-koleksi.index')
                ->with(
                    'error',
                    'Jenis koleksi tidak dapat dihapus karena masih digunakan oleh kategori koleksi.'
                );
        }

        $jenis->delete();

        return redirect()
            ->route('jenis-koleksi.index')
            ->with(
                'success',
                'Jenis koleksi berhasil dihapus.'
            );
    }
}