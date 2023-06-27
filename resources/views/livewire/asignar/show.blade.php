<div>

    {{-- @if ($vistaCrear) --}}
        {{-- <livewire:permiso.create> --}}
    {{-- @elseif ($vistaEditar) --}}
        {{-- <livewire:permiso.edit> --}}
    {{-- @else --}}

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

            <div class="form-group form-inline">
                <select class="form-control mr-1" wire:model="id_rol">
                    <option value="">Seleccionar Rol</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                    @endforeach
                </select>
                <button type="button" wire:click="sincronizarTodos()" class="btn btn-success waves-effect waves-light mr-1">
                    <i class="fas fa-check-circle"></i>&nbsp;
                    Sincronizar todos
                </button>
                @if (verificarPermiso('Revocar_Todos'))
                    <button type="button"
                    wire:click="$emit('revocarTodos', {{ $this->id_rol }})" class="btn btn-danger waves-effect waves-light">
                        <i class="fas fa-times-circle"></i>&nbsp;
                        Revocar todos
                    </button>
                @endif
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-dark text-white text-center">
                    <tr style="cursor: pointer">
                        <th scope="col" style="width: 150px;" >ID</th>
                        <th scope="col">Permiso</th>
                        <th scope="col" style="width: 220px;">Roles con el permiso</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($permisosPaginados->count())
                        @foreach ($permisos as $permiso)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $permiso->id }}</th>
                                <td class="align-middle">
                                    @if (verificarPermiso('Asignar_Permiso'))
                                        <div class="checkbox checkbox-primary">
                                            <input id="{{ $permiso->id }}" value="{{ $permiso->id }}" type="checkbox" wire:click="togglePermiso({{ $permiso->id }})"
                                                @if ($this->verificarPermiso($permiso->id))
                                                    checked
                                                @endif
                                            >
                                            <label for="{{ $permiso->id }}">
                                                {{ $permiso->nombre }}
                                            </label>
                                        </div>
                                    @else
                                        <div class="checkbox checkbox-primary">
                                            <input id="{{ $permiso->id }}" value="{{ $permiso->id }}" type="checkbox" wire:click="togglePermiso({{ $permiso->id }})"
                                                @if ($this->verificarPermiso($permiso->id))
                                                    checked
                                                @endif
                                                disabled
                                            >
                                            <label for="{{ $permiso->id }}">
                                                {{ $permiso->nombre }}
                                            </label>
                                        </div>
                                    @endif
                                    
                                </td>
                                <td class="align-middle">
                                    {{ $this->getCantidadRoles($permiso->id) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="3">No existe ningún registro coincidente.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
            <div class="text-muted d-none d-sm-block pt-1">
                Mostrando del {{ $permisosPaginados->firstItem() }} al {{ $permisosPaginados->lastItem() }} de {{ $permisosPaginados->total() }} registros
            </div>
            @if ($permisosPaginados->hasPages())
                <div class="pagination-links">
                    {{ $permisosPaginados->links() }}
                </div>
            @endif   
        </div>

    {{-- @endif --}}

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


            livewire.on('asignar_rol', function(icon, title, text) {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text           
                })
            });


            livewire.on('revocarTodos', function(idRol) {
                if (idRol) {
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: "¡Se quitarán todos los permisos asignados!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, revocar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            livewire.emitTo('asignar.show', 'revocarTodos');

                            Swal.fire(
                                '¡Permisos Revocados!',
                                'Los permisos han sido revocados exitosamente.',
                                'success'
                            )
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Oops...',
                        text: 'Debes seleccionar un rol'           
                    })
                }
            });

        </script>
    @endpush

</div>



