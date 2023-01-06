<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Carrier status ventas</h4>
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
                <div class="card-body" id="div-table-reporte" >
                    <table id="tb-datatable-carrier_status" class="table stripe row-border order-column" style="width:100%"></table>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

</x-app-layout>

<script src="assets/js/core_js/carrier_status.js?{{ rand() }}"></script>

<style type="text/css">
    
    table.dataTable tbody td {
      vertical-align: top;
    }    
    tr.group, tr.group:hover { background-color: #ddd !important; }
</style>