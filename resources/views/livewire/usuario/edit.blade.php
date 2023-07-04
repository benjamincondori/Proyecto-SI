<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-pencil-alt fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Editar usuario</h3>
    </div>

    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Nombre</label>
                    <input type="text" wire:model="nombres" class="form-control"
                        placeholder="Jhon">
                    @error('nombres')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
                
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Apellido</label>
                    <input type="text" wire:model="apellidos" class="form-control" placeholder="Doe">
                    @error('apellidos')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="email" wire:model="registroSeleccionado.email" class="form-control" placeholder="jhon@gmail.com">
                    @error('registroSeleccionado.email')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="disciplinas" class="control-label">Rol</label>
                    <select class="form-control mr-1" wire:model="registroSeleccionado.id_rol">
                        <option value="">Seleccionar</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                        @endforeach
                    </select>
                    @error('registroSeleccionado.id_rol')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="actualizarUsuario"
                wire:loading.attr="disabled" type="button">
                Actualizar
            </button>
        </div>
    </form>

</div>


