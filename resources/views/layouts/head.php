<?php


@session_start();
if($_SESSION["autentica"] != "SIP"){
    header("Location:".URL."page/login");
}

$nombre = $_SESSION["nombre"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?= URL ?>css/styles.css" rel="stylesheet" />
    <link href="<?= URL ?>css/styles.css" rel="stylesheet" href="<?= URL ?>librerias/bootstrap/css/bootstrap.css" />
    <link href="<?= URL ?>css/styles.css" rel="stylesheet" href="<?= URL ?>librerias/alertifyjs/css/alertify.css" />
    <link href="<?= URL ?>css/styles.css" rel="stylesheet" href="<?= URL ?>librerias/alertifyjs/css/themes/default.css" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>-->
    <script src="<?= URL ?>vendor/jquery/jquery.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            
            //showAllReport();

            function showAllReport() {
                $.ajax({
                    //url: "controllers/reporteController.php",
                    url: "<?=URL?>reporte/read",
                    type: "POST",
                    data: {action: "view"},
                    success: function(response) {
                        console.log(response);
                    }
                });
            }

        });
    </script>

<style>
        .cssload-jar {
	position: relative;
	width: 195px;
	margin: 49px auto 0;
	text-align: center;
}
.cssload-jar .cssload-mouth {
	width: 39px;
	height: 10px;
	margin: 0 auto -1px;
	border-right: 4px solid rgb(0,0,0);
	border-left: 4px solid rgb(0,0,0);
	border-radius: 19px;
		-o-border-radius: 19px;
		-ms-border-radius: 19px;
		-webkit-border-radius: 19px;
		-moz-border-radius: 19px;
}
.cssload-jar .cssload-neck {
	width: 34px;
	height: 46px;
	margin: 0 auto -7px;
	z-index: 7;
	position: relative;
	background-color: rgb(255,255,255);
	border-right: 4px solid rgb(0,0,0);
	border-left: 4px solid rgb(0,0,0);
}
.cssload-jar .cssload-bubble {
	width: 10px;
	height: 10px;
	position: absolute;
	background-color: rgb(193,216,47);
	opacity: 0.4;
	left: 90px;
	z-index: 8;
	top: 107px;
	border-radius: 100%;
		-o-border-radius: 100%;
		-ms-border-radius: 100%;
		-webkit-border-radius: 100%;
		-moz-border-radius: 100%;
	animation: cssload-buble 2.3s linear 1.15s infinite;
		-o-animation: cssload-buble 2.3s linear 1.15s infinite;
		-ms-animation: cssload-buble 2.3s linear 1.15s infinite;
		-webkit-animation: cssload-buble 2.3s linear 1.15s infinite;
		-moz-animation: cssload-buble 2.3s linear 1.15s infinite;
}
.cssload-jar .cssload-bubble + .cssload-bubble {
	left: 85px;
	top: 117px;
	width: 15px;
	height: 15px;
	animation-duration: 3.45s;
		-o-animation-duration: 3.45s;
		-ms-animation-duration: 3.45s;
		-webkit-animation-duration: 3.45s;
		-moz-animation-duration: 3.45s;
}
.cssload-jar .cssload-base {
	margin: auto;
	width: 117px;
	height: 97px;
	border: 4px solid rgb(0,0,0);
	border-radius: 50%;
		-o-border-radius: 50%;
		-ms-border-radius: 50%;
		-webkit-border-radius: 50%;
		-moz-border-radius: 50%;
	overflow: hidden;
	position: relative;
	z-index: 5;
}
.cssload-jar .cssload-base .cssload-bubble {
	left: 15px;
	top: 49px;
	animation: cssload-bounce 2.65s linear 0s infinite alternate;
		-o-animation: cssload-bounce 2.65s linear 0s infinite alternate;
		-ms-animation: cssload-bounce 2.65s linear 0s infinite alternate;
		-webkit-animation: cssload-bounce 2.65s linear 0s infinite alternate;
		-moz-animation: cssload-bounce 2.65s linear 0s infinite alternate;
}
.cssload-jar .cssload-base .cssload-bubble + .cssload-bubble {
	left: 73px;
	top: 39px;
	animation-duration: 3.45s;
		-o-animation-duration: 3.45s;
		-ms-animation-duration: 3.45s;
		-webkit-animation-duration: 3.45s;
		-moz-animation-duration: 3.45s;
}
.cssload-jar .cssload-liquid {
	height: 39px;
	background-color: rgb(193,216,47);
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
}
.cssload-jar .cssload-wave {
	width: 58px;
	height: 19px;
	position: absolute;
	background-color: rgb(193,216,47);
	left: 0;
	top: 56px;
	animation: cssload-wave 1.15s linear 1.15s infinite alternate;
		-o-animation: cssload-wave 1.15s linear 1.15s infinite alternate;
		-ms-animation: cssload-wave 1.15s linear 1.15s infinite alternate;
		-webkit-animation: cssload-wave 1.15s linear 1.15s infinite alternate;
		-moz-animation: cssload-wave 1.15s linear 1.15s infinite alternate;
	border-radius: 50%;
		-o-border-radius: 50%;
		-ms-border-radius: 50%;
		-webkit-border-radius: 50%;
		-moz-border-radius: 50%;
}
.cssload-jar .cssload-wave + .cssload-wave {
	left: auto;
	right: 0;
}


