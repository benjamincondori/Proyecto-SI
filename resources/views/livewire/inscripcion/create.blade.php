<div>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-plus-circle fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Crear nueva inscripción</h3>
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
                    <input type="date" wire:model="fecha_inicio" class="form-control" id="field-9">
                    @error('fecha_inicio')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="paquetes" class="control-label">Seleccionar Paquete</label>
                    <select id="paquetes" class="form-control" wire:model="id_paquete">
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
                    @error('id_paquete')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="duraciones" class="control-label">Seleccionar Duración</label>
                        <select id="duraciones" class="form-control" wire:model="id_duracion">
                            <option value="">Seleccionar</option>
                            @foreach ($duraciones as $duracion)
                                <option value="{{ $duracion->id }}">{{ $duracion->nombre }}</option>
                            @endforeach
                        </select>
                    @error('id_duracion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="grupos" class="control-label">Seleccionar Grupo</label>
                    <select id="grupos" class="form-control" multiple wire:model="selectedGrupos">
                        @foreach ($grupos as $grupo)
                            <option class="cursor-pointer" value="{{ $grupo->id }}"
                                title="{{ $grupo->horario->descripcion }} de {{ $this->formatoHora($grupo->horario->hora_inicio) }} - {{ $this->formatoHora($grupo->horario->hora_fin) }}">{{ $grupo->nombre }}</option>
                        @endforeach
                    </select>
                    {{-- <label class="control-label">Seleccionar Grupo</label>
                    <div class="row">
                        <div class="col-md-4">
                            @foreach ($grupos1 as $grupo)
                                <div class="custom-control custom-radio">
                                    <input type="radio" value="{{ $grupo->id }}" name="customRadio" wire:model="id_grupo1"
                                        class="custom-control-input" id="{{ 'grupo_'.$grupo->id }}">
                                    <label for="{{ 'grupo_'.$grupo->id }}" class="custom-control-label">{{ $grupo->nombre }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-4">
                            @if ($grupos2)
                                @foreach ($grupos2 as $grupo)
                                    <div class="custom-control custom-radio">
                                        <input type="radio" value="{{ $grupo->id }}" name="customRadio2" wire:model="id_grupo2"
                                            class="custom-control-input" id="{{ 'grupo2_'.$grupo->id }}">
                                        <label for="{{ 'grupo2_'.$grupo->id }}" class="custom-control-label">{{ $grupo->nombre }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div> --}}
                     
                    @error('selectedGrupos')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="guardarInscripcion"
                wire:loading.attr="disabled" type="button">
                Guardar
            </button>
        </div>
    </form>    

</div>


