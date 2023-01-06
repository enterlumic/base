<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Register | Skote - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>
        
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Registro</h5>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div>
                                    <a href="index.html">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
            
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Correo</label>
                                            <x-input id="email" class="form-control" :value="old('email')" type="email" name="email" id="email"  required autofocus />
                                            <div class="invalid-feedback">
                                                Por favor ingrese su nombre
                                            </div>
                                        </div>
                
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Nombre</label>
                                            <x-input id="name" class="form-control" :value="old('name')" type="text" name="name"  required  />
                                            <div class="invalid-feedback">
                                                Por favor ingrese su nombre
                                            </div>  
                                        </div>
                
                                        <div class="mb-3">
                                            <label for="userpassword" class="form-label">Contraseña</label>
                                            <x-input id="password" class="form-control pe-5 password-input"
                                                type="password"
                                                name="password"
                                                id="password-input"
                                                onpaste="return false"
                                                    aria-describedby="passwordInput"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                required autocomplete="new-password" />
                                            <div class="invalid-feedback">
                                                Escribe una contraseña
                                            </div>       
                                        </div>
                    
                                        <div class="mb-3">
                                            <label for="userpassword" class="form-label">Repetir contraseña</label>
                                            <x-input id="password" class="form-control pe-5 password-input"
                                                type="password"
                                                name="password_confirmation"
                                                id="password_confirmation"
                                                onpaste="return false"
                                                    aria-describedby="passwordInput"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                required autocomplete="new-password" />
                                            <div class="invalid-feedback">
                                                Escribe una contraseña
                                            </div>       
                                        </div>
                    

                                        <div class="mt-4 d-grid">

                                                <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                    <h5 class="fs-13 fw-semibold">La contraseña debe contener:</h5>
                                                    <p id="pass-length" class="invalid fs-12 mb-2">Mínimo <b>8 caracteres</b></p>
                                                    <p id="pass-lower" class="invalid fs-12 mb-2">En letra <b>minúscula</b> letter (a-z)</p>
                                                    <p id="pass-upper" class="invalid fs-12 mb-2">Al menos una <b>mayúscula</b> (A-Z)</p>
                                                    <p id="pass-number" class="invalid fs-12 mb-0">Por lo menos un <b>número</b> (0-9)</p>
                                                </div>

                                        </div>

                                        <div class="mt-4 d-grid">
                                            <button class="btn btn-primary w-100" type="submit">Enviar</button>
                                        </div>
                            
                                        <div class="mt-5 text-center">
                                            <div>
                                                <p>¿Ya tienes una cuenta<a href="login" class="fw-medium text-primary"> Login</a> </p>
                                            </div>
                                        </div>

                                    </form>
                                </div>
            
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- validation init -->
        <script src="assets/js/pages/validation.init.js"></script>
        
        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>
</html>
