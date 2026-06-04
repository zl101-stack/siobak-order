<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Konfirmasi Pesanan | Sio Bak</title>
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
            --gray: #F4F4F4;
            --text: #222;
            --text-light: #888;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gray);
            min-height: 100vh;
            padding-bottom: 100px;
        }

        .header {
            background: linear-gradient(135deg, var(--dark), #16213E);
            color: white;
            padding: 16px 18px;
            display: flex; align-items: center; gap: 12px;
            position: sticky; top: 0; z-index: 100;
        }
        .back-btn {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.1);
            border: none; border-radius: 10px;
            color: white; font-size: 18px;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            text-decoration: none;
            transition: background 0.2s;
        }
        .back-btn:hover { background: rgba(255,255,255,0.2); }
        .header-title { font-size: 17px; font-weight: 700; }

        .content { padding: 18px; }

        .card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: var(--shadow);
        }

        .card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 14px;
            display: flex; align-items: center; gap: 8px;
        }

        /* Order Items */
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .order-item:last-child { border-bottom: none; }
        .item-left { display: flex; align-items: center; gap: 12px; }
        .item-qty-badge {
            width: 28px; height: 28px;
            background: var(--orange-light);
            color: var(--orange);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 800;
            display: flex; align-items: center; justify-content: center;
        }
        .item-name { font-size: 13px; font-weight: 600; color: var(--dark); }
        .item-price { font-size: 14px; font-weight: 700; color: var(--orange); }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 14px;
            margin-top: 4px;
            border-top: 2px dashed #eee;
        }
        .total-label { font-size: 14px; font-weight: 600; color: var(--text-light); }
        .total-amount { font-size: 20px; font-weight: 800; color: var(--dark); }

        /* Form */
        .form-group { margin-bottom: 16px; }
        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        input[type="text"], textarea, input[type="number"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #eee;
            border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            color: var(--dark);
            outline: none;
            background: var(--cream);
            transition: all 0.3s;
        }
        input:focus, textarea:focus {
            border-color: var(--orange);
            background: white;
            box-shadow: 0 0 0 4px rgba(255,107,53,0.08);
        }
        textarea { resize: none; height: 90px; }

        .table-display {
            display: flex; align-items: center; gap: 10px;
            background: var(--orange-light);
            border-radius: 14px;
            padding: 14px 16px;
        }
        .table-display .num {
            font-size: 28px; font-weight: 800; color: var(--orange);
        }
        .table-display .label { font-size: 13px; color: var(--text-light); }

        /* Submit button */
        .fixed-bottom {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: white;
            padding: 14px 18px;
            box-shadow: 0 -6px 24px rgba(0,0,0,0.1);
            z-index: 100;
        }
        .btn-submit {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white; border: none;
            border-radius: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px; font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(255,107,53,0.4);
            transition: all 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-submit:hover { transform: translateY(-2px); }
        .btn-submit:disabled { background: #ccc; cursor: not-allowed; transform: none; }

        .empty-cart {
            text-align: center;
            padding: 60px 30px;
        }
        .empty-cart .emoji { font-size: 64px; margin-bottom: 16px; display: block; }
        .empty-cart p { font-size: 16px; color: var(--text-light); margin-bottom: 20px; }
        .btn-back-to-menu {
            display: inline-block;
            padding: 12px 24px;
            background: var(--orange);
            color: white; border-radius: 14px;
            text-decoration: none; font-weight: 700;
            transition: opacity 0.3s;
        }

        .error-msg {
            background: #FEE2E2;
            color: #EF4444;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .loading-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            align-items: center; justify-content: center;
            flex-direction: column; gap: 16px;
        }
        .loading-overlay.show { display: flex; }
        .spinner {
            width: 50px; height: 50px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top-color: var(--orange);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loading-text { color: white; font-size: 14px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="header">
        <a href="/menu/{{ $table }}" class="back-btn">←</a>
        <div class="header-title">✅ Konfirmasi Pesanan</div>
    </div>

    <div class="content" id="mainContent">
        <!-- Will be filled by JS -->
    </div>

    <div class="fixed-bottom" id="fixedBottom" style="display:none">
        <button class="btn-submit" id="submitBtn" onclick="submitOrder()">
            <span>🍽️</span>
            <span id="submitBtnText">Pesan Sekarang</span>
        </button>
    </div>

    <!-- Loading -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <div class="loading-text">Memproses pesanan...</div>
    </div>

    <!-- Hidden form for submission -->
    <form id="orderForm" action="/order" method="POST" style="display:none">
        @csrf
        <input type="hidden" name="table_number" id="f_table">
        <input type="hidden" name="customer_name" id="f_name">
        <input type="hidden" name="notes" id="f_notes">
        <div id="f_items"></div>
    </form>

    <script>
        const TABLE = {{ $table }};
        const cart = JSON.parse(localStorage.getItem('siobak_cart_' + TABLE) || '{}');
        const items = Object.entries(cart).map(([id, v]) => ({ id, ...v }));

        function formatRp(num) {
            return 'Rp ' + num.toLocaleString('id');
        }

        function renderContent() {
            const content = document.getElementById('mainContent');

            if (items.length === 0) {
                content.innerHTML = `
                    <div class="empty-cart">
                        <span class="emoji">🛒</span>
                        <p>Keranjang kamu kosong!</p>
                        <a href="/menu/${TABLE}" class="btn-back-to-menu">← Kembali ke Menu</a>
                    </div>`;
                return;
            }

            document.getElementById('fixedBottom').style.display = 'block';

            const total = items.reduce((s, i) => s + i.price * i.qty, 0);
            const totalQty = items.reduce((s, i) => s + i.qty, 0);

            content.innerHTML = `
                <div class="card">
                    <div class="card-title">🪑 Info Meja</div>
                    <div class="table-display">
                        <div class="num">${TABLE}</div>
                        <div class="label">Nomor Meja Anda</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-title">👤 Info Pemesan</div>
                    <div class="form-group">
                        <label>Nama Pemesan *</label>
                        <input type="text" id="customerName" placeholder="Masukkan nama Anda" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label>Catatan (opsional)</label>
                        <textarea id="customerNotes" placeholder="Contoh: tidak pakai kuah, ekstra pedas..."></textarea>
                    </div>
                </div>

                <div class="card">
                    <div class="card-title">🛒 Ringkasan Pesanan (${totalQty} item)</div>
                    ${items.map(i => `
                        <div class="order-item">
                            <div class="item-left">
                                <div class="item-qty-badge">${i.qty}</div>
                                <div class="item-name">${i.name}</div>
                            </div>
                            <div class="item-price">${formatRp(i.price * i.qty)}</div>
                        </div>
                    `).join('')}
                    <div class="total-row">
                        <div class="total-label">Total</div>
                        <div class="total-amount">${formatRp(total)}</div>
                    </div>
                </div>
            `;
        }

        function submitOrder() {
            const name = document.getElementById('customerName')?.value?.trim();
            if (!name) {
                document.getElementById('customerName').focus();
                document.getElementById('customerName').style.borderColor = '#EF4444';
                alert('Nama pemesan wajib diisi!');
                return;
            }

            // Show loading
            document.getElementById('loadingOverlay').classList.add('show');
            document.getElementById('submitBtn').disabled = true;

            // Fill form
            document.getElementById('f_table').value = TABLE;
            document.getElementById('f_name').value = name;
            document.getElementById('f_notes').value = document.getElementById('customerNotes')?.value || '';

            // Add items as hidden fields
            const fItems = document.getElementById('f_items');
            fItems.innerHTML = '';
            items.forEach((item, i) => {
                fItems.innerHTML += `<input type="hidden" name="items[${i}][menu_id]" value="${item.id}">`;
                fItems.innerHTML += `<input type="hidden" name="items[${i}][qty]" value="${item.qty}">`;
            });

            // Clear cart then submit
            localStorage.removeItem('siobak_cart_' + TABLE);
            document.getElementById('orderForm').submit();
        }

        renderContent();
    </script>
</body>
</html>
