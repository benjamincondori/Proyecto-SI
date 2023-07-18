<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jady Sport</title>

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon"/>
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

    @livewireStyles
</head>

<body class="antialiased">

    {{ $slot }}

    @livewireScripts

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>  

    <script>
        livewire.on('accesoDenegado', function() {
            Swal.fire({
                icon: 'warning',
                title: '¡Acceso Denegado!',
                text: 'No tiene los permisos necesarios.'           
            })
        });
    </script>
    
    @stack('js')

</body>

</html>
