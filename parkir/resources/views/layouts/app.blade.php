<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIJA Parking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root {
            --pink:        #e91e8c;
            --pink-dark:   #c2185b;
            --pink-light:  #fce4ec;
            --pink-soft:   rgba(233,30,140,0.12);
            --sidebar-w:   250px;
            --radius-lg:   16px;
            --radius-md:   12px;
            --radius-sm:   8px;
            --shadow-card: 0 4px 24px rgba(0,0,0,0.07);
            --shadow-soft: 0 2px 12px rgba(233,30,140,0.10);
            --bg:          #f0f2f8;
            --white:       #ffffff;
            --text-main:   #2d3436;
            --text-muted:  #8592a6;
            --border:      rgba(0,0,0,0.06);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            display: flex;
            min-height: 100vh;
            color: var(--text-main);
        }

        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
        }

        .sidebar-inner {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-brand-icon {
            width: 38px; height: 38px;
            border-radius: var(--radius-sm);
            background: linear-gradient(135deg, var(--pink), var(--pink-dark));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 16px;
            box-shadow: 0 4px 14px rgba(233,30,140,0.4);
            flex-shrink: 0;
        }

        .sidebar-brand-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.2;
        }
        .sidebar-brand-sub {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .sidebar-divider {
            margin: 0.75rem 1.25rem;
            border: none;
            border-top: 1px solid var(--border);
        }

        .sidebar-section-label {
            padding: 0.25rem 1.25rem 0.4rem;
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

            .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.6rem 0.85rem;
            border-radius: var(--radius-sm);
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.18s ease;
            margin-bottom: 2px;
        }

        .sidebar-menu a .nav-icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            background: transparent;
            transition: all 0.18s ease;
            flex-shrink: 0;
        }

        .sidebar-menu a:hover {
            color: var(--text-main);
            background: var(--bg);
        }
        .sidebar-menu a:hover .nav-icon {
            background: var(--bg);
        }

        .sidebar-menu a.active {
            color: var(--text-main);
            background: var(--pink-soft);
        }
        .sidebar-menu a.active .nav-icon {
            background: linear-gradient(135deg, var(--pink), var(--pink-dark));
            color: #fff;
            box-shadow: 0 3px 10px rgba(233,30,140,0.35);
        }

        .sidebar-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--pink), var(--pink-dark));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 14px;
        }

        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            padding: 1rem 1.75rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-left { flex: 1; }

        .breadcrumb {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 2px;
        }
        .breadcrumb span { color: var(--text-main); font-weight: 600; }

        .topbar-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-main);
        }

        .topbar-search {
            display: flex; align-items: center; gap: 8px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0 14px; height: 36px;
            box-shadow: var(--shadow-card);
        }
        .topbar-search input {
            border: none; background: transparent;
            font-size: 12.5px; outline: none; width: 150px;
            font-family: inherit; color: var(--text-main);
        }
        .topbar-search i { color: var(--text-muted); font-size: 12px; }

        .topbar-icon-btn {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--white);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            font-size: 14px;
            cursor: pointer;
            box-shadow: var(--shadow-card);
            text-decoration: none;
            transition: all 0.15s;
        }
        .topbar-icon-btn:hover {
            background: var(--pink-soft);
            color: var(--pink);
            border-color: rgba(233,30,140,0.2);
        }

        .page-body { padding: 0 1.75rem 1.75rem; flex: 1; }

        .card {
            background: var(--white);
            border-radius: var(--radius-lg);
            border: none;
            padding: 1.5rem;
            margin-bottom: 1.25rem;
            box-shadow: var(--shadow-card);
        }

        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 8px;
        }
        .card-title::before {
            content: '';
            display: inline-block;
            width: 3px; height: 16px;
            border-radius: 4px;
            background: linear-gradient(135deg, var(--pink), var(--pink-dark));
        }
        .card-title span { color: var(--pink); }

        .btn-primary {
            background: linear-gradient(135deg, var(--pink), var(--pink-dark));
            color: #fff; border: none;
            border-radius: 8px;
            padding: 0.5rem 1.1rem;
            font-size: 12.5px; font-weight: 600;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none;
            transition: all 0.18s;
            box-shadow: 0 4px 14px rgba(233,30,140,0.35);
            font-family: inherit;
        }
        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(233,30,140,0.45);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-outline {
            background: var(--white);
            color: var(--text-main);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 1.1rem;
            font-size: 12.5px; font-weight: 600;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none;
            transition: all 0.18s;
            box-shadow: var(--shadow-card);
            font-family: inherit;
        }
        .btn-outline:hover { background: var(--bg); }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b, #e53935);
            color: #fff; border: none;
            border-radius: 8px;
            padding: 0.4rem 0.9rem;
            font-size: 12px; font-weight: 600;
            cursor: pointer; font-family: inherit;
            box-shadow: 0 3px 10px rgba(229,57,53,0.3);
        }
        .btn-danger:hover { box-shadow: 0 5px 15px rgba(229,57,53,0.4); }

        .btn-secondary {
            background: linear-gradient(135deg, #636e72, #2d3436);
            color: #fff; border: none;
            border-radius: 8px;
            padding: 0.5rem 1.1rem;
            font-size: 12.5px; font-weight: 600;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-sm { padding: 0.35rem 0.8rem; font-size: 12px; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead th {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 0.7rem 0.9rem;
            text-align: left;
            font-weight: 700;
            color: var(--text-muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tbody td {
            padding: 0.75rem 0.9rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-main);
            font-size: 13px;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr { transition: background 0.12s; }
        tbody tr:hover { background: var(--bg); }

        .form-group { margin-bottom: 1.2rem; }
        .form-label {
            display: block;
            font-size: 12.5px; font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .form-control {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0.6rem 0.9rem;
            font-size: 13.5px;
            outline: none;
            transition: border 0.18s, box-shadow 0.18s;
            color: var(--text-main);
            background: var(--white);
            font-family: inherit;
        }
        .form-control:focus {
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(233,30,140,0.1);
        }
        select.form-control { background: var(--white); }

        .alert {
            padding: 0.85rem 1.1rem;
            border-radius: var(--radius-md);
            font-size: 13px; font-weight: 500;
            margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-danger {
            background: #fff0f0;
            color: #c62828;
            border-left: 4px solid #e53935;
        }
        .alert-success {
            background: #f0fff4;
            color: #1b5e20;
            border-left: 4px solid #43a047;
        }

        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(45,52,54,0.5);
            backdrop-filter: blur(4px);
            z-index: 999;
            display: flex; align-items: center; justify-content: center;
        }
        .modal-box {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 2.5rem 2rem;
            text-align: center;
            max-width: 420px; width: 90%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            animation: modalIn 0.25s ease;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(16px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .modal-icon-success {
            width: 68px; height: 68px; border-radius: 50%;
            background: linear-gradient(135deg, #69f0ae, #43a047);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem; color: #fff; font-size: 28px;
            box-shadow: 0 8px 20px rgba(67,160,71,0.35);
        }
        .modal-title { font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem; }
        .modal-msg   { color: var(--text-muted); font-size: 13.5px; margin-bottom: 1.75rem; }

        footer {
            text-align: center;
            padding: 1rem 1.75rem;
            font-size: 11.5px; color: var(--text-muted);
            border-top: 1px solid var(--border);
        }
        footer a { color: var(--pink); text-decoration: none; font-weight: 600; }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.25rem 1.5rem;
            box-shadow: var(--shadow-card);
            display: flex; align-items: center; gap: 1rem;
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: #fff; flex-shrink: 0;
        }
        .stat-icon.pink    { background: linear-gradient(135deg, var(--pink), var(--pink-dark)); box-shadow: 0 4px 14px rgba(233,30,140,0.35); }
        .stat-icon.blue    { background: linear-gradient(135deg, #4fc3f7, #0288d1); box-shadow: 0 4px 14px rgba(2,136,209,0.35); }
        .stat-icon.green   { background: linear-gradient(135deg, #69f0ae, #00897b); box-shadow: 0 4px 14px rgba(0,137,123,0.35); }
        .stat-icon.orange  { background: linear-gradient(135deg, #ffcc02, #fb8c00); box-shadow: 0 4px 14px rgba(251,140,0,0.35); }
        .stat-label { font-size: 12px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
        .stat-value { font-size: 22px; font-weight: 800; color: var(--text-main); margin-top: 2px; }

        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 700;
        }
        .badge-success { background: #e8f5e9; color: #2e7d32; }
        .badge-danger  { background: #ffebee; color: #c62828; }
        .badge-warning { background: #fff8e1; color: #f57f17; }
        .badge-info    { background: #e3f2fd; color: #0277bd; }
    </style>
    @stack('styles')
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-inner">

            <div class="sidebar-brand">
                 <img src="{{ asset('images/logo.png') }}" onerror="this.src='{{ asset('public/images/logo.png') }}'" width="34" height="34" class="me-2" style="object-fit: contain;">
                <div>
                    <div class="sidebar-brand-name">SIJA Parking</div>
                </div>
            </div>

            <nav class="sidebar-menu" style="padding-top:0.75rem;">
                <div class="sidebar-section-label">Main Menu</div>

                <a href="{{ route('locations.index') }}"
                   class="{{ request()->routeIs('locations.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-map-marker-alt"></i></span>
                    Location
                </a>

                <a href="{{ route('transactions.index') }}"
                   class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-exchange-alt"></i></span>
                    Transaction
                </a>

                <a href="{{ route('vehicle-types.index') }}"
                   class="{{ request()->routeIs('vehicle-types.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-car"></i></span>
                    Vehicle Type
                </a>

                <hr class="sidebar-divider" style="margin-top:0.75rem;">
                <div class="sidebar-section-label">Reports</div>

                <a href="{{ route('reports.location') }}"
                   class="{{ request()->routeIs('reports.location') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                    Location Report
                </a>

                <a href="{{ route('reports.transaction') }}"
                   class="{{ request()->routeIs('reports.transaction') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-file-invoice"></i></span>
                    Transaction Report
                </a>
            </nav>

        </div>
    </aside>

    <div class="main-content">

        <div class="topbar">
            <div class="topbar-left">
                <div class="breadcrumb">Pages / <span>@yield('page-title', 'Dashboard')</span></div>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            </div>

            @yield('topbar-search')
            @yield('topbar-actions')

            <a href="#" class="topbar-icon-btn" title="Sign Out">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>

        <div class="page-body">
            @yield('content')
        </div>

        <footer>
            &copy; 2025, made with ❤️ by <a href="#">Coding Lover</a> for ASAS Ganjil Web And Mobile Development – SMKN 1 Cibinong.
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#e91e8c',
            confirmButtonText: 'OK',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#e91e8c',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @if(session('success_tiket'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Tiket Berhasil Dicetak!',
            html: 'No. Tiket: <strong>{{ session('success_tiket') }}</strong>',
            confirmButtonColor: '#e91e8c',
            confirmButtonText: 'OK',
            timer: 4000,
            timerProgressBar: true
        });
    </script>
    @endif

    @if(session('total_bayar'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Pembayaran Berhasil!',
            html: '<span style="font-size:28px;font-weight:800;color:#e91e8c;">Rp {{ number_format(session('total_bayar'), 0, ',', '.') }}</span>',
            confirmButtonColor: '#e91e8c',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

</body>
</html>