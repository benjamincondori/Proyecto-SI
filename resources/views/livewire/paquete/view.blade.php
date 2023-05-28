<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-clipboard-list fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Detalles del paquete</h3>
    </div>
    <div class="px-4 pt-2 pb-0">
        <div class="row">
            <div class="col-md-3">
                <label for="disciplinas" class="control-label"><strong>ID del paquete:</strong></label>
            </div>
            <div class="col-md-6">
                <span>{{ $id_paquete }}</span></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <label for="disciplinas" class="control-label"><strong>Nombre del paquete:</strong></label>
            </div>
            <div class="col-md-6">
                <span>{{ $nombre }}</span></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <label for="disciplinas" class="control-label"><strong>Descripción del paquete:</strong></label>
            </div>
            <div class="col-md-6">
                <span>{{ $descripcion }}</span></p>
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
                <label for="disciplinas" class="control-label"><strong>Disciplinas del paquete:</strong></label>
            </div>
            <div class="col-md-6">
                @foreach ($disciplinas as $disciplina)
                    <span class="m-0 p-0"> &bull; {{ $disciplina->nombre }}</span><br>
                @endforeach
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

