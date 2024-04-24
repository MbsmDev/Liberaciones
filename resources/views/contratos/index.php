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
    <h1 class="mt-4">Liberar Contratos Directos</h1>
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
            <h3>Contratos</h3>
        </div>
        <div class="card-body" id="cardBody">
            <form name="formDataLiberaDI" action="liberaPedido.php.php" method="POST">
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
            <div class="table-responsive" id="divPedidosCM">
            
            </div>
                
            </form>
        </div>
    </div>

    <!-- Modal Rechazo -->
    <div class="modal fade" id="rechazoModal" tabindex="-1" aria-labelledby="rechazoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #C1D82F!important;">
                    <h5 class="modal-title" id="rechazoModalLabel">Rechazo de Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="formRP" method="POST">
                        <div class="alert alert-warning" role="alert">
                            Se notificará al comprador para que realice el rechazo del pedido en el sistema SAP.
                        </div>
                        <div class="mb-3">
                            <label for="numPedido" class="col-form-label">Contrato:</label>
                            <input type="text" class="form-control" id="numPedido" name="numPedido" value="" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="txtRechazo" class="col-form-label">Motivo:</label>
                            <button type="button" hidden id="coLi"></button>
                            <textarea class="form-control" id="txtRechazo"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="envRechazo">Rechazar Pedido</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalle -->
    <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #C1D82F!important;">
                    <h5 class="modal-title " id="detalleModalLabel">Detalle Contrato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="bodyD" class="modal-body">
                    <div class="table-responsive d-flex flex-wrap" id="contenidoTabla">
                        <table class="table table-bordered">
                            <thead class='table bg-secondary text-white'>
                                <tr>
                                    <th scope="col">ORDEN</th>
                                    <th scope="col">POSICION</th>
                                    <th scope="col">MATERIAL</th>
                                    <th scope="col">TEXTO</th>
                                    <th scope="col">CANTIDAD</th>
                                    <th scope="col">UMB</th>
                                    <th scope="col">PRECIO UNITARIO</th>
                                    <th scope="col">PRECIO TOTAL</th>
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
    //showTableP(codigoL,'CM','1');
    if (rolL == 'UsuarioMC') {
        $('.cssload-jar').hide();
        getSelects(codigoL);   	
        
        
    }else{
        $( ".divS" ).hide();
        $('#pHeder').text('<?php echo "Usuario: ".$user." | Código de Liberación: ".$codigo_liberacion ?>');
        
        showTableP(codigoL,'CM','1');
        

    }
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
            //$('#codigo').append(<option value="0">Seleccionar Codigo</option>);
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

    showTableP(codigoL,'CM','1');

}

});

