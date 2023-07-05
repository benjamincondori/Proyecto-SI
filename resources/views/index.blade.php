<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jady Sport</title>

    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-1">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/images/logo-gym.png') }}" alt="" height="60">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav ms-auto me-lg-4 py-3">
                    <li>
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Disciplinas</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Paquetes</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                </ul>
                <a class="btn-custom ms-lg-4" href="{{ route('login') }}">Ingresar</a>
            </div>
        </div>
    </nav>


    <header class="wave" id="inicio">
        <div class="container">
            {{-- <div class="row">
                <div class="col-md-5 text-white mt-4 ms-md-5 text-center-xs" style="z-index: 1">
                    <h1 class="fw-normal">
                        Desarrollador de páginas web modernas hechas en
                        Bootstrap 5
                    </h1>
                    <p>
                        Manejo profesional de herramientas para diseño y
                        desarrollo de páginas web adquirido a lo largo de mi
                        carrera
                    </p>
                    <a class="btn btn-lg btn-primary" href="#portafolio">
                        Mis trabajos
                        <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </div>
                <div class="col ms-md-5 mt-3 mt-md-0 text-center-xs" style="z-index: 1";>
                    <img class="img-fluid" src="{{ asset('assets/images/fitness.png') }}" width="700" />
                </div>
            </div> --}}
        </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js "
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin=" anonymous "></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>

</html>
