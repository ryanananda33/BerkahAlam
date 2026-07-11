<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Pesanan::where('status', 'selesai')->sum('total');
        $totalOrders = Pesanan::count();
        $totalProducts = Produk::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Pesanan::with(['user', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $statusCounts = [
            'pending' => Pesanan::where('status', 'pending')->count(),
            'diverifikasi' => Pesanan::where('status', 'diverifikasi')->count(),
            'diproses' => Pesanan::where('status', 'diproses')->count(),
            'selesai' => Pesanan::where('status', 'selesai')->count(),
            'ditolak' => Pesanan::where('status', 'ditolak')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalRevenue', 
            'totalOrders', 
            'totalProducts', 
            'totalCustomers', 
            'recentOrders',
            'statusCounts'
        ));
    }
}
