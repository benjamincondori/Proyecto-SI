<div>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-pencil-alt fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Editar inscripción</h3>
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
                    <label for="field-9" class="control-label">Fecha de inicio</label>
                    <input type="date" wire:model="registroSeleccionado.fecha_inicio" class="form-control" id="field-9">
                    @error('registroSeleccionado.fecha_inicio')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="paquetes" class="control-label">Seleccionar Paquete</label>
                        <select id="paquetes" class="form-control" wire:model="idPaquete">
                            <option value="">Seleccionar</option>
                            @foreach ($paquetes as $paquete)
                                @php
                                    $disciplinas = '';
                                    foreach ($paquete->disciplinas as $disciplina) {
                                        $disciplinas .= $disciplina->nombre . ', ' ;
                                    }
                                    $disciplinas = rtrim($disciplinas, ', ');
                                @endphp
                                <option value="{{ $paquete->id }}" class="cursor-pointer"
                                    title="{{$disciplinas}}">{{ $paquete->nombre }}</option>
                            @endforeach
                        </select>
                    @error('idPaquete')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="duraciones" class="control-label">Seleccionar Duración</label>
                        <select id="duraciones" class="form-control" wire:model="registroSeleccionado.id_duracion">
                            <option value="">Seleccionar</option>
                            @foreach ($duraciones as $duracion)
                                <option value="{{ $duracion->id }}">{{ $duracion->nombre }}</option>
                            @endforeach
                        </select>
                    @error('registroSeleccionado.id_duracion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">

                    @if ($seleccionarNuevo)
                        <label for="grupos" class="control-label">Seleccionar Nuevo Grupo</label>
                        <button type="button" class="btn btn-xs btn-outline-info waves-effect waves-light ml-2" wire:click="$set('seleccionarNuevo', false)">
                            <i class="fas fa-reply"></i>
                        </button>
                        <select id="grupos" class="form-control mt-2" multiple wire:model="selectedGrupos" >
                            @foreach ($grupos as $grupo)
                                <option class="cursor-pointer" value="{{ $grupo->id }}"
                                    title="{{ $grupo->horario->descripcion }} de {{ $this->formatoHora($grupo->horario->hora_inicio) }} - {{ $this->formatoHora($grupo->horario->hora_fin) }}">{{ $grupo->nombre }}</option>
                            @endforeach
                        </select>
                        @error('selectedGrupos')
                            <span class="error text-danger">* {{ $message }}</span>
                        @enderror
                    @else
                        <label for="grupos" class="control-label">Grupos</label>
                        <button type="button" class="btn btn-xs btn-outline-info waves-effect waves-light ml-2" wire:click="$set('seleccionarNuevo', true)">Seleccionar</button>
                        <br>
                        <div class="radio radio-info mt-2">
                            @foreach ($seleccionados as $grupo)
                                &nbsp;&nbsp;&nbsp;
                                <input type="radio" checked>
                                <label title="{{ $grupo->horario->descripcion }} de {{ $this->formatoHora($grupo->horario->hora_inicio) }} - {{ $this->formatoHora($grupo->horario->hora_fin) }}">{{ $grupo->nombre }}&nbsp;&nbsp;<span class="text-muted d-none d-xl-inline-block">({{ $grupo->horario->descripcion }} de {{ $this->formatoHora($grupo->horario->hora_inicio) }} - {{ $this->formatoHora($grupo->horario->hora_fin) }})</span> </label><br>
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="actualizarInscripcion"
                wire:loading.attr="disabled" type="button">
                Actualizar
            </button>
        </div>
    </form>    

</div>


