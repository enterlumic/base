<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Contratos</h4>
                    <div>
                        <a href="javascript:void(0)" id="configuraciones" class="btn btn-info btn-hover" data-bs-toggle="modal" data-bs-target="#modalConfiguraciones"><i class="uil uil-facebook-f"></i> Configuraciones</a>
                        <button id="truncate_Contratos" class="btn btn-danger btn-hover"   >Truncate</button>
                        <button id="refresh_Contratos" class="btn btn-success btn-hover">Actualizar</button>
                        <button id="add_new_contratos" class="btn btn-primary btn-hover" data-bs-toggle="modal" data-bs-target="#modalFormIUContratos">Nuevo</button>
                        <button id="import_contratos" class="btn btn-secondary btn-hover" data-bs-toggle="modal" data-bs-target="#modalImportFormContratos">Importar</button>
                    </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tb-datatable-contratos" class="table table-striped " style="width:100%">
                                <thead >
                                    <tr>
                                        <th style="width: 5%">id</th>
                                        <th >Fza De Venta</th>
                                        <th >Sisact</th>
                                        <th >Campaña</th>
                                        <th >Cac</th>
                                        <th >Apellido Paterno</th>
                                        <th >Apellido Materno</th>
                                        <th >Nombre</th>
                                        <th >Fecha</th>
                                        <th >Plan</th>
                                        <th >Telefono</th>
                                        <th style="width: 9%">Acción</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

    <div class="crm-modals">
        <div class="modal fade" id="modalFormIUContratos" tabindex="-1" aria-labelledby="add_new_contratosLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_contratos" id="form_contratos" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_contratosLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="vc_fza_de_venta" class="form-label">Fza De Venta</label>
                                    <input type="text" class="form-control" id="vc_fza_de_venta" name="vc_fza_de_venta" placeholder="Escribe Fza De Venta">
                                </div>
                                <div class="col-sm-6">
                                    <label for="vc_sisact" class="form-label">Sisact</label>
                                    <input type="text" class="form-control" id="vc_sisact" name="vc_sisact" placeholder="Escribe Sisact">
                                </div>
                                <div class="col-sm-12">
                                    <label for="vc_campania" class="form-label">Campaña</label>
                                    <input type="text" class="form-control" id="vc_campania" name="vc_campania" placeholder="Escribe Campaña">
                                </div>
                                <div class="col-12">
                                    <label for="vc_cac" class="form-label">Cac</label>
                                    <input type="text" class="form-control" id="vc_cac" name="vc_cac" placeholder="Escribe Cac">
                                </div>
                                <div class="col-12">
                                    <label for="vc_cac" class="form-label">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="vc_apellido_paterno" name="vc_apellido_paterno" placeholder="Escribe Apellido Paterno">
                                </div>
                                <div class="col-12">
                                    <label for="vc_apellido_materno" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control" id="vc_apellido_materno" name="vc_apellido_materno" placeholder="Escribe Apellido Materno">
                                </div>
                                <div class="col-12">
                                    <label for="vc_nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="vc_nombre" name="vc_nombre" placeholder="Escribe Nombre">
                                </div>
                                <div class="col-md-4">
                                    <label for="dt_fecha_activa" class="form-label">Fecha</label>
                                    <input type="text" class="form-control" id="dt_fecha_activa" name="dt_fecha_activa" placeholder="Escribe Fecha">
                                </div>
                                <div class="col-md-3">
                                    <label for="vc_plan" class="form-label">Plan</label>
                                    <input type="text" class="form-control" id="vc_plan" name="vc_plan" placeholder="Escribe vc_plan">
                                </div>
                                <div class="col-md-3">
                                    <label for="vc_telefono" class="form-label">Telefono</label>
                                    <input type="text" class="form-control" id="vc_telefono" name="vc_telefono" placeholder="Escribe vc_telefono">
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
        <!-- /.modalFormIUContratos -->

        <div id="modalImportFormContratos" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormContratosLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormContratosLabel">Cargar datos</h5>
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
                                <form action="FormImportarContratos" id="FormImportarContratos" name="FormImportarContratos" >
                                    <input type="file" accept=".xlsx, .ods" name="files" data-fileuploader-limit="1" data-fileuploader-extensions="xlsx, ods">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel">
                                <form class="form-material form-action-post justify-content-center" action="#form_import_contratos" id="form_import_contratos" method="post">
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
        <!-- /#modalImportFormContratos -->


        <div id="modalConfiguraciones" class="modal fade" tabindex="-1" aria-labelledby="modalConfiguracionesLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfiguracionesLabel">Configuraciones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab_configuraciones" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Enviar correo </span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab_automatizaciones" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Programar envio atumatizado</span> 
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3">
                            <div class="tab-pane active" id="tab_configuraciones" role="tabpanel">

                                    <div class=" border-bottom mb-5">
                                        <div class="d-flex align-items-center">
                                            <h5 class="mb-0 card-title flex-grow-1">Jobs Lists</h5>
                                            <div class="flex-shrink-0">
                                                <button id="add_new_enviar_correo_al_cargar_reporte" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalFormIUEnviar_correo_al_cargar_reporte">Agregar nuevo</button>
                                            </div>
                                        </div>
                                    </div>


                                <table id="tb-datatable-enviar_correo_al_cargar_reporte" class="table nowrap dt-responsive align-middle table-hover table-bordered " style="width:100%">
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

                                <div class="modal-footer d-none">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                                </div>

                            </div>
                            <div class="tab-pane" id="tab_automatizaciones" role="tabpanel">
                                <form class="form-material form-action-post justify-content-center" action="#form_import_contratos" id="form_import_contratos" method="post">
                                    <div class="modal-body">
                                        <textarea class="form-control" id="vc_importar" name="vc_importar" rows="10" placeholder="Registro por cada salto de linea"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
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
        <!-- /#modalConfiguraciones -->

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


    </div>
    <!-- .crm-modals -->

</x-app-layout>



<style type="text/css">
    .fileuploader {
        width: 160px;
        height: 160px;
        margin: 15px;
    }

    .fileuploader-theme-dropin{
        text-align: center !important;
    }

</style>

<link href="assets/js/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="assets/js/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="assets/js/fileuploader/script/gallery/css/jquery.fileuploader-theme-gallery.css" media="all" rel="stylesheet">
<link href="assets/js/fileuploader/script/gallery/css/jquery.fileuploader-theme-avatar.css" media="all" rel="stylesheet">
<script src="assets/js/fileuploader/dist/jquery.fileuploader.min.js?{{ rand() }}"></script>

<script src="assets/js/core_js/contratos.js?{{ rand() }}"></script>

<script src="assets/js/core_js/enviar_correo_al_cargar_reporte.js?{{ rand() }}"></script>