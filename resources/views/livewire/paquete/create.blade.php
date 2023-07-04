<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-plus-circle fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Crear nuevo paquete</h3>
    </div>

    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>
                    <input type="text" wire:model="nombre" class="form-control" id="nombre"
                        placeholder="Ej: Paquete básico">
                    @error('nombre')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="descripcion" class="control-label">Descripción</label>
                    <textarea wire:model="descripcion" class="form-control" id="descripcion" rows="5"></textarea>
                    @error('descripcion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="disciplinas" class="control-label">Seleccionar las Disciplinas</label>
                    @foreach ($disciplinas as $id => $nombre)
                        <div class="checkbox checkbox-primary">
                            <input class="ml-2" id="{{ 'Disciplina_'.$id }}" value="{{ $id }}" type="checkbox" wire:model="selectedDisciplinas">
                            <label for="{{ 'Disciplina_'.$id }}" style="cursor: pointer">
                                {{ $nombre }}
                            </label>
                        </div>
                    @endforeach
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

