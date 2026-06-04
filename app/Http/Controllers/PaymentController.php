<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Tampilkan halaman QRIS simulasi
    public function index($orderId)
    {
        $order = Order::with('items.menu')->findOrFail($orderId);

        if ($order->payment_status === 'paid') {
            return redirect()->route('order.show', $order->id)
                ->with('info', 'Pesanan ini sudah dibayar.');
        }

        // Generate QR code content (simulasi)
        $qrContent = 'QRIS-SIOBAK-ORDER-' . $order->id . '-' . $order->payment_token . '-' . $order->total;

        return view('payment.index', compact('order', 'qrContent'));
    }

    // Simulasi pembayaran berhasil
    public function simulatePay($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'status'         => $order->status === 'pending' ? 'pending' : $order->status,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil disimulasikan!',
            'order_id' => $order->id,
        ]);
    }

    // Cek status pembayaran (polling dari halaman payment)
    public function checkStatus($orderId)
    {
        $order = Order::findOrFail($orderId);

        return response()->json([
            'payment_status' => $order->payment_status,
            'is_paid'        => $order->payment_status === 'paid',
        ]);
    }
}