function showTableP(numPedido,grupoL,tipo) {

    $("#divPedidos"+grupoL+"").empty();

    var loadLabC = "<div class='cssload-jar loadContratos'>"+
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

    $("#divPedidos"+grupoL+"").append(loadLabC);
    
    $.ajax({
        url: "<?= URL ?>contratos/getHeaderCM",
        type: "POST",
        cache: false,
        data: {
            codigoL: codigoL,
            grupoL: grupoL,
            tipo: tipo,
        },
        success: function(response) {

            const data0 = JSON.parse(response);
            const data = data0.DATAHEADER;
            var numRows = data0.NUMROWS;
            numRows = parseInt(numRows);

            if (numRows >0) {
                
                var table = "<table class='table table-light table-sm table-responsive table-bordered text-center' id='table"+grupoL+"'>"+
                "<thead class='table bg-secondary  text-white align-middle'>"+
                        "<tr>"+
                            "<th class='text-center' colspan='3' scope='col'>ACCION</th>"+
                            "<th scope='col'>VER DETALLE</th>"+
                            "<th scope='col'>NUMERO DE CONTRATO</th>"+
                            "<th scope='col'>CENTRO</th>"+
                            "<th scope='col'>CLASE DE CONTRATO</th>"+
                            "<th scope='col'>FECHA DE CONTRATO (DD/MM/AAAA)</th>"+
                            "<th scope='col'>INICIO DE PERIODO VALIDEZ (DD/MM/AAAA)</th>"+
                            "<th scope='col'>FIN DE PERIODO VALIDEZ (DD/MM/AAAA)</th>"+
                            "<th scope='col'>CREADO POR</th>"+
                            "<th scope='col'>MONTO A LIBERAR</th>"+
                            "<th scope='col'>CLAVE MONEDA</th>"+
                        "</tr>"+
                    "</thead>"+
                    "<tbody id='tbodyD"+grupoL+"'>"+
                    "</tbody>"+
                "</table>"+
                "<div class='card-footer text-muted footerS'>Liberación Multiple<br>"+
                "<samp>Seleccionar Todos:</samp>"+
                "<input type='checkbox' class='checkAll"+grupoL+"' name='checkAll"+grupoL+"' value=''><br>"+
                "<samp>Liberar Elementos Seleccionados:</samp><button type='button' id='liberaAll"+grupoL+"' class='btn btn-success btn-sm liberaAll"+grupoL+"'>Liberar</button>"+
                "<br><br>"+
                "<div class='card bg-success text-white shadow lbOk"+grupoL+"' hidden></div>"+
                "<div class='card bg-danger text-white shadow lbNok"+grupoL+"' hidden></div>"+
                "</div>";

                $("#divPedidos"+grupoL+"").append(table);
                $(".cssload-jar").remove();
                
                $.each(data, function(i, DATAITEMS) {

                    var fechaC = DATAITEMS.CREATED_ON;
                    if (fechaC.length != 0) {
                        var partesF = fechaC.split('-');
                        year = partesF[0];
                        mom = partesF[1];
                        day = partesF[2];
                        fechaC = day.concat("/" + mom + "/" + year);
                    }
                    var fechaI = DATAITEMS.VPER_START;
                    if (fechaI.length != 0) {
                        var partesF = fechaI.split('-');
                        year = partesF[0];
                        mom = partesF[1];
                        day = partesF[2];
                        fechaI = day.concat("/" + mom + "/" + year);
                    }
                    var fechaF = DATAITEMS.VPER_END;
                    if (fechaF.length != 0) {
                        var partesF = fechaF.split('-');
                        year = partesF[0];
                        mom = partesF[1];
                        day = partesF[2];
                        fechaF = day.concat("/" + mom + "/" + year);
                    }

                    number = Math.round(DATAITEMS.TARGET_VAL);
                    target_val = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(number,);

                    var tblRow =
                        "<tr>" +
                        "<td><input type='checkbox' id='liberaMsv_" + DATAITEMS.PO_NUMBER + "_" + numPedido + "_" + DATAITEMS.REL_GROUP + "'  class='checkboxes"+grupoL+"' name='checkboxes"+grupoL+"[]' value='" + DATAITEMS.PO_NUMBER + "_" + numPedido +"'></td>" +
                        "<td><input type='button' id='liberarP_" + DATAITEMS.PO_NUMBER + "_" + numPedido + "_" + DATAITEMS.REL_GROUP + "' class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>" +
                        "<td><input type='button' id='rechazarP_" + DATAITEMS.PO_NUMBER + "_" + numPedido + "_" + DATAITEMS.REL_GROUP + "_" + DATAITEMS.PUR_GROUP + "' class='btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>" +
                        "<td><type='button' id='detalleP_" + DATAITEMS.PO_NUMBER + "_" + numPedido + "_" + DATAITEMS.REL_GROUP + "' class='btn btn-secondary detalleP'><img src='<?= URL ?>css/images/articles_menu.gif'></button></td>" +
                        "<td>" + DATAITEMS.PO_NUMBER + "</td>" +
                        "<td>" + DATAITEMS.CO_CODE + "</td>" +
                        "<td>" + DATAITEMS.DOC_TYPE + "</td>" +
                        "<td>" + fechaC + "</td>" +
                        "<td>" + fechaI + "</td>" +
                        "<td>" + fechaF + "</td>" +
                        "<td>" + DATAITEMS.CREATED_BY + "</td>" +
                        "<td>" + target_val + "</td>"+
                        "<td>" + DATAITEMS.CURRENCY + "</td>"+
                        "</tr>"
                    $("#tbodyD"+grupoL+"").append(tblRow);
                });

            }else{

                $("#divPedidos"+grupoL+"").append("<div class='card bg-warning text-dark shadow'>No hay ordenes pendientes a liberar</div>");
                $(".cssload-jar").remove();

            }
        }
    });

}

/* RECHAZAR CONTRATOS */

$( document ).on( "click", ".rechazar", function() {
    var id = $(this).attr("id");
    var parts = id.split('_');
    var numPedido = parts[1];
    var coLi = parts[2];
    var grupoL = parts[3];
    $("#numPedido").attr("value", numPedido);
    $("#coLi").attr("value", coLi);
    $("#rechazoModal").modal('show');
    $("#txtRechazo").val('');
});

$( "#envRechazo" ).on( "click", function() {
    var numPedido = $('#numPedido').val();
    var txtRechazo = $("#txtRechazo").val();
    rechazarContrato(numPedido,txtRechazo,coLi);
});

function rechazarContrato(numPedido,txtRechazo,coLi) {
    //console.log("Numero Solicitud: " + numPedido + " Texto Rechazo: " + txtRechazo);
    var usuario = "<?php echo $user?>";
    var url = "<?= URL ?>contratos/rechazoContrato";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'numPedido': numPedido,
            'txtRechazo': txtRechazo,
            'usuario': usuario
        },
        success: function(data) {
            var jsonData = JSON.parse(data);
            if (jsonData.TYPE == "OK") {
                Swal.fire(jsonData.TYPE + ': ' + jsonData.MESSAGE);
                $("#rechazoModal").modal("hide");
                setTimeout(function() {$("#divPedidosCM").empty();showTableP(coLi,'CM','1');}, 2000);
            } else {
                Swal.fire(jsonData.TYPE + ': ' + jsonData.MESSAGE);
                $("#rechazoModal").modal("hide");
            }
        }
    });
}


/* LIBERACION CONTRATOS */

