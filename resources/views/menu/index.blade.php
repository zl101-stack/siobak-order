<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Menu — Meja {{ $table }} | Sio Bak</title>
    <meta name="description" content="Pesan makanan di Sio Bak - Meja {{ $table }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --orange: #FF6B35;
            --orange-dark: #E85A24;
            --orange-light: #FFF0EB;
            --dark: #1A1A2E;
            --cream: #FFF8F5;
            --white: #ffffff;
            --gray: #F4F4F4;
            --text: #222;
            --text-light: #888;
            --green: #10B981;
            --red: #EF4444;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gray);
            padding-bottom: 140px;
            color: var(--text);
        }

        /* ===== HEADER ===== */
        .header {
            background: linear-gradient(135deg, var(--dark) 0%, #16213E 100%);
            color: white;
            padding: 0;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .header-top {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 18px;
        }
        .header-brand { display: flex; align-items: center; gap: 10px; }
        .header-logo {
            width: 40px; height: 40px;
            background: var(--orange);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .header-name { font-size: 18px; font-weight: 800; }
        .header-name span { color: var(--orange); }
        .table-badge {
            background: rgba(255,107,53,0.2);
            border: 1px solid rgba(255,107,53,0.4);
            color: #FFB899;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s;
            display: flex; align-items: center; gap: 6px;
            font-family: 'Poppins', sans-serif;
            user-select: none;
        }
        .table-badge:hover {
            background: rgba(255,107,53,0.35);
            border-color: rgba(255,107,53,0.7);
            color: white;
            transform: scale(1.04);
        }
        .table-badge:active { transform: scale(0.97); }
        .table-badge .edit-hint {
            font-size: 10px;
            opacity: 0.6;
            margin-left: 2px;
        }

        /* ===== EDIT MEJA MODAL (Customer) ===== */
        .meja-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 9000;
            display: none; align-items: center; justify-content: center;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            padding: 20px;
        }
        .meja-overlay.show { display: flex; }
        .meja-modal {
            background: white;
            border-radius: 28px;
            padding: 28px 24px;
            width: 100%; max-width: 360px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.25);
            animation: mejaPopIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
        }
        @keyframes mejaPopIn {
            from { transform: scale(0.7) translateY(30px); opacity: 0; }
            to   { transform: scale(1) translateY(0); opacity: 1; }
        }
        .meja-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            border-radius: 20px;
            margin: 0 auto 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px;
            box-shadow: 0 8px 20px rgba(255,107,53,0.35);
        }
        .meja-title { font-size: 20px; font-weight: 800; color: var(--dark); margin-bottom: 4px; }
        .meja-sub { font-size: 13px; color: var(--text-light); margin-bottom: 20px; }
        .meja-quick {
            display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; margin-bottom: 16px;
        }
        .meja-qbtn {
            padding: 11px 0;
            background: var(--gray);
            border: 2px solid transparent;
            border-radius: 12px;
            font-size: 15px; font-weight: 700;
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            cursor: pointer; transition: all 0.2s;
        }
        .meja-qbtn:hover { background: var(--orange-light); color: var(--orange); }
        .meja-qbtn.sel { background: var(--orange); color: white; border-color: var(--orange-dark); transform: scale(1.08); }
        .meja-input-wrap { position: relative; margin-bottom: 18px; }
        .meja-input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); font-size: 18px; }
        .meja-input {
            width: 100%; padding: 15px 16px 15px 48px;
            border: 2px solid #eee; border-radius: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 20px; font-weight: 700; color: var(--dark);
            outline: none; background: var(--cream);
            transition: all 0.3s;
            text-align: center;
            -moz-appearance: textfield;
        }
        .meja-input::-webkit-outer-spin-button,
        .meja-input::-webkit-inner-spin-button { -webkit-appearance: none; }
        .meja-input:focus { border-color: var(--orange); background: white; box-shadow: 0 0 0 4px rgba(255,107,53,0.1); }
        .meja-warn {
            background: #FEF3C7; border-radius: 12px; padding: 10px 14px;
            font-size: 12px; color: #92400E; margin-bottom: 16px;
            display: none;
        }
        .meja-warn.show { display: block; }
        .meja-row { display: flex; gap: 10px; }
        .meja-cancel {
            padding: 14px 18px;
            background: var(--gray); color: var(--text-light);
            border: none; border-radius: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 600; cursor: pointer;
            transition: all 0.2s;
        }
        .meja-cancel:hover { background: #e5e5e5; }
        .meja-save {
            flex: 1; padding: 14px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white; border: none; border-radius: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px; font-weight: 700; cursor: pointer;
            box-shadow: 0 6px 18px rgba(255,107,53,0.35);
            transition: all 0.2s;
        }
        .meja-save:hover { transform: scale(1.02); }

        /* ===== CATEGORY TABS ===== */
        .cat-tabs {
            display: flex;
            padding: 0 18px 14px;
            gap: 10px;
        }
        .cat-tab {
            flex: 1;
            padding: 10px 0;
            border: none;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 6px;
            text-decoration: none;
        }
        .cat-tab.active {
            background: var(--orange);
            color: white;
            box-shadow: 0 4px 16px rgba(255,107,53,0.4);
        }
        .cat-tab:not(.active) {
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
        }
        .cat-tab:not(.active):hover { background: rgba(255,255,255,0.2); }
        .cat-count {
            background: rgba(255,255,255,0.25);
            border-radius: 99px;
            padding: 2px 7px;
            font-size: 11px;
        }
        .cat-tab.active .cat-count { background: rgba(255,255,255,0.3); }

        /* ===== SEARCH ===== */
        .search-wrap {
            padding: 16px 18px 0;
        }
        .search-input {
            width: 100%;
            padding: 12px 18px 12px 44px;
            background: white;
            border: 2px solid transparent;
            border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: var(--text);
            outline: none;
            box-shadow: var(--shadow);
            transition: all 0.3s;
            position: relative;
        }
        .search-wrap { position: relative; }
        .search-icon {
            position: absolute;
            left: 32px; top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
        }
        .search-input:focus { border-color: var(--orange); }

        /* ===== SECTION TITLE ===== */
        .section-title {
            padding: 20px 18px 12px;
            font-size: 17px;
            font-weight: 700;
            color: var(--dark);
            display: flex; align-items: center; gap: 8px;
        }

        /* ===== MENU GRID ===== */
        .menu-grid {
            padding: 0 18px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .menu-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s;
            position: relative;
        }
        .menu-card:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        .menu-card.out-of-stock { opacity: 0.65; }

        .menu-img {
            width: 100%; height: 110px;
            object-fit: cover;
            display: block;
        }
        .menu-img-placeholder {
            width: 100%; height: 110px;
            display: flex; align-items: center; justify-content: center;
            font-size: 42px;
        }

        .stock-badge {
            position: absolute;
            top: 8px; right: 8px;
            background: var(--red);
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 99px;
        }
        .stock-low {
            position: absolute;
            top: 8px; right: 8px;
            background: #F59E0B;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 99px;
        }

        .menu-body { padding: 12px 12px 14px; }
        .menu-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 3px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .menu-desc {
            font-size: 10px;
            color: var(--text-light);
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }
        .menu-price {
            font-size: 14px;
            font-weight: 800;
            color: var(--orange);
            margin-bottom: 10px;
        }

        /* ===== QTY CONTROL ===== */
        .qty-control {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--gray);
            border-radius: 12px;
            padding: 4px;
        }
        .qty-btn {
            width: 32px; height: 32px;
            border: none;
            border-radius: 10px;
            background: white;
            color: var(--dark);
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .qty-btn.add {
            background: var(--orange);
            color: white;
        }
        .qty-btn:hover { transform: scale(1.1); }
        .qty-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }
        .qty-num {
            font-size: 15px;
            font-weight: 700;
            color: var(--dark);
            min-width: 28px;
            text-align: center;
        }

        .add-to-cart-btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }
        .add-to-cart-btn:hover { opacity: 0.9; transform: scale(1.02); }
        .add-to-cart-btn:disabled { background: #ccc; cursor: not-allowed; transform: none; }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 60px 30px;
            color: var(--text-light);
            grid-column: span 2;
        }
        .empty-state .emoji { font-size: 56px; margin-bottom: 16px; }
        .empty-state p { font-size: 15px; }

        /* ===== CART FOOTER ===== */
        .cart-footer {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: white;
            padding: 12px 18px;
            box-shadow: 0 -8px 30px rgba(0,0,0,0.12);
            z-index: 200;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .cart-footer.visible { transform: translateY(0); }

        .cart-footer-inner {
            max-width: 500px;
            margin: 0 auto;
        }

        .cart-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .cart-info { display: flex; align-items: center; gap: 10px; }
        .cart-icon-wrap {
            position: relative;
            width: 44px; height: 44px;
            background: var(--orange-light);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }
        .cart-badge {
            position: absolute;
            top: -6px; right: -6px;
            background: var(--orange);
            color: white;
            width: 20px; height: 20px;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .cart-label { font-size: 13px; color: var(--text-light); }
        .cart-total { font-size: 18px; font-weight: 800; color: var(--dark); }

        .btn-order {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            border: none;
            border-radius: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(255,107,53,0.4);
        }
        .btn-order:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(255,107,53,0.5); }

        /* ===== CART ITEMS PREVIEW ===== */
        .cart-items-preview {
            background: var(--cream);
            border-radius: 14px;
            padding: 10px 14px;
            margin-bottom: 10px;
            max-height: 120px;
            overflow-y: auto;
            display: none;
        }
        .cart-items-preview.show { display: block; }
        .preview-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 4px 0;
            font-size: 12px;
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }
        .preview-item:last-child { border-bottom: none; }
        .preview-item .name { font-weight: 600; color: var(--dark); }
        .preview-item .price { color: var(--orange); font-weight: 700; }

        /* ===== TOAST ===== */
        .toast {
            position: fixed;
            top: 20px;
            left: 50%; transform: translateX(-50%) translateY(-100px);
            background: var(--dark);
            color: white;
            padding: 12px 20px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 600;
            z-index: 9999;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            white-space: nowrap;
        }
        .toast.show { transform: translateX(-50%) translateY(0); }
        .toast.success { background: #10B981; }

        /* Backdrop */
        .backdrop {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 150;
            opacity: 0; pointer-events: none;
            transition: opacity 0.3s;
        }
        .backdrop.show { opacity: 1; pointer-events: all; }

        @media (min-width: 480px) {
            .menu-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>

    <!-- Modal Edit Meja (dirender di luar body agar tidak terpengaruh z-index) -->
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-top">
            <div class="header-brand">
                <div class="header-logo">🍖</div>
                <div class="header-name">Sio <span>Bak</span></div>
            </div>
            <button class="table-badge" id="tableBadgeBtn" onclick="openTableEdit()">
                🪑 Meja {{ $table }}
                <span class="edit-hint">✏️</span>
            </button>
        </div>
        <div class="cat-tabs">
            <a href="/menu/{{ $table }}?category=makanan"
               class="cat-tab {{ $category === 'makanan' ? 'active' : '' }}">
                🍖 Makanan
                <span class="cat-count">{{ $makanan->count() }}</span>
            </a>
            <a href="/menu/{{ $table }}?category=minuman"
               class="cat-tab {{ $category === 'minuman' ? 'active' : '' }}">
                🥤 Minuman
                <span class="cat-count">{{ $minuman->count() }}</span>
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="search-wrap">
        <span class="search-icon">🔍</span>
        <input type="text" class="search-input" id="searchInput"
               placeholder="Cari menu..." oninput="filterMenus(this.value)">
    </div>

    <!-- Section Title -->
    <div class="section-title">
        {{ $category === 'makanan' ? '🍖 Menu Makanan' : '🥤 Menu Minuman' }}
    </div>

    <!-- Menu Grid -->
    <div class="menu-grid" id="menuGrid">
        @forelse($menus as $menu)
        <div class="menu-card {{ $menu->stock <= 0 ? 'out-of-stock' : '' }}"
             data-name="{{ strtolower($menu->name) }}"
             data-id="{{ $menu->id }}">

            @if($menu->stock <= 0)
                <div class="stock-badge">Habis</div>
            @elseif($menu->stock <= 5)
                <div class="stock-low">Sisa {{ $menu->stock }}</div>
            @endif

            <!-- Image / Placeholder -->
            @if($menu->image)
                <img class="menu-img" src="{{ $menu->image }}" alt="{{ $menu->name }}">
            @else
                <div class="menu-img-placeholder" style="background: {{ $menu->category === 'makanan' ? 'linear-gradient(135deg,#FFF0EB,#FFD4C0)' : 'linear-gradient(135deg,#EBF5FF,#C0DFFF)' }}">
                    {{ $menu->category === 'makanan' ? ['🍖','🥩','🍜','🍚','🥘','🍲'][($menu->id - 1) % 6] : ['🧋','🍵','☕','🥤','🍹','🧃'][($menu->id - 1) % 6] }}
                </div>
            @endif

            <div class="menu-body">
                <div class="menu-name">{{ $menu->name }}</div>
                @if($menu->description)
                    <div class="menu-desc">{{ $menu->description }}</div>
                @endif
                <div class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>

                @if($menu->stock > 0)
                    <div class="qty-control" id="qty-ctrl-{{ $menu->id }}">
                        <button class="qty-btn" onclick="changeQty({{ $menu->id }}, -1)" id="minus-{{ $menu->id }}" disabled>−</button>
                        <span class="qty-num" id="qty-{{ $menu->id }}">0</span>
                        <button class="qty-btn add" onclick="changeQty({{ $menu->id }}, 1)" id="plus-{{ $menu->id }}">+</button>
                    </div>
                @else
                    <button class="add-to-cart-btn" disabled>Habis</button>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="emoji">😢</div>
            <p>Belum ada menu {{ $category }} tersedia.</p>
        </div>
        @endforelse
    </div>

    <!-- Cart Footer -->
    <div class="cart-footer" id="cartFooter">
        <div class="cart-footer-inner">
            <div class="cart-items-preview" id="cartPreview"></div>
            <div class="cart-summary">
                <div class="cart-info" onclick="togglePreview()">
                    <div class="cart-icon-wrap">
                        🛒
                        <div class="cart-badge" id="cartBadge">0</div>
                    </div>
                    <div>
                        <div class="cart-label">Total Pesanan</div>
                        <div class="cart-total" id="cartTotal">Rp 0</div>
                    </div>
                </div>
            </div>
            <button class="btn-order" onclick="goToConfirm()">
                🍽️ Pesan Sekarang →
            </button>
        </div>
    </div>

    <!-- Modal Edit Meja -->
    <div class="meja-overlay" id="mejaOverlay" onclick="handleOverlayClick(event)">
        <div class="meja-modal">
            <div class="meja-icon">🪑</div>
            <div class="meja-title">Ganti Nomor Meja</div>
            <div class="meja-sub">Saat ini di <strong>Meja {{ $table }}</strong>. Pilih meja yang benar:</div>

            <div class="meja-quick">
                @foreach(range(1, 10) as $n)
                    <button class="meja-qbtn {{ $n == $table ? 'sel' : '' }}"
                            onclick="selectMeja({{ $n }})" id="mejaBtn{{ $n }}">{{ $n }}</button>
                @endforeach
            </div>

            <div class="meja-input-wrap">
                <span class="meja-input-icon">🔢</span>
                <input type="number" class="meja-input" id="mejaInput"
                       placeholder="Atau ketik nomor..." min="1" max="100"
                       value="{{ $table }}"
                       oninput="syncMejaInput(this.value)">
            </div>

            <div class="meja-warn" id="mejaWarn">
                ⚠️ Cart Anda saat ini akan dipindahkan ke meja baru.
            </div>

            <div class="meja-row">
                <button class="meja-cancel" onclick="closeMejaModal()">Batal</button>
                <button class="meja-save" onclick="saveMeja()">✅ Pindah ke Meja Ini</button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast"></div>

    @php
        $menusJson = $menus->map(function($m) {
            return ['id' => $m->id, 'name' => $m->name, 'price' => $m->price, 'stock' => $m->stock];
        })->values()->toJson();
    @endphp
    <script>
        const TABLE = {{ $table }};
        const MENUS = {!! $menusJson !!};

        let cart = JSON.parse(localStorage.getItem('siobak_cart_' + TABLE) || '{}');

        // Restore cart quantities on load
        function restoreCart() {
            Object.keys(cart).forEach(id => {
                const qty = cart[id].qty;
                if (qty > 0) {
                    const qtyEl = document.getElementById('qty-' + id);
                    const minusEl = document.getElementById('minus-' + id);
                    if (qtyEl) { qtyEl.textContent = qty; }
                    if (minusEl) { minusEl.disabled = false; }
                }
            });
            updateCartUI();
        }

        function changeQty(menuId, delta) {
            const qtyEl = document.getElementById('qty-' + menuId);
            const minusEl = document.getElementById('minus-' + menuId);
            if (!qtyEl) return;

            const menu = MENUS.find(m => m.id === menuId);
            if (!menu) return;

            let current = parseInt(qtyEl.textContent) || 0;
            let newQty = current + delta;
            if (newQty < 0) newQty = 0;
            if (newQty > menu.stock) {
                showToast('⚠️ Stok tidak cukup! Sisa: ' + menu.stock);
                return;
            }

            qtyEl.textContent = newQty;
            minusEl.disabled = newQty === 0;

            if (newQty > 0) {
                cart[menuId] = { name: menu.name, price: menu.price, qty: newQty };
            } else {
                delete cart[menuId];
            }

            if (delta > 0) {
                showToast('✅ ' + menu.name + ' ditambahkan!', 'success');
            }

            saveCart();
            updateCartUI();
        }

        function saveCart() {
            localStorage.setItem('siobak_cart_' + TABLE, JSON.stringify(cart));
        }

        function updateCartUI() {
            const items = Object.values(cart);
            const totalQty = items.reduce((s, i) => s + i.qty, 0);
            const totalPrice = items.reduce((s, i) => s + i.price * i.qty, 0);

            document.getElementById('cartBadge').textContent = totalQty;
            document.getElementById('cartTotal').textContent = 'Rp ' + totalPrice.toLocaleString('id');

            const footer = document.getElementById('cartFooter');
            if (totalQty > 0) {
                footer.classList.add('visible');
            } else {
                footer.classList.remove('visible');
                document.getElementById('cartPreview').classList.remove('show');
            }

            // Update preview
            const preview = document.getElementById('cartPreview');
            preview.innerHTML = items.map(i =>
                `<div class="preview-item">
                    <span class="name">${i.name} ×${i.qty}</span>
                    <span class="price">Rp ${(i.price * i.qty).toLocaleString('id')}</span>
                </div>`
            ).join('');
        }

        function togglePreview() {
            const preview = document.getElementById('cartPreview');
            preview.classList.toggle('show');
        }

        function goToConfirm() {
            const items = Object.values(cart);
            if (items.length === 0) {
                showToast('⚠️ Pilih menu terlebih dahulu!');
                return;
            }
            window.location.href = '/confirm/' + TABLE;
        }

        function filterMenus(query) {
            const cards = document.querySelectorAll('.menu-card');
            query = query.toLowerCase();
            cards.forEach(card => {
                const name = card.dataset.name || '';
                card.style.display = name.includes(query) ? '' : 'none';
            });
        }

        let toastTimer;
        function showToast(msg, type = '') {
            const toast = document.getElementById('toast');
            toast.textContent = msg;
            toast.className = 'toast show ' + type;
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2000);
        }

        // Init
        restoreCart();

        // ===== EDIT MEJA =====
        let selectedMeja = TABLE;

        function openTableEdit() {
            selectedMeja = TABLE;
            document.getElementById('mejaInput').value = TABLE;
            // Mark current table
            document.querySelectorAll('.meja-qbtn').forEach((btn, i) => {
                btn.classList.toggle('sel', (i + 1) === TABLE);
            });
            const warn = document.getElementById('mejaWarn');
            // Show warning only if cart has items
            const hasCart = Object.keys(cart).length > 0;
            warn.classList.toggle('show', hasCart);
            document.getElementById('mejaOverlay').classList.add('show');
            setTimeout(() => document.getElementById('mejaInput').select(), 300);
        }

        function closeMejaModal() {
            document.getElementById('mejaOverlay').classList.remove('show');
        }

        function handleOverlayClick(e) {
            if (e.target === document.getElementById('mejaOverlay')) closeMejaModal();
        }

        function selectMeja(num) {
            selectedMeja = num;
            document.getElementById('mejaInput').value = num;
            document.querySelectorAll('.meja-qbtn').forEach((btn, i) => {
                btn.classList.toggle('sel', (i + 1) === num);
            });
        }

        function syncMejaInput(val) {
            const num = parseInt(val);
            selectedMeja = isNaN(num) ? 0 : num;
            document.querySelectorAll('.meja-qbtn').forEach((btn, i) => {
                btn.classList.toggle('sel', (i + 1) === selectedMeja);
            });
        }

        function saveMeja() {
            const newTable = parseInt(document.getElementById('mejaInput').value);
            if (!newTable || newTable < 1) {
                document.getElementById('mejaInput').focus();
                document.getElementById('mejaInput').style.borderColor = '#EF4444';
                return;
            }
            if (newTable === TABLE) {
                closeMejaModal();
                return;
            }
            // Pindahkan isi cart ke key meja baru
            const cartData = localStorage.getItem('siobak_cart_' + TABLE);
            if (cartData) {
                localStorage.setItem('siobak_cart_' + newTable, cartData);
                localStorage.removeItem('siobak_cart_' + TABLE);
            }
            // Redirect ke URL meja baru (pertahankan kategori aktif)
            const params = new URLSearchParams(window.location.search);
            const cat = params.get('category') || 'makanan';
            window.location.href = '/menu/' + newTable + '?category=' + cat;
        }

        // Enter key
        document.getElementById('mejaInput').addEventListener('keydown', e => {
            if (e.key === 'Enter') saveMeja();
            if (e.key === 'Escape') closeMejaModal();
        });
    </script>
</body>
</html>