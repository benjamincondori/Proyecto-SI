<x-layouts.app>

    <style>
        html, body {
            height: 100%;
            box-sizing: border-box;
        }

        .col-xl-12, .card-box, .container-fluid, .row {
            height: 100%;
        }

    </style>

    <div class="container-fluid mt-2 mb-0">

        <div class="row">

            <div class="col-xl-12">
                <div class="card-box">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title mb-4">Perfil de Instructor</h4>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="javascript:void(0);" class="dropdown-item notify-item" onclick="this.closest('form').submit()">
                                <i class="fe-log-out"></i>
                                <span>Cerrar Sesión</span>
                            </a>
                        </form>
                    </div>
            
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active show mb-2" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                                    aria-selected="true">
                                    Perfil</a>
                                {{-- <a class="nav-link mb-2" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                    aria-selected="false">
                                    Inscripciones</a>
                                <a class="nav-link mb-2" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" 
                                    aria-selected="false">
                                    Grupos</a> --}}
                                <a class="nav-link mb-2" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                                    aria-selected="false">
                                    Configuración</a>
                            </div>
                        </div> <!-- end col-->
                        <div class="col-sm-9">
                            <div class="tab-content pt-0">
                                <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-lg-9 col-xl-9 d-flex justify-content-center" >
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/users/user-2.jpg') }}" class="rounded-circle avatar-lg img-thumbnail"
                                                    alt="profile-image">
            
                                                <h4 class="mb-0">{{ $instructor->nombres }} {{ $instructor->apellidos }}</h4>
                                                <p class="text-muted">{{ $instructor->email }}</p>
            
                                                {{-- <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Follow</button>
                                                <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Message</button> --}}
            
                                                <div class="text-left mt-3">
                                                    <p class="text-muted mb-2 font-13"><strong>Codigo :</strong> <span class="ml-2">{{ $instructor->id }} </span></p>

                                                    <p class="text-muted mb-2 font-13"><strong>Nombre Completo :</strong> <span class="ml-2">{{ $instructor->nombres }} {{ $instructor->apellidos }}</span></p>
            
                                                    <p class="text-muted mb-2 font-13"><strong>Telefono :</strong><span class="ml-2">{{ $instructor->telefono }}</span></p>

                                                    <p class="text-muted mb-2 font-13"><strong>Cédula de identidad :</strong><span class="ml-2">{{ $instructor->ci }}</span></p>
            
                                                    <p class="text-muted mb-2 font-13"><strong>Especialidad :</strong> <span class="ml-2 ">{{ $instructor->entrenador->especialidad }}</span></p>

                                                    <p class="text-muted mb-2 font-13"><strong>Turno :</strong> <span class="ml-2 ">{{ $instructor->turno }}</span></p>

                                                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 ">{{ $instructor->email }}</span></p>

                                                    <p class="text-muted mb-2 font-13"><strong>Dirección :</strong> <span class="ml-2 ">{{ $instructor->direccion }}</span></p>
            
                                                    <p class="text-muted mb-1 font-13"><strong>Fecha de nacimiento :</strong> <span class="ml-2">{{ $instructor->fecha_nacimiento }}</span></p>
                                                </div>
            
                                            </div> <!-- end card-box -->
            
                                        </div> <!-- end col-->
            
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <p>Culpa dolor voluptate do laboris laboris irure reprehenderit id incididunt duis pariatur mollit aute magna
                                        pariatur consectetur. Eu veniam duis non ut dolor deserunt commodo et minim in quis laboris ipsum velit
                                        id veniam. Quis ut consectetur adipisicing officia excepteur non sit. Ut et elit aliquip labore Lorem
                                        enim eu. Ullamco mollit occaecat dolore ipsum id officia mollit qui esse anim eiusmod do sint minim consectetur
                                        qui.</p>
                                </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                    <p>Fugiat id quis dolor culpa eiusmod anim velit excepteur proident dolor aute qui magna. Ad proident laboris
                                        ullamco esse anim Lorem Lorem veniam quis Lorem irure occaecat velit nostrud magna nulla. Velit et et
                                        proident Lorem do ea tempor officia dolor. Reprehenderit Lorem aliquip labore est magna commodo est ea
                                        veniam consectetur.</p>
                                </div>
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                    <p>Eu dolore ea ullamco dolore Lorem id cupidatat excepteur reprehenderit consectetur elit id dolor proident
                                        in cupidatat officia. Voluptate excepteur commodo labore nisi cillum duis aliqua do. Aliqua amet qui
                                        mollit consectetur nulla mollit velit aliqua veniam nisi id do Lorem deserunt amet. Culpa ullamco sit
                                        adipisicing labore officia magna elit nisi in aute tempor commodo eiusmod.</p>
                                </div>
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row-->
                    
                </div> <!-- end card-box-->
            </div> <!-- end col -->
    
        </div>

    </div>
    

</x-layouts.app>
