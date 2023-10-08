<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-pencil-alt fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Editar máquina</h3>
    </div>
    
    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Código</label>
                    <input type="text" wire:model="registroSeleccionado.codigo" class="form-control"
                        placeholder="Ej: 1005">
                    @error('registroSeleccionado.codigo')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Máquina</label>
                    <select class="form-control" wire:model="registroSeleccionado.id_tipo">
                        <option value="">Seleccionar</option>
                        @foreach ($maquinas as $maquina)
                            <option value="{{ $maquina->id }}" class="cursor-pointer">
                                {{ $maquina->nombre }}</option>
                        @endforeach
                    </select>
                    @error('registroSeleccionado.id_tipo')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Sección</label>
                    <select class="form-control" wire:model="registroSeleccionado.id_seccion">
                        <option value="">Seleccionar</option>
                        @foreach ($secciones as $seccion)
                            <option value="{{ $seccion->id }}" class="cursor-pointer">
                                {{ $seccion->nombre }}</option>
                        @endforeach
                    </select>
                    @error('registroSeleccionado.id_seccion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Estado</label>
                    <select class="form-control" wire:model="registroSeleccionado.estado">
                        <option value="">Seleccionar</option>
                        <option value="1">Habilitado</option>
                        <option value="0">Deshabilitado</option>
                    </select>
                    @error('registroSeleccionado.estado')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="actualizarMaquina" wire:loading.attr="disabled" type="button">
                Guardar
            </button>
        </div>
    </form>

</div>



