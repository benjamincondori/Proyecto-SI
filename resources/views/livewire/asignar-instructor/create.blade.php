<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-plus-circle fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Asignar entrenador</h3>
    </div>
    
    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Entrenador</label>
                    <select class="form-control" wire:model="id_entrenador">
                        <option value="">Seleccionar</option>
                        @foreach ($entrenadores as $entrenador)
                            <option title="{{ $entrenador->id }} - {{ $entrenador->especialidad }}" value="{{ $entrenador->id }}" class="cursor-pointer">
                                {{ $this->obtenerNombreEntrenador($entrenador->id) }}</option>
                        @endforeach
                    </select>
                    @error('id_entrenador')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Disciplina</label>
                    <select class="form-control" wire:model="id_disciplina">
                        <option value="">Seleccionar</option>
                        @foreach ($disciplinas as $disciplina)
                            <option value="{{ $disciplina->id }}" class="cursor-pointer">
                                {{ $disciplina->nombre }}</option>
                        @endforeach
                    </select>
                    @error('id_disciplina')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="guardarAsignacion" wire:loading.attr="disabled" type="button">
                Guardar
            </button>
        </div>
    </form>

</div>



