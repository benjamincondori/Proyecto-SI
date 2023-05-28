<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-plus-circle fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Crear nuevo paquete</h3>
    </div>
    <form class="px-4 pt-2 pb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>
                    <input type="text" wire:model.defer="nombre" class="form-control" id="nombre"
                        placeholder="Ej: Paquete básico">
                    @error('nombre')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="descripcion" class="control-label">Descripción</label>
                    <textarea wire:model.defer="descripcion" class="form-control" id="descripcion" rows="5"></textarea>
                    @error('descripcion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="disciplinas" class="control-label">Seleccionar las Disciplinas (ctrl + click)</label>
                        <select id="disciplinas" multiple class="form-control" wire:model.defer="selectedDisciplinas">
                            @foreach ($disciplinas as $id => $nombre)
                                <option value="{{ $id }}">{{ $nombre }}</option>
                            @endforeach
                        </select>
                    @error('selectedDisciplinas')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="guardarPaquete"
                wire:loading.attr="disabled" type="button">
                Guardar
            </button>
        </div>
    </form>

</div>

