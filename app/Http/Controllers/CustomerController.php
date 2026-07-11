<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $orders = Pesanan::where('user_id', Auth::id())
            ->with(['detailPesanan.produk', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_orders' => $orders->count(),
            'pending' => $orders->where('status', 'pending')->count(),
            'processed' => $orders->where('status', 'diproses')->count(),
            'completed' => $orders->where('status', 'selesai')->count(),
        ];

        return view('customer.dashboard', compact('orders', 'stats'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        // We are updating the authenticated user, which is a User model.
        // In Laravel, Auth::user() returns an Authenticatable instance, but we can update it directly.
        /** @var \App\Models\User $user */
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('customer.profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function uploadPaymentForm($id)
    {
        $order = Pesanan::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('customer.dashboard')->with('error', 'Pesanan ini tidak memerlukan pembayaran atau sudah diverifikasi.');
        }

        return view('customer.pembayaran', compact('order'));
    }

    public function storePayment(Request $request, $id)
    {
        $order = Pesanan::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('customer.dashboard')->with('error', 'Pesanan ini tidak memerlukan pembayaran atau sudah diverifikasi.');
        }

        $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'max:10240'], // Max 10MB image
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $image = $request->file('bukti_pembayaran');
            $imageName = 'bukti_' . $order->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            
            // Save to public storage
            $image->move(public_path('uploads/bukti_pembayaran'), $imageName);

            // Update or create pembayaran
            Pembayaran::updateOrCreate(
                ['pesanan_id' => $order->id],
                [
                    'bukti_pembayaran' => 'uploads/bukti_pembayaran/' . $imageName,
                    'tanggal_bayar' => now(),
                    'status' => 'pending'
                ]
            );

            return redirect()->route('customer.dashboard')->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi admin.');
        }

        return back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Pesanan::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'alamat' => ['required', 'string'],
            'details' => ['required', 'array'],
            'details.*.id' => ['required', 'exists:detail_pesanan,id'],
            'details.*.qty' => ['required', 'integer', 'min:1'],
            'details.*.catatan_ukiran' => ['nullable', 'string'],
        ]);

        $newTotal = 0;
        foreach ($request->details as $detailData) {
            $detail = $order->detailPesanan()->findOrFail($detailData['id']);
            $newTotal += $detail->harga * $detailData['qty'];
            
            $detail->update([
                'qty' => $detailData['qty'],
                'catatan_ukiran' => $detailData['catatan_ukiran'],
            ]);
        }

        $oldTotal = $order->total;
        if ($oldTotal != $newTotal && $order->pembayaran) {
            $bukti = $order->pembayaran->bukti_pembayaran;
            if ($bukti && \Illuminate\Support\Facades\File::exists(public_path($bukti))) {
                \Illuminate\Support\Facades\File::delete(public_path($bukti));
            }
            $order->pembayaran()->delete();
        }

        $order->update([
            'alamat' => $request->alamat,
            'total' => $newTotal,
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Pesanan Anda berhasil diperbarui!');
    }
}
