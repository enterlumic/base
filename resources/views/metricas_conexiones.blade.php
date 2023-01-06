<x-app-layout>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Metricas y conexiones</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Metricas y conexiones</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="row ">
                    <div class="col-xl-5">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="text-center mt-3">
                                    <h4 class="text-muted">HRS CUMPLIMIENTO PROACTIVAS</h4>
                                </div>
                                <table class="table table-sm mt-3">
                                    <tbody>
                                        <tr id="hsr_cumplimiento_proactivas">
                                            <th scope="col"> <img src="assets/images/logo_tecsa.png"> </th>
                                            <th scope="col" class="text-center align-middle" >HORAS R</th>
                                            <th scope="col" class="text-center align-middle" >PROMEDIO BILLABLE X AGENTE</th>
                                            <th scope="col" class="text-center align-middle" >FALTAS</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="text-center mt-3">
                                    <h4 class="text-muted">HRS CUMPLIMIENTO PROACTIVAS</h4>
                                </div>
                                <table class="table table-sm mt-3">
                                    <tbody>
                                        <tr id="aprovechamiento_de_hrs">
                                            <th scope="col" class="text-center align-middle" >TOPE DE HRS X DIA</th>
                                            <th scope="col" class="text-center align-middle" >HRS FACT</th>
                                            <th scope="col" class="text-center align-middle" >DIFERENCIA HRS TOPE/ HRS FACT</th>
                                            <th scope="col" class="text-center align-middle" >% FACT HRS TOPE/HRS FACT</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="text-center mt-3">
                                    <h4 class="text-muted"></h4>
                                </div>
                                <table class="table table-sm mt-5">
                                    <tbody>
                                        <tr id="diferencias">
                                            <th scope="col" class="text-center align-middle" >DIFERENCIA HRS HC/ HRS FACT</th>
                                            <th scope="col" class="text-center align-middle" >% FACT HRS TOPE / HRS FACT REALES</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="text-center mt-3">
                                    <h4 class="text-muted"></h4>
                                </div>
                                <table class="table table-sm mt-5">
                                    <tbody>
                                        <tr>
                                            <th scope="col" class="text-center align-middle" > </th>
                                            <th scope="col" class="text-center align-middle" >Objetivo Minimo horas</th>
                                            <th scope="col" class="text-center align-middle" >Facturacion Mensual</th>
                                        </tr>
                                        <tr>
                                            <td scope="col" class="align-middle" >Objetivo</td>
                                            <td scope="col" class="text-center align-middle" id="objetivo1"> </td>
                                            <td scope="col" class="text-center align-middle" id="objetivo2"></td>
                                        </tr>
                                        <tr>
                                            <td scope="col" class="align-middle" >Real</td>
                                            <td scope="col" class="text-center align-middle" id="real1"></td>
                                            <td scope="col" class="text-center align-middle" id="real2"></td>
                                        </tr>
                                        <tr>
                                            <td scope="col" class=" align-middle" >Diferencia</td>
                                            <td scope="col" class="text-center align-middle" id="diff1"></td>
                                            <td scope="col" class="text-center align-middle" id="diff2"></td>
                                        </tr>
                                        <tr>
                                            <td scope="col" class=" align-middle" ></td>
                                            <td scope="col" class="text-center align-middle" >Porcentaje</td>
                                            <td scope="col" class="text-center align-middle" id="porcentaje"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="text-center mt-3">
                                    <h4 class="text-muted"></h4>
                                </div>
                                <table class="table table-sm mt-5">
                                    <tbody>
                                        <tr>
                                            <th scope="col" class="text-center align-middle" > </th>
                                            <th scope="col" class="text-center align-middle" >Objetivo Minimo horas</th>
                                            <th scope="col" class="text-center align-middle" >Facturacion Mensual</th>
                                        </tr>
                                        <tr>
                                            <td scope="col" class="align-middle" >Objetivo</td>
                                            <td scope="col" class="text-center align-middle" id="_objetivo1"> </td>
                                            <td scope="col" class="text-center align-middle" id="_objetivo2"></td>
                                        </tr>
                                        <tr>
                                            <td scope="col" class="align-middle" >Real</td>
                                            <td scope="col" class="text-center align-middle" id="_real1"></td>
                                            <td scope="col" class="text-center align-middle" id="_real2"></td>
                                        </tr>
                                        <tr>
                                            <td scope="col" class=" align-middle" >Diferencia</td>
                                            <td scope="col" class="text-center align-middle" id="_diff1"></td>
                                            <td scope="col" class="text-center align-middle" id="_diff2"></td>
                                        </tr>
                                        <tr>
                                            <td scope="col" class=" align-middle" ></td>
                                            <td scope="col" class="text-center align-middle" >Porcentaje</td>
                                            <td scope="col" class="text-center align-middle" id="_porcentaje"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body d-none">
                    <table id="tb-datatable-metricas_conexiones" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 5%">id</th>
                                <th >Serverip</th>
                                <th >Fecha</th>
                                <th >User</th>
                                <th >Campaign</th>
                                <th >Usergroup</th>
                                <th >Calls</th>
                                <th >Agenttime</th>
                                <th >Wait</th>
                                <th >Talk</th>
                                <th >Dispo</th>
                                <th style="width: 9%">Acción</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->
</x-app-layout>

<script src="assets/js/core_js/metricas_conexiones.js?{{ rand() }}"></script>