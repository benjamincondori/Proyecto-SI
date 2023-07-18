<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-clipboard-list fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1"><b>Detalles del Paquete</b></h3>
    </div>
    <div class="px-4 pt-2 pb-0">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><strong>ID del paquete :</strong></label>
                    <input value="{{ $id_paquete}}" class="form-control" style="background: transparent" readonly>
                </div>
                <div class="form-group">
                    <label class="control-label"><strong>Nombre del Paquete :</strong></label>
                    <input value="{{ $nombre }}" class="form-control" 
                    style="background: transparent" readonly>
                </div>
                <div class="form-group">
                    <label class="control-label"><strong>Descripción del Paquete :</strong></label>
                    <textarea class="form-control" style="background: transparent" rows="3" readonly> {{ $descripcion }}</textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-group">
                        <label class="control-label"><strong>Disciplinas del Paquete :</strong></label>
                        @foreach ($disciplinas as $disciplina)
                            <div class="radio radio-primary mb-0">
                                &nbsp;&nbsp;<input type="radio" id="{{ $disciplina->id }}" value="{{ $disciplina->id }}" checked>
                                <label for="{{ $disciplina->id }}">
                                    {{ $disciplina->nombre }} 
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label class="control-label"><strong>Duraciones del Paquete :</strong></label>
                        @foreach ($duraciones as $duracion)
                            <div class="radio radio-primary mb-0">
                                &nbsp;&nbsp;<input type="radio" id="{{ $duracion->id }}" value="{{ $duracion->id }}" checked>
                                <label for="{{ $duracion->id }}">
                                    {{ $duracion->nombre }} 
                                </label>
                            </div>
                        @endforeach
                    </div>
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






