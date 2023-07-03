<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-plus-circle fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Crear nueva duración</h3>
    </div>

    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>
                    <input type="text" wire:model="nombre" class="form-control" id="nombre"
                        placeholder="Ej: Mensual">
                    @error('nombre')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dias" class="control-label">Días de duración</label>
                    <input type="number" wire:model="dias_duracion" class="form-control" id="dias"
                        placeholder="Ej: 30 días" min="0">
                    @error('dias_duracion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group text-right m-b-0">
            <button type="button" wire:click="cancelar" wire:loading.attr="disabled"
                class="btn btn-danger waves-effect">
                Cancelar
            </button>
            <button class="btn btn-primary waves-effect waves-light" wire:click="guardarDuracion"
                wire:loading.attr="disabled" type="button">
                Guardar
            </button>
        </div>
    </form>

</div>