@keyframes cssload-wave {
	from {
		transform: translateX(97px);
	}
	to {
		transform: translateX(-97px);
	}
}

@-o-keyframes cssload-wave {
	from {
		-o-transform: translateX(97px);
	}
	to {
		-o-transform: translateX(-97px);
	}
}

@-ms-keyframes cssload-wave {
	from {
		-ms-transform: translateX(97px);
	}
	to {
		-ms-transform: translateX(-97px);
	}
}

@-webkit-keyframes cssload-wave {
	from {
		-webkit-transform: translateX(97px);
	}
	to {
		-webkit-transform: translateX(-97px);
	}
}

@-moz-keyframes cssload-wave {
	from {
		-moz-transform: translateX(97px);
	}
	to {
		-moz-transform: translateX(-97px);
	}
}

@keyframes cssload-bounce {
	0% {
		transform: translate(5px, 15px);
	}
	50% {
		transform: translate(0, -15px);
	}
	100% {
		transform: translate(-5px, -36px);
		opacity: 1;
	}
}

@-o-keyframes cssload-bounce {
	0% {
		-o-transform: translate(5px, 15px);
	}
	50% {
		-o-transform: translate(0, -15px);
	}
	100% {
		-o-transform: translate(-5px, -36px);
		opacity: 1;
	}
}

@-ms-keyframes cssload-bounce {
	0% {
		-ms-transform: translate(5px, 15px);
	}
	50% {
		-ms-transform: translate(0, -15px);
	}
	100% {
		-ms-transform: translate(-5px, -36px);
		opacity: 1;
	}
}

@-webkit-keyframes cssload-bounce {
	0% {
		-webkit-transform: translate(5px, 15px);
	}
	50% {
		-webkit-transform: translate(0, -15px);
	}
	100% {
		-webkit-transform: translate(-5px, -36px);
		opacity: 1;
	}
}

@-moz-keyframes cssload-bounce {
	0% {
		-moz-transform: translate(5px, 15px);
	}
	50% {
		-moz-transform: translate(0, -15px);
	}
	100% {
		-moz-transform: translate(-5px, -36px);
		opacity: 1;
	}
}

@keyframes cssload-buble {
	0% {
		transform: translate(3px, 10px);
	}
	25% {
		transform: translate(0, 0px);
	}
	50% {
		transform: translate(-3px, -24px);
	}
	75% {
		transform: translate(0, -49px);
		opacity: 1;
	}
	100% {
		transform: translate(3px, -97px);
		opacity: 0;
	}
}

@-o-keyframes cssload-buble {
	0% {
		-o-transform: translate(3px, 10px);
	}
	25% {
		-o-transform: translate(0, 0px);
	}
	50% {
		-o-transform: translate(-3px, -24px);
	}
	75% {
		-o-transform: translate(0, -49px);
		opacity: 1;
	}
	100% {
		-o-transform: translate(3px, -97px);
		opacity: 0;
	}
}

@-ms-keyframes cssload-buble {
	0% {
		-ms-transform: translate(3px, 10px);
	}
	25% {
		-ms-transform: translate(0, 0px);
	}
	50% {
		-ms-transform: translate(-3px, -24px);
	}
	75% {
		-ms-transform: translate(0, -49px);
		opacity: 1;
	}
	100% {
		-ms-transform: translate(3px, -97px);
		opacity: 0;
	}
}

@-webkit-keyframes cssload-buble {
	0% {
		-webkit-transform: translate(3px, 10px);
	}
	25% {
		-webkit-transform: translate(0, 0px);
	}
	50% {
		-webkit-transform: translate(-3px, -24px);
	}
	75% {
		-webkit-transform: translate(0, -49px);
		opacity: 1;
	}
	100% {
		-webkit-transform: translate(3px, -97px);
		opacity: 0;
	}
}

@-moz-keyframes cssload-buble {
	0% {
		-moz-transform: translate(3px, 10px);
	}
	25% {
		-moz-transform: translate(0, 0px);
	}
	50% {
		-moz-transform: translate(-3px, -24px);
	}
	75% {
		-moz-transform: translate(0, -49px);
		opacity: 1;
	}
	100% {
		-moz-transform: translate(3px, -97px);
		opacity: 0;
	}
}
        
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-color: #005CAB!important;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?= URL ?>pedidos/index">Portal de Liberaciones</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <div class="input-group">
        </div>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="mr-2 d-none d-lg-inline text-white-400"><?php echo $nombre;?></span><i class="fas fa-user fa-fw"></i></a>
                
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Cerrar Sesión
                    </a>
                </div>

            </li>
        </ul>
    </nav>