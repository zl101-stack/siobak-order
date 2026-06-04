<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Menu | Sio Bak Admin</title>
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
            --green: #10B981;
            --red: #EF4444;
            --yellow: #F59E0B;
            --border: rgba(255,255,255,0.08);
        }
        body { font-family: 'Poppins', sans-serif; background: var(--dark); color: white; min-height: 100vh; }

        .topbar {
            background: var(--dark2);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            display: flex; align-items: center; justify-content: space-between;
            height: 64px;
            position: sticky; top: 0; z-index: 100;
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .nav-icon { font-size: 22px; width: 40px; height: 40px; background: rgba(255,107,53,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .page-title { font-size: 17px; font-weight: 700; }
        .page-sub { font-size: 11px; color: #64748B; }
        .nav-links { display: flex; gap: 8px; }
        .nav-link { padding: 8px 14px; background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.7); border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: rgba(255,107,53,0.2); color: var(--orange); }

        .content { padding: 24px; }

        /* Stats */
        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 24px; }
        .stat-card { background: var(--dark2); border-radius: 14px; padding: 16px; border: 1px solid var(--border); }
        .stat-label { font-size: 11px; color: #64748B; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .stat-val { font-size: 24px; font-weight: 800; }
        .stat-val.green { color: var(--green); }
        .stat-val.yellow { color: var(--yellow); }
        .stat-val.red { color: var(--red); }

        /* Alerts */
        .alert {
            padding: 14px 18px; border-radius: 12px;
            margin-bottom: 20px; font-size: 14px; font-weight: 600;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: var(--green); }
        .alert-error { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: var(--red); }

        /* Add Menu Form */
        .add-form-section { background: var(--dark2); border-radius: 20px; padding: 20px; margin-bottom: 24px; border: 1px solid var(--border); }
        .section-title { font-size: 15px; font-weight: 700; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .form-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 12px; align-items: end; }
        .form-group label { display: block; font-size: 11px; color: #64748B; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 14px;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: rgba(255,107,53,0.5);
            background: rgba(255,107,53,0.05);
        }
        .form-group select option { background: var(--dark2); }
        .btn-add {
            padding: 12px 20px;
            background: linear-gradient(135deg, var(--orange), #E85A24);
            color: white; border: none; border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 700; cursor: pointer;
            white-space: nowrap; transition: all 0.2s;
        }
        .btn-add:hover { transform: scale(1.02); }

        /* Tab system */
        .tabs { display: flex; gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 10px 20px; background: rgba(255,255,255,0.06); border: none; border-radius: 12px; color: rgba(255,255,255,0.6); font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .tab-btn.active { background: rgba(255,107,53,0.2); color: var(--orange); border: 1px solid rgba(255,107,53,0.3); }

        /* Menu Table */
        .menu-table-wrap { background: var(--dark2); border-radius: 20px; border: 1px solid var(--border); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: rgba(255,255,255,0.04); padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 14px 16px; border-bottom: 1px solid var(--border); font-size: 13px; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,0.02); }

        .menu-name-cell { font-weight: 700; color: white; }
        .menu-desc-cell { color: #64748B; font-size: 11px; max-width: 200px; }

        /* Category badge */
        .cat-badge { padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; }
        .cat-badge.makanan { background: rgba(255,107,53,0.2); color: #FFB899; }
        .cat-badge.minuman { background: rgba(59,130,246,0.2); color: #93C5FD; }

        /* Stock editor */
        .stock-wrap { display: flex; align-items: center; gap: 8px; }
        .stock-input { width: 70px; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 8px; padding: 6px 10px; color: white; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 700; text-align: center; outline: none; }
        .stock-input:focus { border-color: rgba(255,107,53,0.5); }
        .stock-save-btn { padding: 6px 10px; background: rgba(16,185,129,0.2); color: var(--green); border: none; border-radius: 8px; font-size: 12px; cursor: pointer; font-weight: 700; transition: all 0.2s; }
        .stock-save-btn:hover { background: rgba(16,185,129,0.3); }
        .stock-low { color: var(--yellow); }
        .stock-out { color: var(--red); }

        /* Availability toggle */
        .toggle-switch { position: relative; width: 44px; height: 24px; cursor: pointer; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; inset: 0; background: #334155; border-radius: 99px; transition: 0.3s; }
        .toggle-slider::before { content: ''; position: absolute; width: 18px; height: 18px; background: white; border-radius: 50%; left: 3px; top: 3px; transition: 0.3s; }
        input:checked + .toggle-slider { background: var(--green); }
        input:checked + .toggle-slider::before { transform: translateX(20px); }

        .action-btns { display: flex; gap: 8px; }
        .btn-edit { padding: 6px 12px; background: rgba(59,130,246,0.2); color: #93C5FD; border: none; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s; }
        .btn-del { padding: 6px 12px; background: rgba(239,68,68,0.15); color: var(--red); border: none; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s; }
        .btn-edit:hover { background: rgba(59,130,246,0.3); }
        .btn-del:hover { background: rgba(239,68,68,0.25); }

        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr 1fr; }
            .stats-row { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="topbar">
        <div class="topbar-left">
            <div class="nav-icon">⚙️</div>
            <div>
                <div class="page-title">Manajemen Menu</div>
                <div class="page-sub">Sio Bak Admin Panel</div>
            </div>
        </div>
        <div class="nav-links">
            <a href="/admin/menus" class="nav-link active">🍖 Menu</a>
            <a href="/admin/qrcode" class="nav-link">📱 QR Code</a>
            <a href="/kitchen" class="nav-link">🍳 Kitchen</a>
            <a href="/" class="nav-link">🏠 Beranda</a>
        </div>
    </div>

    <div class="content">

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error') || $errors->any())
            <div class="alert alert-error">❌ {{ session('error') ?? $errors->first() }}</div>
        @endif

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Total Menu</div>
                <div class="stat-val">{{ $makanan->count() + $minuman->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Menu Tersedia</div>
                <div class="stat-val green">{{ ($makanan->where('stock', '>', 0)->count() + $minuman->where('stock', '>', 0)->count()) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Stok Rendah</div>
                <div class="stat-val yellow">{{ ($makanan->where('stock', '<=', 5)->where('stock', '>', 0)->count() + $minuman->where('stock', '<=', 5)->where('stock', '>', 0)->count()) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Menu Habis</div>
                <div class="stat-val red">{{ ($makanan->where('stock', '<=', 0)->count() + $minuman->where('stock', '<=', 0)->count()) }}</div>
            </div>
        </div>

        <!-- Add Menu Form -->
        <div class="add-form-section">
            <div class="section-title">➕ Tambah Menu Baru</div>
            <form action="/admin/menus" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Menu *</label>
                        <input type="text" name="name" placeholder="Nama menu..." required>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp) *</label>
                        <input type="number" name="price" placeholder="25000" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="category" required>
                            <option value="makanan">🍖 Makanan</option>
                            <option value="minuman">🥤 Minuman</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stok Awal</label>
                        <input type="number" name="stock" placeholder="50" min="0" value="50">
                    </div>
                    <button type="submit" class="btn-add">+ Tambah</button>
                </div>
                <div class="form-group" style="margin-top:12px">
                    <label>Deskripsi (Opsional)</label>
                    <input type="text" name="description" placeholder="Deskripsi singkat menu...">
                </div>
            </form>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('makanan', this)">🍖 Makanan ({{ $makanan->count() }})</button>
            <button class="tab-btn" onclick="showTab('minuman', this)">🥤 Minuman ({{ $minuman->count() }})</button>
        </div>

        <!-- Makanan Table -->
        <div id="tab-makanan" class="tab-content">
            <div class="menu-table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Tersedia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($makanan as $menu)
                            <tr id="menu-row-{{ $menu->id }}">
                                <td style="color:#64748B">{{ $menu->id }}</td>
                                <td>
                                    <div class="menu-name-cell">{{ $menu->name }}</div>
                                    <div class="menu-desc-cell">{{ $menu->description }}</div>
                                </td>
                                <td style="font-weight:700;color:#FFB899">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="stock-wrap">
                                        <input type="number" class="stock-input {{ $menu->stock <= 0 ? 'stock-out' : ($menu->stock <= 5 ? 'stock-low' : '') }}"
                                               id="stock-input-{{ $menu->id }}"
                                               value="{{ $menu->stock }}" min="0">
                                        <button class="stock-save-btn" onclick="saveStock({{ $menu->id }})">💾</button>
                                    </div>
                                </td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" {{ $menu->is_available ? 'checked' : '' }} onchange="toggleAvail({{ $menu->id }}, this.checked)">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <form action="/admin/menus/{{ $menu->id }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-del">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;color:#64748B;padding:30px">Belum ada menu makanan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Minuman Table -->
        <div id="tab-minuman" class="tab-content" style="display:none">
            <div class="menu-table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Tersedia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($minuman as $menu)
                            <tr id="menu-row-{{ $menu->id }}">
                                <td style="color:#64748B">{{ $menu->id }}</td>
                                <td>
                                    <div class="menu-name-cell">{{ $menu->name }}</div>
                                    <div class="menu-desc-cell">{{ $menu->description }}</div>
                                </td>
                                <td style="font-weight:700;color:#93C5FD">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="stock-wrap">
                                        <input type="number" class="stock-input {{ $menu->stock <= 0 ? 'stock-out' : ($menu->stock <= 5 ? 'stock-low' : '') }}"
                                               id="stock-input-{{ $menu->id }}"
                                               value="{{ $menu->stock }}" min="0">
                                        <button class="stock-save-btn" onclick="saveStock({{ $menu->id }})">💾</button>
                                    </div>
                                </td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" {{ $menu->is_available ? 'checked' : '' }} onchange="toggleAvail({{ $menu->id }}, this.checked)">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <form action="/admin/menus/{{ $menu->id }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-del">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;color:#64748B;padding:30px">Belum ada menu minuman</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        function showTab(tab, btn) {
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            document.getElementById('tab-' + tab).style.display = 'block';
            btn.classList.add('active');
        }

        async function saveStock(menuId) {
            const input = document.getElementById('stock-input-' + menuId);
            const stock = parseInt(input.value);
            if (isNaN(stock) || stock < 0) return;

            try {
                const res = await fetch('/admin/menus/' + menuId + '/stock', {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
                    body: JSON.stringify({ stock })
                });
                const data = await res.json();
                if (data.success) {
                    input.className = 'stock-input ' + (stock <= 0 ? 'stock-out' : stock <= 5 ? 'stock-low' : '');
                    showAlert('✅ ' + data.message);
                }
            } catch(e) { showAlert('❌ Gagal menyimpan stok', true); }
        }

        async function toggleAvail(menuId, val) {
            try {
                await fetch('/admin/menus/' + menuId, {
                    method: 'PUT',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
                    body: JSON.stringify({ is_available: val })
                });
                showAlert('✅ Status menu diperbarui');
            } catch(e) {}
        }

        let alertTimer;
        function showAlert(msg, isError = false) {
            let alert = document.getElementById('tempAlert');
            if (!alert) {
                alert = document.createElement('div');
                alert.id = 'tempAlert';
                alert.style.cssText = 'position:fixed;top:80px;right:24px;padding:14px 20px;border-radius:14px;font-size:13px;font-weight:600;z-index:999;transition:all 0.3s';
                document.body.appendChild(alert);
            }
            alert.textContent = msg;
            alert.style.background = isError ? 'rgba(239,68,68,0.9)' : 'rgba(16,185,129,0.9)';
            alert.style.color = 'white';
            alert.style.transform = 'translateX(0)';
            clearTimeout(alertTimer);
            alertTimer = setTimeout(() => alert.style.transform = 'translateX(300px)', 2500);
        }
    </script>
</body>
</html>
