<!DOCTYPE html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none">
    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="gus console" name="console" />
        <meta content="Themesbrand" name="gus@gnu.mx" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- preloader css -->
        <link rel="stylesheet" href="assets/css/preloader.min.css?{{ rand() }}" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css?{{ rand() }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css?{{ rand() }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css?{{ rand() }}" id="app-style" rel="stylesheet" type="text/css" />

        <!-- //////////////////////////////////////////////////////////////////////////////////// -->        
        <!-- //////////////////////////////////////////////////////////////////////////////////// -->
        <script src="assets/js/core_js/jquery-3.6.0.min.js"></script>
        <script src="http://console/assets/js/plugins/bootstrap.min.js"></script>
        <!-- flatpickr js -->
        <script src="assets/js/core_js/flatpickr.min.js?{{ rand() }}"></script>
        <script src="assets/js/core_js/es.js"></script>
        <link href="assets/js/core_js/flatpickr.css" rel="stylesheet" type="text/css" />

        <!-- Datatables -->
        <link href="assets/js/core_js/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />     
        <link href="assets/js/core_js/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/select.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/select.dataTables.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive Table css -->
        <link href="assets/js/core_js/admin-resources/rwd-table/rwd-table.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/datatable-fixed.css" rel="stylesheet" type="text/css" />
        <!-- Validate js -->
        <script src="assets/js/core_js/jquery.validate.js?{{ rand() }}"></script>
        <script src="assets/js/core_js/bootstrap-notify.min.js"></script>
        <!-- Cargando en formularios-->
        <script src="assets/js/core_js/waitMe.js"></script>
        <link href="assets/js/core_js/waitMe.css?{{ rand() }}" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/core.css?{{ rand() }}" rel="stylesheet" type="text/css" />
        <!-- Sweet Alerts js -->
        <script src="assets/js/core_js/sweetalert2.min.js"></script>
        <!-- Libretia General-->
        <script src="assets/js/core_js/Libreria-General.js?{{ rand() }}"></script>

    </head>
    <body id="" data-layout-size="boxed." >
        @include('layouts.header')
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        @include('layouts.footer')
    </body>

    <script type="text/javascript"> LibreriaGeneral.init(); </script>
</html>

