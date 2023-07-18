<div>

    <style>
        .nav-pills .nav-link.active {
            background-color: #3C444D; 
            color: #ffffff; 
        }
    </style>

    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card-box">
                <div class="row justify-content-center">
                    <img src="assets/images/users/user-1.jpg" class="rounded-circle avatar-lg img-thumbnail" style="width: 120px; height: 120px;" alt="profile-image">
                </div>
                <div class="row text-center w-100">
                    <h4 class="mb-0 w-100"><b>{{ $nombreCompleto }}</b></h4>
                    <h5 class="w-100">
                        @if ($cargo == 'Administrador')
                            <span class="badge badge-success">{{ $cargo }}</span>
                        @else
                            <span class="badge badge-info">{{ $cargo }}</span>
                        @endif
                    </h5>
                </div>

                <hr>

                <div class="row">
                    <ul class="nav nav-pills navtab-bg w-100 px-2 py-1">
                        <li class="nav-item w-100">
                            <a href="#informacion" wire:click="$set('activeTab', 'informacion')" data-toggle="tab" aria-expanded="true" class="nav-link {{ $activeTab === 'informacion' ? 'active' : '' }}">
                                <i class="fas fa-user mr-2"></i>Información Personal
                            </a>
                        </li>
                        <li class="nav-item w-100 mt-1">
                            <a href="#configuracion" wire:click="$set('activeTab', 'configuracion')" data-toggle="tab" aria-expanded="true" class="nav-link {{ $activeTab === 'configuracion' ? 'active' : '' }}">
                                <i class="fas fa-cog mr-2"></i>Configuración
                            </a>
                        </li>
                    </ul>
                </div>

            </div> 
        </div> 

        <div class="col-lg-8 col-xl-8">
            <div class="card-box">
                <div class="tab-content p-0">
                    
                    <div class="tab-pane show {{ $activeTab === 'informacion' ? 'active' : '' }}" id="informacion">
                            <h5 class="mb-3 text-uppercase text-white bg-dark p-2"><i class="fas fa-user-circle mr-1"></i><b> Información Personal </b></h5>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">ID del Usuario :</label>
                                        <input wire:model="id_administrativo" class="form-control" 
                                        @if (!$editar)
                                            style="background: transparent"
                                        @endif
                                        readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nombres :</label>
                                        <input wire:model="nombre" class="form-control" 
                                        style="background: transparent" 
                                        @if (!$editar)
                                            readonly
                                        @endif>
                                        @error('nombre')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Apellidos :</label>
                                        <input wire:model="apellido" class="form-control" style="background: transparent" 
                                        @if (!$editar)
                                            readonly
                                        @endif>
                                        @error('apellido')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Email :</label>
                                        <input wire:model="email" class="form-control" 
                                        style="background: transparent" 
                                        @if (!$editar)
                                            readonly
                                        @endif>
                                        @error('email')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Dirección :</label>
                                        <input wire:model="direccion" class="form-control" style="background: transparent" 
                                        @if (!$editar)
                                            readonly
                                        @endif>
                                        @error('direccion')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cédula de Identidad :</label>
                                        <input wire:model="ci" class="form-control" 
                                        @if (!$editar)
                                            style="background: transparent"
                                        @endif
                                        readonly>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Número Telefónico :</label>
                                        <input wire:model="telefono" class="form-control" style="background: transparent" 
                                        @if (!$editar)
                                            readonly
                                        @endif>
                                        @error('telefono')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fecha de Nacimiento :</label>
                                        <input value="{{ $this->formatoFecha($fechaNacimiento) }}" class="form-control" 
                                        @if (!$editar)
                                            style="background: transparent"
                                        @endif 
                                        readonly>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Genero :</label>
                                        <input value="{{ ($genero == 'M') ? 'Masculino' : 'Femenino' }}" class="form-control" 
                                        @if (!$editar)
                                            style="background: transparent"
                                        @endif
                                        readonly>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3 text-uppercase text-white bg-dark p-2"><i class="fas fa-building mr-1"></i><b> Información Administrativa </b></h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cargo :</label>
                                        <input value="{{ $cargo }}" class="form-control" 
                                        @if (!$editar)
                                            style="background: transparent"
                                        @endif
                                        readonly>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Turno :</label>
                                        <input value="{{ $turno }}" class="form-control" 
                                        @if (!$editar)
                                            style="background: transparent"
                                        @endif 
                                        readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                @if (!$editar)
                                    <button type="button" wire:click="$set('editar', true)" class="btn btn-primary waves-effect waves-light mt-2"><i class="fas fa-pencil-alt mr-1"></i> Editar</button>
                                @endif

                                @if ($editar)
                                    <button type="button" wire:click="cancelar" class="btn btn-danger waves-effect waves-light mt-2"><i class="fas fa-times mr-1"></i> Cancelar</button>
                                    <button type="button" wire:click="actualizarDatos" class="btn btn-success waves-effect waves-light mt-2"><i class="fas fa-save mr-1"></i> Actualizar</button>
                                @endif
                            </div>
                    </div>

                    <div class="tab-pane {{ $activeTab === 'configuracion' ? 'active' : '' }}" id="configuracion">
                            <h5 class="mb-3 text-uppercase text-white bg-dark p-2"><i class="fas fa-lock mr-1"></i> Cambiar Contraseña </h5>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Clave Actual <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="{{ $showPassword ? 'text' : 'password' }}" class="form-control" wire:model="passwordActual" placeholder="Contraseña actual" style="border-right: none">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="background: transparent; cursor: pointer; border-left: none;" wire:click="$toggle('showPassword')">
                                                    <i class="fas {{ $showPassword ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('passwordActual')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Contraseña <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="{{ $showPassword ? 'text' : 'password' }}" class="form-control" wire:model="passwordNuevo" placeholder="Nueva contraseña" style="border-right: none;">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="background: transparent; cursor: pointer; border-left: none;" wire:click="$toggle('showPassword')">
                                                    <i class="fas {{ $showPassword ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('passwordNuevo')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Confirmar Contraseña <span class="text-danger">*</span> </label>
                                        <div class="input-group">
                                            <input type="{{ $showPassword ? 'text' : 'password' }}" class="form-control" wire:model="passwordCorfirmar" placeholder="Confirmar contraseña" style="border-right: none;">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="background: transparent; cursor: pointer; border-left: none;" wire:click="$toggle('showPassword')">
                                                    <i class="fas {{ $showPassword ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('passwordCorfirmar')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> 
                            </div> 

                            <div class="text-right">
                                <button type="button" wire:click="cambiarContraseña" class="btn btn-success waves-effect waves-light mt-2"><i class="fas fa-save mr-1"></i> Cambiar Contraseña</button>
                            </div>
                    </div>

                </div> 
            </div> 
        </div> 
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            livewire.on('error', function(message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ha ocurrido un error. Por favor, intenta nuevamente.'           
                })
                console.error(message);
            });

            
            livewire.on('alert', function(accion) {
                var msj2 = accion.charAt(0).toUpperCase() + accion.slice(1);
                Swal.fire(
                    '¡' + msj2 + '!',
                    'Su información personal a sido ' + accion + ' correctamente.',
                    'success'
                )
            });

            livewire.on('password', function() {
                Swal.fire(
                    '¡Actualizado!',
                    'Su contraseña se actualizó correctamente.',
                    'success'
                )
            });
            
        </script>
    @endpush

</div>
