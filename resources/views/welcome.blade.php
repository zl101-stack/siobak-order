<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sio Bak — Selamat Datang</title>
    <meta name="description" content="Restoran Sio Bak - Pesan makanan lezat langsung dari meja Anda">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --orange: #FF6B35;
            --orange-dark: #E85A24;
            --orange-light: #FFF0EB;
            --dark: #1A1A2E;
            --dark-2: #16213E;
            --cream: #FFF8F5;
            --text: #333;
            --text-light: #888;
            --radius: 20px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Background decorations */
        body::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,107,53,0.3) 0%, transparent 70%);
            top: -100px; right: -100px;
            animation: pulse 4s ease-in-out infinite;
        }
        body::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,107,53,0.15) 0%, transparent 70%);
            bottom: -50px; left: -50px;
            animation: pulse 4s ease-in-out infinite 2s;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
        }

        .card {
            background: white;
            border-radius: 32px;
            padding: 40px 32px;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 10;
            box-shadow: 0 40px 80px rgba(0,0,0,0.4);
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-wrap {
            text-align: center;
            margin-bottom: 28px;
        }
        .logo-icon {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            font-size: 40px;
            margin: 0 auto 16px;
            box-shadow: 0 12px 30px rgba(255,107,53,0.4);
            animation: bounce 2s ease-in-out infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .logo-name {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
            line-height: 1.1;
        }
        .logo-name span { color: var(--orange); }
        .logo-tagline {
            font-size: 13px;
            color: var(--text-light);
            margin-top: 4px;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #eee, transparent);
            margin: 20px 0;
        }

        .section-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .input-wrap {
            position: relative;
            margin-bottom: 20px;
        }
        .input-icon {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
        }
        input[type="number"] {
            width: 100%;
            padding: 18px 18px 18px 52px;
            border: 2px solid #eee;
            border-radius: 16px;
            font-size: 22px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: var(--dark);
            outline: none;
            transition: all 0.3s;
            background: var(--cream);
            -moz-appearance: textfield;
        }
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; }
        input[type="number"]:focus {
            border-color: var(--orange);
            background: white;
            box-shadow: 0 0 0 4px rgba(255,107,53,0.1);
        }

        .btn-primary {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 17px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 24px rgba(255,107,53,0.4);
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(255,107,53,0.5);
        }
        .btn-primary:active { transform: translateY(0); }

        .quick-tables {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin-bottom: 20px;
        }
        .quick-table-btn {
            padding: 10px 0;
            background: var(--orange-light);
            color: var(--orange-dark);
            border: 2px solid transparent;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
        }
        .quick-table-btn:hover, .quick-table-btn.active {
            background: var(--orange);
            color: white;
            border-color: var(--orange-dark);
            transform: scale(1.05);
        }

        .info-row {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        .info-chip {
            flex: 1;
            background: var(--cream);
            border-radius: 14px;
            padding: 14px;
            text-align: center;
        }
        .info-chip .emoji { font-size: 22px; display: block; margin-bottom: 4px; }
        .info-chip .label { font-size: 11px; color: var(--text-light); font-weight: 500; }
        .info-chip .val { font-size: 13px; color: var(--dark); font-weight: 700; }

        .bottom-link {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: var(--text-light);
        }
        .bottom-link a {
            color: var(--orange);
            text-decoration: none;
            font-weight: 600;
        }

        .error-msg {
            background: #FEE2E2;
            color: #EF4444;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex; align-items: center; gap: 8px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo-wrap">
            <div class="logo-icon">🍖</div>
            <div class="logo-name">Sio <span>Bak</span></div>
            <div class="logo-tagline">Authentic Chinese Pork Restaurant</div>
        </div>

        <div class="divider"></div>

        <div class="section-label">📍 Pilih Nomor Meja Anda</div>

        @if(session('error'))
            <div class="error-msg">⚠️ {{ session('error') }}</div>
        @endif

        <form action="" method="GET" id="tableForm">
            <div class="input-wrap">
                <span class="input-icon">🪑</span>
                <input
                    type="number"
                    name="table"
                    id="tableInput"
                    placeholder="Contoh: 5"
                    min="1" max="100"
                    required
                    autocomplete="off"
                >
            </div>

            <div class="section-label" style="margin-top: 4px;">Atau pilih cepat:</div>
            <div class="quick-tables">
                @foreach(range(1, 10) as $n)
                    <button type="button" class="quick-table-btn" onclick="selectTable({{ $n }})">{{ $n }}</button>
                @endforeach
            </div>

            <button type="submit" class="btn-primary" id="submitBtn">
                <span>🍽️</span>
                <span>Lihat Menu</span>
            </button>
        </form>

        <div class="info-row">
            <div class="info-chip">
                <span class="emoji">⚡</span>
                <span class="label">Pesan</span>
                <span class="val">Cepat & Mudah</span>
            </div>
            <div class="info-chip">
                <span class="emoji">💳</span>
                <span class="label">Bayar</span>
                <span class="val">QRIS</span>
            </div>
            <div class="info-chip">
                <span class="emoji">🍳</span>
                <span class="label">Proses</span>
                <span class="val">Realtime</span>
            </div>
        </div>

        <div class="bottom-link">
            Staff? <a href="/kitchen">🔑 Kitchen Dashboard</a> &nbsp;|&nbsp; <a href="/admin/menus">⚙️ Admin</a>
        </div>
    </div>

    <script>
        const form = document.getElementById('tableForm');
        const input = document.getElementById('tableInput');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const table = input.value;
            if (!table || table < 1) {
                input.focus();
                input.style.borderColor = '#EF4444';
                return;
            }
            window.location.href = '/menu/' + table;
        });

        function selectTable(num) {
            input.value = num;
            input.style.borderColor = '#FF6B35';
            document.querySelectorAll('.quick-table-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Auto submit after 300ms
            setTimeout(() => {
                window.location.href = '/menu/' + num;
            }, 300);
        }

        input.addEventListener('input', function() {
            this.style.borderColor = '';
            document.querySelectorAll('.quick-table-btn').forEach(btn => btn.classList.remove('active'));
            const val = parseInt(this.value);
            if (val >= 1 && val <= 10) {
                document.querySelectorAll('.quick-table-btn')[val - 1]?.classList.add('active');
            }
        });
    </script>
</body>
</html>
