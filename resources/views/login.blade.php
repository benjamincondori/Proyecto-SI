<x-layouts.app>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <a href="{{ route('index') }}">
                                <span><img src="{{ asset('assets/images/logo-login.png') }}" alt=""
                                        height="120"></span>
                            </a>
                            <h2 class="mb-4 mt-0 text-uppercase font-weight-bold" style="color: #1A1A1A; user-select: none;"><span style="color: #780001">Jady</span> Sport</h2>
                        </div>

                        <h5 class="auth-title">Iniciar Sesión</h5>

                        <form action="#">

                            <div class="form-group mb-3">
                                <label for="emailaddress">Usuario:</label>
                                <input class="form-control" type="email" id="emailaddress" required=""
                                    placeholder="Ingrese su nombre de usuario">
                            </div>

                            <div class="form-group mb-1">
                                <label for="password">Contraseña:</label>
                                <input class="form-control" type="password" required="" id="password"
                                    placeholder="Ingrese su contraseña">
                            </div>

                            <div class="form-group">
                                <div class="col-12 text-right">
                                    <p> <a href="#" class="text-muted ml-1">¿Olvidaste tu contraseña?</a></p>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-dark btn-block" type="button"> INGRESAR </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

</x-layouts.app>
