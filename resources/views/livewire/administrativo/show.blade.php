<div>

    @if ($vistaFormulario)
        @livewire('administrativo.create')
    @else
        <div class="table-responsive">
            <div class="mb-2 d-flex justify-content-between">
                <form class="app-search">
                    <div class="app-search-box">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar...">
                            <div class="input-group-append">
                                <button class="btn text-secondary" type="">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <button type="button" wire:click="agregarNuevo" class="btn btn-primary waves-effect waves-light">
                    <i class="fas fa-plus-circle"></i>&nbsp;
                    Nuevo Administrativo
                </button>

            </div>

            <table class="table table-bordered mb-0">
                <thead class="bg-light" class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Cargo</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($administrativos as $administrativo)
                        <tr class="text-nowrap">
                            <th scope="row" class="align-middle">{{ $administrativo->id }}</th>
                            <td class="align-middle">{{ $administrativo->ci }}</td>
                            <td class="align-middle">{{ $administrativo->nombres }}</td>
                            <td class="align-middle">{{ $administrativo->apellidos }}</td>
                            <td class="align-middle">{{ $administrativo->email }}</td>
                            <td class="align-middle">
                                {{ $administrativo->administrativos()->whereIn('cargo', ['administrador', 'recepcionista'])->value('cargo') }}
                            </td>
                            <td class="align-middle d-flex">
                                <button class="btn btn-sm btn-warning">Ver</button>
                                {{-- @livewire('administrativo.edit', ['administrativo' => $administrativo], key($administrativo->id)) --}}
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="mostrarAlertaConfirmacion()">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
