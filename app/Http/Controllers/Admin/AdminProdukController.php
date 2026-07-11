<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminProdukController extends Controller
{
    public function index()
    {
        $products = Produk::with('kategori')->get();
        $categories = Kategori::all();
        return view('admin.produk.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => ['required', 'exists:kategori,id'],
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['required', 'image', 'max:10240'], // image, max 10MB
        ]);

        $imagePath = null;
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = 'produk_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/produk'), $imageName);
            $imagePath = 'uploads/produk/' . $imageName;
        }

        Produk::create([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'gambar' => $imagePath,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $product = Produk::findOrFail($id);

        $request->validate([
            'kategori_id' => ['required', 'exists:kategori,id'],
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'max:10240'],
        ]);

        $imagePath = $product->gambar;
        if ($request->hasFile('gambar')) {
            // Delete old file
            if ($product->gambar && File::exists(public_path($product->gambar))) {
                File::delete(public_path($product->gambar));
            }

            $image = $request->file('gambar');
            $imageName = 'produk_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/produk'), $imageName);
            $imagePath = 'uploads/produk/' . $imageName;
        }

        $product->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'gambar' => $imagePath,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Produk::findOrFail($id);

        if ($product->gambar && File::exists(public_path($product->gambar))) {
            File::delete(public_path($product->gambar));
        }

        $product->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
