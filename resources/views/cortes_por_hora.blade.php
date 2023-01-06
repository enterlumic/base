<x-app-layout>
    <div class="row">

        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Cortes por hora</h4>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 align-self-center">
                        <section>
                            <div class="outer-wrapper">
                                <div class="inner-wrapper" id="div-fechas"></div>
                            </div>
                            <div class="pseduo-track"></div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

    <div class="crm-modals">
        <div class="modal fade" id="modalFormIUCortes_por_hora" tabindex="-1" aria-labelledby="add_new_cortes_por_horaLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-material form-action-post" action="#form_cortes_por_hora" id="form_cortes_por_hora" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_new_cortes_por_horaLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="event_date" class="form-label">Eventdate</label>
                                    <input type="text" class="form-control" id="event_date" name="event_date" placeholder="Escribe Eventdate">
                                </div>
                                <div class="col-sm-6">
                                    <label for="interval_hour" class="form-label">Intervalhour</label>
                                    <input type="text" class="form-control" id="interval_hour" name="interval_hour" placeholder="Escribe Intervalhour">
                                </div>
                                <div class="col-sm-12">
                                    <label for="agenttime_time" class="form-label">Agenttimetime</label>
                                    <input type="text" class="form-control" id="agenttime_time" name="agenttime_time" placeholder="Escribe Agenttimetime">
                                </div>
                                <div class="col-12">
                                    <label for="sales" class="form-label">Sales</label>
                                    <input type="text" class="form-control" id="sales" name="sales" placeholder="Escribe Sales">
                                </div>
                                <div class="col-12">
                                    <label for="sales" class="form-label">Sph</label>
                                    <input type="text" class="form-control" id="SPH" name="SPH" placeholder="Escribe Sph">
                                </div>
                                <div class="col-12">
                                    <label for="vCampo6_cortes_por_hora" class="form-label">vTema6_cortes_por_hora</label>
                                    <input type="text" class="form-control" id="vCampo6_cortes_por_hora" name="vCampo6_cortes_por_hora" placeholder="Escribe vTema6_cortes_por_hora">
                                </div>
                                <div class="col-12">
                                    <label for="vCampo7_cortes_por_hora" class="form-label">vTema7_cortes_por_hora</label>
                                    <input type="text" class="form-control" id="vCampo7_cortes_por_hora" name="vCampo7_cortes_por_hora" placeholder="Escribe vTema7_cortes_por_hora">
                                </div>
                                <div class="col-md-4">
                                    <label for="vCampo8_cortes_por_hora" class="form-label">vTema8_cortes_por_hora</label>
                                    <select class="form-select" id="vCampo8_cortes_por_hora" name="vCampo8_cortes_por_hora">
                                        <option value="">Choose...</option>
                                        <option value="1">demo1</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="vCampo9_cortes_por_hora" class="form-label">vTema9_cortes_por_hora</label>
                                    <input type="text" class="form-control" id="vCampo9_cortes_por_hora" name="vCampo9_cortes_por_hora" placeholder="Escribe vCampo9_cortes_por_hora">
                                </div>
                                <div class="col-md-3">
                                    <label for="vCampo10_cortes_por_hora" class="form-label">vTema10_cortes_por_hora</label>
                                    <input type="text" class="form-control" id="vCampo10_cortes_por_hora" name="vCampo10_cortes_por_hora" placeholder="Escribe vCampo10_cortes_por_hora">
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
        <!-- /.modalFormIUCortes_por_hora -->

        <div id="modalImportFormCortes_por_hora" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormCortes_por_horaLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportFormCortes_por_horaLabel">Cargar datos</h5>
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
                                <form action="FormImportarCortes_por_hora" id="FormImportarCortes_por_hora" name="FormImportarCortes_por_hora" >
                                    <input type="file" accept=".xlsx, .ods" name="files" data-fileuploader-limit="1" data-fileuploader-extensions="xlsx, ods">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel">
                                <form class="form-material form-action-post justify-content-center" action="#form_import_cortes_por_hora" id="form_import_cortes_por_hora" method="post">
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
        <!-- /.modalImportFormCortes_por_hora -->
    </div>
    <!-- .crm-modals -->

</x-app-layout>

<script src="assets/js/core_js/cortes_por_hora.js?{{ rand() }}"></script>
<link href="assets/css/cortes_por_horas.css?{{ rand() }}" rel="stylesheet" type="text/css" />
