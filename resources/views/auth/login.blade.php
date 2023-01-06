<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Login" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Bootstrap Css -->
    <link href="assets/css_login/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css_login/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css_login/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
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
                                            <h5 class="text-primary">Bienvenido de nuevo !</h5>

                                            <!-- Session Status -->
                                            <x-auth-session-status class="mb-4" :status="session('status')" />

                                            <!-- Validation Errors -->
                                            <x-auth-validation-errors class="mb-4" :errors="$errors" />

                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div class="p-2">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Usuario</label>
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Usuario">
                                        </div>
                
                                        <div class="mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" name="password" class="form-control pe-5" placeholder="Escribe la Contraseña" id="password-input">
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="remember_me" name="remember">
                                            <label class="form-check-label" for="remember_me">
                                                Recuerdame
                                            </label>
                                        </div>
                                        
                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Entrar</button>
                                        </div>
            
                                        <div class="mt-5 text-center">
                                            <p><a href="register" class="fw-medium text-primary"> Registro </a> </p>
                                        </div>
            
                                        <div class="mt-4 text-center d-none">
                                            <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                        </div>
                                    </form>
                                </div>
            
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->

        <!-- JAVASCRIPT -->
        <script src="assets/libs_login/jquery/jquery.min.js"></script>
        <script src="assets/libs_login/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs_login/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs_login/simplebar/simplebar.min.js"></script>
        <script src="assets/libs_login/node-waves/waves.min.js"></script>
        
        <!-- App js -->
        <script src="assets/js/app.js"></script>
    </body>
    
</html>