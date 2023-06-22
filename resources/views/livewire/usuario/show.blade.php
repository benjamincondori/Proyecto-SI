<div>

    @if ($vistaCrear)
        <livewire:usuario.create>
    @elseif ($vistaEditar)
        <livewire:usuario.edit>
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
                <span>resultados</span>
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
                    Nuevo Usuario
                </button>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-dark text-white">
                    <tr style="cursor: pointer">
                        <th scope="col" style="width: 120px;" wire:click="order('id')">ID
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
                        <th scope="col" wire:click="order('usuario')">Nombre del Usuario
                            @if ($sort == 'usuario')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col">Email</th>
                        <th scope="col" style="width: 160px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($usuarios->count())
                        @foreach ($usuarios as $usuario)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $usuario->id }}</th>
                                <td class="align-middle text-left">
                                    @if ($usuario->cliente)
                                        {{ $usuario->cliente->nombres }} {{ $usuario->cliente->apellidos }}
                                    @elseif ($usuario->empleado)
                                        {{ $usuario->empleado->nombres }} {{ $usuario->empleado->apellidos }}
                                    @endif
                                </td>
                                <td class="align-middle text-left"> 
                                    @if ($usuario->cliente)
                                        {{ $usuario->cliente->email }}
                                    @elseif ($usuario->empleado)
                                        {{ $usuario->empleado->email }}
                                    @endif
                                </td>
                                <td class="align-middle text-nowrap">
                                    <button type="button" title="Editar" wire:click="seleccionarUsuario({{ $usuario->id }})" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $usuario->id }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="4">No existe ningún registro coincidente.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
                <div class="text-muted d-none d-sm-block pt-1">
                    Mostrando del {{ $usuarios->firstItem() }} al {{ $usuarios->lastItem() }} de {{ $usuarios->total() }} resultados
                </div>
                @if ($usuarios->hasPages())
                    <div class="pagination-links">
                        {{ $usuarios->links() }}
                    </div>
                @endif   
            </div>

        </div>

    @endif

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            livewire.on('error', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ha ocurrido un error. Por favor, intenta nuevamente.'           
                })
            });

            livewire.on('alert', function(accion) {

                var msj2 = accion.charAt(0).toUpperCase() + accion.slice(1);

                Swal.fire(
                    '¡' + msj2 + '!',
                    'El usuario ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });

            livewire.on('eliminarRegistro', usuarioId => {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡Se eliminará el usuario definitivamente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        livewire.emitTo('rol.show', 'eliminarUsuario', usuarioId);

                        Swal.fire(
                            '¡Eliminado!',
                            'El usuario ha sido eliminado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>


