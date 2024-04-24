<?php require_once(FUNCTIONS . '/getHeaderPC.php'); ?>
<?php $codigo_liberacion = 13;?>
<!-- Solicitudes -->

        <div class="table-responsive">
            <?php
            $NUMROWS = 0;
            //$data = getSolicitudes($codigo_liberacion);
            $data = getHeaderS();

            if (isset($data['NUMROWS'])) {
                $NUMROWS = $data['NUMROWS'];
            }
            $DATAHEADER = $data['DATAHEADER'];

            if (!($NUMROWS == 0)) {

                $TIPO_ERROR = '';

                $DATARETURN = $data['DATARETURN'];

                if (isset($DATARETURN['TYPE'])) {
                    $TIPO_ERROR = $DATARETURN['TYPE'];
                }

                if ($TIPO_ERROR == 'E') {

                    $msgError = '<div class="card bg-warning text-dark shadow"> ' . utf8_encode($DATARETURN['MESSAGE']) . '</div>';
                    echo $msgError;
                } else {

                    echo "<table class='table table-light table-responsive table-bordered'>
                            <thead class='table bg-secondary  text-white'>
                                <tr>
                                    <th class='text-center' colspan='3' scope='col'>ACCION</th>
                                    <th scope='col'>SOLICITUD DE PEDIDO</th>
                                    <th scope='col'>POSICIÓN</th>
                                    <th scope='col'>MATERIAL</th>
                                    <th scope='col'>TEXTO BREVE</th>
                                    <th scope='col'>TEXTO DE SUMINISTRO</th>
                                    <th scope='col'>CANTIDAD</th>
                                    <th scope='col'>UMB</th>
                                    <th scope='col'>PRECIO</th>
                                    <th scope='col'>MONEDA</th>
                                    <th scope='col'>MONTO A LIBERAR</th>
                                    <th scope='col'>CANTIDAD BASE</th>
                                    <th scope='col'>CENTRO</th>
                                    <th scope='col'>TIPO DE DOCUMENTO</th>
                                    <th scope='col'>FECHA DEL DOCUMENTO (DD/MM/AAAA)</th>
                                    <th scope='col'>SOLICITANTE</th>
                                </tr>
                            </thead>";


                    $DATAHEADER = $data['DATAHEADER'];

                    $PREQ_NO = '';
                    $PREQ_ITEM = '';
                    $PUR_GROUP = '';
                    $MATERIAL = '';
                    //$CREATED_ON = '';
                    $SHORT_TEXT = '';
                    $QUANTITY = 0;
                    $UNIT = '';
                    $C_AMT_BAPI = 0;
                    $CURRENCY_ISO = '';
                    $PRICE_UNIT = 0;
                    $PLANT = '';
                    $DOC_TYPE = '';
                    $PREQ_DATE = '';
                    $PREQ_NAME = '';
                    $precioTotal = 0;

                    foreach ($DATAHEADER as $row) {

                        if (isset($row['PREQ_NO'])) {
                            $PREQ_NO = $row['PREQ_NO'];
                            empty($PREQ_NO) ? $PREQ_NO= '' : $PREQ_NO;
                        }
                        if (isset($row['PREQ_ITEM'])) {
                            $PREQ_ITEM = $row['PREQ_ITEM'];
                            empty($PREQ_ITEM) ? $PREQ_ITEM= '' : $PREQ_ITEM;
                        }
                        if (isset($row['PUR_GROUP'])) {
                            $PUR_GROUP = $row['PUR_GROUP'];
                            empty($PUR_GROUP) ? $PUR_GROUP= '' : $PUR_GROUP;
                        }
                        if (isset($row['MATERIAL'])) {
                            $MATERIAL = $row['MATERIAL'];
                            empty($MATERIAL) ? $MATERIAL= '' : $MATERIAL;
                        }
                        if (isset($row['SHORT_TEXT'])) {
                            $SHORT_TEXT = $row['SHORT_TEXT'];
                            empty($SHORT_TEXT) ? $SHORT_TEXT= '' : $SHORT_TEXT;
                            $SHORT_TEXT = utf8_encode($SHORT_TEXT);
                        }
                        if (isset($row['QUANTITY'])) {
                            $QUANTITY = $row['QUANTITY'];
                            empty($QUANTITY) ? $QUANTITY= '' : $QUANTITY;
                            $QUANTITY = floatval($QUANTITY);
                            $QUANTITY = round($QUANTITY, 2);
                        }
                        if (isset($row['UNIT'])) {
                            $UNIT = $row['UNIT'];
                            empty($UNIT) ? $UNIT= '' : $UNIT;
                        }
                        if (isset($row['C_AMT_BAPI'])) {
                            $C_AMT_BAPI = $row['C_AMT_BAPI'];
                            empty($C_AMT_BAPI) ? $C_AMT_BAPI= '' : $C_AMT_BAPI;
                            $C_AMT_BAPI = floatval($C_AMT_BAPI);
                            $C_AMT_BAPI = number_format($C_AMT_BAPI, 2, '.', "");
                            //$C_AMT_BAPI = round($C_AMT_BAPI, 2);
                        }
                        if (isset($row['CURRENCY_ISO'])) {
                            $CURRENCY_ISO = $row['CURRENCY_ISO'];
                            empty($CURRENCY_ISO) ? $CURRENCY_ISO= '' : $CURRENCY_ISO;
                        }
                        if (isset($row['PRICE_UNIT'])) {
                            $PRICE_UNIT = $row['PRICE_UNIT'];
                            empty($PRICE_UNIT) ? $PRICE_UNIT= '' : $PRICE_UNIT;
                            $PRICE_UNIT = floatval($PRICE_UNIT);
                            $PRICE_UNIT = number_format($PRICE_UNIT, 2, '.', "");
                            //$PRICE_UNIT = round($PRICE_UNIT, 2);
                        }
                        if (isset($row['PLANT'])) {
                            $PLANT = $row['PLANT'];
                            empty($PLANT) ? $PLANT= '' : $PLANT;
                        }
                        if (isset($row['DOC_TYPE'])) {
                            $DOC_TYPE = $row['DOC_TYPE'];
                            empty($DOC_TYPE) ? $DOC_TYPE= '' : $DOC_TYPE;
                        }
                        /*if (isset($row['PREQ_DATE'])) {
                                            $PREQ_DATE = $row['PREQ_DATE'];
                                        }*/
                        if (isset($row['PREQ_DATE'])) {
                            $PREQ_DATE = $row['PREQ_DATE'];
                            empty($PREQ_DATE) ? $PREQ_DATE= '' : $PREQ_DATE;
                            $year = substr($PREQ_DATE, 0, 4);
                            $mom = substr($PREQ_DATE, 4, 2);
                            $day = substr($PREQ_DATE, 6, 2);
                            $PREQ_DATE_N =  $day . "/" . $mom . "/" . $year;
                        }
                        if (isset($row['PREQ_NAME'])) {
                            $PREQ_NAME = $row['PREQ_NAME'];
                            empty($PREQ_NAME) ? $PREQ_NAME= '' : $PREQ_NAME;
                        }
                        if (isset($row['precioTotal'])) {
                            $precioTotal = $row['precioTotal'];
                        }

                        $part1 = $PREQ_NO;
                        $part2 = $PREQ_ITEM;
                        $sltdItem = "$part1$part2";

                        if ($PRICE_UNIT > 0 and $QUANTITY > 0) {
                            $precioTotal = ($QUANTITY * $C_AMT_BAPI) / $PRICE_UNIT;
                            $precioTotal = floatval($precioTotal);
                            $precioTotal = number_format($precioTotal, 2, '.', "");
                            //$precioTotal = round($precioTotal, 2);
                        }

                        if (count($row) > 0) {

                            echo "
                                            <tr> 
                                                <td><input type='checkbox' id=\"liberaMsv_" . $codigo_liberacion . "_" . $PREQ_NO . "_" . $PREQ_ITEM . "\"  class='checkboxesS' name='checkboxesS[]' value=\"" . $codigo_liberacion . "_" . $PREQ_NO . "_" . $PREQ_ITEM . "\"></td>
                                                <td><input type='button' id=\"liberarS_" . $codigo_liberacion . "_" . $PREQ_NO . "_" . $PREQ_ITEM . "\" class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>
                                                <td><input type='button' id=\"rechazarS_" . $codigo_liberacion . "_" . $PREQ_NO . "_" . $PREQ_ITEM . "_" . $PUR_GROUP . "\" class='btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>
                                                <td>$PREQ_NO</td>
                                                <td>$PREQ_ITEM</td>
                                                <td>$MATERIAL</td>
                                                <td>$SHORT_TEXT</td>
                                                <td><type='button' onClick=\"getTxtSuministro('" . $PREQ_NO . "','" . $PREQ_ITEM . "')\" class='btn btn-secondary getTxtSuministro'><img src='css/images/articles_menu.gif'></button></td>
                                                <td>$QUANTITY</td>
                                                <td>$UNIT</td>
                                                <td>$C_AMT_BAPI</td>
                                                <td>$CURRENCY_ISO</td>
                                                <td>$precioTotal</td>
                                                <td>$PRICE_UNIT</td>
                                                <td>$PLANT</td>
                                                <td>$DOC_TYPE</td>
                                                <td>$PREQ_DATE_N</td>
                                                <td>$PREQ_NAME</td>
                                            </tr>";
                        }
                    }
                    echo "
                            </table>";
                }
            } else {
                echo "<div class='card bg-warning text-dark shadow'>No hay ordenes pendientes a liberar</div>";
            }
            ?>
        </div>
<?php
if (!($NUMROWS == 0)) {
    echo "
                        <div class='card-footer text-muted footerS'>
                            Liberación Multiple
                            <br>
                            <samp>Seleccionar Todos:</samp>
                            <input type='checkbox' class='checkAllS' name='checkAllS' value=''>
                            <br>
                            <samp>Liberar Elementos Seleccionados:</samp>
                            <button type='button' id='liberarAllS' class='btn btn-success btn-sm liberarAllS'>Liberar</button>
                            <br>
                            <br>
                            <div class='card bg-success text-white shadow lbOkS' hidden>
                            </div>
                            <div class='card bg-danger text-white shadow lbNokS' hidden>
                            </div>
                        </div>
                        ";
}
?>
<!-- Divider -->
<hr class="sidebar-divider">

