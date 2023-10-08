<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-clipboard-list fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1"><b>Datos del Entrenador</b></h3>
    </div>
    <div class="px-4 pt-2 pb-0">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Identificador del Usuario :</strong></label>
                    <input value="{{ $id_entrenador }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Nombre Completo :</strong></label>
                    <input value="{{ $nombre }} {{ $apellido }}" class="form-control" style="background: transparent" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Email :</strong></label>
                    <input value="{{ $email }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Dirección :</strong></label>
                    <input value="{{ $direccion }}" class="form-control" style="background: transparent" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Cédula de Identidad :</strong></label>
                    <input value="{{ $ci }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Número Telefónico :</strong></label>
                    <input value="{{ $telefono }}" class="form-control" style="background: transparent" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Fecha de Nacimiento :</strong></label>
                    <input value="{{ $this->formatoFecha($fechaNacimiento) }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Especialidad :</strong></label>
                    <input value="{{ $especialidad }}" class="form-control" style="background: transparent" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Genero :</strong></label>
                    <input value="{{ ($genero == 'M') ? 'Masculino' : 'Femenino' }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Turno :</strong></label>
                    <input value="{{ $turno }}" class="form-control" style="background: transparent" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Grupos de Entrenamiento :</strong></label>
                    @foreach ($grupos as $grupo)
                        <div class="radio radio-primary mb-0">
                            &nbsp;&nbsp;<input type="radio" id="{{ $grupo->id }}" value="{{ $grupo->id }}" checked>
                            <label for="{{ $grupo->id }}">
                                {{ $grupo->nombre }} &nbsp;&nbsp; ({{ $grupo->horario->descripcion }}, {{ $this->formatoHora($grupo->horario->hora_inicio) }} - {{ $this->formatoHora($grupo->horario->hora_fin) }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="form-group text-right m-b-0">
            <button type="button" wire:click="cancelar" wire:loading.attr="disabled"
                class="btn btn-danger waves-effect">
                Cerrar
            </button>
        </div>
    </div>

</div>



