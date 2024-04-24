<h1>Hola</h1>
<?php
require 'functions/getHeaderPC.php';

$data = getHeader('11', 'CO');
//var_dump($data);

$codigo_liberacion = 13;

echo "<table class='table table-light table-responsive table-bordered'>
                                        <thead class='table bg-secondary  text-white'>
                                            <tr>
                                                <th class='text-center' colspan='3' scope='col'>ACCION</th>
                                                <th scope='col'>VER DETALLE</th>
                                                <th scope='col'>FECHA ENTREGA</th>
                                                <th scope='col'>ORDEN DE COMPRA</th>
                                                <th scope='col'>PROVEEDOR</th>
                                                <th scope='col'>FECHA DEL DOCUMENTO (DD/MM/AAAA)</th>
                                                <th scope='col'>MONTO A LIBERAR</th>
                                                <th scope='col'>MONEDA</th>
                                                <th scope='col'>CENTRO</th>
                                                <th scope='col'>TIPO DE DOCUMENTO</th>
                                                <th scope='col'>GRUPO DE LIBERACION</th>
                                                <th scope='col'>ESTRATEGIA DE LIBERACION</th>
                                            </tr>
                                        </thead>";


$DATAHEADER = $data['DATAHEADER'];

$PO_NUMBER = '';
$CO_CODE = '';
$DOC_TYPE = '';
$CREATED_ON = '';
$TARGET_VAL = '';
$CURRENCY = '';
$REL_GROUP = '';
$PUR_GROUP = '';
$REL_STRAT = '';
$VEND_NAME = '';

foreach ($DATAHEADER as $row) {

    if (isset($row['PO_NUMBER'])) {
        $PO_NUMBER = $row['PO_NUMBER'];
    }
    if (isset($row['CO_CODE'])) {
        $CO_CODE = $row['CO_CODE'];
    }
    if (isset($row['DOC_TYPE'])) {
        $DOC_TYPE = $row['DOC_TYPE'];
    }
    if (isset($row['CREATED_ON'])) {
        $CREATED_ON = $row['CREATED_ON'];
        $year = substr($CREATED_ON, 0, 4);
        $mom = substr($CREATED_ON, 4, 2);
        $day = substr($CREATED_ON, 6, 2);
        $CREATED_ON_N = $day . "/" . $mom . "/" . $year;
    }
    if (isset($row['TARGET_VAL'])) {
        $TARGET_VAL = $row['TARGET_VAL'];
        $TARGET_VAL = floatval($TARGET_VAL);
        $TARGET_VAL = number_format($TARGET_VAL, 2, '.', "");
        //$TARGET_VAL = round($TARGET_VAL, 2);
    }
    if (isset($row['CURRENCY'])) {
        $CURRENCY = $row['CURRENCY'];
    }
    if (isset($row['REL_GROUP'])) {
        $REL_GROUP = $row['REL_GROUP'];
    }
    if (isset($row['PUR_GROUP'])) {
        $PUR_GROUP = $row['PUR_GROUP'];
    }
    if (isset($row['REL_STRAT'])) {
        $REL_STRAT = $row['REL_STRAT'];
    }
    if (isset($row['VEND_NAME'])) {
        $VEND_NAME = $row['VEND_NAME'];
    }

    if (count($row) > 0) {

        echo "
        <tr> 
            <td><input type='checkbox' id=\"liberaMsv_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\"  class='checkboxesDI' name='checkboxesDI[]' value=\"" . $PO_NUMBER . "|" . $codigo_liberacion . "\"></td>
            <td><input type='button' id=\"liberarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>
            <td><input type='button' id=\"rechazarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "_" . $PUR_GROUP . "\" class='btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>
            <td ><type='button' id=\"detalleP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detalleP'><img src='css/images/articles_menu.gif'></button></td>
            <td ><type='button' id=\"detallePF_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detallePF'><img src='css/images/calendar.png'></button></td>
            <td>$PO_NUMBER</td>
            <td>$VEND_NAME</td>
            <td>$CREATED_ON_N</td>
            <td>$TARGET_VAL</td>
            <td>$CURRENCY</td>
            <td>$CO_CODE</td>
            <td>$DOC_TYPE</td>
            <td>$REL_GROUP</td>
            <td>$REL_STRAT</td>
        </tr>";
    }
}
echo "
                                    </table>";

                                    
                                    echo "<br/><hr/>";    
                                    

                                    $data2 = getHeader('11', 'CM');
