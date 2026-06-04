<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'table_number'  => 'required|integer|min:1|max:100',
            'customer_name' => 'required|string|max:100',
            'notes'         => 'nullable|string|max:500',
            'items'         => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.qty'     => 'required|integer|min:1|max:50',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $menu = Menu::lockForUpdate()->findOrFail($item['menu_id']);

                if ($menu->stock < $item['qty']) {
                    DB::rollBack();
                    return back()->withErrors([
                        'stock' => "Stok {$menu->name} tidak cukup. Sisa stok: {$menu->stock}"
                    ])->withInput();
                }

                $subtotal = $menu->price * $item['qty'];
                $total += $subtotal;

                $orderItems[] = [
                    'menu_id'  => $menu->id,
                    'qty'      => $item['qty'],
                    'price'    => $menu->price,
                    'subtotal' => $subtotal,
                ];

                // Kurangi stok
                $menu->decrement('stock', $item['qty']);
            }

            // Buat order
            $order = Order::create([
                'table_number'   => $request->table_number,
                'customer_name'  => $request->customer_name,
                'notes'          => $request->notes,
                'status'         => 'pending',
                'total'          => $total,
                'payment_status' => 'unpaid',
                'payment_method' => 'qris',
                'payment_token'  => 'SIM-' . strtoupper(uniqid()),
            ]);

            // Simpan order items
            foreach ($orderItems as &$oi) {
                $oi['order_id'] = $order->id;
                $oi['created_at'] = now();
                $oi['updated_at'] = now();
            }
            OrderItem::insert($orderItems);

            DB::commit();

            return redirect()->route('order.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan ke pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.'])->withInput();
        }
    }

    public function show($id)
    {
        $order = Order::with(['items.menu'])->findOrFail($id);
        return view('order.show', compact('order'));
    }

    // API endpoint untuk kitchen polling (cek order baru)
    public function latestOrders(Request $request)
    {
        $since = $request->input('since', now()->subMinutes(60)->toIso8601String());

        $orders = Order::with('items.menu')
            ->where('created_at', '>', $since)
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    // Cek status order (untuk polling dari halaman customer)
    public function status($id)
    {
        $order = Order::findOrFail($id);
        return response()->json([
            'status'         => $order->status,
            'status_label'   => $order->status_label,
            'payment_status' => $order->payment_status,
        ]);
    }
}
