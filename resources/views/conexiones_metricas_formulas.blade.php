<x-app-layout>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Conexiones_metricas_formulas</h5>
                    <div>
                        <button id="truncate_Conexiones_metricas_formulas" class="btn btn-danger">Truncate</button>
                        <button id="refresh_Conexiones_metricas_formulas" class="btn btn-success">Actualizar</button>
                        <button id="add_new_conexiones_metricas_formulas" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUConexiones_metricas_formulas">Nuevo</button>
                        <button id="import_conexiones_metricas_formulas" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalImportFormConexiones_metricas_formulas">Importar</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tb-datatable-conexiones_metricas_formulas" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 5%">id</th>
                                <th >Waitcalling</th>
                                <th >Waitcalling_login_time</th>
                                <th >Tiempoentre_llamdadas</th>
                                <th >Breakbanio</th>
                                <th >Breakbanio_login_time</th>
                                <th >Llamadaspor_hora_promedio</th>
                                <th >Talk</th>
                                <th >Tiempoentre_llamdadas_permitos</th>
                                <th >Billable</th>
                                <th >Horaslaborables</th>
                                <th style="width: 9%">Acción</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

    <div class="crm-modals">
        <div class="modal fade" id="modalFormIUConexiones_metricas_formulas" tabindex="-1" aria-labelledby="add_new_conexiones_metricas_formulasLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_conexiones_metricas_formulas" id="form_conexiones_metricas_formulas" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_conexiones_metricas_formulasLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="wait_calling" class="form-label">Waitcalling</label>
                                    <input type="text" class="form-control" id="wait_calling" name="wait_calling" placeholder="Escribe Waitcalling">
                                </div>
                                <div class="col-sm-6">
                                    <label for="wait_calling_login_time" class="form-label">Waitcalling_login_time</label>
                                    <input type="text" class="form-control" id="wait_calling_login_time" name="wait_calling_login_time" placeholder="Escribe Waitcalling_login_time">
                                </div>
                                <div class="col-sm-12">
                                    <label for="tiempo_entre_llamdadas" class="form-label">Tiempoentre_llamdadas</label>
                                    <input type="text" class="form-control" id="tiempo_entre_llamdadas" name="tiempo_entre_llamdadas" placeholder="Escribe Tiempoentre_llamdadas">
                                </div>
                                <div class="col-12">
                                    <label for="break_banio" class="form-label">Breakbanio</label>
                                    <input type="text" class="form-control" id="break_banio" name="break_banio" placeholder="Escribe Breakbanio">
                                </div>
                                <div class="col-12">
                                    <label for="break_banio" class="form-label">Breakbanio_login_time</label>
                                    <input type="text" class="form-control" id="break_banio_login_time" name="break_banio_login_time" placeholder="Escribe Breakbanio_login_time">
                                </div>
                                <div class="col-12">
                                    <label for="llamadas_por_hora_promedio" class="form-label">Llamadaspor_hora_promedio</label>
                                    <input type="text" class="form-control" id="llamadas_por_hora_promedio" name="llamadas_por_hora_promedio" placeholder="Escribe Llamadaspor_hora_promedio">
                                </div>
                                <div class="col-12">
                                    <label for="talk" class="form-label">Talk</label>
                                    <input type="text" class="form-control" id="talk" name="talk" placeholder="Escribe Talk">
                                </div>
                                <div class="col-md-4">
                                    <label for="tiempo_entre_llamdadas_permitidos" class="form-label">Tiempoentre_llamdadas_permitos</label>
                                    <select class="form-select" id="tiempo_entre_llamdadas_permitidos" name="tiempo_entre_llamdadas_permitidos">
                                        <option value="">Choose...</option>
                                        <option value="1">demo1</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="billable" class="form-label">Billable</label>
                                    <input type="text" class="form-control" id="billable" name="billable" placeholder="Escribe billable">
                                </div>
                                <div class="col-md-3">
                                    <label for="horas_laborables" class="form-label">Horaslaborables</label>
                                    <input type="text" class="form-control" id="horas_laborables" name="horas_laborables" placeholder="Escribe horas_laborables">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer m-t-10">
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modalFormIUConexiones_metricas_formulas -->

        <div id="modalImportFormConexiones_metricas_formulas" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormConexiones_metricas_formulasLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormConexiones_metricas_formulasLabel">Cargar datos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="card card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Cargar archivo de Excel</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Copiar y pegar</span> 
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3">
                            <div class="tab-pane active" id="tab1" role="tabpanel">
                                <form action="FormImportarConexiones_metricas_formulas" id="FormImportarConexiones_metricas_formulas" name="FormImportarConexiones_metricas_formulas" >
                                    <input type="file" accept=".xlsx, .ods" name="files" data-fileuploader-limit="1" data-fileuploader-extensions="xlsx, ods">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel">
                                <form class="form-material form-action-post justify-content-center" action="#form_import_conexiones_metricas_formulas" id="form_import_conexiones_metricas_formulas" method="post">
                                    <div class="modal-body">
                                        <textarea class="form-control" id="vc_importar" name="vc_importar" rows="10" placeholder="Registro por cada salto de linea"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modalImportFormConexiones_metricas_formulas -->


    </div>
    <!-- .crm-modals -->

</x-app-layout>

<script src="assets/js/core_js/conexiones_metricas_formulas.js?{{ rand() }}"></script>