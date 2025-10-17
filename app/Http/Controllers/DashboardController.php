<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * 🔹 Menampilkan halaman utama dashboard.
     */
    public function index()
    {
        // Hitung jumlah servis berdasarkan status
        $jumlahServis = Service::count();
        $menunggu     = Service::where('status', 'accepted')->count();
        $diproses     = Service::where('status', 'process')->count();
        $selesai      = Service::where('status', 'finished')->count();
        $diambil      = Service::where('status', 'taken')->count();
        $batal        = Service::where('status', 'cancelled')->count();

        // Ambil 5 servis terbaru, lengkap dengan relasi
        $riwayat = Service::with(['handphone', 'customer'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Pastikan data customer tetap aman
        foreach ($riwayat as $service) {
            if (is_string($service->customer)) {
                $decoded = json_decode($service->customer, true);
                $service->customer_name = $decoded['name'] ?? '-';
            } else {
                $service->customer_name = $service->customer->name ?? '-';
            }
        }

        // Kirim semua data ke view
        return view('page.dashboard.index', compact(
            'jumlahServis',
            'menunggu',
            'diproses',
            'selesai',
            'diambil',
            'batal',
            'riwayat'
        ));
    }
}
