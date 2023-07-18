<div>

    @if ($vistaVisita)
        <livewire:pago.visita>
    @elseif($vistaCrear)
        <livewire:pago.create>
    @elseif ($vistaFactura)
        <livewire:pago.factura>
    @else

        <div class="mb-2 d-flex justify-content-between">

            <div class="form-group d-none d-lg-flex align-items-center">
                <span>Mostrar</span>
                <select wire:model="cant" class="custom-select px-3 mx-1">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>registros</span>
            </div>

            <div class="form-group w-50 d-flex">
                @if (verificarPermiso('Pago_Buscar'))
                    <input type="text" wire:model="buscar" class="form-control" 
                    placeholder="Buscar...">
                    <button class="btn text-secondary" type="button" disabled>
                        <i class="fas fa-search"></i>
                    </button>
                @endif
            </div>
            
            <div class="form-group">
                <button type="button" wire:click="agregarNuevo" class="btn btn-primary waves-effect waves-light">
                    <i class="fas fa-plus-circle"></i>&nbsp;
                    Agregar Pago
                </button>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-dark text-white text-nowrap">
                    <tr style="cursor: pointer">
                        <th scope="col" wire:click="order('id')">ID
                            @if ($sort == 'id')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up " style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort " style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('id_cliente')">Cliente
                            @if ($sort == 'id_cliente')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('id_administrativo')">Administrativo
                            @if ($sort == 'id_administrativo')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('concepto')">Concepto
                            @if ($sort == 'concepto')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up " style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort " style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('fecha')">Fecha y Hora
                            @if ($sort == 'fecha')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('monto')">Monto
                            @if ($sort == 'monto')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('estado')">Estado
                            @if ($sort == 'estado')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($pagos->count())
                        @foreach ($pagos as $pago)
                            <tr class="text-nowrap text-center">
                                <th scope="row" class="align-middle">{{ $pago->id }}</th>
                                <td class="align-middle text-left">
                                    @if ($pago->cliente)
                                        {{ $pago->cliente->nombres }}
                                        {{ $pago->cliente->apellidos }}
                                    @else
                                        Sin nombre
                                    @endif
                                </td>
                                <td class="align-middle text-left">
                                    {{ $pago->administrativo->empleado->nombres }}
                                    {{ $pago->administrativo->empleado->apellidos }}
                                </td>
                                <td class="align-middle">
                                    {{ $pago->concepto }} </td>
                                <td class="align-middle">
                                    {{ $this->obtenerFechaPago($pago->id) }}</td>
                                <td class="align-middle">
                                    {{ $this->formatoMoneda($pago->monto) }}</td>
                                <td class="align-middle">
                                    @if (is_null($pago->estado))
                                        <span class="text-danger py-1 px-2 rounded-lg d-inline-block" style="background-color: #f8d7da; width: 90px">Sin pagar</span>
                                    @elseif ($pago->estado === 0)
                                        <span class="text-warning py-1 px-2 rounded-lg d-inline-block"
                                        style="background-color: #ffeeba; width: 90px">Pendiente</span>
                                    @elseif ($pago->estado === 1)
                                        <span class="text-success py-1 px-2 rounded-lg d-inline-block" style="background-color: #c3e6cb; width: 90px">Pagado</span>
                                    @endif
                                </td>
                                <td class="align-middle text-nowrap">
                                    <button type="button" title="Pagar"
                                        @if ($pago->cliente)
                                            wire:click="seleccionarPago({{ $pago->id }}, 'pagar')"
                                        @else
                                            wire:click="seleccionarPago({{ $pago->id }}, 'visita')"
                                        @endif
                                        class="btn btn-sm btn-outline-success"><i class="fas fa-dollar-sign"></i></button>
                                    <button type="button" 
                                        @if ($pago->factura)
                                            title="Factura"
                                            wire:click="seleccionarPago({{ $pago->id }}, 'factura')"
                                        @else
                                            title="No tiene Factura"
                                            disabled
                                        @endif

                                        class="btn btn-sm btn-outline-danger"><i class="fas fa-file-pdf"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="9">No existe ningún registro.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
            <div class="text-muted d-none d-sm-block pt-1">
                Mostrando del {{ ($pagos->firstItem()) ? $pagos->firstItem() : 0 }} al {{ ($pagos->lastItem()) ? $pagos->lastItem() : 0 }} de {{ $pagos->total() }} registros
            </div>
            @if ($pagos->hasPages())
                <div class="pagination-links">
                    {{ $pagos->links() }}
                </div>
            @endif 
        </div>

    @endif

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            livewire.on('error', function(message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ha ocurrido un error. Por favor, intenta nuevamente.'           
                })
                console.error(message);
            });


            livewire.on('alert', function(accion) {
                var msj2 = accion.charAt(0).toUpperCase() + accion.slice(1);
                Swal.fire(
                    '¡' + msj2 + '!',
                    'El pago ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });

        </script>

    @endpush

</div>


