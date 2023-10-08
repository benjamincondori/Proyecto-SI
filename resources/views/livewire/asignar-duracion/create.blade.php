<div>

    <div class="form-group px-4 pt-2">
        <i class="fas fa-plus-circle fa-2x"></i>
        <h3 class="fs-1 d-inline-block ml-1">Asignar duración</h3>
    </div>
    
    <form class="px-4 pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Paquete</label>
                    <select class="form-control" wire:model="id_paquete">
                        <option value="">Seleccionar</option>
                        @foreach ($paquetes as $paquete)
                            <option title="{{ $paquete->id }}" value="{{ $paquete->id }}" class="cursor-pointer">
                                {{ $paquete->nombre }}</option>
                        @endforeach
                    </select>
                    @error('id_paquete')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Duración</label>
                    <select class="form-control" wire:model="id_duracion">
                        <option value="">Seleccionar</option>
                        @foreach ($duraciones as $duracion)
                            <option value="{{ $duracion->id }}" class="cursor-pointer">
                                {{ $duracion->nombre }}</option>
                        @endforeach
                    </select>
                    @error('id_duracion')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Precio</label>
                    <div class="input-group">
                        <input type="number" wire:model="precio" class="form-control" name="precio" placeholder="150" min="0" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">Bs</span>
                        </div>
                    </div>
                    @error('precio')
                        <span class="error text-danger">* {{ $message }}</span>
                    @enderror
                </div>
            </div>     
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Descuento</label>
                    <div class="input-group">
                        <input type="number" wire:model="descuento" class="form-control" name="descuento" placeholder="20" min="0">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    @error('descuento')
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
            <button class="btn btn-primary waves-effect waves-light" wire:click="guardarAsignacion" wire:loading.attr="disabled" type="button">
                Guardar
            </button>
        </div>
    </form>

    @push('js')
        
    
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- <script type="text/javascript" src="{{ asset('assets/js/jquery.js') }}"></script>  --}}
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        {{-- <script type="text/javascript" src="{{ asset('assets/libs/jquery-mask-plugin/jquery.mask.min.js') }}"></script> --}}

        <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.9.0/autoNumeric.min.js"></script>
        {{-- <script type="text/javascript" src="{{ asset('assets/libs/autonumeric/autoNumeric-min.js') }}"></script> --}}

        <script>

            $(document).ready(function() {
                // Inicializar jQuery Mask Plugin
                $('#myInput').mask('0.000,00', { reverse: true });

                // Inicializar AutoNumeric
                new AutoNumeric('#myInput', {
                    digitGroupSeparator: '.',
                    decimalCharacter: ',',
                    decimalPlaces: 2,
                    currencySymbol: 'Bs',
                    currencySymbolPlacement: 's'
                });
            });

        </script>
        

    @endpush

</div>




