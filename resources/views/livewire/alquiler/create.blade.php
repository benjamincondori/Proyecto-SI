<div>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-plus-circle fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Crear nuevo alquiler</h3>
    </div>
    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre del cliente</label>
                    <input type="text" wire:model="search" class="form-control" id="nombre" placeholder="Buscar cliente..." autocomplete="off" list="sugerencias">
                    @error('id_cliente')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                    
                    <datalist id="sugerencias">
                        @foreach($searchResults as $result)
                            <option value="{{ $result->id }} - {{ $result->nombres }} {{ $result->apellidos }}"></option>
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Seleccionar Casillero</label>
                    <select class="form-control" wire:model="id_casillero">
                        <option value="">Seleccionar</option>
                        @foreach ($casilleros as $casillero)
                            <option value="{{ $casillero->id }}" class="cursor-pointer"
                                title="Precio: {{ $casillero->precio }}">
                              {{ 'Nro: '.$casillero->nro }} - {{ $casillero->tamaño }}</option>
                        @endforeach
                    </select>
                    @error('id_casillero')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Días de duración</label>
                    <div class="input-group">
                        <input type="number" wire:model="dias_duracion" class="form-control" placeholder="Ej: 30" min="0">
                        <div class="input-group-append">
                            <span class="input-group-text">Días</span>
                        </div>
                    </div>
                    @error('dias_duracion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-9" class="control-label">Fecha de inicio</label>
                    <input type="date" wire:model="fecha_inicio" class="form-control" id="field-9">
                    @error('fecha_inicio')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            
        </div>

        <div class="form-group text-right m-b-0">
            <button type="button" wire:click="cancelar" wire:loading.attr="disabled"
                class="btn btn-danger waves-effect m-l-5">
                Cancelar
            </button>
            <button class="btn btn-primary waves-effect waves-light" wire:click="guardarAlquiler"
                wire:loading.attr="disabled" type="button">
                Guardar
            </button>
        </div>
    </form>    

</div>



