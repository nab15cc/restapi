<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Data Mahasiswa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="d-flex" style="min-height: 100vh;">
        <div class="bg-danger text-white p-3" style="width: 220px;">
            <div class="mb-4 text-center">
                <img src="{{ asset('assets/image/logo.png') }}" style="max-width: 180px; height: auto;" alt="">
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="/">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mahasiswa') }}">Data Mahasiswa</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link text-white">Logout</a>

                </li>
            </ul>
        </div>
        <div class="flex-fill">
            <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 d-flex justify-content-between">
                <span class="navbar-brand">Sistem Akademik</span>
                <div class="ms-auto">
                    <span class="navbar-text">Selamat Datang, {{ Auth::user()->name }}</span>
                </div>
            </nav>
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
    @yield('scripts')
</body>
</html>
