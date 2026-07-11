<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminKategoriController extends Controller
{
    public function index()
    {
        $categories = Kategori::withCount('produk')->get();
        return view('admin.kategori.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori'],
        ]);

        Kategori::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $category = Kategori::findOrFail($id);

        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori,nama,' . $category->id],
        ]);

        $category->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $category = Kategori::findOrFail($id);
        
        if ($category->produk()->count() > 0) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk terkait.');
        }

        $category->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
