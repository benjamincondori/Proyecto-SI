<div>

    @if ($vistaVer)
        <livewire:cliente.view>
    @elseif($vistaCrear)
        <livewire:cliente.create>
    @elseif ($vistaEditar)
        <livewire:cliente.edit>
    @else
        <div class="mb-2 d-flex justify-content-between">

            <div class="form-group d-none d-lg-flex align-items-center">
                <span>Mostrar</span>
                <select wire:model="cant" class="form-control px-1 mx-1">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>entradas</span>
            </div>

            <div class="form-group w-50 d-flex">
                <input type="text" wire:model="buscar" class="form-control" placeholder="Buscar...">
                <button class="btn text-secondary" type="button" disabled>
                    <i class="fas fa-search"></i>
                </button>
            </div>
            
            <div class="form-group">
                <button type="button" wire:click="agregarNuevo" class="btn btn-primary waves-effect waves-light">
                    <i class="fas fa-plus-circle"></i>&nbsp;
                    Nuevo Cliente
                </button>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="bg-light">
                    <tr style="cursor: pointer">
                        <th scope="col" wire:click="order('id')">ID
                            @if ($sort == 'id')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('ci')">CI
                            @if ($sort == 'ci')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('nombres')">Nombre
                            @if ($sort == 'nombres')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('apellidos')">Apellido
                            @if ($sort == 'apellidos')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('email')">Email
                            @if ($sort == 'email')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('telefono')">Telefono
                            @if ($sort == 'telefono')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($clientes->count())
                        @foreach ($clientes as $cliente)
                            <tr class="text-nowrap text-center">
                                <th scope="row" class="align-middle">{{ $cliente->id }}</th>
                                <td class="align-middle">{{ $cliente->ci }}</td>
                                <td class="align-middle text-left">{{ $cliente->nombres }}</td>
                                <td class="align-middle text-left">{{ $cliente->apellidos }}</td>
                                <td class="align-middle text-left">{{ $cliente->email }}</td>
                                <td class="align-middle text-left">{{ $cliente->telefono }}</td>
                                <td class="align-middle text-nowrap">
                                    <button type="button" title="Ver"
                                        wire:click="seleccionarCliente({{ $cliente->id }}, 'ver')"
                                        class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></button>
                                    <button type="button" title="Editar" wire:click="seleccionarCliente({{ $cliente->id }}, 'editar')" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $cliente->id }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="7">No existe ningún registro coincidente.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if ($clientes->hasPages())
                <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
                    <div class="text-muted d-none d-sm-block pt-1">
                        Mostrando {{ $clientes->firstItem() }} a {{ $clientes->lastItem() }} de {{ $clientes->total() }} resultados
                    </div>
                    <div class="pagination-links">
                        {{ $clientes->links() }}
                    </div>
                </div>
            @endif 

        </div>
    @endif

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            livewire.on('alert', function(accion) {

                var msj2 = accion.charAt(0).toUpperCase() + accion.slice(1);

                Swal.fire(
                    '¡' + msj2 + '!',
                    'El cliente ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });

            livewire.on('eliminarRegistro', clienteId => {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡Se eliminará el cliente definitivamente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        livewire.emitTo('cliente.show', 'eliminarCliente', clienteId);

                        Swal.fire(
                            '¡Eliminado!',
                            'El cliente ha sido eliminado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>

