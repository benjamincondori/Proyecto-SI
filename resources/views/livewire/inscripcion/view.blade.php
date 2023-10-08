<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-clipboard-list fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1"><b>Detalles de la Inscripción</b></h3>
    </div>
    <div class="px-4 pt-2 pb-0">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Nombre del Cliente :</strong></label>
                    <input value="{{ $nombre }} {{ $apellido }}" class="form-control" style="background: transparent" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Fecha de Inscripción :</strong></label>
                    <input value="{{ $this->formatoFechaHora($fechaInscripcion) }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Fecha de Inicio :</strong></label>
                    <input value="{{ $this->formatoFecha($fechaInicio) }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Fecha de Vencimiento :</strong></label>
                    <input value="{{ $this->formatoFecha($fechaVencimiento) }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Paquete :</strong></label>
                    <input value="{{ $paquete }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Duración :</strong></label>
                    <input value="{{ $duracion }}" class="form-control" style="background: transparent" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Días Restantes :</strong></label>
                    <input value="{{ $diasRestantes }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>Estado :</strong></label>
                    <input value="{{ ($estado === 1) ? 'Activo' :  (($estado === 0) ? 'Vencido' : 'Pendiente') }}" class="form-control" 
                    style="background: transparent" readonly>
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





