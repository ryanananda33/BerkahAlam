<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPesananController extends Controller
{
    public function index()
    {
        $orders = Pesanan::with(['user', 'pembayaran'])->orderBy('created_at', 'desc')->get();
        return view('admin.pesanan.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Pesanan::with(['user', 'pembayaran', 'detailPesanan.produk'])->findOrFail($id);
        return view('admin.pesanan.show', compact('order'));
    }

    public function verifyPayment(Request $request, $id)
    {
        $order = Pesanan::with('pembayaran')->findOrFail($id);
        
        if (!$order->pembayaran) {
            return back()->with('error', 'Pesanan ini belum memiliki bukti pembayaran.');
        }

        $request->validate([
            'action' => ['required', 'in:verify,reject'],
        ]);

        if ($request->action === 'verify') {
            $order->pembayaran->update(['status' => 'diverifikasi']);
            $order->update(['status' => 'diverifikasi']);
            return back()->with('success', 'Pembayaran berhasil diverifikasi! Status pesanan berubah menjadi Diverifikasi.');
        } else {
            $order->pembayaran->update(['status' => 'ditolak']);
            $order->update(['status' => 'ditolak']);
            return back()->with('success', 'Pembayaran ditolak! Status pesanan berubah menjadi Ditolak.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Pesanan::findOrFail($id);

        $request->validate([
            'status' => ['required', 'in:pending,diverifikasi,diproses,selesai,ditolak'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . ucfirst($request->status) . '!');
    }

    public function update(Request $request, $id)
    {
        try {
            $order = Pesanan::with('detailPesanan')->findOrFail($id);

            $request->validate([
                'alamat' => ['required', 'string'],
                'total' => ['required', 'numeric', 'min:0'],
                'details' => ['required', 'array'],
                'details.*.id' => ['required', 'exists:detail_pesanan,id'],
                'details.*.qty' => ['required', 'integer', 'min:1'],
                'details.*.catatan_ukiran' => ['nullable', 'string'],
            ]);

            $order->update([
                'alamat' => $request->alamat,
                'total' => $request->total,
            ]);

            foreach ($request->details as $detailData) {
                $detail = $order->detailPesanan()->findOrFail($detailData['id']);
                $detail->update([
                    'qty' => $detailData['qty'],
                    'catatan_ukiran' => $detailData['catatan_ukiran'],
                ]);
            }

            return back()->with('success', 'Detail pesanan berhasil diperbarui!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal edit pesanan: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui pesanan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $order = Pesanan::findOrFail($id);
        
        $order->detailPesanan()->delete();
        if ($order->pembayaran) {
            $bukti = $order->pembayaran->bukti_pembayaran;
            if ($bukti && \Illuminate\Support\Facades\File::exists(public_path($bukti))) {
                \Illuminate\Support\Facades\File::delete(public_path($bukti));
            }
            $order->pembayaran()->delete();
        }
        
        $order->delete();

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    public function exportPdf($id)
    {
        $order = Pesanan::with(['user', 'pembayaran', 'detailPesanan.produk'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.pesanan.pdf', compact('order'));
        return $pdf->download('Invoice-BA-' . $order->id . '.pdf');
    }
}
