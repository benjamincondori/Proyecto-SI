<div>
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
            @if (verificarPermiso('Bitacora_Buscar'))                  
                <input type="text" wire:model="buscar" class="form-control" 
                placeholder="Buscar...">
                <button class="btn text-secondary" type="button" disabled>
                    <i class="fas fa-search"></i>
                </button>
            @endif
        </div>

    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead class="bg-dark text-white text-nowrap">
                <tr style="cursor: pointer">
                    <th scope="col" style="width: 70px;" wire:click="order('id')">Id
                        @if ($sort == 'id')
                            @if ($direction == 'asc')
                                <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                            @else
                                <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                            @endif
                        @else
                            <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                        @endif
                    </th>
                    <th scope="col" style="width: 120px;" wire:click="order('id_usuario')">Id Usuario
                        @if ($sort == 'id_usuario')
                            @if ($direction == 'asc')
                                <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                            @else
                                <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                            @endif
                        @else
                            <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                        @endif
                    </th>
                    <th scope="col">Usuario</th>
                    <th scope="col" wire:click="order('descripcion')">Descripción
                        @if ($sort == 'descripcion')
                            @if ($direction == 'asc')
                                <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                            @else
                                <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                            @endif
                        @else
                            <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
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
                </tr>
            </thead>
            <tbody>
                @if ($registros->count())
                    @foreach ($registros as $registro)
                        <tr class="text-nowrap text-center">
                            <th scope="row" class="align-middle">{{ $registro->id }}</th>
                            <td class="align-middle">{{ $registro->id_usuario }}</td>
                            <td class="align-middle text-wrap text-left">
                                {{ $this->obtenerNombreUsuario($registro->id_usuario) }}</td>
                            <td class="align-middle text-wrap">{{ $registro->descripcion }}</td>
                            <td class="align-middle">{{ $this->formatoFecha($registro->fecha) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="5">No existe ningún registro.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
        <div class="text-muted d-none d-sm-block pt-1">
            Mostrando del  {{ ($registros->firstItem()) ? $registros->firstItem() : 0 }} al {{ ($registros->lastItem()) ? $registros->lastItem() : 0 }} de {{ $registros->total() }} registros
        </div>
        @if ($registros->hasPages())
            <div class="pagination-links">
                {{ $registros->links() }}
            </div>
        @endif   
    </div>

</div>


