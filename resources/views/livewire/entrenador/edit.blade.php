<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-pencil-alt fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Editar entrenador</h3>
    </div>
    
    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-1" class="control-label">Nombres</label>
                    <input type="text" wire:model="registroSeleccionado.nombres" class="form-control" id="field-1" placeholder="John">
                    @error('registroSeleccionado.nombres')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-2" class="control-label">Apellidos</label>
                    <input type="text" wire:model="registroSeleccionado.apellidos" class="form-control" id="field-2" placeholder="Doe">
                    @error('registroSeleccionado.apellidos')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="field-3" class="control-label">Email</label>
                    <input type="email" wire:model="registroSeleccionado.email" class="form-control" id="field-3"
                        placeholder="jhondoe@gmail.com">
                    @error('registroSeleccionado.email')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="field-8" class="control-label">Dirección</label>
                    <input type="text" wire:model="registroSeleccionado.direccion" class="form-control" id="field-8"
                        placeholder="Av. Busch">
                    @error('registroSeleccionado.direccion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-4" class="control-label">Cédula de identidad</label>
                    <input type="number" wire:model="registroSeleccionado.ci" class="form-control" id="field-4" placeholder="1234567">
                    @error('registroSeleccionado.ci')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-5" class="control-label">Número telefónico</label>
                    <input type="number" wire:model="registroSeleccionado.telefono" class="form-control" id="field-5"
                        placeholder="12345678">
                    @error('registroSeleccionado.telefono')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-9" class="control-label">Fecha de nacimiento</label>
                    <input type="date" wire:model="registroSeleccionado.fecha_nacimiento" class="form-control" id="field-9"
                        placeholder="1234567">
                    @error('registroSeleccionado.fecha_nacimiento')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-10" class="control-label">Seleccionar imagen</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" wire:model="registroSeleccionado.fotografia" class="custom-file-input" id="field-10">
                            <label class="custom-file-label">Elija una foto</label>
                        </div>
                    </div>
                    @error('registroSeleccionado.fotografia')
                        <span class="error text-danger" >* {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-11" class="control-label">Especialidad</label>
                    <input type="text" wire:model="especialidad" class="form-control" id="field-11"
                        placeholder="Instructor de aparatos">
                    @error('especialidad')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-12" class="control-label">Turno</label>
                    <select class="form-control" wire:model="registroSeleccionado.turno" name="turno" id="field-12">
                        <option value="">Seleccionar</option>
                        <option value="Mañana">Mañana</option>
                        <option value="Tarde">Tarde</option>
                    </select>
                    @error('registroSeleccionado.turno')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Género</label>
                    <div class="custom-control custom-radio">
                        <input type="radio" value="F" name="customRadio" wire:model="registroSeleccionado.genero"
                            class="custom-control-input" id="femenino">
                        <label for="femenino" class="custom-control-label">Femenino</label>
                    </div>
                    <div class="custom-control custom-radio mt-1">
                        <input type="radio" value="M" name="customRadio" wire:model="registroSeleccionado.genero"
                            class="custom-control-input" id="masculino">
                        <label for="masculino" class="custom-control-label">Masculino</label>
                    </div>
                </div>
                @error('registroSeleccionado.genero')
                    <span class="error text-danger">* {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group text-right m-b-0">
            <div class="form-group text-right m-b-0">
                <button type="button" wire:click="cancelar" wire:loading.attr="disabled"
                    class="btn btn-danger waves-effect m-l-5">
                    Cancelar
                </button>
                <button class="btn btn-primary waves-effect waves-light" wire:click="actualizarEntrenador"
                    wire:loading.attr="disabled" type="button">
                    Actualizar
                </button>
            </div>
        </div>
    </form>

</div>


