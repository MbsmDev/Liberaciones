<?php
require_once MODELS . 'Pedidos.php';
require_once MODELS . 'Rechazos.php';
require_once MODELS . 'User.php';

class pedidosController
{
    public function index()
    {
        require_once VIEWS . 'pedidos/index.php';
    }

    public function indexR()
    {
        require_once VIEWS . 'pedidos/indexR.php';
    }

    public function indexP()
    {
        require_once VIEWS . 'pedidos/indexP.php';
    }

    function liberaPedido()
    {
        $codigo_liberacion = $_POST['codigo_liberacion'];
        $orden_compra = $_POST['orden_compra'];
        //$orden_compra = '3100004913';
        //var_dump("Codigo: ".$codigo_liberacion." Orden :".$orden_compra);

        $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped2/300/zsn_lped2/znbn_lped2";

        $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
            <soapenv:Header/>
            <soapenv:Body>
            <urn:PoRelease>
                <!--Optional:-->
                <NoCommit></NoCommit>
                <PoRelCode>$codigo_liberacion</PoRelCode>
                <Purchaseorder>$orden_compra</Purchaseorder>
                <!--Optional:-->
                <UseExceptions>X</UseExceptions>
            </urn:PoRelease>
            </soapenv:Body>
        </soapenv:Envelope>";

        $action = "PoRelease";
        $headers = [
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: Content-Type: text/xml;charset=UTF-8',
            'SOAPAction: "PoRelease"'
        ];

        $ch = curl_init($location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        //Tipo de autorización
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);//NTLM para webservices con dominios de windows
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); //AUTH BASIC para este caso
        curl_setopt($ch, CURLOPT_USERPWD, 'usuariog:php&2011'); //usuario:contraseña

        $response = curl_exec($ch);
        $err_status = curl_error($ch);

        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//soap-env:Body')[0];
        $array = json_decode(json_encode((array)$body), TRUE);
        //var_dump($array);
        if (!empty($array)) {

            $type="OK";
            $message="Liberacion correcta";

        }else{

            $type="ER";
            $message="No se pudo realizar la liberacion";

        }

