<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index()
    {
        $appUrl    = config('app.url');
        $qrUrl     = $appUrl . '/';
        $totalMenus    = Menu::count();
        $totalOrders   = Order::whereDate('created_at', today())->count();
        $totalRevenue  = Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total');

        return view('admin.qrcode.index', compact('qrUrl', 'totalMenus', 'totalOrders', 'totalRevenue'));
    }

    public function generate()
    {
        $appUrl = config('app.url');
        $qrUrl  = $appUrl . '/';

        $qrCode = QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H')
            ->generate($qrUrl);

        return response($qrCode, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="siobak-qr-meja.svg"');
    }
}
