<x-app-layout>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Dashboard</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-xl-4  col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="me-2">
                            <h5 class="card-title mb-4">Envios programados</h5>
                        </div>
                    </div>
                    <div data-simplebar class="mt-2" style="max-height: 280px;">
                        <table class="table align-middle table-nowrap">
                            <tbody id="div-cron-reporte">
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            <!-- end card -->
        </div>

        <div class="col-xl-2 col-xl-4 {{ isset(Auth::user()->name) && Auth::user()->name =='gus'  ? '' : 'd-none' }}    ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="me-2">
                            <h5 class="card-title mb-4">Sistema</h5>
                        </div>
                    </div>
                    <div data-simplebar class="mt-2" style="max-height: 280px;">
                        <ul class="verti-timeline list-unstyled">
                            <li class="event-list">
                                <div class="event-timeline-dot ">
                                    <i class="bx bxs-right-arrow-circle font-size-18" id="python3"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <h5 class="font-size-14">Python3<i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i></h5>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            sudo apt-get install python3
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-xl-4 {{ isset(Auth::user()->name) && Auth::user()->name =='gus'  ? '' : 'd-none' }}    ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="me-2">
                            <h5 class="card-title mb-4">Login</h5>
                        </div>
                    </div>

                    <table id="tb-datatable-login" class="table stripe row-border order-column" style="width:100%"></table>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</x-app-layout>

<script src="assets/js/core_js/dashboard.js?{{ rand(); }}"></script>