<x-app-layout>

<!--     <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">

                    <div class="mb-3">
                        <span id="menu-navi" class="">
                            <div class="d-sm-flex  gap-1">
                                <button id="truncate_Skynet" class="btn btn-danger">Truncate</button>
                                <button id="refresh_Skynet" class="btn btn-light">Actualizar</button>
                            </div>
                        </span>
                    </div>

                    <table id="tb-datatable-skynet" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 5%">id</th>
                                <th >User_o_id_cliente</th>
                                <th >Evento</th>
                                <th >Query</th>
                                <th >Info</th>
                                <th style="width: 9%">Acción</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div> -->
    <!-- .row -->

    <div class="crm-modals">
        <div class="modal fade" id="modalFormIUSkynet" tabindex="-1" aria-labelledby="add_new_skynetLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_skynet" id="form_skynet" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_skynetLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="id_user_o_id_cliente" class="form-label">User_o_id_cliente</label>
                                    <input type="text" class="form-control" id="id_user_o_id_cliente" name="id_user_o_id_cliente" placeholder="Escribe User_o_id_cliente">
                                </div>
                                <div class="col-sm-6">
                                    <label for="vc_evento" class="form-label">Evento</label>
                                    <input type="text" class="form-control" id="vc_evento" name="vc_evento" placeholder="Escribe Evento">
                                </div>
                                <div class="col-sm-12">
                                    <label for="vc_query" class="form-label">Query</label>
                                    <input type="text" class="form-control" id="vc_query" name="vc_query" placeholder="Escribe Query">
                                </div>
                                <div class="col-12">
                                    <label for="vc_info" class="form-label">Info</label>
                                    <input type="text" class="form-control" id="vc_info" name="vc_info" placeholder="Escribe Info">
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
        <!-- /.modalFormIUSkynet -->

        <div id="modalImportFormSkynet" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormSkynetLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormSkynetLabel">Importar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form-material form-action-post" action="#form_import_skynet" id="form_import_skynet" method="post">
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
