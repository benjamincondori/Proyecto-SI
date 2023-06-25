<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-plus-circle fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Crear nuevo permiso</h3>
    </div>

    <form  class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="descripcion" class="control-label">Nombre del Permiso</label>
                    <input type="text" wire:model="nombre" class="form-control" id="descripcion"
                        placeholder="Ej. Cliente_Crear">
                    @error('nombre')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="guardarPermiso" wire:loading.attr="disabled" type="button">
                Guardar
            </button>
        </div>
    </form>

</div>


