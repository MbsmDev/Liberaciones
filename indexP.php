<?php
require_once "conexion.php";
$con = conexion();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css" />
    <link href="css/styles.css" rel="stylesheet" href="librerias/alertifyjs/css/alertify.css" />
    <link href="css/styles.css" rel="stylesheet" href="librerias/alertifyjs/css/themes/default.css" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-color: #005CAB!important;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Portal Recertificación</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <div class="input-group">
        </div>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="mr-2 d-none d-lg-inline text-white-400">Miguel Sanchez </span><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>

            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Layouts
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Pages
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.html">Login</a>
                                        <a class="nav-link" href="register.html">Register</a>
                                        <a class="nav-link" href="password.html">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.html">401 Page</a>
                                        <a class="nav-link" href="404.html">404 Page</a>
                                        <a class="nav-link" href="500.html">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <img src="assets/img/carnot-logo.png" alt="logo" width="200" height="80" style="float:right" />
                    <h1 class="mt-4">Reporte Recertificaión</h1>
                    <!--<ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>-->
                    <br>
                    <br>
                    <br>
                    <div class="card mb-4">
                        <div class="card-header" style="background-color: #C1D82F!important;">
                            <i class="fas fa-table me-1"></i>
                            <!--KI-CAB-->
                        </div>
                        <div class="card-body">
                            <table class='table table-light table-responsive table-bordered'>
                                <thead class='table bg-secondary  text-white'>
                                    <tr>
                                        <th>ROL</th>
                                        <th>DESCRIPCIÓN</th>
                                        <th>DETALLE</th>
                                        <th>COMENTARIOS</th>
                                        <th>RESPUESTA</th>
                                        <th class='text-center' colspan='2' scope='col'>ACCIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT DISTINCT rol, UPPER(denominacion) FROM `temp_load` ORDER BY rol ASC";
                                    $result = mysqli_query($con, $sql);
                                    while ($ver = mysqli_fetch_row($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $ver[0] ?></td>
                                            <td><?php echo $ver[1] ?></td>
                                            <td>
                                                <type='button' id="detalle|<?php echo $ver[0] ?>" class='btn btn-secondary detalleRol'><img src='assets/img/articles_menu.gif'></button>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td><input type='button' id="aprobar|<?php echo $ver[0] ?>" class='btn btn-sm btn-success aprobar' VALUE='Aprobar' /></td>
                                            <td><input type='button' id="rechazar|<?php echo $ver[0] ?>" class='btn btn-sm btn-danger rechazar' VALUE='Rechazar' /></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Detalle -->
    <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #C1D82F!important;">
                    <h5 class="modal-title " id="detalleModalLabel">DETALLE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="bodyD" class="modal-body">
                    <div class="table-responsive d-flex flex-wrap" id="contenidoTabla">
                        <table class="table table-bordered">
                            <thead class='table bg-secondary text-white'>
                                <tr>
                                    <th scope="col">ROL</th>
                                    <th scope="col">TRANSACCIÓN</th>
                                    <th scope="col">DESCRIPCIÓN</th>
                                    <th scope="col">COMENTARIOS</th>
                                    <th class='text-center' colspan='2' scope='col'>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyD">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>-->
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="librerias/alertifyjs/alertify.js"></script>
</body>

</html>

<script type="text/javascript">
    $(function() {

        $(".detalleRol").click(function() {
            //alert("Hola - Detalle Rol");
            $("#tbodyD").empty();
            $("#detalleModal").modal('show');
            var id = $(this).attr("id");
            var parts = id.split('|');
            var idRol = parts[1];
            //alert("Hola - Detalle Rol:"+idRol);
            var parm = {};
            parm['idRol'] = idRol;

            $.getJSON('showItemsRol.php', parm, function(data) {

                console.log(data);

                $.each(data, function(i, DATAITEMS) {

                    var tblRow =
                        "<tr>" +
                        "<td>" + DATAITEMS.rol + "</td>" +
                        "<td>" + DATAITEMS.transaccion + "</td>" +
                        "<td>" + DATAITEMS.descripcion + "</td>" +
                        "<td></td>" +
                        "<td><input type='button' id="+ DATAITEMS.transaccion +" class='btn btn-sm btn-success aprobarD' VALUE='Aprobar' /></td>" +
                        "<td><input type='button' id="+ DATAITEMS.transaccion +" class='btn btn-sm btn-danger rechazar' VALUE='Rechazar' /></td>" +
                        "</tr>"
                    $('#tbodyD').append(tblRow);
                });

            });

        });

        $(".aprobar").click(function() {
            alert("Hola - Aprobar");
        });

        $(".rechazar").click(function() {
            alert("Hola - Rechazar");
        });

    });
</script>