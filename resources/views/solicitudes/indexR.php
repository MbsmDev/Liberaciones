<?php include_once(VIEWS . 'layouts/head.php'); ?>
<?php include_once(VIEWS . 'layouts/slidebar.php'); ?>
<?php include_once(FUNCTIONS . '/getHeaderPC.php'); ?>

<?php 
$codigo_liberacion = $_SESSION["codigo"];
$nombre = $_SESSION["nombre"];
$user = $_SESSION["user"];
$rol = $_SESSION["rol"];
?>

<div class="container-fluid px-4">
    <img src="<?= URL ?>assets/img/carnot-logo.png" alt="logo" width="200" height="80" style="float:right" />
    <h1 class="mt-4">Solicitudes Rechazadas</h1>
    <div class="mb-3 divS" >
        </br>
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <strong>Favor de seleccionar el codigo que desea liberar.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <label for="codigo" class="form-label">Codigo:</label>
        </br>
        <select class="form-contcodigo" id="codigo" name="codigo">
        <option value="0">Seleccionar Codigo</option>
        </select>
        <button type="button" class="btn btn-primary text-white btn-sm buscar">Buscar</button>
    </div>
    <p id="pHeder"></p>
</div>

</br>

<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header" style="background-color: #C1D82F!important;">
            <h3>Solicitudes</h3>
        </div>
        <div class="card-body" id="cardBody">
            <form name="formDataLiberaS" action="liberaSolicitud.php.php" method="POST">
            <div class="cssload-jar">
                <div class="cssload-mouth"></div>
                <div class="cssload-neck"></div>
                <div class="cssload-base">
                    <div class="cssload-liquid"> </div>
                    <div class="cssload-wave"></div>
                    <div class="cssload-wave"></div>
                    <div class="cssload-bubble"></div>
                    <div class="cssload-bubble"></div>
                </div>
                <div class="cssload-bubble"></div>
                <div class="cssload-bubble"></div>
            </div>
            <div class="table-responsive" id="divSolicitudes">
            
            </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal Rechazo -->
<div class="modal fade" id="rechazoModal" tabindex="-1" aria-labelledby="rechazoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #C1D82F!important;">
                <h5 class="modal-title" id="rechazoModalLabel">Rechazo de Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="formRP" method="POST">
                    <div class="alert alert-warning" role="alert">
                        Se notificará al comprador para que realice el rechazo de la solicitud en el sistema SAP.
                    </div>
                    <div class="mb-3">
                        <label for="numSolicitud" class="col-form-label">Solicitud:</label>
                        <input type="text" class="form-control" id="numSolicitud" name="numSolicitud" value="" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="txtRechazo" class="col-form-label">Motivo:</label>
                        <textarea class="form-control" id="txtRechazo"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!--<a class="btn btn-primary" href="mailRechazoAx.php">Cerrar sesión</a>-->
                <button type="button" class="btn btn-primary" id="envRechazo">Rechazar Solicitud</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= URL ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= URL ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= URL ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?= URL ?>js/scripts.js"></script>

