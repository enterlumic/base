<x-app-layout>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Trabajadorsonarh</h5>
                    <div>
                        <button id="truncate_Trabajadorsonarh" class="btn btn-danger">Truncate</button>
                        <button id="refresh_Trabajadorsonarh" class="btn btn-success">Actualizar</button>
                        <button id="add_new_trabajadorsonarh" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUTrabajadorsonarh">Nuevo</button>
                        <button id="import_trabajadorsonarh" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalImportFormTrabajadorsonarh">Importar</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tb-datatable-trabajadorsonarh" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 5%">id</th>
                                <th >Nombre</th>
                                <th >Paterno</th>
                                <th >Materno</th>
                                <th >Fechaingreso</th>
                                <th >Fechabaja</th>
                                <th >Fecha</th>
                                <th >De</th>
                                <th >Nacimiento</th>
                                <th >Centro</th>
                                <th >Costo</th>
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
        <div class="modal fade" id="modalFormIUTrabajadorsonarh" tabindex="-1" aria-labelledby="add_new_trabajadorsonarhLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_trabajadorsonarh" id="form_trabajadorsonarh" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_trabajadorsonarhLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="Nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Escribe Nombre">
                                </div>
                                <div class="col-sm-6">
                                    <label for="Paterno" class="form-label">Paterno</label>
                                    <input type="text" class="form-control" id="Paterno" name="Paterno" placeholder="Escribe Paterno">
                                </div>
                                <div class="col-sm-12">
                                    <label for="Materno" class="form-label">Materno</label>
                                    <input type="text" class="form-control" id="Materno" name="Materno" placeholder="Escribe Materno">
                                </div>
                                <div class="col-12">
                                    <label for="FechaIngreso" class="form-label">Fechaingreso</label>
                                    <input type="text" class="form-control" id="FechaIngreso" name="FechaIngreso" placeholder="Escribe Fechaingreso">
                                </div>
                                <div class="col-12">
                                    <label for="FechaIngreso" class="form-label">Fechabaja</label>
                                    <input type="text" class="form-control" id="FechaBaja" name="FechaBaja" placeholder="Escribe Fechabaja">
                                </div>
                                <div class="col-12">
                                    <label for="Fecha" class="form-label">Fecha</label>
                                    <input type="text" class="form-control" id="Fecha" name="Fecha" placeholder="Escribe Fecha">
                                </div>
                                <div class="col-12">
                                    <label for="De" class="form-label">De</label>
                                    <input type="text" class="form-control" id="De" name="De" placeholder="Escribe De">
                                </div>
                                <div class="col-md-4">
                                    <label for="Nacimiento" class="form-label">Nacimiento</label>
                                    <select class="form-select" id="Nacimiento" name="Nacimiento">
                                        <option value="">Choose...</option>
                                        <option value="1">demo1</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="Centro" class="form-label">Centro</label>
                                    <input type="text" class="form-control" id="Centro" name="Centro" placeholder="Escribe Centro">
                                </div>
                                <div class="col-md-3">
                                    <label for="Costo" class="form-label">Costo</label>
                                    <input type="text" class="form-control" id="Costo" name="Costo" placeholder="Escribe Costo">
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
        <!-- /.modalFormIUTrabajadorsonarh -->

        <div id="modalImportFormTrabajadorsonarh" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormTrabajadorsonarhLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormTrabajadorsonarhLabel">Cargar datos</h5>
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
                                <form action="FormImportarTrabajadorsonarh" id="FormImportarTrabajadorsonarh" name="FormImportarTrabajadorsonarh" >
                                    <input type="file" accept=".xlsx, .ods" name="files" data-fileuploader-limit="1" data-fileuploader-extensions="xlsx, ods">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel">
                                <form class="form-material form-action-post justify-content-center" action="#form_import_trabajadorsonarh" id="form_import_trabajadorsonarh" method="post">
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
        <!-- /.modalImportFormTrabajadorsonarh -->


    </div>
    <!-- .crm-modals -->

</x-app-layout>

<script src="assets/js/core_js/trabajadorsonarh.js?{{ rand() }}"></script>