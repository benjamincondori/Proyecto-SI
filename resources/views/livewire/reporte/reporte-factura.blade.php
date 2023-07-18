<div>

    <div class="row justify-content-center font-weight-bold font-22 mb-2">
        Reportes de Facturas</div>

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
                    <option value="0">Facturas del Día</option>
                    <option value="1">Facturas por fecha</option>
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
    </div>

    <div class="row">
        <div class="col-md-3 px-1 pt-2">
            <div class="form-group mb-1">
                <button type="button" wire:click="generarReporte" wire:loading.attr="disabled"
                    class="btn btn-dark waves-effect m-l-5 w-100 d-flex align-items-center justify-content-center py-2">
                    <i class="fas fa-check-square mr-2 font-20"></i>
                    Consultar
                </button>
            </div>
        </div>

        {{-- <div class="col-md-3 px-1 pt-2">
            <div class="form-group mb-1">
                <a href="{{ url('/reportePago-pdf/'.$id_administrativo.'/'.$id_cliente.'/'.$tipoReporte.'/'.$fechaDesde.'/'.$fechaHasta) }}" target="_blank" wire:loading.attr="disabled" class="btn btn-dark waves-effect m-l-5 w-100 d-flex align-items-center justify-content-center py-2 
                {{ ($facturas->count() < 1) ? 'disabled' : '' }}">
                    <i class="fas fa-file-pdf mr-2 font-20"></i>
                    Generar PDF
                </a>
            </div>
        </div> --}}

        {{-- <div class="col-md-3 px-1 pt-2">
            <div class="form-group mb-1">
                <a href="{{ url('reporte-inscripciones-pdf') }}" target="_blank"  
                wire:loading.attr="disabled" class="btn btn-dark waves-effect m-l-5 w-100 d-flex align-items-center justify-content-center py-2 
                {{ ($inscripciones->count() < 1) ? 'disabled' : '' }}">
                    <i class="fas fa-file-excel mr-2 font-20"></i>
                    Exportar a Excel
                </a>
            </div>
        </div> --}}

    </div>

    <hr style="background: rgb(237, 237, 237); height: 1.2px">
        
    <div class="row mt-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-dark text-white text-nowrap text-center">
                    <tr style="cursor: pointer">
                        <th scope="col" style="width: 60px;">ID</th>
                        <th scope="col">Fecha Emisión</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Administrativo</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($facturas) && $facturas->count())
                        @foreach ($facturas as $factura)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $factura->id }}</th>
                                <td class="align-middle text-left text-md-center">
                                    {{ $factura->fecha }}</td>
                                <td class="align-middle text-left">
                                    @if ($factura->cliente)
                                        {{ $factura->cliente->nombres }} 
                                        {{ $factura->cliente->apellidos }}
                                    @else
                                        Sin nombre
                                    @endif
                                </td>
                                <td class="align-middle text-left">
                                    {{ $factura->administrativo->empleado->nombres }} 
                                    {{ $factura->administrativo->empleado->apellidos }}
                                </td>
                                <td class="align-middle">
                                    {{ $factura->factura->descripcion }}
                                </td>
                                <td class="align-middle text-nowrap">
                                    {{ 'Bs '.number_format($factura->factura->monto_total, 2) }}
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