<script src="<?= URL ?>js/datatables-simple-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= URL ?>librerias/alertifyjs/alertify.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">

    $(document).ready(function() {

        codigoL =  "<?php echo $codigo_liberacion ?>";
        rolL = "<?php echo $rol ?>";
        
        if (rolL == 'UsuarioMC') {
            $('.cssload-jar').hide();
            getSelects(codigoL);   	
            
            
        }else{
            $( ".divS" ).hide();
            $('#pHeder').text('<?php echo "Usuario: ".$user." | Código de Liberación: ".$codigo_liberacion ?>');
            
            showTableS(codigoL,'2');
            

        }
        //showTableS();
    });

    function getSelects(codigoL) {

        $.ajax({
            url: "<?= URL ?>pedidos/getSelect",
            cache: false,
            method: "POST",
            data: {codigoL: codigoL},
            success: function(data) {
                const datos = JSON.parse(data);
                let dataC = datos.CODE;
                $.each(dataC, function(i, CODE) {
                    var listC = "<option value="+CODE.id_codidoS+">"+CODE.id_codidoS+"</option>";
                    $('#codigo').append(listC);
                });
            }
        });

    }

    $( document ).on( "click", ".buscar", function() {

        codigoL = $("#codigo").val();
        user =  "<?php echo $user ?>";
        if (codigoL ==0 ) {
            //alert("Debes seleccionar un codigo !!!");
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: "Debes seleccionar un codigo !!!",
                showConfirmButton: true,
                //timer: 2500
            });
        }else{

        $('#pHeder').text('Usuario: '+user+' | Código de Liberación: '+codigoL+'');

        showTableS(codigoL,'2');

        }

    });

    $( document ).on( "click", ".rechazar", function() {

        var id = $(this).attr("id");
        var parts = id.split('_');
        var numSolicitud = parts[2];
        var posicion = parts[3];
        var grupoLib = parts[4];
        //var idNew = '#rechazarP_'+parts[1];
        //console.log(numSolicitud);
        $("#numSolicitud").attr("value", numSolicitud);
        $("#rechazoModal").modal('show');
        $("#txtRechazo").val('');

        $(document).on('click', '#envRechazo', function() {

            var txtRechazo = $("#txtRechazo").val();

            rechazarSolicitud(numSolicitud,posicion ,grupoLib, txtRechazo);

        });

    });

    function rechazarSolicitud(numSolicitud, posicion, grupoLib, txtRechazo) {
       // console.log("Numero Solicitud: " + numSolicitud + " Grupo Liberacion: " + grupoLib + " Texto Rechazo: " + txtRechazo);
       var usuario = "<?php echo $user?>"; 
       var url = "<?= URL ?>solicitudes/rechazoSolicitud";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'numSolicitud': numSolicitud,
                'posicion': posicion,
                'grupoLib': grupoLib,
                'txtRechazo': txtRechazo,
                'usuario': usuario
            },
            success: function(data) {
                var jsonData = JSON.parse(data);

                if (jsonData.TYPE == "OK") {
                    Swal.fire(jsonData.TYPE + ': ' + jsonData.MESSAGE);
                    $("#rechazoModal").modal("hide");
                } else {
                    Swal.fire(jsonData.TYPE + ': ' + jsonData.MESSAGE);
                    $("#rechazoModal").modal("hide");
                }
            }
        });
    }

    $( document ).on( "click", ".liberar", function() {

        var id = $(this).attr("id");
        var parts = id.split('_');
        var codigo_liberacion = parts[1];
        var num_solicitud = parts[2];
        var posicion = parts[3];
        //console.log("Codigo Liberacion: " + codigo_liberacion);
        //console.log("Numero Solicitud: " +num_solicitud);
        //console.log("Posicion: " +posicion);

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: "¿Está seguro de liberar la solicitud: " + num_solicitud + "?",
            //text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, liberar!',
            cancelButtonText: 'No, cancelar!',
            //reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                var url = "<?= URL ?>solicitudes/liberaSolicitud";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        'codigo_liberacion': codigo_liberacion,
                        'num_solicitud': num_solicitud,
                        'posicion': posicion,
                    },
                    success: function(data) {
                        console.log(data);
                        var jsonData = JSON.parse(data);
                        //console.log(jsonData);
                        if (jsonData.TYPE == "OK") {
                            Swal.fire(jsonData.TYPE + ': ' + jsonData.MESSAGE);
                            swalWithBootstrapButtons.fire(
                                'Solicitud Liberada!',
                                '',
                                'success'
                            )
                            setTimeout(function() {$("#divSolicitudes").empty();showTableS(codigo_liberacion,'2');}, 2000);
                        } else {
                            //Swal.fire(jsonData.TYPE + ': ' + jsonData.MESSAGE);
                            swalWithBootstrapButtons.fire(
                                jsonData.MESSAGE,
                                '',
                                'error'
                            )
                        }
                    }
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Liberación cancelada',
                    '',
                    'error'
                )
            }
        })

    });

    $( document ).on( "click", ".txtSuministro", function() {
        var id = $(this).attr("id");
        var parts = id.split('_');
        var orden_compra = parts[1];
        var posicion = parts[2];
        //alert(orden_compra+"|"+posicion);
        $.ajax({
            url: "<?= URL ?>solicitudes/getTextoS",
            type: "POST",
            cache: false,
            data: {
                'orden_compra': orden_compra,
                'posicion': posicion
            },
            success: function(response) {
                //console.log(response);
                const data = JSON.parse(response);
                var text = data.dataItems;
                if (text != 'SND') {
                    Swal.fire(text);
                } else {
                    Swal.fire('Sin descripción!');
                }
            }
        });
    });

    /* LIBERACION MASIVA */

    $( document ).on( "click", ".checkAllS", function() {
        if (this.checked) {
            $(".checkboxesS").prop("checked", true);
        } else {
            $(".checkboxesS").prop("checked", false);
        }
    });

    $( document ).on( "click", ".liberarAllS", function() {

    var selected = '';
    $('[name="checkboxesS[]"]').each(function() {
        if (this.checked) {
            selected += $(this).val() + ',';
        }
    });
    selected = selected.substring(0, selected.length - 1);

    if (selected.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Debes seleccionar al menos una solicitud',
            showConfirmButton: true
        })
    } else {

        var arreglo = selected.split(",");
        var pedidosOK = [];
        var pedidosNO = [];

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: "¿Está seguro de liberar las solicitudes?",
            //text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, liberar!',
            cancelButtonText: 'No, cancelar!',
            //reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                for (i = 0; i < arreglo.length; i++) {
                    //console.log(arreglo[i]);
                    parts = arreglo[i].split("_");
                    var codigo_liberacion = parts[0];
                    var num_solicitud = parts[1];
                    var posicion = parts[2];
                    var url = "<?= URL ?>solicitudes/liberaSolicitud";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            'codigo_liberacion': codigo_liberacion,
                            'num_solicitud': num_solicitud,
                            'posicion': posicion,
                        },
                        success: function(data) {
                            var jsonData = JSON.parse(data);
                            if (jsonData.TYPE == "OK") {
                                pedidosOK.push(jsonData.SOLICITUD);
                                var div = "<p>SOLICITUD LIBERADA:   " + jsonData.SOLICITUD + "</p>";
                                $('.lbOkS').append(div);
                                $('.lbOkS').removeAttr('hidden');
                            } else {
                                pedidosNO.push(jsonData.SOLICITUD);
                                pedidosNO.push(num_solicitud);
                                var div = "<p>SOLICITUD NO LIBERADA: " + jsonData.SOLICITUD + "</p>";
                                $('.lbNokS').append(div);
                                $('.lbNokS').removeAttr('hidden');
                            }
                        }
                    });
                }

                rolL = "<?php echo $rol ?>";
                    
                if (rolL == 'UsuarioMC') {
                    codigoL = $("#codigo").val();
                    setTimeout(function() {$("#divSolicitudes").empty();showTableS(codigo_liberacion,'2');}, 4000);
                }else{
                    codigoL =  "<?php echo $codigo_liberacion ?>";
                    setTimeout(function() {$("#divSolicitudes").empty();showTableS(codigo_liberacion,'2');}, 4000);
                }

            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Liberación cancelada',
                    '',
                    'error'
                )
            }
        });

    }


    });

    function showTableS(numPedido,tipo) {
        //var numPedido = "<?php echo $codigo_liberacion ?>";
        //var tipo = "2";
        $("#divSolicitudes").empty();
        var loadLabS = "<div class='cssload-jar loadContratos'>"+
                        "<div class='cssload-mouth'></div>"+
                        "<div class='cssload-neck'></div>"+
                        "<div class='cssload-base'>"+
                            "<div class='cssload-liquid'> </div>"+
                            "<div class='cssload-wave'></div>"+
                            "<div class='cssload-wave'></div>"+
                            "<div class='cssload-bubble'></div>"+
                            "<div class='cssload-bubble'></div>"+
                        "</div>"+
                        "<div class='cssload-bubble'></div>"+
                        "<div class='cssload-bubble'></div>"+
                        "<p>Cargando...</p>"+
                    "</div>";
        
        $("#divSolicitudes").append(loadLabS);

        $.ajax({
            url: "<?= URL ?>solicitudes/getHeaderS",
            type: "POST",
            cache: false,
            data: {
                numPedido: numPedido,
                tipo: tipo
            },
            success: function(response) {
                //console.log(response);
                const data0 = JSON.parse(response);
                const data = data0.DATAHEADER;
                var numRows = data0.NUMROWS;
                numRows = parseInt(numRows);
                if (numRows >0) {
                    
                    var table = "<table class='table table-light table-sm table-responsive table-bordered text-center' id='tableS'>"+
                    "<thead class='table bg-secondary  text-white align-middle'>"+
                            "<tr>"+
                                "<th class='text-center' colspan='2' scope='col'>ACCION</th>"+
                                "<th scope='col'>MOTIVO REACHAZO</th>"+
                                "<th scope='col'>SOLICITUD DE PEDIDO</th>"+
                                "<th scope='col'>POSICIÓN</th>"+
                                "<th scope='col'>MATERIAL</th>"+
                                "<th scope='col'>TEXTO BREVE</th>"+
                                "<th scope='col'>TEXTO DE SUMINISTRO</th>"+
                                "<th scope='col'>CANTIDAD</th>"+
                                "<th scope='col'>UMB</th>"+
                                "<th scope='col'>PRECIO</th>"+
                                "<th scope='col'>MONEDA</th>"+
                                "<th scope='col'>MONTO A LIBERAR</th>"+
                                "<th scope='col'>CANTIDAD BASE</th>"+
                                "<th scope='col'>CENTRO</th>"+
                                "<th scope='col'>TIPO DE DOCUMENTO</th>"+
                                "<th scope='col'>FECHA DEL DOCUMENTO (DD/MM/AAAA)</th>"+
                                "<th scope='col'>SOLICITANTE</th>"+
                            "</tr>"+
                        "</thead>"+
                        "<tbody id='tbodyD'>"+
                        "</tbody>"+
                    "</table>"+
                    "<div class='card-footer text-muted footerS'>Liberación Multiple<br>"+
                    "<samp>Seleccionar Todos:</samp>"+
                    "<input type='checkbox' class='checkAllS' name='checkAllS' value=''><br>"+
                    "<samp>Liberar Elementos Seleccionados:</samp><button type='button' id='liberarAllS' class='btn btn-success btn-sm liberarAllS'>Liberar</button>"+
                    "<br><br>"+
                    "<div class='card bg-success text-white shadow lbOkS' hidden></div>"+
                    "<div class='card bg-danger text-white shadow lbNokS' hidden></div>"+
                    "</div>";

                    $('#divSolicitudes').append(table);
                    $(".cssload-jar").remove();

                    $.each(data, function(i, DATAITEMS) {
                        //var quantity = parseFloat(DATAITEMS.QUANTITY);
                        var a = parseFloat(DATAITEMS.QUANTITY);
                        var b = parseFloat(DATAITEMS.C_AMT_BAPI);
                        var c = parseFloat(DATAITEMS.PRICE_UNIT);
                        
                        quantity = a.toFixed(2);
                        quantityB = b.toFixed(2);
                        priceUnit = c.toFixed(2);

                        precioTotal = ( quantity * quantityB) / priceUnit;
                        precioTotal = parseFloat(precioTotal);
                        //precioTotal = precioTotal.toFixed(2);
                        precioTotal = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(precioTotal,);
                        quantityB = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(quantityB,);

                        var fecha = DATAITEMS.PREQ_DATE;

                        if (fecha.length != 0) {
                            var partesF = fecha.split('-');
                            year = partesF[0];
                            mom = partesF[1];
                            day = partesF[2];
                            fecha = day.concat("/" + mom + "/" + year);
                        }

                        var tblRow =
                            "<tr>" +
                            "<td><input type='checkbox' id='liberaMsv_" + numPedido + "_" + DATAITEMS.PREQ_NO + "_" + DATAITEMS.PREQ_ITEM + "'  class='checkboxesS' name='checkboxesS[]' value='" + numPedido + "_" + DATAITEMS.PREQ_NO +"_" + DATAITEMS.PREQ_ITEM +"'></td>" +
                            "<td><input type='button' id='liberarS_" + numPedido +  "_" + DATAITEMS.PREQ_NO + "_" + DATAITEMS.PREQ_ITEM + "' class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>" +
                            //"<td><input type='button' id='rechazarS_" +numPedido + "_" + DATAITEMS.PREQ_NO + "_" + DATAITEMS.PREQ_ITEM + "_" + DATAITEMS.PUR_GROUP + "' class='btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>" +
                            "<td>" + DATAITEMS.MOTIVO + "</td>" +
                            "<td>" + DATAITEMS.PREQ_NO + "</td>" +
                            "<td>" + DATAITEMS.PREQ_ITEM + "</td>" +
                            "<td>" + DATAITEMS.MATERIAL + "</td>" +
                            "<td>" + DATAITEMS.SHORT_TEXT + "</td>" +
                            "<td><type='button' id='txtSuministro_" + DATAITEMS.PREQ_NO + "_" + DATAITEMS.PREQ_ITEM + "' class='btn btn-secondary txtSuministro'><img src='<?= URL ?>css/images/articles_menu.gif'></button></td>" +
                            "<td>" + quantity + "</td>" +
                            "<td>" + DATAITEMS.UNIT + "</td>" +
                            "<td>" + quantityB + "</td>" +
                            "<td>" + DATAITEMS.CURRENCY_ISO + "</td>"+
                            "<td>" + precioTotal +"</td>" +
                            "<td>" + priceUnit + "</td>"+
                            "<td>" + DATAITEMS.PLANT + "</td>"+
                            "<td>" + DATAITEMS.DOC_TYPE + "</td>"+
                            "<td>" + fecha + "</td>"+
                            "<td>" + DATAITEMS.PREQ_NAME + "</td>"+
                            "</tr>"
                        $('#tbodyD').append(tblRow);
                    });

                }else{

                    $('#divSolicitudes').append("<div class='card bg-warning text-dark shadow'>No hay ordenes pendientes a liberar</div>");
                    $(".cssload-jar").remove();
                }
            }
        });

    }

</script>

<?php include_once(VIEWS . 'layouts/footer.php'); ?>