<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-plus-circle fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Agregar Pago</h3>
    </div>

    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Monto Total a Pagar</label>
                    <div class="input-group">
                        <input type="text" wire:change="actualizarCambio" wire:model="monto" class="form-control" placeholder="0.00" min="0"
                        @if ($this->estado)
                            style="background-color: transparent;" readonly
                        @endif
                        >
                        <div class="input-group-append">
                            <span class="input-group-text">Bs</span>
                        </div>
                    </div>
                    @error('monto')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Efectivo recibido</label>
                    <div class="input-group">
                        <input type="text" wire:change="actualizarCambio" wire:model="efectivo" class="form-control" placeholder="0.00" min="0" 
                        @if ($this->estado)
                            style="background-color: transparent;" readonly
                        @endif
                        >
                        <div class="input-group-append">
                            <span class="input-group-text">Bs</span>
                        </div>
                    </div>
                    @error('efectivo')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Cambio</label>
                    <div class="input-group">
                        <input type="text" wire:model="cambio" class="form-control" placeholder="0.00" min="0" style="background-color: transparent;" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">Bs</span>
                        </div>
                    </div>
                    @error('cambio')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div> 
            </div>
        </div>

        <div class="form-group text-right m-b-0">
            <button type="button" wire:click="cancelar" wire:loading.attr="disabled"
                class="btn btn-danger waves-effect m-l-5">
                @if (!$this->estado)
                    Cancelar
                @else
                    Cerrar
                @endif
            </button>
            @if (!$this->estado)
                <button class="btn btn-primary waves-effect waves-light" wire:click="guardarPago"
                    wire:loading.attr="disabled" type="button">
                    Guardar
                </button>
            @endif
        </div>
    </form>

</div>



