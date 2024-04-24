<?php 
# @session_start(); 
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="icon"  type="image/x-icon" href="carnotL.ico"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Liberación de Pedidos y Solicitud de Pedidos</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="<?= URL ?>css/styles.css" rel="stylesheet" />
        <link href="<?= URL ?>css/styles.css" rel="stylesheet" href="<?= URL ?>librerias/bootstrap/css/bootstrap.css" />
        <link href="<?= URL ?>css/styles.css" rel="stylesheet" href="<?= URL ?>librerias/alertifyjs/css/alertify.css" />
        <link href="<?= URL ?>css/styles.css" rel="stylesheet" href="<?= URL ?>librerias/alertifyjs/css/themes/default.css" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="<?=URL?>vendor/jquery/jquery.min.js"></script>
    </head>
    <body class="bg-Secondary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                    <div class="logodiv" align="center">
                                        <!--<a class="navbar-brand" href="index.html">-->
                                        <img src="<?= URL ?>assets/img/carnot-logo.png" alt="logo" width="250" height="100"/>
                                        </a>
                                    </div>
                                    </div>
                                    <div class="card-body">
                                    <h4 class="text-center font-weight-light my-4">Portal liberaciones de<br>solicitudes y pedidos</h4>
                                    <h5 class="text-center h5 text-gray-900 mb-4">Bienvenido(a)</h5>
                                    <br/>
                                        <form action="<?= URL ?>page/control" method="POST">
                                            <?php if(isset($_GET['error'])){ ?>
                                                <div class="alert alert-danger text-center" role="alert">
                                                <? echo $_GET['error']; ?>
                                                </div>
                                            <?php } ?>
                                            <div class="form-floating mb-3">
                                                <input type="user" class="form-control form-control-user" name="usuario" placeholder="Usuario..." required/>
                                                <label for="inputPassword">Usuario</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="clave" required/>
                                                <label for="inputPassword">Contraseña</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="https://autosoporte.carnotapps.com:9251/authorization.do">Has olvidado tu contraseña?</a>
                                            </div>
                                            </br>
                                            <div class="col text-center">
                                                <input class="btn btn-primary" type="submit" value="Ingresar">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                    <div class="copyright text-center my-auto">
                        <span>Laboratorios &reg; Carnot</span>
                    </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?= URL ?>js/scripts.js"></script>
    </body>
</html>
<?php exit(); ?>
