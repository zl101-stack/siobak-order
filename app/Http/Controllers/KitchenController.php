<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        $pendingOrders   = Order::with('items.menu')->where('status', 'pending')->orderBy('created_at', 'asc')->get();
        $preparingOrders = Order::with('items.menu')->where('status', 'preparing')->orderBy('created_at', 'asc')->get();
        $readyOrders     = Order::with('items.menu')->where('status', 'ready')->orderBy('created_at', 'asc')->get();
        $doneOrders      = Order::with('items.menu')->where('status', 'done')->whereDate('created_at', today())->orderBy('created_at', 'desc')->take(10)->get();

        return view('kitchen.index', compact('pendingOrders', 'preparingOrders', 'readyOrders', 'doneOrders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $nextStatus = match ($order->status) {
            'pending'   => 'preparing',
            'preparing' => 'ready',
            'ready'     => 'done',
            default     => $order->status,
        };

        $order->update(['status' => $nextStatus]);

        return response()->json([
            'success'    => true,
            'new_status' => $nextStatus,
            'message'    => 'Status pesanan diperbarui: ' . $order->status_label,
        ]);
    }

    // Polling: ambil order baru sejak timestamp tertentu
    public function newOrders(Request $request)
    {
        $since = $request->input('since');

        $query = Order::with('items.menu');

        if ($since) {
            $query->where('created_at', '>', $since);
        } else {
            $query->where('created_at', '>', now()->subMinutes(5));
        }

        $orders = $query->where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'count'  => $orders->count(),
            'orders' => $orders->map(function ($o) {
                return [
                    'id'            => $o->id,
                    'table_number'  => $o->table_number,
                    'customer_name' => $o->customer_name,
                    'total'         => $o->total,
                    'item_count'    => $o->items->count(),
                    'created_at'    => $o->created_at->toIso8601String(),
                ];
            }),
        ]);
    }

    // Semua order aktif (untuk refresh tampilan kitchen)
    public function allOrders()
    {
        $orders = Order::with('items.menu')
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($orders->map(function ($o) {
            return [
                'id'            => $o->id,
                'table_number'  => $o->table_number,
                'customer_name' => $o->customer_name,
                'status'        => $o->status,
                'total'         => $o->total,
                'created_at'    => $o->created_at->diffForHumans(),
            ];
        }));
    }

    // Ganti nomor meja dari kitchen (jika customer salah input)
    public function updateTable(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'table_number' => 'required|integer|min:1|max:100',
        ]);

        $oldTable = $order->table_number;
        $order->update(['table_number' => $request->table_number]);

        return response()->json([
            'success'    => true,
            'old_table'  => $oldTable,
            'new_table'  => $order->table_number,
            'message'    => "Meja order #{$order->id} diubah dari Meja {$oldTable} ke Meja {$order->table_number}",
        ]);
    }
}
