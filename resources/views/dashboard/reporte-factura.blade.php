<x-layouts.app>

    <div id="wrapper">

        @include('plantillas.navbar')

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">
            @include('plantillas.sidebar')
        </div>
        <!-- Left Sidebar End -->

        <!-- ========================================================== -->
        <!-- Start Page Content here -->
        <!-- ========================================================== -->

        <div class="content-page">
            <div id="content">

                <x-layouts.content title="Reportes" subtitle="Reportes de Facturas" name="Reportes de Facturas">

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                
                                @livewire('reporte.reporte-factura')

                            </div>
                        </div> 
                    </div>
                </x-layouts.content>

            </div>

            @include('plantillas.footer')

        </div>

        <!-- ========================================================== -->
        <!-- End Page content -->
        <!-- ========================================================== -->

    </div>

</x-layouts.app>