        echo json_encode(array("TYPE"=>"$type",'MESSAGE'=>"$message",'PEDIDO'=>"$orden_compra"));

    }

    public function rechazoPedido()
    {
        //var_dump($_POST);
        if(isset($_POST['numPedido'])){
        $numPedido=$_POST['numPedido'];
        }
        
        if(isset($_POST['txtRechazo'])){
        $txtRechazo = $_POST['txtRechazo'];
        }

        if(isset($_POST['usuario'])){
        $usuario = $_POST['usuario'];
        }

        $rechazo = new Pedidos();
        $response = $rechazo->sendMail($numPedido,$txtRechazo);
        $insertR = new Rechazos();
        $insertR->setNumeroID($numPedido);
        $insertR->setPosicion(null);
        $insertR->setTipo("PEDIDO");
        $insertR->setRechazo("X");
        $insertR->setMotivo($txtRechazo);
        $insertR->setUsuarioR($usuario);
        $save = $insertR->saveRechazos();
        /*if($response=="S"){
            $type="OK";
            $message="Recuerde validar la informacion con su comprador";
        }else{
            $type="ERROR";
            $message="Mensaje No Enviado";
        }*/
        $type="OK";
        $message="Recuerde validar la informacion con su comprador";
        echo json_encode(array('TYPE'=>"$type",'MESSAGE'=>"$message"));

    }

    function getHeader()
    {
    $codigoL = $_POST['codigoL'];
    $grupoL = $_POST['grupoL'];
    $tipo = $_POST['tipo'];

    $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped1/300/zsn_lped1/znbn_lped1";

    $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
    <soapenv:Header/>
    <soapenv:Body>
    <urn:PoGetitemsrel>
        <!--Optional:-->
        <ItemsForRelease>X</ItemsForRelease>
        <!--Optional:-->
        <RelCode>$codigoL</RelCode>
        <!--Optional:-->
        <RelGroup>$grupoL</RelGroup>
    </urn:PoGetitemsrel>
    </soapenv:Body>
    </soapenv:Envelope>";

    $action = "PoGetitemsrel";
    $headers = [
        'Method: POST',
        'Connection: Keep-Alive',
        'User-Agent: PHP-SOAP-CURL',
        'Content-Type: Content-Type: text/xml;charset=UTF-8',
        'SOAPAction: "PoGetitemsrel"'
    ];

    $ch = curl_init($location);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

    //Tipo de autorización
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);//NTLM para webservices con dominios de windows
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); //AUTH BASIC para este caso
    curl_setopt($ch, CURLOPT_USERPWD, 'usuariog:php&2011'); //usuario:contraseña

    $response = curl_exec($ch);
    $err_status = curl_error($ch);

    $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
    $xml = new SimpleXMLElement($response);
    $body = $xml->xpath('//soap-env:Body')[0];
    $array = json_decode(json_encode((array)$body), TRUE);
    //var_dump($array);
    //echo "<br/><hr/>";
    $items = $array["n0PoGetitemsrelResponse"]["PoHeaders"];
    $messages = $array["n0PoGetitemsrelResponse"]["Return"];
    $DATARETURN = $messages;
    //var_dump($items);
    //echo "<br/><hr/>";
    //var_dump($messages);
    //echo "<br/><hr/>";
    $sum = count(array_column($items, 'PoNumber'));
    //echo($sum);
    $DATAHEADER = array();
    //$DATAHEADER[] = "";
    $numRows = 0;

    if ($tipo == "1") {

        if(!empty($items) && $sum == 1) {
            //var_dump("array 1");
            foreach ($items as $key => $value) {
                $item = $value;
                $poNumber = $item['PoNumber'];
                $numR = new Pedidos();
                $numRowsXL = $numR->numPxL($poNumber);
    
                $getPedidoR = new Rechazos();
                $pedidoR = $getPedidoR->getrechazos($poNumber);
                //var_dump($pedidoR);
                if (empty($pedidoR)) {
                    if ($numRowsXL >= 1) {
                        $DATAHEADER[] = array(
                        'PO_NUMBER' => $item['PoNumber'], 'CO_CODE' => $item['CoCode'], 'DOC_TYPE' => $item['DocType'], 'CREATED_ON' => $item['CreatedOn'], 'TARGET_VAL' => $item['TargetVal'], 'CURRENCY' => $item['Currency'],
                        'REL_GROUP' => $item['RelGroup'], 'REL_STRAT' => $item['RelStrat'], 'VEND_NAME' => $item['VendName']
                        );
                        $numRows++;
                    }
                }
            }
    
        }elseif(!empty($items) && $sum == 0) {
            //var_dump("array 2");
            foreach($items as $key => $value) {
                $item = $value;
            }
    
            foreach ($item as $key => $value) {
                $data = $value;
                $poNumber = $data['PoNumber'];
                $numR = new Pedidos();
                $numRowsXL = $numR->numPxL($poNumber);
    
                $getPedidoR = new Rechazos();
                $pedidoR = $getPedidoR->getrechazos($poNumber);
                //var_dump($pedidoR);
                if (empty($pedidoR)) {
                    if ($numRowsXL >= 1) {
                        $DATAHEADER[] = array(
                        'PO_NUMBER' => $data['PoNumber'], 'CO_CODE' => $data['CoCode'], 'DOC_TYPE' => $data['DocType'], 'CREATED_ON' => $data['CreatedOn'], 'TARGET_VAL' => $data['TargetVal'], 'CURRENCY' => $data['Currency'],
                        'REL_GROUP' => $data['RelGroup'], 'REL_STRAT' => $data['RelStrat'], 'VEND_NAME' => $data['VendName']
                        );
                        $numRows++;
                    }
                }
            }
        } else {
            //echo 'array vacio';
        }
        
    } elseif($tipo == "2") {

        if(!empty($items) && $sum == 1) {
            //var_dump("array 1");
            foreach ($items as $key => $value) {
                $item = $value;
                $poNumber = $item['PoNumber'];
                $numR = new Pedidos();
                $numRowsXL = $numR->numPxL($poNumber);
    
                $getPedidoR = new Rechazos();
                $pedidoR = $getPedidoR->getrechazos($poNumber);
                if (!empty($pedidoR)) {
                    $motivo = $pedidoR[0]["motivo"];
                    if ($numRowsXL >= 1) {
                        $DATAHEADER[] = array(
                        'PO_NUMBER' => $item['PoNumber'], 'CO_CODE' => $item['CoCode'], 'DOC_TYPE' => $item['DocType'], 'CREATED_ON' => $item['CreatedOn'], 'TARGET_VAL' => $item['TargetVal'], 'CURRENCY' => $item['Currency'],
                        'REL_GROUP' => $item['RelGroup'], 'REL_STRAT' => $item['RelStrat'], 'VEND_NAME' => $item['VendName'], 'MOTIVO' => $motivo
                        );
                        $numRows++;
                    }
                }
            }
    
        }elseif(!empty($items) && $sum == 0) {
            //var_dump("array 2");
            foreach($items as $key => $value) {
                $item = $value;
            }
    
            foreach ($item as $key => $value) {
                $data = $value;
                $poNumber = $data['PoNumber'];
                $numR = new Pedidos();
                $numRowsXL = $numR->numPxL($poNumber);
    
                $getPedidoR = new Rechazos();
                $pedidoR = $getPedidoR->getrechazos($poNumber);
                if (!empty($pedidoR)) {
                    $motivo = $pedidoR[0]["motivo"];
                    if ($numRowsXL >= 1) {
                        $DATAHEADER[] = array(
                        'PO_NUMBER' => $data['PoNumber'], 'CO_CODE' => $data['CoCode'], 'DOC_TYPE' => $data['DocType'], 'CREATED_ON' => $data['CreatedOn'], 'TARGET_VAL' => $data['TargetVal'], 'CURRENCY' => $data['Currency'],
                        'REL_GROUP' => $data['RelGroup'], 'REL_STRAT' => $data['RelStrat'], 'VEND_NAME' => $data['VendName'], 'MOTIVO' => $motivo
                        );
                        $numRows++;
                    }
                }
            }
        } else {
            //echo 'array vacio';
        }

    }

    $tablesData = array('DATAHEADER' => $DATAHEADER, 'DATARETURN' => $DATARETURN, 'NUMROWS' => $numRows);
    //return ($tablesData);
    echo json_encode($tablesData);
    }

    function numPxL($orden_compra)
    {
    //echo $orden_compra."</br>";
    $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped3/300/zsn_lped3/znbn_lped3";

    $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
    <soapenv:Header/>
    <soapenv:Body>
        <urn:PoGetdetail>
            <!--Optional:-->
            <Items>x</Items>
            <Purchaseorder>$orden_compra</Purchaseorder>
            <!--Optional:-->
            <Schedules>x</Schedules>
        </urn:PoGetdetail>
    </soapenv:Body>
    </soapenv:Envelope>";

    $action = "PoGetdetail";
    $headers = [
        'Method: POST',
        'Connection: Keep-Alive',
        'User-Agent: PHP-SOAP-CURL',
        'Content-Type: Content-Type: text/xml;charset=UTF-8',
        'SOAPAction: "PoGetdetail"'
    ];

    $ch = curl_init($location);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

    //Tipo de autorización
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);//NTLM para webservices con dominios de windows
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); //AUTH BASIC para este caso
    curl_setopt($ch, CURLOPT_USERPWD, 'usuariog:php&2011'); //usuario:contraseña

    $response = curl_exec($ch);
    $err_status = curl_error($ch);

    $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
    $xml = new SimpleXMLElement($response);
    $body = $xml->xpath('//soap-env:Body')[0];
    $array = json_decode(json_encode((array)$body), TRUE);
    //var_dump($array);
    //echo "<br/><hr/>";
    $items = $array["n0PoGetdetailResponse"]["PoItems"];
    $sum = count(array_column($items, 'PO_NUMBER'));
    //var_dump($sum);
    //echo "<br/><hr/>";
    $numRowsXL = 0;

    if (!empty($items) && $sum == 1) {

        foreach ($items as $key => $value) {
            $item = $value;
            if ($item['PO_NUMBER'] == $orden_compra && empty($item['DELETE_IND']) == 1) {
                $numRowsXL++;
            }
            /*echo $item['PO_NUMBER']."</br>";echo empty($item['DELETE_IND']);echo $item['DELETE_IND']."</br>";echo "<br/><hr/>";$numRows++;*/
        }
        //echo $numRowsXL;
    } elseif (!empty($items) && $sum == 0) {

        foreach ($items as $key => $value) {
            $item = $value;
        }

        foreach ($item as $key => $value) {
            $data = $value;
            if ($data['PO_NUMBER'] == $orden_compra && empty($data['DELETE_IND']) == 1) {
                $numRowsXL++;
            }
            /*echo $data['PO_NUMBER']."</br>"; echo $data['DELETE_IND']."</br>";echo "<br/><hr/>";*/
        }
        //echo $numRowsXL;
    } else {
    }

    return $numRowsXL;
    }

    function getItems()
    {
        $orden_compra = $_POST['numPedido'];

        $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped3/300/zsn_lped3/znbn_lped3";

        $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:PoGetdetail>
                <!--Optional:-->
                <Items>x</Items>
                <Purchaseorder>$orden_compra</Purchaseorder>
                <!--Optional:-->
                <Schedules>x</Schedules>
            </urn:PoGetdetail>
        </soapenv:Body>
        </soapenv:Envelope>";

        $action = "PoGetdetail";
        $headers = [
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: Content-Type: text/xml;charset=UTF-8',
            'SOAPAction: "PoGetdetail"'
        ];

        $ch = curl_init($location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        //Tipo de autorización
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);//NTLM para webservices con dominios de windows
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); //AUTH BASIC para este caso
        curl_setopt($ch, CURLOPT_USERPWD, 'usuariog:php&2011'); //usuario:contraseña

        $response = curl_exec($ch);
        $err_status = curl_error($ch);

        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//soap-env:Body')[0];
        $array = json_decode(json_encode((array)$body), TRUE);
        $items = $array["n0PoGetdetailResponse"]["PoItems"];
        $sum = count(array_column($items, 'PO_NUMBER'));
        //$DATAITEMS[] = array();
        $numRows = 0;
        
        if (!empty($items) && $sum == 1) {
            
            foreach($items as $key => $value){
                $item = $value;
                $DATAITEMS[] = array(
                'PO_NUMBER' => $item['PO_NUMBER'], 'PO_ITEM' => $item['PO_ITEM'], 'PUR_MAT' => $item['PUR_MAT'], 'SHORT_TEXT' => utf8_encode($item['SHORT_TEXT']), 'DISP_QUAN' => $item['QUANTITY'], 'UNIT' => $item['UNIT'],
                'NET_PRICE' => $item['NET_PRICE'], 'PRICE_UNIT' => $item['PRICE_UNIT']
                );
                $numRows++;
            }

        }elseif (!empty($items) && $sum == 0) {

            foreach ($items as $key => $value) {
                $item = $value;
            }

            foreach ($item as $key => $value) {
                $data = $value;
                $DATAITEMS[] = array(
                'PO_NUMBER' => $data['PO_NUMBER'], 'PO_ITEM' => $data['PO_ITEM'], 'PUR_MAT' => $data['PUR_MAT'], 'SHORT_TEXT' => utf8_encode($data['SHORT_TEXT']), 'DISP_QUAN' => $data['QUANTITY'], 'UNIT' => $data['UNIT'],
                'NET_PRICE' => $data['NET_PRICE'], 'PRICE_UNIT' => $data['PRICE_UNIT']
                );
                $numRows++;
            }

        }else{

        }

        $tablesData = $DATAITEMS;
        
        echo json_encode($tablesData);
    }

    public function getFecha()
    {
        $orden_compra = $_POST['numPedido'];

        $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped3/300/zsn_lped3/znbn_lped3";

        $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:PoGetdetail>
                <!--Optional:-->
                <Items>x</Items>
                <Purchaseorder>$orden_compra</Purchaseorder>
                <!--Optional:-->
                <Schedules>x</Schedules>
            </urn:PoGetdetail>
        </soapenv:Body>
        </soapenv:Envelope>";

        $action = "PoGetdetail";
        $headers = [
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: Content-Type: text/xml;charset=UTF-8',
            'SOAPAction: "PoGetdetail"'
        ];

        $ch = curl_init($location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        //Tipo de autorización
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);//NTLM para webservices con dominios de windows
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); //AUTH BASIC para este caso
        curl_setopt($ch, CURLOPT_USERPWD, 'usuariog:php&2011'); //usuario:contraseña

        $response = curl_exec($ch);
        $err_status = curl_error($ch);

        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//soap-env:Body')[0];
        $array = json_decode(json_encode((array)$body), TRUE);
        $items = $array["n0PoGetdetailResponse"]["PoItemSchedules"]["item"];
        $sum = count(array_column($items, 'PoItem'));
        //var_dump($items);
        $DATAITEMS = array();
        if (!empty($items) && $sum == 0) {
            $DATAITEMS[] = array('PO_ITEM' => $items['PoItem'], 'DELIV_DATE' => $items['DelivDate'], 'QUANTITY' => $items['Quantity']);
        }else {
            foreach ($items as $key => $value) {
                $item = $value;
                $DATAITEMS[] = array('PO_ITEM' => $item['PoItem'], 'DELIV_DATE' => $item['DelivDate'], 'QUANTITY' => $item['Quantity']);
            }
        }
        //var_dump($DATAITEMS);
        $tablesData = $DATAITEMS;
        echo json_encode($tablesData);
    }

    public function getTextoL()
    {
        $ordenCompra = $_POST['ordenCompra'];
        $posicion = $_POST['posicion'];
        $ordenPosicion = "$ordenCompra$posicion";
        //var_dump($ordenPosicion);
        $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped4/300/zsn_lped4/znbn_lped4";

        $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:ZexReadText>
                <IArchiveHandle>0</IArchiveHandle>
                <!--Optional:-->
                <IClient>300</IClient>
                <IId>F01</IId>
                <ILanguage>S</ILanguage>
                <IName>$ordenPosicion</IName>
                <IObject>EKPO</IObject>
            </urn:ZexReadText>
            </soapenv:Body>
        </soapenv:Envelope>";

        $action = "ZexReadText";

        $headers = [
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: Content-Type: text/xml;charset=UTF-8',
            'SOAPAction: "ZexReadText"'
        ];

        $ch = curl_init($location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        //Tipo de autorización
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);//NTLM para webservices con dominios de windows
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); //AUTH BASIC para este caso
        curl_setopt($ch, CURLOPT_USERPWD, 'usuariog:php&2011'); //usuario:contraseña

        $response = curl_exec($ch);
        $err_status = curl_error($ch);

        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//soap-env:Body')[0];
        $array = json_decode(json_encode((array)$body), TRUE);
        //var_dump($array);
        $returnM = $array["n0ZexReadTextResponse"]["Return"];
        $message = "";
        foreach ($returnM as $key => $value) {
            $message = $value['MESSAGE'];
        }
        //var_dump("MENSAGE: ".$message);
        $DATALINE = "";

        if (!($message == "TEXTO NO ENCONTRADO")) {

            $texts = $array["n0ZexReadTextResponse"]["Lines"]["item"];

            foreach ($texts as $key => $value) {
                $text = $value['Tdline'];
                $texto = $text;
                //var_dump($texto);
                if(!empty($texto)){
                    $DATALINE .= $texto."\n";
                }
            }

        } else {
            $DATALINE = "TEXTO NO ENCONTRADO";
        }
        
        $data = $DATALINE;
        echo json_encode($data);
    }

    public function getTextoS()
    {
        $ordenCompra = $_POST['ordenCompra'];
        $posicion = $_POST['posicion'];
        $ordenPosicion = "$ordenCompra$posicion";
        //var_dump($ordenPosicion);
        $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped4/300/zsn_lped4/znbn_lped4";

        $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:ZexReadText>
                <IArchiveHandle>0</IArchiveHandle>
                <!--Optional:-->
                <IClient>300</IClient>
                <IId>F04</IId>
                <ILanguage>S</ILanguage>
                <IName>$ordenPosicion</IName>
                <IObject>EKPO</IObject>
            </urn:ZexReadText>
            </soapenv:Body>
        </soapenv:Envelope>";

        $action = "ZexReadText";

        $headers = [
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: Content-Type: text/xml;charset=UTF-8',
            'SOAPAction: "ZexReadText"'
        ];

        $ch = curl_init($location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        //Tipo de autorización
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);//NTLM para webservices con dominios de windows
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); //AUTH BASIC para este caso
        curl_setopt($ch, CURLOPT_USERPWD, 'usuariog:php&2011'); //usuario:contraseña

        $response = curl_exec($ch);
        $err_status = curl_error($ch);

        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//soap-env:Body')[0];
        $array = json_decode(json_encode((array)$body), TRUE);
        //var_dump($array);
        $returnM = $array["n0ZexReadTextResponse"]["Return"];
        //var_dump($returnM);
        $message = "";
        foreach ($returnM as $key => $value) {
            $message = $value['MESSAGE'];
        }
        //var_dump($message);
        $DATALINE = "";
        
        if (!empty($message) and !($message == "TEXTO NO ENCONTRADO")) {

            $texts = $array["n0ZexReadTextResponse"]["Lines"];

            foreach ($texts as $key => $value) {
                $text = $value['Tdline'];
                $texto = $text;
                //var_dump($texto);
                if(!empty($texto)){
                    $DATALINE .= $texto."\n";
                }
            }

        } else {
            $DATALINE = "TEXTO NO ENCONTRADO";
        }

        $data = $DATALINE;
        echo json_encode($data);

    }

    public function getSelect(){
        $user = new User();
        $data = $user->getSelectCS($_POST['codigoL']);
        //echo  json_encode($data);

        $filtersData = array('CODE' => $data);
        
        echo json_encode($filtersData);
    }
}
