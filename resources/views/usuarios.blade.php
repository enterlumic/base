<x-app-layout>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Usuarios</h5>
                    <div>
                        <button id="refresh_Usuarios" class="btn btn-success">Actualizar</button>
                        <button id="add_new_usuarios" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUUsuarios">Nuevo</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tb-datatable-usuarios" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 5%">id</th>
                                <th >Name</th>
                                <th >Email</th>
                                <th >Emailverified_at</th>
                                <th >Phone</th>
                                <th >Photo</th>
                                <th >Password</th>
                                <th >Remembertoken</th>
                                <th >Createdat</th>
                                <th >Updatedat</th>
                                <th >Gu</th>
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
        <div class="modal fade" id="modalFormIUUsuarios" tabindex="-1" aria-labelledby="add_new_usuariosLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_usuarios" id="form_usuarios" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_usuariosLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Escribe Name">
                                </div>
                                <div class="col-sm-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Escribe Email">
                                </div>
                                <div class="col-sm-12">
                                    <label for="email_verified_at" class="form-label">Emailverified_at</label>
                                    <input type="text" class="form-control" id="email_verified_at" name="email_verified_at" placeholder="Escribe Emailverified_at">
                                </div>
                                <div class="col-12">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Escribe Phone">
                                </div>
                                <div class="col-12">
                                    <label for="phone" class="form-label">Photo</label>
                                    <input type="text" class="form-control" id="photo" name="photo" placeholder="Escribe Photo">
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" placeholder="Escribe Password">
                                </div>
                                <div class="col-12">
                                    <label for="remember_token" class="form-label">Remembertoken</label>
                                    <input type="text" class="form-control" id="remember_token" name="remember_token" placeholder="Escribe Remembertoken">
                                </div>
                                <div class="col-md-4">
                                    <label for="created_at" class="form-label">Createdat</label>
                                    <select class="form-select" id="created_at" name="created_at">
                                        <option value="">Choose...</option>
                                        <option value="1">demo1</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="updated_at" class="form-label">Updatedat</label>
                                    <input type="text" class="form-control" id="updated_at" name="updated_at" placeholder="Escribe updated_at">
                                </div>
                                <div class="col-md-3">
                                    <label for="guid" class="form-label">Gu</label>
                                    <input type="text" class="form-control" id="guid" name="guid" placeholder="Escribe guid">
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
        <!-- /.modalFormIUUsuarios -->

        <div id="modalImportFormUsuarios" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormUsuariosLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormUsuariosLabel">Cargar datos</h5>
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
                                <form action="FormImportarUsuarios" id="FormImportarUsuarios" name="FormImportarUsuarios" >
                                    <input type="file" accept=".xlsx, .ods" name="files" data-fileuploader-limit="1" data-fileuploader-extensions="xlsx, ods">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel">
                                <form class="form-material form-action-post justify-content-center" action="#form_import_usuarios" id="form_import_usuarios" method="post">
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
        <!-- /.modalImportFormUsuarios -->


    </div>
    <!-- .crm-modals -->

</x-app-layout>

<script src="assets/js/core_js/usuarios.js?{{ rand() }}"></script>