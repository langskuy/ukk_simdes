<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Wonoayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="#">Desa Wonoayu</a>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item mx-3">
                        <a class="nav-link text-white" href="#">AGENDA KEGIATAN PEMDES WONOAYU</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link text-white" href="#">PERATURAN DESA WONOAYU</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <a href="#" class="btn btn-info me-2">Layanan Mandiri</a>
                <a href="#" class="btn btn-success">Login Admin</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero d-flex flex-column justify-content-center align-items-center text-center text-white">
        <div class="overlay"></div>
        <div class="content">
            <img src="{{ asset('images/logo-desa.png') }}" alt="Logo Desa" width="100" class="mb-3">
            <h1 class="fw-bold">Desa Wonoayu</h1>
            <p>Kec. Wonoayu, Kab. Sidoarjo, Provinsi Jawa Timur</p>

            <div class="row justify-content-center mt-3">
                <div class="col-md-3">
                    <img src="{{ asset('images/kegiatan1.jpg') }}" class="img-fluid rounded shadow-sm" alt="Kegiatan 1">
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('images/kegiatan2.jpg') }}" class="img-fluid rounded shadow-sm" alt="Kegiatan 2">
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('images/kegiatan3.jpg') }}" class="img-fluid rounded shadow-sm" alt="Kegiatan 3">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-center text-white p-3 mt-0">
        WEBSITE RESMI DESA WONOAYU KECAMATAN WONOAYU, CS : 085730151992
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
