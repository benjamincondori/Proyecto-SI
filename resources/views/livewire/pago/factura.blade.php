<div>
    <div class="row justify-content-center mt-3">
        <div class="col-11">
            <div class="card-box">
                <div class="clearfix">
                    <div class="float-left">
                        <img src="{{ asset('assets/images/logo-gym-dark.png') }}" alt="" height="100">
                    </div>
                    <div class="float-right">
                        <h4 class="m-0" style="font-size: 3.5em">FACTURA</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <p><b>Bienvenido/a, 
                                {{ isset($cliente->nombres) ? $cliente->nombres : '' }} 
                                {{ isset($cliente->apellidos) ? $cliente->apellidos : '' }}</b></p>
                            <p class="text-muted">Valoramos tu confianza en nosotros y nos comprometemos a proporcionarte un servicio personalizado y ayudarte a alcanzar tus metas fitness.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 offset-md-3">
                        <div class="mt-3">
                            <p class="m-b-10"><strong>N° de Factura : </strong> <span class="float-right"> {{ isset($factura->id) ? $factura->id : '' }}</span></p>
                            <p class="m-b-10"><strong>Fecha : </strong> <span class="float-right">
                                {{ isset($factura->fecha_emision) ? 
                                $this->formatoFecha($factura->fecha_emision) : '' }} 
                            </span></p>
                            <p class="m-b-10"><strong>Estado : </strong><span class="float-right">
                                <span 
                                    @if (isset($pago->estado) && $pago->estado)
                                        class="text-white py-0 px-1 rounded-lg bg-success"
                                    @else
                                        class="text-white py-0 px-1 rounded-lg bg-warning"
                                    @endif
                                >
                                {{ (isset($pago->estado) && $pago->estado) ? 'Pagado' : 'Pendiente' }}</span>
                            </span></p>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <address>
                            <strong>Jady Sport Gym Center</strong><br>
                            Av. Bush N° 968 final modulos universitarios<br>
                            Santa Cruz - Bolivia<br>
                        </address>
                    </div>

                    <div class="col-md-4">
                        <address>
                            <strong>Usuario</strong><br>
                            {{ isset($usuario->nombres) ? $usuario->nombres : '' }} 
                            {{ isset($usuario->apellidos) ? $usuario->apellidos : '' }}<br>
                            {{ isset($usuario->email) ? $usuario->email : '' }}<br>
                        </address>
                    </div>

                    <div class="col-md-4">
                        <address>
                            <strong>Cliente</strong><br>
                            ID: {{ isset($cliente->id) ? $cliente->id : '' }} <br>
                            {{ isset($cliente->nombres) ? $cliente->nombres : '' }} 
                            {{ isset($cliente->apellidos) ? $cliente->apellidos : '' }}
                        </address>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table mt-4">
                                <thead>
                                    <tr><th>#</th>
                                        <th>Detalle</th>
                                        <th style="width: 20%" class="text-right">Precio</th>
                                    </tr></thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle">1</td>
                                        @php
                                            $disciplinas = [];
                                            if (isset($paquete->disciplinas)) {
                                                $disciplinas = $paquete->disciplinas;
                                            }
                                        @endphp
                                        <td>
                                            <b>{{ isset($paquete->nombre) ? 'Paquete: '.$paquete->nombre : '' }}</b><br/>
                                            @foreach ($disciplinas as $disciplina)
                                            {{ ' - '.$disciplina->nombre }}<br>
                                            @endforeach
                                            @if (isset($duracion->nombre))
                                                <b>Duración:</b><br>
                                                {{ ' - '.$duracion->nombre }} 
                                                {{ '('.$duracion->dias_duracion.' Días)' }}
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            &nbsp; <br>
                                            @foreach ($disciplinas as $disciplina)
                                            {{ $this->formatoMoneda($disciplina->precio) }}<br>
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                    </div> 
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="float-right">
                            <p class="m-0"><b>Sub-total:</b> <span class="float-right">
                                {{ isset($precio) ? $this->formatoMoneda($precio) : '' }}</span></p>
                            <p class="m-0"><b>Descuento 
                                ({{ isset($descuento) ? $this->formatoPorcentaje($descuento) : ''}}):
                            </b> <span class="float-right"> 
                                {{ isset($precio) ? $this->formatoMoneda($precio * $descuento) : '' }}</span></p>
                            <h3><b>TOTAL:&nbsp;&nbsp;</b>
                                {{ (isset($pago->monto)) ? $this->formatoMoneda($pago->monto) : '' }}</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div> 
                </div>

                <div class="mt-4 mb-1">
                    <div class="text-right d-print-none">
                        <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer mr-1"></i> Imprimir</a>
                        <button type="button" wire:click="cancelar" class="btn btn-danger waves-effect waves-light"></i> Cerrar</button>
                    </div>
                </div>
            </div> 
        </div> 
    </div>

</div>
