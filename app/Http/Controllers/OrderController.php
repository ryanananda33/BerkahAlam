<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function showProductDetail($id)
    {
        $product = Produk::with('kategori')->findOrFail($id);
        return view('customer.produk_detail', compact('product'));
    }

    public function placeOrder(Request $request, $id)
    {
        $product = Produk::findOrFail($id);

        $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
            'catatan_ukiran' => ['nullable', 'string'],
            'alamat' => ['required', 'string', 'max:500'],
        ]);

        if ($product->stok < $request->qty) {
            return back()->with('error', 'Stok produk tidak mencukupi untuk jumlah yang Anda minta.');
        }

        try {
            DB::beginTransaction();

            $total = $product->harga * $request->qty;

            // Create pesanan
            $order = Pesanan::create([
                'user_id' => Auth::id(),
                'tanggal' => now(),
                'total' => $total,
                'status' => 'pending',
                'alamat' => $request->alamat,
            ]);

            // Create detail_pesanan
            DetailPesanan::create([
                'pesanan_id' => $order->id,
                'produk_id' => $product->id,
                'qty' => $request->qty,
                'harga' => $product->harga,
                'catatan_ukiran' => $request->catatan_ukiran,
            ]);

            // Decrement product stock
            $product->decrement('stok', $request->qty);

            DB::commit();

            return redirect()->route('customer.pembayaran', $order->id)
                ->with('success', 'Pesanan Anda berhasil dibuat! Silakan lakukan pembayaran dan unggah buktinya.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda: ' . $e->getMessage());
        }
    }
}
