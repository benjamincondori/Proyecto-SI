<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Asistencias</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    
    <section>
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="2" class="text-center">
                    <span style="font-size: 25px; font-weight: bold;">Jady Sport Gym Center</span>
                </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative;">
                    <img src="assets/images/logo-gym-dark.png" alt="" height="100">
                </td>
                <td width="70%" class="text-left" style="vertical-align: top; padding-top: 10px;">
                    @if ($tipoReporte == 0)
                        <span><strong>Reporte de Asistencias del Día</strong></span>
                    @else
                        <span><strong>Reporte de Asistencias por Fechas</strong></span>
                    @endif
                    <br>
                    @if ($tipoReporte != 0)
                        <span><strong>Fecha de Consulta:</strong> 
                            {{ \Carbon\Carbon::parse($fechaInicio)->format('d-m-Y') }} al 
                            {{ \Carbon\Carbon::parse($fechaFin)->format('d-m-Y') }}</span>
                    @else
                        <span><strong>Fecha de Consulta:</strong> {{\Carbon\Carbon::now()->format('d-m-Y')}} </span>
                    @endif
                    <br>
                    <span><strong>Usuario:</strong> 
                        @if (isset($usuario))
                            {{ $usuario->nombres }} {{ $usuario->apellidos }} 
                        @else
                            Todos
                        @endif
                    </span>
                    <br>
                    <span><strong>Cliente:</strong> 
                        @if (isset($cliente))
                            {{ $cliente->nombres }} {{ $cliente->apellidos }} 
                        @else
                            Todos
                        @endif
                    </span>
                </td>
            </tr>
        </table>
    </section>

    <section>
        <div class="table-responsive mt-4">
            <table class="table table-bordered" cellpadding="0" cellspacing="0">
                <thead class="bg-dark text-white text-nowrap text-center">
                    <tr style="cursor: pointer">
                        <th scope="col">ID</th>
                        <th scope="col">Fecha Ingreso</th>
                        <th scope="col">Hora Ingreso</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Administrativo</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($asistencias) && $asistencias->count())
                        @foreach ($asistencias as $asistencia)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $asistencia->id }}</th>
                                <td class="align-middle">
                                    {{ $asistencia->fecha_de_ingreso }}</td>
                                <td class="align-middle text-nowrap">
                                    {{ $asistencia->hora_de_ingreso }}</td>
                                <td class="align-middle">
                                    {{ $asistencia->cliente->nombres }} 
                                    {{ $asistencia->cliente->apellidos }}
                                </td>
                                <td class="align-middle">
                                    {{ $asistencia->administrativo->empleado->nombres }} 
                                    {{ $asistencia->administrativo->empleado->apellidos }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="6">Sin resultados.</td>
                        </tr>
                    @endif
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <td class="text-center">
                            <span><b>TOTAL</b></span>
                        </td>
                        <td class="text-center">
                            <span><strong>{{ $inscripciones->count() }}</strong></span>
                        </td>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </section>

    {{-- <section style="position: fixed; bottom: 0; width: 100%;">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="20%">
                    <span>Jady Sport Gym Center</span>
                </td>
                <td width="60%" class="text-center">
                    <span>Sistemas de Informacion 1</span>
                </td>
                <td width="20%" class="text-right">
                    Página <span></span>
                </td>
            </tr>
        </table>
    </section> --}}


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

    






