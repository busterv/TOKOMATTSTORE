<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">  <!-- ← PASTIKAN ADA -->
    <title>MATTSTORE - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --emerald: #059669; --slate: #0f172a; --light-bg: #f8fafc; }
        body { background-color: var(--light-bg); font-family: 'Segoe UI', sans-serif; color: var(--slate); }
        .navbar { background-color: var(--slate) !important; }
        .navbar-brand { color: var(--emerald) !important; font-weight: 800; letter-spacing: 1px; }
        .btn-emerald { background-color: var(--emerald); color: white; border: none; }
        .btn-emerald:hover { background-color: #047857; color: white; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .login-bg { background: linear-gradient(135deg, var(--slate) 0%, var(--emerald) 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.2); border-radius: 16px; padding: 2rem; width: 100%; max-width: 400px; }
    </style>
    @yield('styles')
</head>
<body>
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-mobile-alt me-2"></i>MATTSTORE</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pos">Kasir POS</a></li>
                    <li class="nav-item"><a class="nav-link" href="/menu">Master HP</a></li>
                    <li class="nav-item"><a class="nav-link" href="/categories">Kategori</a></li>
                </ul>
                <form method="POST" action="/logout">@csrf<button type="submit" class="btn btn-outline-light btn-sm">Logout</button></form>
            </div>
        </div>
    </nav>
    @endauth

    <div class="container mb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @yield('content')
    </div>

    <footer class="text-center py-4 mt-auto"><small class="text-muted">Developed for: <strong>Riyhan Putra Rohman</strong> | MATTSTORE System © {{ date('Y') }}</small></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function exportToExcel(tableId, filename = 'Laporan_MATTSTORE') {
            let table = document.getElementById(tableId);
            let blob = new Blob(['\ufeff', table.outerHTML], { type: 'application/vnd.ms-excel' });
            let url = URL.createObjectURL(blob);
            let link = document.createElement("a"); link.href = url; link.download = filename + '.xls';
            document.body.appendChild(link); link.click(); document.body.removeChild(link);
        }
        function exportToWord(tableId, filename = 'Laporan_MATTSTORE') {
            let table = document.getElementById(tableId);
            let html = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'></head><body>" + table.outerHTML + "</body></html>";
            let blob = new Blob(['\ufeff', html], { type: 'application/msword' });
            let url = URL.createObjectURL(blob);
            let link = document.createElement("a"); link.href = url; link.download = filename + '.doc';
            document.body.appendChild(link); link.click(); document.body.removeChild(link);
        }
    </script>
    @yield('scripts')
</body>
</html>