<x-app-layout>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Filtros</h5>
                    <div>
                        <button id="truncate_Filtros" class="btn btn-danger btn-sm">Truncate</button>
                        <button id="refresh_Filtros" class="btn btn-light btn-sm">Actualizar</button>
                        <button id="add_new_filtros" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFormIUFiltros">Nuevo</button>
                        <button id="import_filtros" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportFormFiltros">Importar</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tb-datatable-filtros" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 5%">id</th>
                                <th >vTema1_filtros</th>
                                <th >vTema2_filtros</th>
                                <th >vTema3_filtros</th>
                                <th >vTema4_filtros</th>
                                <th >vTema5_filtros</th>
                                <th >vTema6_filtros</th>
                                <th >vTema7_filtros</th>
                                <th >vTema8_filtros</th>
                                <th >vTema9_filtros</th>
                                <th >vTema10_filtros</th>
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
        <div class="modal fade" id="modalFormIUFiltros" tabindex="-1" aria-labelledby="add_new_filtrosLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_filtros" id="form_filtros" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_filtrosLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
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
        <!-- /.modalFormIUFiltros -->

        <div id="modalImportFormFiltros" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormFiltrosLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormFiltrosLabel">Importar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form-material form-action-post" action="#form_import_filtros" id="form_import_filtros" method="post">
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

<script src="assets/js/core_js/filtros.js?{{ rand() }}"></script>