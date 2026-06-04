<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Dashboard | Sio Bak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --orange: #FF6B35;
            --dark: #0F172A;
            --dark2: #1E293B;
            --dark3: #334155;
            --yellow: #F59E0B;
            --blue: #3B82F6;
            --green: #10B981;
            --purple: #8B5CF6;
            --gray: #64748B;
            --border: rgba(255,255,255,0.08);
            --card-bg: #1E293B;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--dark);
            color: white;
            min-height: 100vh;
        }

        /* ===== TOP BAR ===== */
        .topbar {
            background: var(--dark2);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            display: flex; align-items: center; justify-content: space-between;
            height: 64px;
            position: sticky; top: 0; z-index: 100;
        }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .kitchen-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--orange), #E85A24);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }
        .kitchen-title { font-size: 18px; font-weight: 800; }
        .kitchen-sub { font-size: 11px; color: #64748B; }

        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .live-indicator {
            display: flex; align-items: center; gap: 6px;
            background: rgba(16,185,129,0.15);
            border: 1px solid rgba(16,185,129,0.3);
            padding: 6px 14px; border-radius: 99px;
            font-size: 12px; font-weight: 600; color: var(--green);
        }
        .live-dot {
            width: 7px; height: 7px;
            background: var(--green); border-radius: 50%;
            animation: liveAnimate 1.5s ease-in-out infinite;
        }
        @keyframes liveAnimate { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.4;transform:scale(0.8)} }

        .time-display { font-size: 13px; color: #64748B; font-weight: 600; }

        .nav-links { display: flex; gap: 8px; }
        .nav-link {
            padding: 8px 14px;
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.7);
            border-radius: 10px;
            text-decoration: none;
            font-size: 12px; font-weight: 600;
            transition: all 0.2s;
        }
        .nav-link:hover { background: rgba(255,255,255,0.12); color: white; }

        /* ===== STATS BAR ===== */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
        }
        .stat-card {
            background: var(--dark2);
            border-radius: 14px;
            padding: 14px 16px;
            display: flex; align-items: center; gap: 12px;
            border: 1px solid var(--border);
        }
        .stat-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .stat-icon.yellow { background: rgba(245,158,11,0.2); }
        .stat-icon.blue   { background: rgba(59,130,246,0.2); }
        .stat-icon.green  { background: rgba(16,185,129,0.2); }
        .stat-icon.purple { background: rgba(139,92,246,0.2); }
        .stat-num { font-size: 22px; font-weight: 800; }
        .stat-label { font-size: 11px; color: #64748B; font-weight: 500; }

        /* ===== KANBAN COLUMNS ===== */
        .kanban {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            padding: 16px 24px;
            min-height: calc(100vh - 200px);
        }

        .col-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 14px;
        }
        .col-title-wrap { display: flex; align-items: center; gap: 8px; }
        .col-dot { width: 10px; height: 10px; border-radius: 50%; }
        .col-title { font-size: 14px; font-weight: 700; }
        .col-count {
            font-size: 11px; font-weight: 700;
            padding: 2px 8px; border-radius: 99px;
        }

        /* Column colors */
        .col-pending   .col-dot { background: var(--yellow); }
        .col-preparing .col-dot { background: var(--blue); }
        .col-ready     .col-dot { background: var(--green); }
        .col-done      .col-dot { background: var(--gray); }

        .col-pending   .col-count { background: rgba(245,158,11,0.2); color: var(--yellow); }
        .col-preparing .col-count { background: rgba(59,130,246,0.2); color: var(--blue); }
        .col-ready     .col-count { background: rgba(16,185,129,0.2); color: var(--green); }
        .col-done      .col-count { background: rgba(100,116,139,0.2); color: var(--gray); }

        /* Order cards */
        .order-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 14px;
            margin-bottom: 12px;
            border: 1px solid var(--border);
            transition: all 0.3s;
            animation: cardIn 0.4s ease-out;
        }
        @keyframes cardIn { from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }
        .order-card:hover { border-color: rgba(255,255,255,0.15); transform: translateY(-2px); }
        .order-card.new-order {
            border-color: var(--orange);
            box-shadow: 0 0 0 2px rgba(255,107,53,0.3);
            animation: newOrderPulse 2s ease-in-out 3;
        }
        @keyframes newOrderPulse {
            0%,100%{box-shadow: 0 0 0 2px rgba(255,107,53,0.3)}
            50%{box-shadow: 0 0 0 6px rgba(255,107,53,0.1)}
        }

        .card-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 10px;
        }
        .card-order-num {
            font-size: 11px; font-weight: 700; color: #64748B;
            background: rgba(255,255,255,0.05);
            padding: 3px 8px; border-radius: 6px;
        }
        .card-table {
            font-size: 13px; font-weight: 700;
            background: rgba(255,107,53,0.15);
            color: #FFB899;
            padding: 3px 10px; border-radius: 8px;
        }

        .card-customer { font-size: 14px; font-weight: 700; margin-bottom: 8px; }
        .card-time { font-size: 11px; color: #64748B; margin-bottom: 10px; }

        .card-items { margin-bottom: 12px; }
        .card-item {
            display: flex; justify-content: space-between;
            font-size: 12px; padding: 4px 0;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            color: rgba(255,255,255,0.8);
        }
        .card-item:last-child { border-bottom: none; }
        .item-name-qty { display: flex; gap: 6px; align-items: center; }
        .qty-badge {
            background: rgba(255,255,255,0.1);
            padding: 1px 6px; border-radius: 4px;
            font-size: 11px; font-weight: 700;
        }

        .card-notes {
            background: rgba(245,158,11,0.1);
            border-left: 2px solid var(--yellow);
            padding: 6px 10px;
            border-radius: 0 8px 8px 0;
            font-size: 11px; color: #FDE68A;
            margin-bottom: 10px;
        }

        .card-total {
            display: flex; justify-content: space-between;
            font-size: 12px; color: #64748B;
            margin-bottom: 10px;
        }
        .card-total strong { color: white; font-size: 13px; }

        .card-action-btn {
            width: 100%;
            padding: 10px;
            border: none; border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px; font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-accept  { background: linear-gradient(135deg, var(--yellow), #D97706); color: white; }
        .btn-process { background: linear-gradient(135deg, var(--blue), #2563EB); color: white; }
        .btn-ready   { background: linear-gradient(135deg, var(--green), #059669); color: white; }
        .btn-done    { background: rgba(255,255,255,0.08); color: #64748B; }
        .card-action-btn:hover { transform: scale(1.02); opacity: 0.9; }
        .card-action-btn:active { transform: scale(0.98); }

        /* Empty column */
        .col-empty {
            text-align: center;
            padding: 40px 20px;
            color: #334155;
        }
        .col-empty .icon { font-size: 36px; margin-bottom: 8px; }
        .col-empty p { font-size: 12px; }

        /* ===== NOTIFICATION POPUP ===== */
        .notif-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 9998;
            display: none; align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .notif-overlay.show { display: flex; }

        .notif-popup {
            background: var(--dark2);
            border-radius: 24px;
            padding: 32px;
            width: 90%; max-width: 420px;
            border: 1px solid rgba(255,107,53,0.3);
            box-shadow: 0 0 60px rgba(255,107,53,0.2);
            animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
        }
        @keyframes popIn { from{transform:scale(0.5);opacity:0} to{transform:scale(1);opacity:1} }

        .notif-ring {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, var(--orange), #E85A24);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 36px;
            animation: ringShake 0.6s ease-in-out infinite;
            box-shadow: 0 0 0 0 rgba(255,107,53,0.4);
        }
        @keyframes ringShake {
            0%,100%{transform:rotate(0);box-shadow:0 0 0 0 rgba(255,107,53,0.4)}
            25%{transform:rotate(-10deg)}
            50%{transform:rotate(0);box-shadow:0 0 0 20px rgba(255,107,53,0)}
            75%{transform:rotate(10deg)}
        }

        .notif-title { font-size: 22px; font-weight: 800; margin-bottom: 8px; }
        .notif-count {
            font-size: 42px; font-weight: 800;
            color: var(--orange);
            margin-bottom: 6px;
        }
        .notif-sub { font-size: 14px; color: #64748B; margin-bottom: 24px; }
        .notif-orders { text-align: left; background: rgba(255,255,255,0.04); border-radius: 14px; padding: 14px; margin-bottom: 20px; }
        .notif-order-item {
            display: flex; justify-content: space-between;
            font-size: 13px; padding: 6px 0;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.85);
        }
        .notif-order-item:last-child { border-bottom: none; }
        .notif-table { font-weight: 700; color: #FFB899; }
        .notif-name { color: rgba(255,255,255,0.6); }

        .btn-dismiss {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--orange), #E85A24);
            color: white; border: none;
            border-radius: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px; font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-dismiss:hover { opacity: 0.9; transform: scale(1.02); }

        /* Toast */
        .toast {
            position: fixed; bottom: 24px; right: 24px;
            background: var(--dark2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex; align-items: center; gap: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
            z-index: 1000;
            transform: translateX(200%);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            max-width: 300px;
        }
        .toast.show { transform: translateX(0); }
        .toast-icon { font-size: 20px; }
        .toast-text { font-size: 13px; font-weight: 600; }

        /* Sound toggle */
        .sound-toggle {
            background: rgba(255,255,255,0.08);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 6px 12px;
            color: rgba(255,255,255,0.6);
            font-size: 12px; font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
        }
        .sound-toggle:hover { background: rgba(255,255,255,0.12); color: white; }
        .sound-toggle.active { background: rgba(16,185,129,0.2); color: var(--green); border-color: rgba(16,185,129,0.3); }

        /* Edit table button */
        .edit-table-btn {
            background: rgba(255,255,255,0.08);
            border: none; border-radius: 6px;
            color: rgba(255,255,255,0.5);
            font-size: 11px; cursor: pointer;
            padding: 3px 6px;
            transition: all 0.2s;
        }
        .edit-table-btn:hover {
            background: rgba(255,107,53,0.2);
            color: var(--orange);
        }

        /* Edit table modal */
        .edit-table-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 9999;
            display: none; align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .edit-table-overlay.show { display: flex; }
        .edit-table-modal {
            background: var(--dark2);
            border-radius: 20px;
            padding: 28px;
            width: 90%; max-width: 340px;
            border: 1px solid rgba(255,107,53,0.3);
            box-shadow: 0 0 40px rgba(255,107,53,0.15);
            animation: popIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
        }
        .edit-table-title { font-size: 18px; font-weight: 800; margin-bottom: 6px; }
        .edit-table-sub { font-size: 13px; color: #64748B; margin-bottom: 20px; }
        .edit-table-input {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 2px solid rgba(255,107,53,0.4);
            border-radius: 14px;
            padding: 16px;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 28px; font-weight: 800;
            text-align: center;
            outline: none;
            margin-bottom: 16px;
            -moz-appearance: textfield;
        }
        .edit-table-input::-webkit-outer-spin-button,
        .edit-table-input::-webkit-inner-spin-button { -webkit-appearance: none; }
        .edit-table-input:focus { border-color: var(--orange); background: rgba(255,107,53,0.08); }
        .edit-table-row { display: flex; gap: 10px; }
        .btn-save-table {
            flex: 1; padding: 14px;
            background: linear-gradient(135deg, var(--orange), #E85A24);
            color: white; border: none; border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 700; cursor: pointer;
            transition: all 0.2s;
        }
        .btn-save-table:hover { transform: scale(1.02); }
        .btn-cancel-table {
            padding: 14px 18px;
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.6); border: none; border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 600; cursor: pointer;
        }
        .quick-table-grid {
            display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; margin-bottom: 16px;
        }
        .quick-tbl {
            padding: 10px 0;
            background: rgba(255,255,255,0.06);
            border: none; border-radius: 10px;
            color: rgba(255,255,255,0.7);
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 700; cursor: pointer;
            transition: all 0.2s;
        }
        .quick-tbl:hover { background: rgba(255,107,53,0.2); color: var(--orange); }
        .quick-tbl.selected { background: var(--orange); color: white; }

        @media (max-width: 1200px) {
            .kanban { grid-template-columns: repeat(2, 1fr); }
            .stats-bar { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .kanban { grid-template-columns: 1fr; }
            .stats-bar { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="topbar">
        <div class="topbar-left">
            <div class="kitchen-icon">🍳</div>
            <div>
                <div class="kitchen-title">Kitchen Dashboard</div>
                <div class="kitchen-sub">Sio Bak Restaurant</div>
            </div>
        </div>
        <div class="topbar-right">
            <span class="time-display" id="clockDisplay"></span>
            <button class="sound-toggle" id="soundToggle" onclick="toggleSound()">🔔 Suara ON</button>
            <div class="live-indicator">
                <div class="live-dot"></div>
                LIVE
            </div>
            <div class="nav-links">
                <a href="/admin/menus" class="nav-link">⚙️ Menu</a>
                <a href="/admin/qrcode" class="nav-link">📱 QR Code</a>
            </div>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-icon yellow">⏳</div>
            <div>
                <div class="stat-num" id="statPending">{{ $pendingOrders->count() }}</div>
                <div class="stat-label">Menunggu</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">👨‍🍳</div>
            <div>
                <div class="stat-num" id="statPreparing">{{ $preparingOrders->count() }}</div>
                <div class="stat-label">Diproses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">✅</div>
            <div>
                <div class="stat-num" id="statReady">{{ $readyOrders->count() }}</div>
                <div class="stat-label">Siap</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">🎉</div>
            <div>
                <div class="stat-num" id="statDone">{{ $doneOrders->count() }}</div>
                <div class="stat-label">Selesai (Hari ini)</div>
            </div>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="kanban">

        <!-- PENDING -->
        <div class="col col-pending">
            <div class="col-header">
                <div class="col-title-wrap">
                    <div class="col-dot"></div>
                    <div class="col-title">⏳ Menunggu</div>
                </div>
                <span class="col-count" id="pendingCount">{{ $pendingOrders->count() }}</span>
            </div>
            <div id="pendingCol">
                @forelse($pendingOrders as $order)
                    @include('kitchen._order_card', ['order' => $order, 'action' => 'accept'])
                @empty
                    <div class="col-empty">
                        <div class="icon">☕</div>
                        <p>Belum ada pesanan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- PREPARING -->
        <div class="col col-preparing">
            <div class="col-header">
                <div class="col-title-wrap">
                    <div class="col-dot"></div>
                    <div class="col-title">👨‍🍳 Dimasak</div>
                </div>
                <span class="col-count" id="preparingCount">{{ $preparingOrders->count() }}</span>
            </div>
            <div id="preparingCol">
                @forelse($preparingOrders as $order)
                    @include('kitchen._order_card', ['order' => $order, 'action' => 'process'])
                @empty
                    <div class="col-empty">
                        <div class="icon">🍳</div>
                        <p>Sedang kosong</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- READY -->
        <div class="col col-ready">
            <div class="col-header">
                <div class="col-title-wrap">
                    <div class="col-dot"></div>
                    <div class="col-title">✅ Siap</div>
                </div>
                <span class="col-count" id="readyCount">{{ $readyOrders->count() }}</span>
            </div>
            <div id="readyCol">
                @forelse($readyOrders as $order)
                    @include('kitchen._order_card', ['order' => $order, 'action' => 'ready'])
                @empty
                    <div class="col-empty">
                        <div class="icon">🍽️</div>
                        <p>Belum ada yang siap</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- DONE -->
        <div class="col col-done">
            <div class="col-header">
                <div class="col-title-wrap">
                    <div class="col-dot"></div>
                    <div class="col-title">🎉 Selesai</div>
                </div>
                <span class="col-count" id="doneCount">{{ $doneOrders->count() }}</span>
            </div>
            <div id="doneCol">
                @forelse($doneOrders as $order)
                    @include('kitchen._order_card', ['order' => $order, 'action' => 'done'])
                @empty
                    <div class="col-empty">
                        <div class="icon">📋</div>
                        <p>Belum ada yang selesai</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Edit Table Modal -->
    <div class="edit-table-overlay" id="editTableOverlay">
        <div class="edit-table-modal">
            <div class="edit-table-title">✏️ Ganti Nomor Meja</div>
            <div class="edit-table-sub" id="editTableSub">Order #? saat ini di Meja ?</div>

            <div class="quick-table-grid" id="quickTableGrid">
                @foreach(range(1, 10) as $n)
                    <button class="quick-tbl" onclick="selectQuickTable({{ $n }})">{{ $n }}</button>
                @endforeach
            </div>

            <input type="number" class="edit-table-input" id="editTableInput"
                   placeholder="No. Meja" min="1" max="100">

            <div class="edit-table-row">
                <button class="btn-cancel-table" onclick="closeEditTable()">Batal</button>
                <button class="btn-save-table" onclick="saveTable()">💾 Simpan</button>
            </div>
        </div>
    </div>

    <!-- Notification Popup -->
    <div class="notif-overlay" id="notifOverlay">
        <div class="notif-popup">
            <div class="notif-ring">🔔</div>
            <div class="notif-title">Pesanan Baru Masuk!</div>
            <div class="notif-count" id="notifCount">1</div>
            <div class="notif-sub">pesanan baru menunggu konfirmasi</div>
            <div class="notif-orders" id="notifOrdersList"></div>
            <button class="btn-dismiss" onclick="dismissNotif()">
                ✅ Lihat Pesanan
            </button>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
        <span class="toast-icon" id="toastIcon"></span>
        <span class="toast-text" id="toastText"></span>
    </div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;
        let soundEnabled = true;
        let lastOrderTimestamp = '{{ now()->toIso8601String() }}';
        let knownOrderIds = new Set([{{ $pendingOrders->pluck('id')->join(',') }}, {{ $preparingOrders->pluck('id')->join(',') }}, {{ $readyOrders->pluck('id')->join(',') }}]);
        let toastTimer;

        // Clock
        function updateClock() {
            const now = new Date();
            document.getElementById('clockDisplay').textContent =
                now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Sound toggle
        function toggleSound() {
            soundEnabled = !soundEnabled;
            const btn = document.getElementById('soundToggle');
            btn.textContent = soundEnabled ? '🔔 Suara ON' : '🔕 Suara OFF';
            btn.className = 'sound-toggle' + (soundEnabled ? ' active' : '');
        }
        document.getElementById('soundToggle').classList.add('active');

        // Play notification sound
        function playNotifSound() {
            if (!soundEnabled) return;
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const times = [0, 0.3, 0.6];
                times.forEach(t => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.frequency.value = 880;
                    osc.type = 'sine';
                    gain.gain.setValueAtTime(0.3, ctx.currentTime + t);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + t + 0.25);
                    osc.start(ctx.currentTime + t);
                    osc.stop(ctx.currentTime + t + 0.25);
                });
            } catch(e) {}
        }

        // Update status from button click
        async function updateStatus(orderId, btn) {
            btn.disabled = true;
            btn.innerHTML = '⏳ Loading...';

            try {
                const res = await fetch('/kitchen/order/' + orderId + '/status', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' }
                });
                const data = await res.json();

                if (data.success) {
                    showToast('✅', 'Status diperbarui!');
                    setTimeout(() => refreshBoard(), 500);
                }
            } catch(e) {
                btn.disabled = false;
                showToast('❌', 'Gagal update status');
            }
        }

        // Show toast
        function showToast(icon, text) {
            document.getElementById('toastIcon').textContent = icon;
            document.getElementById('toastText').textContent = text;
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // Refresh entire board via polling
        async function pollNewOrders() {
            try {
                const res = await fetch('/api/kitchen/new-orders?since=' + encodeURIComponent(lastOrderTimestamp));
                const data = await res.json();

                if (data.count > 0) {
                    const newOrders = data.orders.filter(o => !knownOrderIds.has(o.id));
                    if (newOrders.length > 0) {
                        newOrders.forEach(o => knownOrderIds.add(o.id));
                        lastOrderTimestamp = new Date().toISOString();
                        showNewOrderNotif(newOrders);
                        playNotifSound();
                        refreshBoard();
                    }
                }
            } catch(e) {}
        }

        function showNewOrderNotif(orders) {
            document.getElementById('notifCount').textContent = orders.length;
            document.getElementById('notifOrdersList').innerHTML = orders.map(o =>
                `<div class="notif-order-item">
                    <span class="notif-table">🪑 Meja ${o.table_number}</span>
                    <span class="notif-name">${o.customer_name}</span>
                    <span style="color:#FF6B35;font-weight:700">Rp ${parseInt(o.total).toLocaleString('id')}</span>
                </div>`
            ).join('');
            document.getElementById('notifOverlay').classList.add('show');
        }

        function dismissNotif() {
            document.getElementById('notifOverlay').classList.remove('show');
        }

        // Refresh board
        async function refreshBoard() {
            location.reload();
        }

        // Poll every 5 seconds
        setInterval(pollNewOrders, 5000);

        // Click outside notif to dismiss
        document.getElementById('notifOverlay').addEventListener('click', function(e) {
            if (e.target === this) dismissNotif();
        });

        // ===== EDIT TABLE =====
        let editingOrderId = null;
        let editingCurrentTable = null;

        function openEditTable(orderId, currentTable) {
            editingOrderId = orderId;
            editingCurrentTable = currentTable;
            document.getElementById('editTableSub').textContent = `Order #${orderId} — saat ini di Meja ${currentTable}`;
            const input = document.getElementById('editTableInput');
            input.value = currentTable;
            // Mark current table in quick grid
            document.querySelectorAll('.quick-tbl').forEach(btn => {
                btn.classList.toggle('selected', parseInt(btn.textContent) === currentTable);
            });
            document.getElementById('editTableOverlay').classList.add('show');
            setTimeout(() => input.focus(), 300);
        }

        function closeEditTable() {
            document.getElementById('editTableOverlay').classList.remove('show');
            editingOrderId = null;
        }

        function selectQuickTable(num) {
            document.getElementById('editTableInput').value = num;
            document.querySelectorAll('.quick-tbl').forEach(btn => {
                btn.classList.toggle('selected', parseInt(btn.textContent) === num);
            });
        }

        async function saveTable() {
            const newTable = parseInt(document.getElementById('editTableInput').value);
            if (!newTable || newTable < 1) {
                document.getElementById('editTableInput').focus();
                return;
            }
            if (newTable === editingCurrentTable) {
                closeEditTable();
                return;
            }

            try {
                const res = await fetch('/kitchen/order/' + editingOrderId + '/table', {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
                    body: JSON.stringify({ table_number: newTable })
                });
                const data = await res.json();

                if (data.success) {
                    // Update label di kartu langsung
                    const label = document.getElementById('table-label-' + editingOrderId);
                    if (label) label.textContent = '🪑 Meja ' + newTable;
                    showToast('✅', `Meja order #${editingOrderId} → Meja ${newTable}`);
                    closeEditTable();
                }
            } catch(e) {
                showToast('❌', 'Gagal mengubah meja');
            }
        }

        // Close modal click outside
        document.getElementById('editTableOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeEditTable();
        });

        // Enter key to save
        document.getElementById('editTableInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') saveTable();
            if (e.key === 'Escape') closeEditTable();
        });
    </script>
</body>
</html>
