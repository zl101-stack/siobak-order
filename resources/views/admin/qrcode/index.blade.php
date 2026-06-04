<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Restoran | Sio Bak Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --orange: #FF6B35;
            --dark: #0F172A;
            --dark2: #1E293B;
            --green: #10B981;
            --border: rgba(255,255,255,0.08);
        }
        body { font-family: 'Poppins', sans-serif; background: var(--dark); color: white; min-height: 100vh; }

        .topbar {
            background: var(--dark2); border-bottom: 1px solid var(--border);
            padding: 0 24px; display: flex; align-items: center; justify-content: space-between; height: 64px;
            position: sticky; top: 0; z-index: 100;
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .nav-icon { font-size: 22px; width: 40px; height: 40px; background: rgba(255,107,53,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .page-title { font-size: 17px; font-weight: 700; }
        .page-sub { font-size: 11px; color: #64748B; }
        .nav-links { display: flex; gap: 8px; }
        .nav-link { padding: 8px 14px; background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.7); border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: rgba(255,107,53,0.2); color: var(--orange); }

        .content { padding: 24px; max-width: 900px; margin: 0 auto; }

        /* Stats */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 24px; }
        .stat-card { background: var(--dark2); border-radius: 14px; padding: 20px; border: 1px solid var(--border); text-align: center; }
        .stat-emoji { font-size: 32px; margin-bottom: 8px; }
        .stat-val { font-size: 28px; font-weight: 800; margin-bottom: 4px; }
        .stat-label { font-size: 12px; color: #64748B; font-weight: 600; }
        .stat-val.orange { color: var(--orange); }
        .stat-val.green { color: var(--green); }

        /* Main QR Card */
        .qr-main-card {
            background: var(--dark2);
            border-radius: 24px;
            padding: 32px;
            border: 1px solid var(--border);
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 40px;
            align-items: center;
            margin-bottom: 24px;
        }

        .qr-display {
            background: white;
            border-radius: 20px;
            padding: 20px;
            display: inline-block;
            position: relative;
        }
        .qr-display::after {
            content: 'QRIS';
            position: absolute;
            bottom: -12px; left: 50%;
            transform: translateX(-50%);
            background: var(--orange);
            color: white;
            padding: 4px 16px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
        }
        .qr-display svg, .qr-display img { display: block; width: 180px; height: 180px; }

        .qr-info h2 { font-size: 24px; font-weight: 800; margin-bottom: 8px; }
        .qr-info p { font-size: 14px; color: #64748B; line-height: 1.6; margin-bottom: 20px; }

        .qr-url {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
            color: var(--orange);
            font-weight: 600;
            margin-bottom: 20px;
            word-break: break-all;
            display: flex; align-items: center; gap: 8px;
        }

        .action-btns { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn-primary {
            padding: 14px 24px;
            background: linear-gradient(135deg, var(--orange), #E85A24);
            color: white; border: none; border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 700; cursor: pointer;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255,107,53,0.4); }
        .btn-secondary {
            padding: 14px 24px;
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.8); border: 1px solid var(--border); border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 600; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.12); }

        /* Instructions */
        .instructions { background: var(--dark2); border-radius: 20px; padding: 24px; border: 1px solid var(--border); margin-bottom: 24px; }
        .inst-title { font-size: 15px; font-weight: 700; margin-bottom: 16px; }
        .step { display: flex; gap: 14px; margin-bottom: 14px; }
        .step-num { width: 32px; height: 32px; background: linear-gradient(135deg, var(--orange), #E85A24); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 800; flex-shrink: 0; }
        .step-text { padding-top: 6px; font-size: 14px; color: rgba(255,255,255,0.8); line-height: 1.5; }
        .step-text strong { color: white; }

        /* Network hint */
        .network-hint {
            background: rgba(245,158,11,0.1);
            border: 1px solid rgba(245,158,11,0.3);
            border-radius: 14px;
            padding: 16px 20px;
            font-size: 13px;
            color: #FDE68A;
            display: flex; gap: 12px; align-items: flex-start;
        }
        .hint-icon { font-size: 20px; flex-shrink: 0; }
        .hint-text { line-height: 1.6; }
        .hint-text strong { color: #F59E0B; }

        @media print {
            body { background: white; }
            .topbar, .nav-links, .action-btns, .instructions, .stats-row, .network-hint { display: none !important; }
            .qr-main-card { border: none; padding: 20px; display: block; text-align: center; }
            .qr-info { display: none; }
            .qr-display { margin: 0 auto; }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-left">
            <div class="nav-icon">📱</div>
            <div>
                <div class="page-title">QR Code Restoran</div>
                <div class="page-sub">Sio Bak Admin Panel</div>
            </div>
        </div>
        <div class="nav-links">
            <a href="/admin/menus" class="nav-link">🍖 Menu</a>
            <a href="/admin/qrcode" class="nav-link active">📱 QR Code</a>
            <a href="/kitchen" class="nav-link">🍳 Kitchen</a>
            <a href="/" class="nav-link">🏠 Beranda</a>
        </div>
    </div>

    <div class="content">

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-emoji">🍖</div>
                <div class="stat-val orange">{{ $totalMenus }}</div>
                <div class="stat-label">Total Menu</div>
            </div>
            <div class="stat-card">
                <div class="stat-emoji">📋</div>
                <div class="stat-val">{{ $totalOrders }}</div>
                <div class="stat-label">Order Hari Ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-emoji">💰</div>
                <div class="stat-val green">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-label">Revenue Hari Ini</div>
            </div>
        </div>

        <!-- QR Main -->
        <div class="qr-main-card" id="printArea">
            <div class="qr-display">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(180)->errorCorrection('H')->generate($qrUrl) !!}
            </div>

            <div class="qr-info">
                <h2>🔲 QR Code Pemesanan</h2>
                <p>Tempel QR Code ini di setiap meja. Customer tinggal scan, masukkan nomor meja, lalu langsung bisa pesan makanan!</p>
                <div class="qr-url">
                    🌐 {{ $qrUrl }}
                </div>
                <div class="action-btns">
                    <a href="/admin/qrcode/download" class="btn-primary">
                        ⬇️ Download SVG
                    </a>
                    <button class="btn-secondary" onclick="window.print()">
                        🖨️ Print QR Code
                    </button>
                    <button class="btn-secondary" onclick="copyUrl()">
                        📋 Copy URL
                    </button>
                </div>
            </div>
        </div>

        <!-- Network hint -->
        <div class="network-hint" style="margin-bottom:24px">
            <span class="hint-icon">⚠️</span>
            <div class="hint-text">
                <strong>Penting untuk penggunaan di HP:</strong> Saat ini app berjalan di <code>localhost</code>. Agar bisa diakses dari HP pelanggan, pastikan HP dan laptop terhubung ke <strong>WiFi yang sama</strong>, lalu gunakan <strong>IP lokal</strong> Anda (contoh: <code>http://192.168.1.x:8000</code>). Update nilai <code>APP_URL</code> di file <code>.env</code> sesuai IP tersebut.
            </div>
        </div>

        <!-- Instructions -->
        <div class="instructions">
            <div class="inst-title">📖 Cara Penggunaan Sistem Pemesanan</div>
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text">Print atau tampilkan QR Code di atas dan <strong>tempel di setiap meja</strong> restoran</div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text">Customer <strong>scan QR Code</strong> dengan kamera HP → otomatis terbuka halaman web di browser HP</div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text">Customer pilih <strong>nomor meja</strong> mereka di halaman yang muncul</div>
            </div>
            <div class="step">
                <div class="step-num">4</div>
                <div class="step-text">Customer <strong>browse menu</strong>, pilih makanan & minuman, lalu checkout</div>
            </div>
            <div class="step">
                <div class="step-num">5</div>
                <div class="step-text">Pesanan masuk ke <strong>Kitchen Dashboard</strong> → dapur terima notifikasi popup otomatis</div>
            </div>
            <div class="step">
                <div class="step-num">6</div>
                <div class="step-text">Customer bisa <strong>bayar dengan QRIS</strong> simulasi langsung dari HP</div>
            </div>
        </div>

    </div>

    <script>
        function copyUrl() {
            navigator.clipboard.writeText('{{ $qrUrl }}').then(() => {
                const btn = event.target;
                btn.textContent = '✅ Copied!';
                setTimeout(() => btn.textContent = '📋 Copy URL', 2000);
            });
        }
    </script>
</body>
</html>
