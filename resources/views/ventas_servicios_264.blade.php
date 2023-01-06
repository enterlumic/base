<x-app-layout>

    <div class="row">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Ventas (servicios) 264 R3</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Fecha de consulta</a></li>
                            <li class="breadcrumb-item active" > <span class="fecha-dicamico"> {{ date('Y-m-d', strtotime('-1 days')) }} </span> </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- end page title -->
        <div class="col-lg-12">
            <div class="tab-content p-3 text-muted" id="preloader-ventas-servicios-264">
                <div class="card">
                    <div class="card-body" id="div-table-ventas-servicios-264"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->
</x-app-layout>

<script src="assets/js/core_js/ventas_servicios_264.js?{{ rand() }}"></script>


