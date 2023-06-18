<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-pencil-alt fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Editar casillero</h3>
    </div>

    <form class="px-4 pt-2 pb-2">
        <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <label for="nro" class="control-label">Número del casillero</label>
                    <input type="number" wire:model="registroSeleccionado.nro" class="form-control" id="nro"
                        placeholder="Ej: 15">
                    @error('registroSeleccionado.nro')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <label for="tamaño" class="control-label">Tamaño</label>
                    <input type="text" wire:model="registroSeleccionado.tamaño" class="form-control" id="tamaño"
                        placeholder="Ej: Mediano">
                    @error('registroSeleccionado.tamaño')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="precio" class="control-label">Precio</label>
                    <input type="number" wire:model="registroSeleccionado.precio" class="form-control" id="precio"
                        placeholder="Ej: 50 bs">
                    @error('registroSeleccionado.precio')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="actualizarCasillero"
                wire:loading.attr="disabled" type="button">
                Actualizar
            </button>
        </div>
    </form>

</div>


