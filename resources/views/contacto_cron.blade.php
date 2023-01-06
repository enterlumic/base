<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Contactos</h4>
                <div>
                    <button id="refresh_Contacto_cron" class="btn btn-success">Actualizar</button>
                    <button id="add_new_contacto_cron" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUContacto_cron">Nuevo</button>
                </div>                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="tb-datatable-contacto_cron" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 5%">id</th>
                                <th >Nombre</th>
                                <th >Correo</th>
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
        <div class="modal fade" id="modalFormIUContacto_cron" tabindex="-1" aria-labelledby="add_new_contacto_cronLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_contacto_cron" id="form_contacto_cron" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_contacto_cronLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-sm-12">
                                    <label for="vc_nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="vc_nombre" name="vc_nombre" placeholder="Escribe Nombre">
                                </div>
                                <div class="col-sm-12">
                                    <label for="vc_correo" class="form-label">Correo</label>
                                    <input type="text" class="form-control" id="vc_correo" name="vc_correo" placeholder="Escribe Correo">
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
        <!-- /.modalFormIUContacto_cron -->

        <div id="modalImportFormContacto_cron" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormContacto_cronLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormContacto_cronLabel">Cargar datos</h5>
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
                                <form action="FormImportarContacto_cron" id="FormImportarContacto_cron" name="FormImportarContacto_cron" >
                                    <input type="file" accept=".xlsx, .ods" name="files" data-fileuploader-limit="1" data-fileuploader-extensions="xlsx, ods">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel">
                                <form class="form-material form-action-post justify-content-center" action="#form_import_contacto_cron" id="form_import_contacto_cron" method="post">
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
        <!-- /.modalImportFormContacto_cron -->


    </div>
    <!-- .crm-modals -->

</x-app-layout>

<script src="assets/js/core_js/contacto_cron.js?{{ rand() }}"></script>