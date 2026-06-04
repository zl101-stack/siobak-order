<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Status Pesanan #{{ $order->id }} | Sio Bak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --orange: #FF6B35;
            --orange-dark: #E85A24;
            --orange-light: #FFF0EB;
            --dark: #1A1A2E;
            --cream: #FFF8F5;
            --gray: #F4F4F4;
            --green: #10B981;
            --blue: #3B82F6;
            --yellow: #F59E0B;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        body { font-family: 'Poppins', sans-serif; background: var(--gray); min-height: 100vh; padding-bottom: 100px; }

        .header {
            background: linear-gradient(135deg, var(--dark), #16213E);
            color: white; padding: 16px 18px;
            display: flex; align-items: center; gap: 12px;
        }
        .header-title { font-size: 17px; font-weight: 700; }
        .header-sub { font-size: 12px; color: rgba(255,255,255,0.6); margin-top: 2px; }

        .content { padding: 18px; }

        .card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: var(--shadow);
        }
        .card-title { font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }

        /* Status Banner */
        .status-banner {
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 16px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .status-banner.pending   { background: linear-gradient(135deg, #FEF3C7, #FDE68A); }
        .status-banner.preparing { background: linear-gradient(135deg, #DBEAFE, #BFDBFE); }
        .status-banner.ready     { background: linear-gradient(135deg, #D1FAE5, #A7F3D0); }
        .status-banner.done      { background: linear-gradient(135deg, #F3F4F6, #E5E7EB); }

        .status-icon { font-size: 56px; margin-bottom: 12px; animation: statusBounce 2s ease-in-out infinite; }
        @keyframes statusBounce { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

        .status-label {
            font-size: 20px; font-weight: 800; color: var(--dark);
            margin-bottom: 6px;
        }
        .status-desc { font-size: 13px; color: #666; }

        /* Timeline */
        .timeline { display: flex; flex-direction: column; gap: 0; }
        .timeline-item {
            display: flex; gap: 14px;
            position: relative;
        }
        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 15px; top: 36px;
            width: 2px; height: calc(100% - 12px);
            background: #eee;
        }
        .timeline-item.done-step::after { background: var(--orange); }

        .tl-dot {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: #eee;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            z-index: 1;
            transition: all 0.5s;
        }
        .tl-dot.active { background: var(--orange); box-shadow: 0 0 0 6px rgba(255,107,53,0.2); }
        .tl-dot.completed { background: var(--green); }

        .tl-content { padding: 6px 0 20px; }
        .tl-title { font-size: 14px; font-weight: 700; color: var(--dark); }
        .tl-sub { font-size: 12px; color: var(--text-light, #888); margin-top: 2px; }

        /* Order items */
        .order-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0; }
        .order-item:last-child { border-bottom: none; }
        .item-name { font-size: 13px; font-weight: 600; }
        .item-qty { font-size: 12px; color: #888; }
        .item-price { font-size: 13px; font-weight: 700; color: var(--orange); }

        .total-row { display: flex; justify-content: space-between; padding-top: 12px; border-top: 2px dashed #eee; margin-top: 4px; }
        .total-label { font-size: 14px; font-weight: 600; color: #888; }
        .total-amount { font-size: 20px; font-weight: 800; color: var(--dark); }

        /* Payment Status */
        .payment-status {
            display: flex; align-items: center; justify-content: space-between;
            background: var(--cream);
            border-radius: 14px;
            padding: 16px;
        }
        .ps-left { display: flex; align-items: center; gap: 10px; }
        .ps-icon { font-size: 28px; }
        .ps-label { font-size: 12px; color: #888; }
        .ps-val { font-size: 15px; font-weight: 700; }
        .ps-val.paid { color: var(--green); }
        .ps-val.unpaid { color: var(--orange); }

        /* Pay Button */
        .btn-pay {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #1A1A2E, #16213E);
            color: white; border: none;
            border-radius: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px; font-weight: 700;
            cursor: pointer;
            margin-top: 12px;
            transition: all 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-pay:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }

        .btn-back-menu {
            display: block; width: 100%;
            padding: 16px;
            background: var(--orange-light);
            color: var(--orange);
            border: none; border-radius: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px; font-weight: 700;
            text-align: center; text-decoration: none;
            margin-top: 10px;
            transition: all 0.3s;
        }
        .btn-back-menu:hover { background: var(--orange); color: white; }

        /* Polling badge */
        .live-badge {
            display: inline-flex; align-items: center; gap: 4px;
            background: rgba(16,185,129,0.15);
            color: var(--green);
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 11px; font-weight: 600;
            margin-left: auto;
        }
        .live-dot {
            width: 6px; height: 6px;
            background: var(--green);
            border-radius: 50%;
            animation: livePulse 1.5s ease-in-out infinite;
        }
        @keyframes livePulse { 0%,100%{opacity:1} 50%{opacity:0.3} }

        @keyframes successPop {
            0% { transform: scale(0); opacity: 0; }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        .success-flash { animation: successPop 0.5s ease-out; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="header-title">📋 Status Pesanan</div>
            <div class="header-sub">Order #{{ $order->id }} • Meja {{ $order->table_number }}</div>
        </div>
        <div class="live-badge" id="liveBadge">
            <div class="live-dot"></div>
            Live
        </div>
    </div>

    @php
        $statusConfig = [
            'pending'   => ['icon' => '⏳', 'label' => 'Menunggu Konfirmasi', 'desc' => 'Pesanan Anda sedang menunggu dikonfirmasi oleh dapur...'],
            'preparing' => ['icon' => '👨‍🍳', 'label' => 'Sedang Dimasak', 'desc' => 'Dapur sedang memproses pesanan Anda. Mohon tunggu sebentar!'],
            'ready'     => ['icon' => '✅', 'label' => 'Pesanan Siap!', 'desc' => 'Pesanan Anda sudah siap! Silakan ambil di meja Anda.'],
            'done'      => ['icon' => '🎉', 'label' => 'Selesai', 'desc' => 'Pesanan telah selesai. Terima kasih sudah makan di Sio Bak!'],
        ];
        $sc = $statusConfig[$order->status] ?? $statusConfig['pending'];
        $steps = ['pending', 'preparing', 'ready', 'done'];
        $currentIdx = array_search($order->status, $steps);
    @endphp

    <div class="content">

        <!-- Status Banner -->
        <div class="status-banner {{ $order->status }}" id="statusBanner">
            <div class="status-icon" id="statusIcon">{{ $sc['icon'] }}</div>
            <div class="status-label" id="statusLabel">{{ $sc['label'] }}</div>
            <div class="status-desc" id="statusDesc">{{ $sc['desc'] }}</div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <div class="card-title">📍 Progres Pesanan</div>
            <div class="timeline">
                @php
                    $timelineSteps = [
                        'pending'   => ['Pesanan Diterima', 'Pesanan Anda masuk ke sistem'],
                        'preparing' => ['Sedang Dimasak', 'Dapur sedang menyiapkan pesanan'],
                        'ready'     => ['Siap Disajikan', 'Pesanan siap di meja Anda'],
                        'done'      => ['Selesai', 'Terima kasih!'],
                    ];
                @endphp
                @foreach($timelineSteps as $key => [$title, $sub])
                    @php
                        $stepIdx = array_search($key, $steps);
                        $isDone = $stepIdx < $currentIdx;
                        $isActive = $stepIdx === $currentIdx;
                    @endphp
                    <div class="timeline-item {{ $isDone ? 'done-step' : '' }}">
                        <div class="tl-dot {{ $isActive ? 'active' : ($isDone ? 'completed' : '') }}">
                            {{ $isDone ? '✓' : ($isActive ? '●' : '') }}
                        </div>
                        <div class="tl-content">
                            <div class="tl-title" style="color: {{ $isActive ? 'var(--orange)' : ($isDone ? '#666' : '#ccc') }}">{{ $title }}</div>
                            <div class="tl-sub">{{ $sub }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card">
            <div class="card-title">🛒 Detail Pesanan</div>
            @foreach($order->items as $item)
                <div class="order-item">
                    <div>
                        <div class="item-name">{{ $item->menu->name ?? 'Menu dihapus' }}</div>
                        <div class="item-qty">×{{ $item->qty }}</div>
                    </div>
                    <div class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                </div>
            @endforeach
            @if($order->notes)
                <div style="margin-top: 10px; font-size:12px; color:#888; background:#f9f9f9; padding: 10px; border-radius: 10px;">
                    📝 <strong>Catatan:</strong> {{ $order->notes }}
                </div>
            @endif
            <div class="total-row">
                <div class="total-label">Total</div>
                <div class="total-amount">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Payment -->
        <div class="card">
            <div class="card-title">💳 Pembayaran</div>
            <div class="payment-status">
                <div class="ps-left">
                    <div class="ps-icon">{{ $order->payment_status === 'paid' ? '✅' : '⏳' }}</div>
                    <div>
                        <div class="ps-label">Status Pembayaran</div>
                        <div class="ps-val {{ $order->payment_status }}">{{ $order->payment_status_label }}</div>
                    </div>
                </div>
                <div style="font-size:12px;color:#888;font-weight:600">QRIS</div>
            </div>

            @if($order->payment_status !== 'paid')
                <a href="/payment/{{ $order->id }}" class="btn-pay">
                    <span>💳</span>
                    <span>Bayar dengan QRIS</span>
                </a>
            @else
                <div style="text-align:center; margin-top:14px; padding: 12px; background:#D1FAE5; border-radius: 12px; color: #065F46; font-weight: 700; font-size: 14px;">
                    ✅ Pembayaran Lunas!
                </div>
            @endif

            <a href="/menu/{{ $order->table_number }}" class="btn-back-menu">
                + Tambah Pesanan
            </a>
        </div>

    </div>

    <script>
        const ORDER_ID = {{ $order->id }};
        let lastStatus = '{{ $order->status }}';
        let lastPayment = '{{ $order->payment_status }}';

        const statusConfig = {
            pending:   { icon: '⏳', label: 'Menunggu Konfirmasi', desc: 'Pesanan Anda sedang menunggu dikonfirmasi oleh dapur...', cls: 'pending' },
            preparing: { icon: '👨‍🍳', label: 'Sedang Dimasak', desc: 'Dapur sedang memproses pesanan Anda. Mohon tunggu sebentar!', cls: 'preparing' },
            ready:     { icon: '✅', label: 'Pesanan Siap!', desc: 'Pesanan Anda sudah siap! Silakan ambil di meja Anda.', cls: 'ready' },
            done:      { icon: '🎉', label: 'Selesai', desc: 'Pesanan telah selesai. Terima kasih sudah makan di Sio Bak!', cls: 'done' },
        };

        async function pollStatus() {
            try {
                const res = await fetch('/api/order/' + ORDER_ID + '/status');
                const data = await res.json();

                if (data.status !== lastStatus) {
                    lastStatus = data.status;
                    updateStatusUI(data.status);
                }
                if (data.payment_status !== lastPayment && data.payment_status === 'paid') {
                    lastPayment = data.payment_status;
                    location.reload();
                }
            } catch(e) { /* ignore */ }
        }

        function updateStatusUI(status) {
            const cfg = statusConfig[status];
            if (!cfg) return;

            const banner = document.getElementById('statusBanner');
            banner.className = 'status-banner ' + cfg.cls + ' success-flash';
            document.getElementById('statusIcon').textContent = cfg.icon;
            document.getElementById('statusLabel').textContent = cfg.label;
            document.getElementById('statusDesc').textContent = cfg.desc;

            setTimeout(() => banner.classList.remove('success-flash'), 600);
        }

        // Poll every 5 seconds
        if (lastStatus !== 'done') {
            setInterval(pollStatus, 5000);
        } else {
            document.getElementById('liveBadge').style.display = 'none';
        }
    </script>
</body>
</html>
