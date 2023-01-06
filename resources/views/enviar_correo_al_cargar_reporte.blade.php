<x-app-layout>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Configuraciones</h5>
                    <div>
                        <button id="truncate_Enviar_correo_al_cargar_reporte" class="btn btn-danger btn-sm">Truncate</button>
                        <button id="refresh_Enviar_correo_al_cargar_reporte" class="btn btn-light btn-sm">Actualizar</button>
                        <button id="add_new_enviar_correo_al_cargar_reporte" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFormIUEnviar_correo_al_cargar_reporte">Nuevo</button>
                        <button id="import_enviar_correo_al_cargar_reporte" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportFormEnviar_correo_al_cargar_reporte">Importar</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tb-datatable-enviar_correo_al_cargar_reporte" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 5%">id</th>
                                <th >Correo</th>
                                <th >Reporte</th>
                                <th >Fecha personalizado</th>
                                <th >Fecha incial</th>
                                <th >Fecha final</th>
                                <th >Api Whatsapp</th>
                                <th >vc_telefono</th>
                                <th >vTema8_enviar_correo_al_cargar_reporte</th>
                                <th >vTema9_enviar_correo_al_cargar_reporte</th>
                                <th >vTema10_enviar_correo_al_cargar_reporte</th>
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
        <div class="modal fade" id="modalFormIUEnviar_correo_al_cargar_reporte" tabindex="-1" aria-labelledby="add_new_enviar_correo_al_cargar_reporteLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_enviar_correo_al_cargar_reporte" id="form_enviar_correo_al_cargar_reporte" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_enviar_correo_al_cargar_reporteLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="vc_correo" class="form-label">Correo</label>
                                    <input type="text" class="form-control" id="vc_correo" name="vc_correo" placeholder="Escribe Correo">
                                </div>
                                <div class="col-sm-6">
                                    <label for="id_cat_reporte" class="form-label">Reporte</label>
                                    <input type="text" class="form-control" id="id_cat_reporte" name="id_cat_reporte" placeholder="Escribe Reporte">
                                </div>
                                <div class="col-sm-12">
                                    <label for="dt_fecha_personalizado" class="form-label">Fecha personalizado</label>
                                    <input type="text" class="form-control" id="dt_fecha_personalizado" name="dt_fecha_personalizado" placeholder="Escribe Fecha personalizado">
                                </div>
                                <div class="col-12">
                                    <label for="dt_fecha_inicial" class="form-label">Fecha incial</label>
                                    <input type="text" class="form-control" id="dt_fecha_inicial" name="dt_fecha_inicial" placeholder="Escribe Fecha incial">
                                </div>
                                <div class="col-12">
                                    <label for="dt_fecha_inicial" class="form-label">Fecha final</label>
                                    <input type="text" class="form-control" id="vc_fecha_final" name="vc_fecha_final" placeholder="Escribe Fecha final">
                                </div>
                                <div class="col-12">
                                    <label for="vc_api_whatsapp" class="form-label">Api Whatsapp</label>
                                    <input type="text" class="form-control" id="vc_api_whatsapp" name="vc_api_whatsapp" placeholder="Escribe Api Whatsapp">
                                </div>
                                <div class="col-12">
                                    <label for="vc_telefono" class="form-label">vc_telefono</label>
                                    <input type="text" class="form-control" id="vc_telefono" name="vc_telefono" placeholder="Escribe vc_telefono">
                                </div>
                                <div class="col-md-4">
                                    <label for="vCampo8_enviar_correo_al_cargar_reporte" class="form-label">vTema8_enviar_correo_al_cargar_reporte</label>
                                    <select class="form-select" id="vCampo8_enviar_correo_al_cargar_reporte" name="vCampo8_enviar_correo_al_cargar_reporte">
                                        <option value="">Choose...</option>
                                        <option value="1">demo1</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="vCampo9_enviar_correo_al_cargar_reporte" class="form-label">vTema9_enviar_correo_al_cargar_reporte</label>
                                    <input type="text" class="form-control" id="vCampo9_enviar_correo_al_cargar_reporte" name="vCampo9_enviar_correo_al_cargar_reporte" placeholder="Escribe vCampo9_enviar_correo_al_cargar_reporte">
                                </div>
                                <div class="col-md-3">
                                    <label for="vCampo10_enviar_correo_al_cargar_reporte" class="form-label">vTema10_enviar_correo_al_cargar_reporte</label>
                                    <input type="text" class="form-control" id="vCampo10_enviar_correo_al_cargar_reporte" name="vCampo10_enviar_correo_al_cargar_reporte" placeholder="Escribe vCampo10_enviar_correo_al_cargar_reporte">
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
        <!-- /.modalFormIUEnviar_correo_al_cargar_reporte -->

        <div id="modalImportFormEnviar_correo_al_cargar_reporte" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormEnviar_correo_al_cargar_reporteLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormEnviar_correo_al_cargar_reporteLabel">Cargar datos</h5>
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
                                <form action="FormImportarEnviar_correo_al_cargar_reporte" id="FormImportarEnviar_correo_al_cargar_reporte" name="FormImportarEnviar_correo_al_cargar_reporte" >
                                    <input type="file" accept=".xlsx, .ods" name="files" data-fileuploader-limit="1" data-fileuploader-extensions="xlsx, ods">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel">
                                <form class="form-material form-action-post justify-content-center" action="#form_import_enviar_correo_al_cargar_reporte" id="form_import_enviar_correo_al_cargar_reporte" method="post">
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
        <!-- /.modalImportFormEnviar_correo_al_cargar_reporte -->


    </div>
    <!-- .crm-modals -->

</x-app-layout>

<script src="assets/js/core_js/enviar_correo_al_cargar_reporte.js?{{ rand() }}"></script>