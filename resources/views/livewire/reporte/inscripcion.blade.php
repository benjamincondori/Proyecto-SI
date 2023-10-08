<div>

    <div class="row justify-content-center font-weight-bold font-22 mb-2">
        Reportes de Inscripciones</div>

    <hr style="background: rgb(237, 237, 237); height: 1.2px">

    <div class="row">

        <div class="col-md-3 px-1">
            <div class="form-group">
                <label class="control-label mb-1"><strong>Elige el administrativo</strong></label>
                <select class="form-control text-truncate" wire:model="id_administrativo">
                    <option value="0">Todos</option>
                    @foreach ($administrativos as $administrativo)
                        <option value="{{ $administrativo->id }}">
                            {{ $administrativo->nombres }} 
                            {{ $administrativo->apellidos }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3 px-1">
            <div class="form-group">
                <label class="control-label mb-1"><strong>Elige el cliente</strong></label>
                <select class="form-control text-truncate" wire:model="id_cliente">
                    <option value="0">Todos</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">
                            {{ $cliente->nombres }} {{ $cliente->apellidos }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3 px-1">
            <div class="form-group">
                <label class="control-label mb-1"><strong>Elige el tipo de reporte</strong></label>
                <select class="form-control text-truncate" wire:model="tipoReporte">
                    <option value="0">Inscripciones del Día</option>
                    <option value="1">Inscripciones por fecha</option>
                </select>
            </div>
        </div>

        <div class="col-md-3 px-1">
            <div class="form-group">
                <label class="control-label mb-1"><strong>Elige el estado</strong></label>
                <select class="form-control text-truncate" wire:model="estado">
                    <option value="3">Todos</option>
                    <option value="1">Activa</option>
                    <option value="0">Vencida</option>
                </select>
            </div>
        </div>

        <div class="col-md-3 px-1">
            <div class="form-group">
                <label class="control-label mb-1"><strong>Elige el paquete</strong></label>
                <select class="form-control text-truncate" wire:model="id_paquete">
                    <option value="0">Todos</option>
                    @foreach ($paquetes as $paquete)
                        <option value="{{ $paquete->id }}">
                            {{ $paquete->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3 px-1">
            <div class="form-group">
                <label class="control-label mb-1"><strong>Elige la duración</strong></label>
                <select class="form-control text-truncate" wire:model="id_duracion">
                    <option value="0">Todos</option>
                    @foreach ($duraciones as $duracion)
                        <option value="{{ $duracion->id }}">
                            {{ $duracion->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3 px-1">
            <div class="form-group">
                <label class="control-label mb-1"><strong>Fecha desde</strong></label>
                <input type="text" wire:model="fechaDesde" placeholder="Click para elegir" class="form-control flatpickr" style="background: transparent; cursor: pointer" readonly>
                @error('fechaDesde')
                    <span class="error text-danger">* {{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-3 px-1">
            <div class="form-group">
                <label class="control-label mb-1"><strong>Fecha hasta</strong></label>
                <input type="text" wire:model="fechaHasta" placeholder="Click para elegir" class="form-control flatpickr" style="background: transparent; cursor: pointer" readonly>
                @error('fechaHasta')
                    <span class="error text-danger">* {{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-3 px-1 pt-2">
            <div class="form-group mb-1">
                <button type="button" wire:click="generarReporte" wire:loading.attr="disabled"
                    class="btn btn-dark waves-effect m-l-5 w-100 d-flex align-items-center justify-content-center py-2">
                    <i class="fas fa-check-square mr-2 font-20"></i>
                    Consultar
                </button>
            </div>
        </div>

        <div class="col-md-3 px-1 pt-2">
            <div class="form-group mb-1">
                <a href="{{ url('/reporteInscripcion-pdf/'.$id_administrativo.'/'.$id_cliente.'/'.$tipoReporte.'/'.$estado.'/'.$id_paquete.'/'.$id_duracion.'/'.$fechaDesde.'/'.$fechaHasta) }}" target="_blank" wire:loading.attr="disabled" class="btn btn-dark waves-effect m-l-5 w-100 d-flex align-items-center justify-content-center py-2 
                {{ ($inscripciones->count() < 1) ? 'disabled' : '' }}">
                    <i class="fas fa-file-pdf mr-2 font-20"></i>
                    Generar PDF
                </a>
            </div>
        </div>

    </div>

    <hr style="background: rgb(237, 237, 237); height: 1.2px">
        
    <div class="row mt-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-dark text-white text-nowrap text-center">
                    <tr style="cursor: pointer">
                        <th scope="col" style="width: 60px;">ID</th>
                        <th scope="col">Fecha Inscripción</th>
                        <th scope="col">Fecha Inicio</th>
                        <th scope="col">Fecha Fin</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Administrativo</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Paquete</th>
                        <th scope="col">Duración</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($inscripciones) && $inscripciones->count())
                        @foreach ($inscripciones as $inscripcion)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $inscripcion->id }}</th>
                                <td class="align-middle text-left text-md-center">
                                    {{ $inscripcion->fecha_inscripcion }}</td>
                                <td class="align-middle text-nowrap">
                                    {{ $inscripcion->detalle->fecha_inicio }}</td>
                                <td class="align-middle text-nowrap">
                                    {{ $inscripcion->detalle->fecha_vencimiento }}</td>
                                <td class="align-middle">
                                    {{ $inscripcion->cliente->nombres }} 
                                    {{ $inscripcion->cliente->apellidos }}
                                </td>
                                <td class="align-middle">
                                    {{ $inscripcion->administrativo->empleado->nombres }} 
                                    {{ $inscripcion->administrativo->empleado->apellidos }}
                                </td>
                                <td class="align-middle text-nowrap">
                                    @if (is_null($inscripcion->detalle->estado))
                                        <span class="text-warning py-1 px-2 rounded-lg d-inline-block"
                                        style="background-color: #ffeeba; width: 90px">Pendiente</span>
                                    @elseif ($inscripcion->detalle->estado === 0)
                                        <span class="text-danger py-1 px-2 rounded-lg d-inline-block" style="background-color: #f8d7da; width: 90px">Vencida</span>
                                    @elseif ($inscripcion->detalle->estado === 1)
                                        <span class="text-success py-1 px-2 rounded-lg d-inline-block" style="background-color: #c3e6cb; width: 90px">Activa</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    {{ $inscripcion->paquete->nombre }}
                                </td>
                                <td class="align-middle text-nowrap">
                                    {{ $inscripcion->duracion->nombre }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="9">Sin resultados.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @push('js')
        {{-- <script src="{{ asset('assets/js/jquery.js') }}"></script> --}}
        <script src="{{ asset('assets/plugins/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-select/bootstrap-select.min.js') }}"></script>

        <script>
            $('.selectpicker').selectpicker();
        </script>

        <script>
            flatpickr(".flatpickr", {
                enableTime: false,
                dateFormat: 'Y-m-d',
                locale: {
                    firstDayofWeek: 1,
                    weekdays: {
                        shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                        longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                        ],
                    },
                    months: {
                        shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                        ],
                        longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                        ],
                    },
                }
            });
        </script>
    @endpush

</div>