$( document ).on( "click", ".liberar", function() {

    var id = $(this).attr("id");
    var parts = id.split('_');
    var orden_compra = parts[1];
    var codigo_liberacion = parts[2];


    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: "¿Está seguro de liberar el contrato: " + orden_compra + "?",
        //text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, liberar!',
        cancelButtonText: 'No, cancelar!',
        //reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            var url = "<?= URL ?>contratos/liberaContrato";

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    'orden_compra': orden_compra,
                    'codigo_liberacion': codigo_liberacion
                },
                success: function(data) {
                    var jsonData = JSON.parse(data);
                    //console.log(jsonData);
                    if (jsonData.TYPE == "OK") {
                        Swal.fire(jsonData.TYPE + ': ' + jsonData.MESSAGE);
                        swalWithBootstrapButtons.fire(
                            'Contrato Liberado!',
                            '',
                            'success'
                        )
                        codigoL =  "<?php echo $codigo_liberacion ?>";
                        setTimeout(function() {$("#divPedidosCM").empty();showTableP(codigoL,'CM','1');}, 2000);
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


/* LIBERACION MASIVA CONTRATOS */

$( document ).on( "click", ".checkAllCM", function() {
    if (this.checked) {
        $(".checkboxesCM").prop("checked", true);
    } else {
        $(".checkboxesCM").prop("checked", false);
    }
});

$( document ).on( "click", ".liberaAllCM", function() {

    var selected = '';
    $('[name="checkboxesCM[]"]').each(function() {
        if (this.checked) {
            selected += $(this).val() + ',';
        }
    });
    selected = selected.substring(0, selected.length - 1);

    if (selected.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Debes seleccionar al menos un pedido',
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
            title: "¿Está seguro de liberar los pedidos?",
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
                    var orden_compra = parts[0];
                    var codigo_liberacion = parts[1];
                    console.log(orden_compra);
                    console.log(codigo_liberacion);
                    var url = "<?= URL ?>contratos/liberaContrato";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            'orden_compra': orden_compra,
                            'codigo_liberacion': codigo_liberacion
                        },
                        success: function(data) {
                            var jsonData = JSON.parse(data);
                            if (jsonData.TYPE == "OK") {
                                pedidosOK.push(jsonData.PEDIDO);
                                //console.log(pedidosOK);
                                var div = "<p>PEDIDO LIBERADO:   " + jsonData.PEDIDO + "</p>";
                                $('.lbOkCM').append(div);
                                $('.lbOkCM').removeAttr('hidden');
                            } else {
                                pedidosNO.push(jsonData.PEDIDDO);
                                //console.log(pedidosNO);
                                pedidosNO.push(orden_compra);
                                var div = "<p>PEDIDO NO LIBERADO: " + jsonData.PEDIDO + "</p>";
                                $('.lbNokCM').append(div);
                                $('.lbNokCM').removeAttr('hidden');
                            }
                        }
                    });
                }

                codigoL =  "<?php echo $codigo_liberacion ?>";
                setTimeout(function() {$("#divPedidosCM").empty();showTableP(codigoL,'CM','1');}, 4000);

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

/* DETALLE DE PEDIDO */

$( document ).on( "click", ".detalleP", function() {
    $("#tbodyD").empty();
    $("#detalleModal").modal('show');
    var id = $(this).attr("id");
    var parts = id.split('_');
    var numPedido = parts[1];
    var codigo_liberacion = parts[2];
    var grpLiberacion = parts[3];
    //alert(numPedido+"|"+codigo_liberacion+"|"+grpLiberacion);
    $.ajax({
    url: "<?= URL ?>contratos/getItemsCM",
    type: "POST",
    cache: false,
    data: {
        numPedido: numPedido
    },
    success: function(response) {
        //console.log(response);
        const data = JSON.parse(response);
        console.log(data);
        $.each(data, function(i, DATAITEMS) {
            a = parseFloat(DATAITEMS.NET_PRICE);
            b = parseFloat(DATAITEMS.TARGET_QTY);

            precioU = a.toFixed(2);
            precioU = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(precioU,);
            cantidad = b.toFixed(2);

            precioTotal = ((a * b) / DATAITEMS.PRICE_UNIT);
            precioTotal = Math.round(precioTotal);
            precioTotal = precioTotal.toFixed(2);
            precioTotal = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(precioTotal,);

            var tblRow =
                "<tr>" +
                "<td>" + numPedido + "</td>" +
                "<td>" + DATAITEMS.ITEM_NO + "</td>" +
                "<td>" + DATAITEMS.MATERIAL + "</td>" +
                "<td>" + DATAITEMS.SHORT_TEXT + "</td>" +
                "<td>" + cantidad + "</td>" +
                "<td>" + DATAITEMS.PO_UNIT + "</td>" +
                "<td>" + precioU + "</td>" +
                "<td>" + precioTotal + "</td>" +
                "</tr>"
            $('#tbodyD').append(tblRow);
        });
    }
    });
});

</script>    

<?php include_once(VIEWS . 'layouts/footer.php'); ?>