<x-app-layout>

    <div class="row mt-5">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="assets/images/users/avatar-1.jpg" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" class="profile-img-file-input" accept="image/png, image/jpeg, image/webp">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="bx bx-camera"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-1 user-name-text">{{ Auth::user()->name }}</h5>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-9 ">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                Datos personales
                            </a>
                        </li>
                        <li class="nav-item d-none">
                            <a class="nav-link" data-bs-toggle="tab" href="#Historial-usuario" role="tab">
                                <i class="far fa-user"></i>
                                Historial
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form class="form-material form-action-post" action="#form_perfil_usuario" id="form_perfil_usuario" method="post">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="{{ isset(Auth::user()->name) ? Auth::user()->name: '' }}">
                                            <input type="hidden" name="id" id="id" value=" {{ isset(Auth::user()->id) ? Auth::user()->id : '' }} ">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control vc_telefono" id="phone" name="phone" placeholder="Teléfono" value="{{ isset(Auth::user()->phone) ? Auth::user()->phone : '' }}">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Correo</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ isset(Auth::user()->email) ? Auth::user()->email : '' }}">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                            <button type="button" class="btn btn-soft-secondary">Cancelar</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <div class="tab-pane " id="Historial-usuario" role="tabpanel">
                                        <div class="">
                                            <ul class="verti-timeline list-unstyled">
                                                <li class="event-list">
                                                    <div class="event-timeline-dot">
                                                        <i class="bx bx-right-arrow-circle"></i>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="bx bx-copy-alt h2 text-primary"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div>
                                                                <h5>Ordered</h5>
                                                                <p class="text-muted">New common language will be more simple and regular than the existing.</p>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="event-list">
                                                    <div class="event-timeline-dot">
                                                        <i class="bx bx-right-arrow-circle"></i>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="bx bx-package h2 text-primary"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div>
                                                                <h5>Packed</h5>
                                                                <p class="text-muted">To achieve this, it would be necessary to have uniform grammar.</p>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="event-list active">
                                                    <div class="event-timeline-dot">
                                                        <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="bx bx-car h2 text-primary"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div>
                                                                <h5>Shipped</h5>
                                                                <p class="text-muted">It will be as simple as Occidental in fact, it will be Occidental..</p>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="event-list">
                                                    <div class="event-timeline-dot">
                                                        <i class="bx bx-right-arrow-circle"></i>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="bx bx-badge-check h2 text-primary"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div>
                                                                <h5>Delivered</h5>
                                                                <p class="text-muted">To an English person, it will seem like simplified English.</p>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->



</x-app-layout>


<style type="text/css">
    .fileuploader {
        width: 160px;
        height: 160px;
        margin: 15px;
    }
 .profile-user .profile-img-file-input{
     display:none 
}

 .avatar-title{
     -webkit-box-align:center;
     -ms-flex-align:center;
     align-items:center;
     background-color:#F04029;
     color:#fff;
     display:-webkit-box;
     display:-ms-flexbox;
     display:flex;
     font-weight:500;
     height:100%;
     -webkit-box-pack:center;
     -ms-flex-pack:center;
     justify-content:center;
     width:100% 
}
 .avatar-group{
     padding-left:12px;
     display:-webkit-box;
     display:-ms-flexbox;
     display:flex;
     -ms-flex-wrap:wrap;
     flex-wrap:wrap 
}
 .avatar-group .avatar-group-item{
     margin-left:-12px;
     border:2px solid var(--vz-card-bg);
     border-radius:50%;
     -webkit-transition:all .2s;
     transition:all .2s 
}
 .avatar-group .avatar-group-item:hover{
     position:relative;
     -webkit-transform:translateY(-2px);
     transform:translateY(-2px);
     z-index:1 
}
 .profile-user{
     position:relative;
     display:inline-block 
}
 .profile-user .profile-photo-edit{
     position:absolute;
     right:0;
     left:auto;
     bottom:0;
     cursor:pointer 
}
 .profile-user .user-profile-image{
     -o-object-fit:cover;
     object-fit:cover 
}
 .profile-user .profile-img-file-input{
     display:none 
}

</style>
<link href="assets/js/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="assets/js/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="assets/js/fileuploader/script/gallery/css/jquery.fileuploader-theme-gallery.css" media="all" rel="stylesheet">
<link href="assets/js/fileuploader/script/gallery/css/jquery.fileuploader-theme-avatar.css" media="all" rel="stylesheet">
<!-- <link href="assets/css/core/index.css" media="all" rel="stylesheet"> -->
<script src="assets/js/fileuploader/dist/jquery.fileuploader.min.js"></script>

<script src="assets/js/core_js/perfil_usuario.js?<?php echo rand()?>"></script>