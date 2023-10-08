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

            <x-layouts.content title="Perfil" subtitle="" name="Perfil">

                @livewire('perfil.show')
                
            </x-layouts.content>

            @include('plantillas.footer')

        </div>

        <!-- ========================================================== -->
        <!-- End Page content -->
        <!-- ========================================================== -->

    </div>

</x-layouts.app>
