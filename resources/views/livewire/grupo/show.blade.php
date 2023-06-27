<div>

    @if ($vistaCrear)
        <livewire:grupo.create>
    @elseif ($vistaEditar)
        <livewire:grupo.edit>
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
                @if (verificarPermiso('Grupo_Buscar'))
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
                    Nuevo Grupo
                </button>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-dark text-white">
                    <tr style="cursor: pointer">
                        <th scope="col" style="width: 60px;" wire:click="order('id')">ID
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
                        <th scope="col" wire:click="order('nombre')">Grupo
                            @if ($sort == 'nombre')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('nro_integrantes')">Nro de integrantes
                            @if ($sort == 'nro_integrantes')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col">Disciplina</th>
                        <th scope="col">Entrenador</th>
                        <th scope="col">Horario</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($grupos->count())
                        @foreach ($grupos as $grupo)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $grupo->id }}</th>
                                <td class="align-middle text-left">{{ $grupo->nombre }}</td>
                                <td class="align-middle">{{ $grupo->nro_integrantes }}</td>
                                <td class="align-middle text-left">{{ $this->obtenerNombreDisciplina($grupo->id_disciplina) }}</td>
                                <td class="align-middle text-left">{{ $this->obtenerNombreEntrenador($grupo->id_entrenador) }}</td>
                                <td class="align-middle">{{ $this->obtenerNombreHorario($grupo->id_horario) }}</td>
                                <td class="align-middle text-nowrap">
                                    <button type="button" title="Editar" wire:click="seleccionarGrupo({{ $grupo->id }})" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $grupo->id }}, {{ $this->verificarPermiso }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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

            <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
                <div class="text-muted d-none d-sm-block pt-1">
                    Mostrando del {{ $grupos->firstItem() }} al {{ $grupos->lastItem() }} de {{ $grupos->total() }} registros
                </div>
                @if ($grupos->hasPages())
                    <div class="pagination-links">
                        {{ $grupos->links() }}
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
                    'El grupo ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });


            livewire.on('eliminarRegistro', function(grupoId, tienePermiso) {
                if (tienePermiso) {
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: "¡Se eliminará el grupo definitivamente!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            livewire.emitTo('grupo.show', 'eliminarGrupo', grupoId);

                            Swal.fire(
                                '¡Eliminado!',
                                'El grupo ha sido eliminado.',
                                'success'
                            )
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Acceso Denegado!',
                        text: 'No tienes los permisos necesarios.'           
                    })
                }
            });
        </script>
    @endpush

</div>
