<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Pembayaran QRIS | Sio Bak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --orange: #FF6B35;
            --dark: #1A1A2E;
            --green: #10B981;
            --cream: #FFF8F5;
            --gray: #F4F4F4;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        body { font-family: 'Poppins', sans-serif; background: var(--gray); min-height: 100vh; }

        .header {
            background: linear-gradient(135deg, var(--dark), #16213E);
            color: white; padding: 16px 18px;
            display: flex; align-items: center; gap: 12px;
        }
        .back-btn {
            width: 36px; height: 36px; background: rgba(255,255,255,0.1);
            border: none; border-radius: 10px; color: white; font-size: 18px;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            text-decoration: none;
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

        /* QRIS Card */
        .qris-card {
            background: white;
            border-radius: 24px;
            padding: 24px;
            margin-bottom: 16px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .qris-header {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            margin-bottom: 20px;
        }
        .qris-logo {
            font-size: 28px;
        }
        .qris-title {
            font-size: 22px; font-weight: 800; color: var(--dark);
        }
        .qris-subtitle { font-size: 12px; color: #888; }

        /* QR Container */
        .qr-container {
            background: linear-gradient(135deg, #1A1A2E, #16213E);
            border-radius: 20px;
            padding: 20px;
            display: inline-block;
            position: relative;
            margin-bottom: 16px;
        }
        .qr-container::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(255,107,53,0.3), transparent);
            pointer-events: none;
        }
        .qr-inner {
            background: white;
            border-radius: 12px;
            padding: 12px;
            display: inline-block;
        }
        .qr-inner svg, .qr-inner img {
            display: block;
            width: 200px;
            height: 200px;
        }

        /* Simulated QR using CSS art */
        .fake-qr {
            width: 200px; height: 200px;
            background: white;
            display: grid;
            grid-template-columns: repeat(21, 1fr);
            grid-template-rows: repeat(21, 1fr);
            gap: 1px;
        }

        .amount-display {
            background: linear-gradient(135deg, #FFF0EB, #FFE0D0);
            border-radius: 16px;
            padding: 16px 24px;
            margin-bottom: 16px;
        }
        .amount-label { font-size: 12px; color: #888; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .amount-value { font-size: 28px; font-weight: 800; color: var(--dark); }

        /* Timer */
        .timer-wrap {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-bottom: 16px;
        }
        .timer-label { font-size: 13px; color: #888; }
        .timer-value { font-size: 16px; font-weight: 700; color: var(--orange); }
        .timer-value.urgent { color: #EF4444; animation: timerBlink 0.5s ease-in-out infinite; }
        @keyframes timerBlink { 0%,100%{opacity:1} 50%{opacity:0.5} }

        .qris-badge {
            display: flex; align-items: center; gap: 8px;
            justify-content: center;
            font-size: 12px; color: #666;
        }
        .bi-logo { font-size: 16px; }

        /* Steps */
        .steps { text-align: left; }
        .step { display: flex; gap: 12px; margin-bottom: 12px; }
        .step-num {
            width: 28px; height: 28px;
            background: var(--orange);
            color: white;
            border-radius: 50%;
            font-size: 13px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .step-text { font-size: 13px; color: #444; line-height: 1.5; padding-top: 4px; }
        .step-text strong { color: var(--dark); font-weight: 700; }

        /* Simulate Button */
        .btn-simulate {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--green), #059669);
            color: white; border: none;
            border-radius: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px; font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(16,185,129,0.4);
            display: flex; align-items: center; justify-content: center; gap: 10px;
            margin-bottom: 10px;
        }
        .btn-simulate:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(16,185,129,0.5); }
        .btn-simulate:disabled { background: #ccc; cursor: not-allowed; transform: none; box-shadow: none; }

        .btn-cancel {
            width: 100%;
            padding: 14px;
            background: transparent;
            color: #888; border: 2px solid #eee;
            border-radius: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            display: flex; align-items: center; justify-content: center;
        }

        /* Success Overlay */
        .success-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 999;
            align-items: center; justify-content: center;
        }
        .success-overlay.show { display: flex; }
        .success-card {
            background: white;
            border-radius: 28px;
            padding: 40px 32px;
            text-align: center;
            max-width: 340px; width: 90%;
            animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes popIn { from{transform:scale(0.5);opacity:0} to{transform:scale(1);opacity:1} }
        .success-icon { font-size: 72px; margin-bottom: 16px; animation: successSpin 0.8s ease-out; }
        @keyframes successSpin { from{transform:rotate(-180deg) scale(0)} to{transform:rotate(0) scale(1)} }
        .success-title { font-size: 24px; font-weight: 800; color: var(--dark); margin-bottom: 8px; }
        .success-sub { font-size: 14px; color: #888; margin-bottom: 24px; }
        .btn-to-status {
            display: block;
            padding: 16px;
            background: linear-gradient(135deg, var(--orange), #E85A24);
            color: white; text-decoration: none;
            border-radius: 16px;
            font-size: 16px; font-weight: 700;
        }

        .sim-notice {
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 11px;
            color: #92400E;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="/order/{{ $order->id }}" class="back-btn">←</a>
        <div>
            <div class="header-title">💳 Pembayaran QRIS</div>
            <div class="header-sub">Order #{{ $order->id }} • Rp {{ number_format($order->total, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="content">

        <div class="qris-card">
            <div class="qris-header">
                <span class="qris-logo">📱</span>
                <div>
                    <div class="qris-title">QRIS</div>
                    <div class="qris-subtitle">Quick Response Code Indonesian Standard</div>
                </div>
            </div>

            <!-- QR Code (SVG generated) -->
            <div class="qr-container">
                <div class="qr-inner">
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(200)->errorCorrection('H')->generate($qrContent) !!}
                </div>
            </div>

            <div class="amount-display">
                <div class="amount-label">Total Pembayaran</div>
                <div class="amount-value">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
            </div>

            <div class="timer-wrap">
                <span class="timer-label">⏱ Berlaku selama:</span>
                <span class="timer-value" id="timerValue">14:59</span>
            </div>

            <div class="qris-badge">
                🏦 <span>Dapat dibayar via semua e-wallet & bank yang mendukung QRIS</span>
            </div>
        </div>

        <!-- Cara Bayar -->
        <div class="card">
            <div style="font-size:14px;font-weight:700;color:var(--dark);margin-bottom:14px;">📖 Cara Bayar QRIS</div>
            <div class="steps">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text">Buka aplikasi <strong>GoPay, OVO, Dana, ShopeePay</strong> atau mobile banking Anda</div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text">Pilih menu <strong>"Scan QR"</strong> atau <strong>"Bayar"</strong></div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text">Arahkan kamera ke <strong>QR Code</strong> di atas</div>
                </div>
                <div class="step">
                    <div class="step-num">4</div>
                    <div class="step-text">Konfirmasi pembayaran sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></div>
                </div>
            </div>
        </div>

        <!-- Simulasi -->
        <div class="sim-notice">
            ⚠️ Mode Simulasi — Klik tombol di bawah untuk mensimulasikan pembayaran berhasil
        </div>

        <button class="btn-simulate" id="simBtn" onclick="simulatePayment()">
            <span>✅</span>
            <span>Simulasi Pembayaran Berhasil</span>
        </button>

        <a href="/order/{{ $order->id }}" class="btn-cancel">← Kembali ke Status Pesanan</a>

    </div>

    <!-- Success Overlay -->
    <div class="success-overlay" id="successOverlay">
        <div class="success-card">
            <div class="success-icon">🎉</div>
            <div class="success-title">Pembayaran Berhasil!</div>
            <div class="success-sub">Terima kasih! Pesanan Anda sedang diproses oleh dapur.</div>
            <a href="/order/{{ $order->id }}" class="btn-to-status">
                Lihat Status Pesanan →
            </a>
        </div>
    </div>

    <script>
        const ORDER_ID = {{ $order->id }};
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // Timer countdown
        let seconds = 14 * 60 + 59;
        const timerEl = document.getElementById('timerValue');

        const timer = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(timer);
                timerEl.textContent = '00:00';
                timerEl.classList.add('urgent');
                return;
            }
            const m = Math.floor(seconds / 60).toString().padStart(2, '0');
            const s = (seconds % 60).toString().padStart(2, '0');
            timerEl.textContent = m + ':' + s;
            if (seconds < 60) timerEl.classList.add('urgent');
        }, 1000);

        // Simulate payment
        async function simulatePayment() {
            const btn = document.getElementById('simBtn');
            btn.disabled = true;
            btn.innerHTML = '<span>⏳</span><span>Memproses...</span>';

            try {
                const res = await fetch('/payment/' + ORDER_ID + '/simulate', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Content-Type': 'application/json',
                    }
                });
                const data = await res.json();

                if (data.success) {
                    clearInterval(timer);
                    document.getElementById('successOverlay').classList.add('show');
                }
            } catch(e) {
                btn.disabled = false;
                btn.innerHTML = '<span>✅</span><span>Simulasi Pembayaran Berhasil</span>';
                alert('Terjadi kesalahan, coba lagi.');
            }
        }

        // Auto-check payment status from other device (polling)
        const pollPayment = setInterval(async () => {
            try {
                const res = await fetch('/api/payment/' + ORDER_ID + '/status');
                const data = await res.json();
                if (data.is_paid) {
                    clearInterval(pollPayment);
                    clearInterval(timer);
                    document.getElementById('successOverlay').classList.add('show');
                }
            } catch(e) {}
        }, 4000);
    </script>
</body>
</html>
