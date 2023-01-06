<x-app-layout>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Reporte de desempeño</h4>
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
                <div class="tab-content p-3">
                    <div class="tab-pane active" id="all-order" role="tabpanel">
                        <form>
                            <div class="row">
                                <div class="col-xl col-sm-6">
                                    <div class="mb-3">
                                        <div class="position-relative">
                                            <!-- <input type="text" class="form-control chat-input" id="buscar_reporte" placeholder="Buscar..."> -->
                                            <div class="chat-input-links" id="tooltip-container">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="javascript: void(0);" 
                                                            title="Mostrar opciones de búsqueda" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mostrar opciones de búsqueda">
                                                            <!-- <i class="mdi mdi-filter-variant-plus"></i> -->
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md">
                                                            <form class="p-3">
                                                                <div class="form-group m-0">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">                                        
                                        <table id="tb-datatable-desepenio" class="table stripe row-border order-column" style="width: 100%;">
                                            <thead class="table-light">
                                                <tr>
                                                    <th >IdTrab</th>
                                                    <th >Gestor</th>
                                                    <th width="100">Ingreso</th>
                                                    <th >Baja</th>
                                                    <th >Ant</th>
                                                    <th >Turno</th>
                                                    <th >Rol</th>
                                                    <th >Descripcion</th>
                                                    <th >Departamento</th>
                                                    <th >Coordinador</th>
                                                    <th >Jefe Piso</th>
                                                    <th >HORAS MES</th>
                                                    <th >TIEMPO EFECTIVO</th>
                                                    <th >% TIEMPO EFECTIVO</th>
                                                    <th >SPH MES</th>
                                                    <th >LOGROS MES</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="processing" role="tabpanel">
                        <div>
                            <div class="table-responsive mt-4">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- .row -->

    <div class="crm-modals">
        <div class="modal fade" id="modalFormIUDesepenio" tabindex="-1" aria-labelledby="add_new_desepenioLabel">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_desepenio" id="form_desepenio" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_desepenioLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table class="table stripe row-border order-column" style="width: 100%;" id="tb-datatable-resumen">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Horas Conexión</th>
                                                    <th>Logros</th>
                                                    <th>SPH</th>
                                                    <th>AgentTime</th>
                                                    <th>BRK</th>
                                                    <th>JUN</th>
                                                    <th>BA</th>
                                                    <th>Tiempo Efectivo</th>
                                                    <th>% Tiempo Efectivo</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer m-t-10">
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-primary btn-action-form" data-bs-dismiss="modal" aria-label="Close">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modalFormIUDesepenio -->

        <div id="modalImportFormDesepenio" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormDesepenioLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormDesepenioLabel">Importar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form-material form-action-post" action="#form_import_desepenio" id="form_import_desepenio" method="post">
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

        <div class="modal fade" id="modalFormIUFiltros" tabindex="-1" aria-labelledby="add_new_filtrosLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_filtros" id="form_filtros" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_filtrosLabel">Seleccionar Rango de fechas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer m-t-10">
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-action-form">Filtrar</button>
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

<script src="assets/js/core_js/desepenio.js?{{ rand() }}"></script>

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
 
    div.container {
        width: 80%;
    }
</style>