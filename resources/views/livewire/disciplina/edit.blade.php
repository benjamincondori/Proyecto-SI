<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-pencil-alt fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Editar disciplina</h3>
    </div>
    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>
                    <input type="text" wire:model="registroSeleccionado.nombre" class="form-control" id="nombre"
                        placeholder="Ej: Zumba">
                    @error('registroSeleccionado.nombre')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="precio" class="control-label">Precio</label>
                    <input type="number" wire:model="registroSeleccionado.precio" class="form-control" id="capacidad"
                        placeholder="Ej: 150 bs" min="0">
                    @error('registroSeleccionado.precio')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="seccion" class="control-label">Sección</label>
                    <select class="form-control" wire:model="registroSeleccionado.id_seccion" name="seccion"
                        id="seccion">
                        <option value="">Seleccionar</option>
                        @foreach ($secciones as $id => $nombre)
                            <option value="{{ $id }}">{{ $nombre }}</option>
                        @endforeach
                    </select>
                    @error('registroSeleccionado.id_seccion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="descripcion" class="control-label">Descripción</label>
                    <textarea wire:model="registroSeleccionado.descripcion" class="form-control" id="descripcion" rows="5"></textarea>
                    @error('registroSeleccionado.descripcion')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="actualizarDisciplina"
                wire:loading.attr="disabled" type="button">
                Actualizar
            </button>
        </div>
    </form>

</div>
