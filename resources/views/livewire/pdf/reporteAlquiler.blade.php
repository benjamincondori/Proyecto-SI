<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Alquileres</title>

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
                        <span><strong>Reporte de Alquileres del Día</strong></span>
                    @else
                        <span><strong>Reporte de Alquileres por Fechas</strong></span>
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
                    <br>
                    <span><strong>Casillero:</strong> 
                        @if (isset($casillero))
                            {{ $casillero->nro }}
                        @else
                            Todos
                        @endif
                    </span>
                    <br>
                    <span><strong>Estado:</strong> 
                        @if ($estado == 0)
                            Vencida
                        @elseif ($estado == 1) 
                            Activa
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
                        <th scope="col">Fecha Alquiler</th>
                        <th scope="col">Fecha Inicio</th>
                        <th scope="col">Fecha Fin</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Administrativo</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Nro Casillero</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($alquileres) && $alquileres->count())
                        @foreach ($alquileres as $alquiler)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $alquiler->id }}</th>
                                <td class="align-middle">
                                    {{ $alquiler->fecha_alquiler }}</td>
                                <td class="align-middle text-nowrap">
                                    {{ $alquiler->fecha_inicio }}</td>
                                <td class="align-middle text-nowrap">
                                    {{ $alquiler->fecha_fin }}</td>
                                <td class="align-middle">
                                    {{ $alquiler->cliente->nombres }} 
                                    {{ $alquiler->cliente->apellidos }}
                                </td>
                                <td class="align-middle">
                                    {{ $alquiler->administrativo->empleado->nombres }} 
                                    {{ $alquiler->administrativo->empleado->apellidos }}
                                </td>
                                <td class="align-middle text-nowrap">
                                    @if (is_null($alquiler->estado))
                                        <span class="text-warning py-1 px-2 rounded-lg d-inline-block"
                                        style="background-color: #ffeeba; width: 90px">Pendiente</span>
                                    @elseif ($alquiler->estado === 0)
                                        <span class="text-danger py-1 px-2 rounded-lg d-inline-block" style="background-color: #f8d7da; width: 90px">Vencida</span>
                                    @elseif ($alquiler->estado === 1)
                                        <span class="text-success py-1 px-2 rounded-lg d-inline-block" style="background-color: #c3e6cb; width: 90px">Activa</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    {{ $alquiler->casillero->nro }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="9">Sin resultados.</td>
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

    