//var_dump($data);

$codigo_liberacion = 13;

echo "<table class='table table-light table-responsive table-bordered'>
                                        <thead class='table bg-secondary  text-white'>
                                            <tr>
                                                <th class='text-center' colspan='3' scope='col'>ACCION</th>
                                                <th scope='col'>VER DETALLE</th>
                                                <th scope='col'>FECHA ENTREGA</th>
                                                <th scope='col'>ORDEN DE COMPRA</th>
                                                <th scope='col'>PROVEEDOR</th>
                                                <th scope='col'>FECHA DEL DOCUMENTO (DD/MM/AAAA)</th>
                                                <th scope='col'>MONTO A LIBERAR</th>
                                                <th scope='col'>MONEDA</th>
                                                <th scope='col'>CENTRO</th>
                                                <th scope='col'>TIPO DE DOCUMENTO</th>
                                                <th scope='col'>GRUPO DE LIBERACION</th>
                                                <th scope='col'>ESTRATEGIA DE LIBERACION</th>
                                            </tr>
                                        </thead>";


$DATAHEADER = $data2['DATAHEADER'];

$PO_NUMBER = '';
$CO_CODE = '';
$DOC_TYPE = '';
$CREATED_ON = '';
$TARGET_VAL = '';
$CURRENCY = '';
$REL_GROUP = '';
$PUR_GROUP = '';
$REL_STRAT = '';
$VEND_NAME = '';

foreach ($DATAHEADER as $row) {

    if (isset($row['PO_NUMBER'])) {
        $PO_NUMBER = $row['PO_NUMBER'];
    }
    if (isset($row['CO_CODE'])) {
        $CO_CODE = $row['CO_CODE'];
    }
    if (isset($row['DOC_TYPE'])) {
        $DOC_TYPE = $row['DOC_TYPE'];
    }
    if (isset($row['CREATED_ON'])) {
        $CREATED_ON = $row['CREATED_ON'];
        $year = substr($CREATED_ON, 0, 4);
        $mom = substr($CREATED_ON, 4, 2);
        $day = substr($CREATED_ON, 6, 2);
        $CREATED_ON_N = $day . "/" . $mom . "/" . $year;
    }
    if (isset($row['TARGET_VAL'])) {
        $TARGET_VAL = $row['TARGET_VAL'];
        $TARGET_VAL = floatval($TARGET_VAL);
        $TARGET_VAL = number_format($TARGET_VAL, 2, '.', "");
        //$TARGET_VAL = round($TARGET_VAL, 2);
    }
    if (isset($row['CURRENCY'])) {
        $CURRENCY = $row['CURRENCY'];
    }
    if (isset($row['REL_GROUP'])) {
        $REL_GROUP = $row['REL_GROUP'];
    }
    if (isset($row['PUR_GROUP'])) {
        $PUR_GROUP = $row['PUR_GROUP'];
    }
    if (isset($row['REL_STRAT'])) {
        $REL_STRAT = $row['REL_STRAT'];
    }
    if (isset($row['VEND_NAME'])) {
        $VEND_NAME = $row['VEND_NAME'];
    }

    if (count($row) > 0) {

        echo "
        <tr> 
            <td><input type='checkbox' id=\"liberaMsv_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\"  class='checkboxesDI' name='checkboxesDI[]' value=\"" . $PO_NUMBER . "|" . $codigo_liberacion . "\"></td>
            <td><input type='button' id=\"liberarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>
            <td><input type='button' id=\"rechazarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "_" . $PUR_GROUP . "\" class='btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>
            <td ><type='button' id=\"detalleP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detalleP'><img src='css/images/articles_menu.gif'></button></td>
            <td ><type='button' id=\"detallePF_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detallePF'><img src='css/images/calendar.png'></button></td>
            <td>$PO_NUMBER</td>
            <td>$VEND_NAME</td>
            <td>$CREATED_ON_N</td>
            <td>$TARGET_VAL</td>
            <td>$CURRENCY</td>
            <td>$CO_CODE</td>
            <td>$DOC_TYPE</td>
            <td>$REL_GROUP</td>
            <td>$REL_STRAT</td>
        </tr>";
    }
}
echo "
                                    </table>";

                                    
                                    echo "<br/><hr/>";
?>