<div class="order-card" id="order-{{ $order->id }}" data-id="{{ $order->id }}">
    <div class="card-header">
        <span class="card-order-num">#{{ $order->id }}</span>
        <div style="display:flex; align-items:center; gap:6px;">
            <span class="card-table" id="table-label-{{ $order->id }}">🪑 Meja {{ $order->table_number }}</span>
            @if($action !== 'done')
                <button
                    class="edit-table-btn"
                    onclick="openEditTable({{ $order->id }}, {{ $order->table_number }})"
                    title="Ganti nomor meja">
                    ✏️
                </button>
            @endif
        </div>
    </div>

    <div class="card-customer">{{ $order->customer_name ?? 'Tanpa Nama' }}</div>
    <div class="card-time">🕒 {{ $order->created_at->diffForHumans() }}</div>

    <div class="card-items">
        @foreach($order->items as $item)
            <div class="card-item">
                <div class="item-name-qty">
                    <span class="qty-badge">×{{ $item->qty }}</span>
                    {{ $item->menu->name ?? 'Menu dihapus' }}
                </div>
                <span style="color:#64748B; font-size:11px">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
    </div>

    @if($order->notes)
        <div class="card-notes">📝 {{ $order->notes }}</div>
    @endif

    <div class="card-total">
        <span>Total</span>
        <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
    </div>

    @if($action === 'accept')
        <button class="card-action-btn btn-accept" onclick="updateStatus({{ $order->id }}, this)">
            👍 Terima Pesanan
        </button>
    @elseif($action === 'process')
        <button class="card-action-btn btn-process" onclick="updateStatus({{ $order->id }}, this)">
            ✅ Tandai Siap
        </button>
    @elseif($action === 'ready')
        <button class="card-action-btn btn-ready" onclick="updateStatus({{ $order->id }}, this)">
            🎉 Selesaikan
        </button>
    @else
        <div class="card-action-btn btn-done" style="cursor:default">
            ✓ Selesai
        </div>
    @endif
</div>
