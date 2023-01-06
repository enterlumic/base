<x-app-layout>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-n4 mx-n4 border-0">
                <div class="bg-soft-primary">
                    <div class="card-body pb-0 px-4">
                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-auto">
                                        <div class="avatar-md">
                                            <div class="avatar-title bg-white rounded-circle">
                                                <img src="assets/images/brands/slack.png" alt="" class="avatar-xs">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <divs>
                                            <form action="#crear-core" id="crear-core" method="post">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                         <input type="text" class="form-control" required value="pruebas" name="proyecto" id="proyecto">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" required value="probando" name="name_strtolower" id="name_strtolower">
                                                    </div>
                                                    <div class="col-md-3 btn-crear crear">
                                                        <input type="submit" id="crear-nuevo" form="crear-core" value="Crear" class="btn btn-sm btn-primary">
                                                        <a href="javascript:void(0);" id="reset-api" class="btn btn-danger btn-sm pull-right">Reset</a>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-1">
                                                        <div class="form-group fill ">
                                                            <label class="check-task custom-control  d-flex justify-content-center done-task">
                                                                <input type="checkbox" class="custom-control-input" name="seleccionar-todo" id="seleccionar-todo">
                                                                <span class="custom-control-label"></span> All </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="form-group fill">
                                                            <label class="check-task custom-control  d-flex justify-content-center done-task">
                                                                <input type="checkbox" class="custom-control-input" name="migrate" id="migrate">
                                                                <span class="custom-control-label"></span> Migrate </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="form-group fill">
                                                            <label class="check-task custom-control  d-flex justify-content-center done-task">
                                                                <input type="checkbox" class="custom-control-input" name="route" id="route">
                                                                <span class="custom-control-label"></span> Routes </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="form-group fill">
                                                            <label class="check-task custom-control  d-flex justify-content-center done-task">
                                                                <input type="checkbox" class="custom-control-input" name="model" id="model">
                                                                <span class="custom-control-label"></span> Model </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group fill">
                                                            <label class="check-task custom-control  d-flex justify-content-center done-task">
                                                                <input type="checkbox" class="custom-control-input" name="view" id="view">
                                                                <span class="custom-control-label"></span> View </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <label class="check-task custom-control  d-flex justify-content-center done-task">
                                                            <input type="checkbox" class="custom-control-input" name="controller" id="controller">
                                                            <span class="custom-control-label"></span> Controler </label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class="check-task custom-control  d-flex justify-content-center done-task">
                                                            <input type="checkbox" class="custom-control-input" name="js" id="js">
                                                            <span class="custom-control-label"></span> JS </label>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <label class="check-task custom-control  d-flex justify-content-center done-task">
                                                            <input type="checkbox" class="custom-control-input" name="sql" id="sql">
                                                            <span class="custom-control-label"></span> SQL </label>
                                                    </div>
                                                </div>
                                            </form>                                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#tab_api" role="tab">
                                    APi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab_comandos" role="tab">
                                    Comandos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab_notas" role="tab">
                                    Notas
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end card body -->
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="tab-content text-muted">
                <div class="tab-pane fade show active" id="tab_api" role="tabpanel">
                    <div class="row">
                        <div class="col-xl-9 col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <table id="tb-datatable-api_by_lumic" class="table" data-addclass-on-xs="table-sm" width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>id</th>
                                                <th>Nombre</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <textarea id="campos" class="d-none"></textarea>                                                    
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- ene col -->
                        <div class="col-xl-3 col-lg-4">

                            <div class="card">
                                <div class="card-header align-items-center d-flex border-bottom-dashed">
                                    <h4 class="card-title mb-0 flex-grow-1">Archivos</h4>
                                </div>
                                <div class="card-body">
                                    <div data-simplebar style="height: 235px;" class="mx-n3 px-3">
                                        <div class="vstack gap-3">
                                            <!-- end member item -->
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs flex-shrink-0 me-3">
                                                    <div class="avatar-title bg-soft-success text-success rounded-circle">
                                                        HB
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0"><a href="" class="text-body d-block">Henry Baird</a></h5>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button type="button" class="btn btn-light btn-sm">Message</button>
                                                        <div class="dropdown">
                                                            <button class="btn btn-icon btn-sm fs-16 text-muted dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-fill text-muted me-2 align-bottom"></i>View</a></li>
                                                                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-star-fill text-muted me-2 align-bottom"></i>Favourite</a></li>
                                                                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end member item -->
                                        </div>
                                        <!-- end list -->
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <div class="tab-pane fade show " id="tab_notas" role="tabpanel">

                </div>

                <div class="tab-pane fade show " id="tab_comandos" role="tabpanel">

                    <div class="row">
                        <div class="col-xl-9 col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <table id="tb-datatable-comandos"class="table table-striped" width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th >id</th>
                                                <th >#</th>
                                                <th >Comando</th>
                                                <th >Comentarios</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- end tab pane -->
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <!-- Modal --> 
    <div class="modal fade" id="modal_form_update">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Editar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-horizontal" action="#notes" id="form_apy_by_lumic_update" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="hidden" id="id" name="id">
                                <textarea id="vc_description_update" name="vc_description_update"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default close" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-sm btn-primary btn-action-form">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_form_reemplazar_tema">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reemplazar Tema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-material form-action-post" action="#reemplazar_tema" id="form_reemplazar_tema" method="post">
                    <div class="modal-body">
                        <div class="form-group form-primary">
                            <textarea id="vc_reemplazar_tema" name="vc_reemplazar_tema" rows="15" cols="50" class="form-control form-control-capitalize"></textarea>
                            <span class="form-bar"></span>
                            <label class="float-label">Agrega la lista, salto de linea es un registro</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default close" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-sm btn-primary btn-action-form">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- quill css -->
<link href="assets/libs/quill/quill.core.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/quill/quill.bubble.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />
<script src="assets/js/core_js/editor.js"></script>
<script src="assets/js/core_js/bootstrap-notify.min.js?{{ rand() }}"></script>
<script src="assets/js/core_js/api-lumic.js?{{ rand() }}"></script>
<script src="assets/js/core_js/console_gt.js?{{ rand() }}"></script>
<script src="assets/js/core_js/notas.js?{{ rand() }}"></script>
