<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-pencil-alt fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Editar Horario</h3>
    </div>
    <form class="px-4 pt-2 pb-4">
        <div class="row">
            {{-- la forma de la caja de texto de descripcion --}}
            <div class="col-md-12">
                <div class="form-group">
                    <label for="descripcion" class="control-label">Descripción</label>
                    <input type="text" wire:model.defer="registroSeleccionado.descripcion" class="form-control" id="descripcion"
                        placeholder="Ej. lunes, miercoles, viernes">
                    @error('registroSeleccionado.descripcion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            
             {{-- la forma de la caja de texto de hora inicio --}}
             <div class="col-md-6">
                <div class="form-group">
                    <label for="hora-inicio" class="control-label">Hora de Inicio</label>
                    <input class="form-control" wire:model.defer="registroSeleccionado.hora_inicio" id="hora-inicio" type="time" name="time">
                    @error('registroSeleccionado.hora_inicio')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

             {{-- la forma de la caja de texto de hora fin --}}
             <div class="col-md-6">
                <div class="form-group">
                    <label for="hora-fin" class="control-label">Hora de Fin</label>
                    <input class="form-control" wire:model.defer="registroSeleccionado.hora_fin" id="hora-fin" type="time" name="time">
                    @error('registroSeleccionado.hora_fin')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="actualizarHorario" wire:loading.attr="disabled"  type="button">
                Actualizar
            </button>
        </div>
    </form>

</div>