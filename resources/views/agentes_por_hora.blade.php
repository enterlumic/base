<x-app-layout>

    <div class="row">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Agentes por hora</h4>
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
            <div class="card">
                <div class="card-body">
                    <table id="tb-datatable-agentes_por_hora" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th >Total</th>
                                <th >8</th>
                                <th >9</th>
                                <th >10</th>
                                <th >11</th>
                                <th >12</th>
                                <th >13</th>
                                <th >14</th>
                                <th >15</th>
                                <th >16</th>
                                <th >17</th>
                                <th >18</th>
                                <th >19</th>
                                <th >20</th>
                                <th >21</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body mb-10">
                    <h4 class="card-title mb-4">Grafica General</h4>
                    <div id="grafica-rango-fecha"></div>
                </div>
            </div> 
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body mb-10">
                    <h4 class="card-title mb-4">Grafica Agentes por Hora Office vs Home Office</h4>
                    <div id="grafica-rango-fecha-ho-o"></div>
                </div>
            </div> 
        </div>
    </div>
    <!-- .row -->
</x-app-layout>

<!-- tui charts Css -->
<link href="assets/libs/tui-chart/tui-chart.min.css" rel="stylesheet" type="text/css" />
<!-- tui charts plugins -->
<script src="assets/libs/tui-chart/tui-chart-all.min.js"></script>
<!-- tui charts map -->
<script src="assets/libs/tui-chart/maps/usa.js"></script>
<!-- tui charts plugins -->
<script src="assets/js/pages/tui-charts.init.js?{{ rand() }}"></script> 
<script src="assets/js/core_js/agentes_por_hora.js?{{ rand() }}"></script>


