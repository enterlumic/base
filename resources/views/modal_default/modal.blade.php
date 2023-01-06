<div class="modal fade" id="modal_form_modal_add_git">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ADD GIT</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-material form-action-post" action="#modal_add_git" id="modal_add_git" method="post">
                <div class="modal-body">
                    <div class="form-group form-primary">
                        <label class="float-label">Path</label>
                        <span class="form-bar"></span>
                        <textarea id="vc_add_git" name="vc_add_git" rows="4" cols="50" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form_modal_seleccionar_opciones">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Opciones</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-material form-action-post" action="#modal_seleccionar_opciones" id="modal_seleccionar_opciones" method="post">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tbl-mas-de-un-comando" class="table table-sm mb-0">
                                    <tbody id="tbody-opciones">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modals-interno" class="d-none">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">

                    <div class="mb-3">
                        <span id="menu-navi" class="">
                            <div class="d-sm-flex  gap-1">
                                <button id="truncate_Skynet" class="btn btn-danger">Truncate</button>
                                <button id="refresh_Skynet" class="btn btn-success">Actualizar</button>
                            </div>
                        </span>
                    </div>

                    <table id="tb-datatable-skynet" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead class="table-primary">
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
    </div>                 
</div>

<div class="modal fade" id="modal_form_modal_comandos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-material form-action-post" action="#comandos" id="form_comandos" method="post">
                <div class="modal-body">
                    <div class="form-group form-primary">
                        <label class="float-label">Atajo teclado</label>
                        <span class="form-bar"></span>
                        <input type="text" class="form-control form-control-capitalize" id="vc_atajo_teclado" name="vc_atajo_teclado" required>
                    </div>
                    <div class="form-group form-primary">
                        <label class="float-label">Comando</label>
                        <span class="form-bar"></span>
                        <textarea id="vc_comando" name="vc_comando" class="form-control" rows="2" ></textarea>
                    </div>
                    <div class="form-group form-primary">
                        <label class="float-label">Comentarios</label>
                        <span class="form-bar"></span>
                        <textarea id="vc_comentario" name="vc_comentario" class="form-control" rows="2" ></textarea>
                    </div>
                    <div class="form-group form-primary">
                        <label class="float-label">Script</label>
                        <span class="form-bar"></span>
                        <input type="text" class="form-control" id="vc_path_script" name="vc_path_script" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form_modal_replace">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reemplazar</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-material form-action-post" action="#modal_replace" id="form_modal_replace" method="post">
                <div class="modal-body">
                    <div class="form-group form-primary">
                        <label class="float-label">Buscar</label>
                        <span class="form-bar"></span>
                        <input type="text" class="form-control form-control-capitalize" id="vc_buscar" name="vc_buscar" >
                    </div>
                    <div class="form-group form-primary">
                        <label class="float-label">Reemplazar</label>
                        <span class="form-bar"></span>
                        <input type="text" class="form-control" id="vc_reemplazar" name="vc_reemplazar" >
                    </div>
                    <div id="response_prueba" class="d-none"></div>
                    <div id="response" class="d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form_modal_remove_files" data-toggle="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">RM -R</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-material form-action-post" action="#modal_remove_files" id="modal_remove_files" method="post">
                <div class="modal-body">
                    <div class="form-group form-primary">
                        <label class="float-label">Path</label>
                        <span class="form-bar"></span>
                        <textarea id="vc_path_replace" name="vc_path_replace" rows="4" cols="50" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>