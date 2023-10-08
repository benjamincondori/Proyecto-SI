<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-plus-circle fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Registro Datos de Condición Física</h3>
    </div>
    
    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre del cliente</label>
                    <input type="text" wire:model="search" class="form-control" id="nombre" placeholder="Buscar cliente..." autocomplete="off" list="sugerencias">
                    @error('id_cliente')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                    
                    <datalist id="sugerencias">
                        @foreach($searchResults as $result)
                            <option value="{{ $result->id }} - {{ $result->nombres }} {{ $result->apellidos }}"></option>
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Nivel</label>
                    <input type="text" wire:model="nivel" class="form-control" name="nivel" placeholder="Ej: Principiante, Intermedio, Avanzado" list="niveles">
                    @error('nivel')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror

                    <datalist id="niveles">
                        <option value="Principiante">
                        <option value="Intermedio">
                        <option value="Avanzado">
                    </datalist>
                </div>
            </div> 

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Altura</label>
                    <div class="input-group">
                        <input type="number" id="altura" wire:model="altura" class="form-control" name="altura" placeholder="170,00" min="0">
                        <div class="input-group-append">
                            <span class="input-group-text">cm</span>
                        </div>
                    </div>
                    @error('altura')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Peso</label>
                    <div class="input-group">
                        <input type="number" wire:model="peso" class="form-control" name="peso" placeholder="73,00" min="0">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                    @error('peso')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="guardarRegistro" wire:loading.attr="disabled" type="button">
                Guardar
            </button>
        </div>
    </form>

</div>





