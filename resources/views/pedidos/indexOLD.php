<?php include_once(VIEWS . 'layouts/head.php'); ?>
<?php include_once(VIEWS . 'layouts/slidebar.php'); ?>
<?php include_once(FUNCTIONS . '/getHeaderPC.php'); ?>

<?php $codigo_liberacion = '11' ?>

<div class="container-fluid px-4">
    <img src="<?= URL ?>assets/img/carnot-logo.png" alt="logo" width="200" height="80" style="float:right" />
    <h1 class="mt-4">Liberar Pedidos</h1>
    <p> <?php echo "Usuario: Miguel";  /*echo "Usuario: " . $usuario . " | Código de Liberación: " . $codigo_liberacion */?>
    </p>
</div>
</br>

<div class="container-fluid px-4">
    <!-- Pedidos Directos -->
    <div class="card mb-4">
        <div class="card-header" style="background-color: #C1D82F!important;">
            <h3>Pedidos Pedidos Directos</h3>
        </div>
        <div class="card-body">
            <form name="formDataLiberaDI" action="liberaPedido.php" method="POST">
                <div class="table-responsive">
                    <?php
                    $NUMROWS = 0;
                    //$data = getHeader($codigo_liberacion, 'CO');
                    $data = getHeader('11', 'CM');
                    //$sum = array_sum(array_column($data, 0));
                    //$count = count($data);
                    //echo "count is ". $count . " And sum is " . $sum;
                    //$NUMROWS = array_sum(array_column($data, 0));

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

                            echo "<table class='table table-light table-sm table-responsive table-bordered text-center'>
                                    <thead class='table bg-secondary  text-white align-middle'>
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

                                    echo "<tr> 
                                            <td><input type='checkbox' id=\"liberaMsv_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\"  class='checkboxesDI' name='checkboxesDI[]' value=\"" . $PO_NUMBER . "|" . $codigo_liberacion . "\"></td>
                                            <td><input type='button' id=\"liberarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>
                                            <td><input type='button' id=\"rechazarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "_" . $PUR_GROUP . "\" class='btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>
                                            <td ><type='button' id=\"detalleP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detalleP'><img src='".URL."css/images/articles_menu.gif'></button></td>
                                            <td ><type='button' id=\"detallePF_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detallePF'><img src='".URL."css/images/calendar.png'></button></td>
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
                            echo "</table>";
                        }
                    } else {
                        echo "<div class='card bg-warning text-dark shadow'>No hay ordenes pendientes a liberar</div>";
                    }
                    ?>
                </div>
        </div>
        </form>
        <?php
        if (!($NUMROWS == 0)) {
            echo "<div class='card-footer text-muted footerDI'>
                    Liberación Multiple
                    <br>
                    <samp>Seleccionar Todos:</samp>
                    <input type='checkbox' class='checkAllDI' name='checkAllDI' value=''>
                    <br>
                    <samp>Liberar Elementos Seleccionados:</samp>
                    <button type='button' id='liberaAllDI' class='btn btn-success btn-sm liberaAllDI'>Liberar</button>
                    <br>
                    <br>
                    <div class='card bg-success text-white shadow lbOkDI' hidden>
                    </div>
                    <div class='card bg-danger text-white shadow lbNokDI' hidden>
                    </div>
                </div>";
        }
        ?>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Pedidos Indirectos -->
    <div class="card mb-4">
        <div class="card-header" style="background-color: #C1D82F!important;">
            <h3>Pedidos Indirectos</h3>
        </div>
        <div class="card-body">
            <form name="formDataLiberaIN" action="liberaPedido.php" method="POST">
                <div class="table-responsive">
                    <?php
                $NUMROWS = 0;

                $data = getHeader('11', 'IN');


                if (isset($data['NUMROWS'])) {
                    $NUMROWS = $data['NUMROWS'];
                }

                //$NUMROWS = 2;

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
                                    <td><input type='checkbox' id=\"liberaMsv_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\"  class='checkboxesIN' name='checkboxesIN[]' value=\"" . $PO_NUMBER . "|" . $codigo_liberacion . "\"></td>
                                    <td><input type='button' id=\"liberarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>
                                    <td><input type='button' id=\"rechazarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "_" . $PUR_GROUP . "\" class='btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>
                                    <td ><type='button' id=\"detalleP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detalleP'><img src=".URL."css/images/articles_menu.gif></button></td>
                                    <td ><type='button' id=\"detallePF_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detallePF'><img src=".URL."css/images/calendar.png></button></td>
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
                    }
                } else {
                    echo "<div class='card bg-warning text-dark shadow'>No hay ordenes pendientes a liberar</div>";
                }
                ?>
                </div>
        </div>
        </form>
        <?php
    if (!($NUMROWS == 0)) {
        echo "
            <div class='card-footer text-muted footerIN'>
                Liberación Multiple
                <br>
                <samp>Seleccionar Todos:</samp>
                <input type='checkbox' class='checkAllIN' name='checkAllIN' value=''>
                <br>
                <samp>Liberar Elementos Seleccionados:</samp>
                <button type='button' id='liberaAllIN' class='btn btn-success btn-sm liberaAllIN'>Liberar</button>
                <br>
                <br>
                <div class='card bg-success text-white shadow lbOkIN' hidden>
                </div>
                <div class='card bg-danger text-white shadow lbNokIN' hidden>
                </div>
            </div>
            ";
    }
    ?>
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Pedidos Corporativos -->
    <div class="card mb-4">
        <div class="card-header" style="background-color: #C1D82F!important;">
            <h3>Pedidos Corporativos</h3>
        </div>
        <div class="card-body">
            <form name="formDataLiberaIN" action="liberaPedido.php" method="POST">
                <div class="table-responsive">
                    <?php
                $NUMROWS = 0;

                $data = getHeader('11', 'CO');


                if (isset($data['NUMROWS'])) {
                    $NUMROWS = $data['NUMROWS'];
                }

                //$NUMROWS = 2;

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
                                    <td><input type='checkbox' id=\"liberaMsv_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\"  class='checkboxesIN' name='checkboxesIN[]' value=\"" . $PO_NUMBER . "|" . $codigo_liberacion . "\"></td>
                                    <td><input type='button' id=\"liberarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>
                                    <td><input type='button' id=\"rechazarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "_" . $PUR_GROUP . "\" class='btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>
                                    <td ><type='button' id=\"detalleP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detalleP'><img src=".URL."css/images/articles_menu.gif></button></td>
                                    <td ><type='button' id=\"detallePF_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detallePF'><img src=".URL."css/images/calendar.png></button></td>
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
                    }
                } else {
                    echo "<div class='card bg-warning text-dark shadow'>No hay ordenes pendientes a liberar</div>";
                }
                ?>
                </div>
        </div>
        </form>
        <?php
    if (!($NUMROWS == 0)) {
        echo "
            <div class='card-footer text-muted footerIN'>
                Liberación Multiple
                <br>
                <samp>Seleccionar Todos:</samp>
                <input type='checkbox' class='checkAllIN' name='checkAllIN' value=''>
                <br>
                <samp>Liberar Elementos Seleccionados:</samp>
                <button type='button' id='liberaAllIN' class='btn btn-success btn-sm liberaAllIN'>Liberar</button>
                <br>
                <br>
                <div class='card bg-success text-white shadow lbOkIN' hidden>
                </div>
                <div class='card bg-danger text-white shadow lbNokIN' hidden>
                </div>
            </div>
            ";
    }
    ?>
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Pedidos Estrategias -->
    <div class="card mb-4">
        <div class="card-header" style="background-color: #C1D82F!important;">
            <h3>Pedidos Estrategias</h3>
        </div>
        <div class="card-body">
            <form name="formDataLiberaIN" action="liberaPedido.php" method="POST">
                <div class="table-responsive">
                    <?php
                $NUMROWS = 0;

                $data = getHeader('11', '03');


                if (isset($data['NUMROWS'])) {
                    $NUMROWS = $data['NUMROWS'];
                }

                //$NUMROWS = 2;

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
                                    <td><input type='checkbox' id=\"liberaMsv_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\"  class='checkboxesIN' name='checkboxesIN[]' value=\"" . $PO_NUMBER . "|" . $codigo_liberacion . "\"></td>
                                    <td><input type='button' id=\"liberarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>
                                    <td><input type='button' id=\"rechazarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "_" . $PUR_GROUP . "\" class='btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>
                                    <td ><type='button' id=\"detalleP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detalleP'><img src=".URL."css/images/articles_menu.gif></button></td>
                                    <td ><type='button' id=\"detallePF_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detallePF'><img src=".URL."css/images/calendar.png></button></td>
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
                    }
                } else {
                    echo "<div class='card bg-warning text-dark shadow'>No hay ordenes pendientes a liberar</div>";
                }
                ?>
                </div>
        </div>
        </form>
        <?php
    if (!($NUMROWS == 0)) {
        echo "
            <div class='card-footer text-muted footerIN'>
                Liberación Multiple
                <br>
                <samp>Seleccionar Todos:</samp>
                <input type='checkbox' class='checkAllIN' name='checkAllIN' value=''>
                <br>
                <samp>Liberar Elementos Seleccionados:</samp>
                <button type='button' id='liberaAllIN' class='btn btn-success btn-sm liberaAllIN'>Liberar</button>
                <br>
                <br>
                <div class='card bg-success text-white shadow lbOkIN' hidden>
                </div>
                <div class='card bg-danger text-white shadow lbNokIN' hidden>
                </div>
            </div>
            ";
    }
    ?>
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Pedidos Estrategias Anteriores -->
    <div class="card mb-4">
        <div class="card-header" style="background-color: #C1D82F!important;">
            <h3>Pedidos Estrategias Anteriores</h3>
        </div>
        <div class="card-body">
            <form name="formDataLiberaIN" action="liberaPedido.php" method="POST">
                <div class="table-responsive">
                    <?php
                $NUMROWS = 0;

                $data = getHeader('11', '02');


                if (isset($data['NUMROWS'])) {
                    $NUMROWS = $data['NUMROWS'];
                }

                //$NUMROWS = 2;

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
                                    <td><input type='checkbox' id=\"liberaMsv_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\"  class='checkboxesIN' name='checkboxesIN[]' value=\"" . $PO_NUMBER . "|" . $codigo_liberacion . "\"></td>
                                    <td><input type='button' id=\"liberarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>
                                    <td><input type='button' id=\"rechazarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "_" . $PUR_GROUP . "\" class='btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>
                                    <td ><type='button' id=\"detalleP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detalleP'><img src=".URL."css/images/articles_menu.gif></button></td>
                                    <td ><type='button' id=\"detallePF_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detallePF'><img src=".URL."css/images/calendar.png></button></td>
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
                    }
                } else {
                    echo "<div class='card bg-warning text-dark shadow'>No hay ordenes pendientes a liberar</div>";
                }
                ?>
                </div>
        </div>
        </form>
        <?php
    if (!($NUMROWS == 0)) {
        echo "
            <div class='card-footer text-muted footerIN'>
                Liberación Multiple
                <br>
                <samp>Seleccionar Todos:</samp>
                <input type='checkbox' class='checkAllIN' name='checkAllIN' value=''>
                <br>
                <samp>Liberar Elementos Seleccionados:</samp>
                <button type='button' id='liberaAllIN' class='btn btn-success btn-sm liberaAllIN'>Liberar</button>
                <br>
                <br>
                <div class='card bg-success text-white shadow lbOkIN' hidden>
                </div>
                <div class='card bg-danger text-white shadow lbNokIN' hidden>
                </div>
            </div>
            ";
    }
    ?>
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Pedidos Estrategias Anteriores -->
    <div class="card mb-4">
        <div class="card-header" style="background-color: #C1D82F!important;">
            <h3>Pedidos Estrategias Anteriores</h3>
        </div>
        <div class="card-body">
            <form name="formDataLiberaIN" action="liberaPedido.php" method="POST">
                <div class="table-responsive">
                    <?php
                $NUMROWS = 0;

                $data = getHeader('11', '07');


                if (isset($data['NUMROWS'])) {
                    $NUMROWS = $data['NUMROWS'];
                }

                //$NUMROWS = 2;

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
                                    <td><input type='checkbox' id=\"liberaMsv_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\"  class='checkboxesIN' name='checkboxesIN[]' value=\"" . $PO_NUMBER . "|" . $codigo_liberacion . "\"></td>
                                    <td><input type='button' id=\"liberarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-sm btn-success liberar' VALUE='Liberar'/></td>
                                    <td><input type='button' id=\"rechazarP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "_" . $PUR_GROUP . "\" class='".URL."btn btn-sm btn-danger rechazar' VALUE='Rechazar'/></td>
                                    <td ><type='button' id=\"detalleP_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detalleP'><img src=".URL."css/images/articles_menu.gif></button></td>
                                    <td ><type='button' id=\"detallePF_" . $PO_NUMBER . "_" . $codigo_liberacion . "_" . $REL_GROUP . "\" class='btn btn-secondary detallePF'><img src=".URL."css/images/calendar.png></button></td>
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
                    }
                } else {
                    echo "<div class='card bg-warning text-dark shadow'>No hay ordenes pendientes a liberar</div>";
                }
                ?>
                </div>
        </div>
        </form>
        <?php
    if (!($NUMROWS == 0)) {
        echo "
            <div class='card-footer text-muted footerIN'>
                Liberación Multiple
                <br>
                <samp>Seleccionar Todos:</samp>
                <input type='checkbox' class='checkAllIN' name='checkAllIN' value=''>
                <br>
                <samp>Liberar Elementos Seleccionados:</samp>
                <button type='button' id='liberaAllIN' class='btn btn-success btn-sm liberaAllIN'>Liberar</button>
                <br>
                <br>
                <div class='card bg-success text-white shadow lbOkIN' hidden>
                </div>
                <div class='card bg-danger text-white shadow lbNokIN' hidden>
                </div>
            </div>
            ";
    }
    ?>
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
        $(".detalleP").click(function(){
            //alert("Modal Detalle");
            $("#tbodyD").empty();
            $("#detalleModal").modal('show');
            var id = $(this).attr("id");
            var parts = id.split('_');
            var numPedido = parts[1];
            var codigo_liberacion = parts[2];
            var grpLiberacion = parts[3];
            //alert(numPedido+"|"+codigo_liberacion+"|"+grpLiberacion);
            var parm = {};
            parm['numPedido'] = numPedido;
            parm['codigo_liberacion'] = codigo_liberacion;
            parm['grpLiberacion'] = grpLiberacion;
            //console.log(parm);
            $.ajax({
            url: "<?= URL ?>pedidos/getItems",
            type: "POST",
            cache: false,
            data: {
                numPedido: numPedido
            },
            success: function(response) {
                //console.log(response);
                const data = JSON.parse(response);
                //console.log(data);
                $.each(data, function(i, DATAITEMS) {
                    a = parseFloat(DATAITEMS.NET_PRICE);
                    b = parseFloat(DATAITEMS.DISP_QUAN);

                    cantidad = a.toFixed(2);
                    precioU = b.toFixed(2);

                    precioTotal = ((a * b) / DATAITEMS.PRICE_UNIT);
                    precioTotal = Math.round(precioTotal);
                    precioTotal = precioTotal.toFixed(2);
                    
                    var tblRow =
                        "<tr>" +
                        "<td>" + DATAITEMS.PO_NUMBER + "</td>" +
                        "<td>" + DATAITEMS.PO_ITEM + "</td>" +
                        "<td>" + DATAITEMS.PUR_MAT + "</td>" +
                        "<td>" + DATAITEMS.SHORT_TEXT + "</td>" +
                        "<td>" + cantidad + "</td>" +
                        "<td>" + DATAITEMS.UNIT + "</td>" +
                        "<td>" + precioU + "</td>" +
                        "<td>" + precioTotal + "</td>" +
                        "<TD><type='button' onClick='getTxtLargo(" + DATAITEMS.PO_NUMBER + ", " + DATAITEMS.PO_ITEM + " )' class='btn btn-secondary getTxtLargo'><img src='<?= URL ?>css/images/articles_menu.gif'></button></TD>" +
                        "<TD><type='button' onClick='getTxtSuministro(" + DATAITEMS.PO_NUMBER + ", " + DATAITEMS.PO_ITEM + " )' class='btn btn-secondary getTxtSuministro'><img src='<?= URL ?>css/images/articles_menu.gif'></button></TD>" +
                        "</tr>"
                    $('#tbodyD').append(tblRow);
                });
            }
            });
        });

    </script>

    <?php include_once(VIEWS . 'layouts/footer.php'); ?>