<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Control a ceros</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);"></a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="col-lg-4">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#reporte_a_ceros" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Reporte</span> 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#uso_de_sistema" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Uso de sistema</span> 
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="tab-content p-3 text-muted" id="preloader-control-a-ceros">
                        <div class="tab-pane active" id="reporte_a_ceros" role="tabpanel">
                            <div class="card-body" id="div-table-reporte"></div>
                        </div>
                        <div class="tab-pane" id="uso_de_sistema" role="tabpanel">
                            <div class="card-body" id="div-table-uso-sistema"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

</x-app-layout>

<script src="assets/js/core_js/control_a_ceros.js?{{ rand() }}"></script>


<style type="text/css">

    th, td { white-space: nowrap; }

    div.dataTables_wrapper {
        margin: 0 auto;
    }
 
    div.container {
        width: 80%;
    }

    table thead th:eq(9) {
        transform: rotate(-60deg);
        height: 120px;
    }

    table thead th {
        --bs-table-color: #000;
        --bs-table-bg: #eff2f7;
        --bs-table-border-color: #d7dade;
        --bs-table-striped-bg: #e3e6eb;
        --bs-table-striped-color: #000;
        --bs-table-active-bg: #d7dade;
        --bs-table-active-color: #000;
        --bs-table-hover-bg: #dde0e4;
        --bs-table-hover-color: #000;
        color: var(--bs-table-color);
        border-color: var(--bs-table-border-color);
    }
</style>