<x-app-layout>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Sql_server</h5>
                    <div>
                        <button id="truncate_Sql_server" class="btn btn-danger btn-sm">Truncate</button>
                        <button id="refresh_Sql_server" class="btn btn-light btn-sm">Actualizar</button>
                        <button id="add_new_sql_server" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFormIUSql_server">Nuevo</button>
                        <button id="import_sql_server" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportFormSql_server">Importar</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tb-datatable-sql_server" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 5%">id</th>
                                <th >vTema1_sql_server</th>
                                <th >vTema2_sql_server</th>
                                <th >vTema3_sql_server</th>
                                <th >vTema4_sql_server</th>
                                <th >vTema5_sql_server</th>
                                <th >vTema6_sql_server</th>
                                <th >vTema7_sql_server</th>
                                <th >vTema8_sql_server</th>
                                <th >vTema9_sql_server</th>
                                <th >vTema10_sql_server</th>
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
        <div class="modal fade" id="modalFormIUSql_server" tabindex="-1" aria-labelledby="add_new_sql_serverLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_sql_server" id="form_sql_server" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_sql_serverLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="vCampo1_sql_server" class="form-label">vTema1_sql_server</label>
                                    <input type="text" class="form-control" id="vCampo1_sql_server" name="vCampo1_sql_server" placeholder="Escribe vTema1_sql_server">
                                </div>
                                <div class="col-sm-6">
                                    <label for="vCampo2_sql_server" class="form-label">vTema2_sql_server</label>
                                    <input type="text" class="form-control" id="vCampo2_sql_server" name="vCampo2_sql_server" placeholder="Escribe vTema2_sql_server">
                                </div>
                                <div class="col-sm-12">
                                    <label for="vCampo3_sql_server" class="form-label">vTema3_sql_server</label>
                                    <input type="text" class="form-control" id="vCampo3_sql_server" name="vCampo3_sql_server" placeholder="Escribe vTema3_sql_server">
                                </div>
                                <div class="col-12">
                                    <label for="vCampo4_sql_server" class="form-label">vTema4_sql_server</label>
                                    <input type="text" class="form-control" id="vCampo4_sql_server" name="vCampo4_sql_server" placeholder="Escribe vTema4_sql_server">
                                </div>
                                <div class="col-12">
                                    <label for="vCampo4_sql_server" class="form-label">vTema5_sql_server</label>
                                    <input type="text" class="form-control" id="vCampo5_sql_server" name="vCampo5_sql_server" placeholder="Escribe vTema5_sql_server">
                                </div>
                                <div class="col-12">
                                    <label for="vCampo6_sql_server" class="form-label">vTema6_sql_server</label>
                                    <input type="text" class="form-control" id="vCampo6_sql_server" name="vCampo6_sql_server" placeholder="Escribe vTema6_sql_server">
                                </div>
                                <div class="col-12">
                                    <label for="vCampo7_sql_server" class="form-label">vTema7_sql_server</label>
                                    <input type="text" class="form-control" id="vCampo7_sql_server" name="vCampo7_sql_server" placeholder="Escribe vTema7_sql_server">
                                </div>
                                <div class="col-md-4">
                                    <label for="vCampo8_sql_server" class="form-label">vTema8_sql_server</label>
                                    <select class="form-select" id="vCampo8_sql_server" name="vCampo8_sql_server">
                                        <option value="">Choose...</option>
                                        <option value="1">demo1</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="vCampo9_sql_server" class="form-label">vTema9_sql_server</label>
                                    <input type="text" class="form-control" id="vCampo9_sql_server" name="vCampo9_sql_server" placeholder="Escribe vCampo9_sql_server">
                                </div>
                                <div class="col-md-3">
                                    <label for="vCampo10_sql_server" class="form-label">vTema10_sql_server</label>
                                    <input type="text" class="form-control" id="vCampo10_sql_server" name="vCampo10_sql_server" placeholder="Escribe vCampo10_sql_server">
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
        <!-- /.modalFormIUSql_server -->

        <div id="modalImportFormSql_server" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormSql_serverLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormSql_serverLabel">Importar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form-material form-action-post" action="#form_import_sql_server" id="form_import_sql_server" method="post">
                        <div class="modal-body">
                            <textarea class="form-control" id="vc_importar" name="vc_importar" rows="10" placeholder="Registro por cada salto de linea"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->

        </div>
    </div>
    <!-- .crm-modals -->

</x-app-layout>

<script src="assets/js/core_js/sql_server.js?{{ rand() }}"></script>