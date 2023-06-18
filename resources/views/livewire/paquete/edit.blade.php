<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-pencil-alt fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Editar paquete</h3>
    </div>

    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>
                    <input type="text" wire:model="registroSeleccionado.nombre" class="form-control" id="nombre"
                        placeholder="Ej: Paquete básico">
                    @error('registroSeleccionado.nombre')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="descripcion" class="control-label">Descripción</label>
                    <textarea wire:model="registroSeleccionado.descripcion" class="form-control" id="descripcion" rows="5"></textarea>
                    @error('registroSeleccionado.descripcion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    
                    @if ($seleccionarNuevo)
                        <label for="disciplinas" class="control-label">Seleccionar las Disciplinas (ctrl + click)</label>
                        <select id="disciplinas" multiple class="form-control" wire:model="selectedDisciplinas">
                            @foreach ($disciplinas as $disciplina)
                                <option value="{{ $disciplina->id }}">{{ $disciplina->nombre }}</option>
                            @endforeach
                        </select>
                        @error('selectedDisciplinas')
                            <span class="error text-danger">* {{ $message }}</span>
                        @enderror
                    @else
                        <label for="disciplinas" class="control-label">Disciplinas del Paquete</label>
                        <button type="button" class="btn btn-xs btn-outline-info waves-effect waves-light" wire:click="$set('seleccionarNuevo', true)">Seleccionar</button>
                        <br>
                        <div class="radio radio-info mb-2">
                            @foreach ($seleccionados as $disciplina)
                                &nbsp;&nbsp;&nbsp;
                                <input type="radio" checked>
                                <label>{{ $disciplina->nombre }}</label><br>
                            @endforeach
                        </div> 
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group text-right m-b-0">
            <button type="button" wire:click="cancelar" wire:loading.attr="disabled"
                class="btn btn-danger waves-effect m-l-5">
                Cancelar
            </button>
            <button class="btn btn-primary waves-effect waves-light" wire:click="actualizarPaquete"
                wire:loading.attr="disabled" type="button">
                Actualizar
            </button>
        </div>
    </form>

</div>

