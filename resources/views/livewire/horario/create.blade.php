<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-user-plus fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Crear nuevo horario</h3>
    </div>
    <form  class="px-4 pt-2 pb-4">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="descripcion" class="control-label">Descripcion</label>
                    <input type="text" wire:model="descripcion" class="form-control" id="descripcion"
                        placeholder="...">
                    @error('descripcion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="hora_inicio" class="control-label">Hora de Inicio</label>
                    <input type="text" wire:model="hora_inicio" class="form-control" id="hora_inicio"
                        placeholder="Ej: 00:00:00">
                    @error('hora_inicio')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="hora_fin" class="control-label">Hora de Fin</label>
                    <input type="text" wire:model="hora_fin" class="form-control" id="hora_fin"
                        placeholder="Ej: 00:00:00">
                    @error('hora_fin')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            
        </div>

        <div class="form-group text-right m-b-0">
            <button type="reset" wire:click="cancelar" wire:loading.attr="disabled"
                class="btn btn-danger waves-effect m-l-5">
                Cancelar
            </button>
            <button class="btn btn-primary waves-effect waves-light" wire:click="guardarHorario" wire:loading.attr="disabled" type="button">
                Guardar
            </button>
        </div>
    </form>

</div>
