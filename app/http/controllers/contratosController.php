<?php
require_once MODELS . 'Contratos.php';
require_once MODELS . 'StatusCMDI.php';
require_once MODELS . 'Rechazos.php';

class contratosController
{

    public function index()
    {
        require_once VIEWS . 'contratos/index.php';
    }

    public function indexR()
    {
        require_once VIEWS . 'contratos/indexR.php';
    }

    function getHeaderCM()
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
        $sum = count(array_column($items, 'PoNumber'));
        $DATAHEADER = array();
        $numRows = 0;

        switch ($codigoL) {
            case "11":
                $where = "and step1 is null";
                break;
            case "C1":
                $where = "and step1 = 'X' and step2 is null";
                break;
            case "CE":
                $where = "and step1 = 'X' and step2 = 'X' and step3 is null";
                break;
        }

        if ($tipo == "1") {

            if(!empty($items) && $sum == 1) {
                foreach ($items as $key => $value) {
                    $item = $value;
                    $poNumber = $item['PoNumber'];
                    $numR = new Contratos();
                    $numRowsXL = $numR->numPxL($poNumber);
                    $cmDI = new StatusCMDI();
                    $poNR = $cmDI->getCM1($poNumber);
                    if ($poNR == FALSE){
                        $cmDI->setPoNnumber($poNumber);
                        $save = $cmDI->saveCMDI();
                    }
                    $poNR2 = $cmDI->getCM2($poNumber,$where);

                    $getContratoR = new Rechazos();
                    $contratoR = $getContratoR->getrechazos($poNumber);

                    if ($poNR2 != FALSE){
                        if (empty($contratoR)) {
                            if ($numRowsXL >= 1) {
                                $DATAHEADER[] = array(
                                'PO_NUMBER' => $item['PoNumber'], 'CO_CODE' => $item['CoCode'], 'DOC_TYPE' => $item['DocType'], 'CREATED_ON' => $item['CreatedOn'], 'TARGET_VAL' => $item['TargetVal'], 'CURRENCY' => $item['Currency'],
                                'REL_GROUP' => $item['RelGroup'], 'REL_STRAT' => $item['RelStrat'], 'VEND_NAME' => $item['VendName']
                                );
                                $numRows++;
                            }
                        }
                    }
                }
    
            }elseif(!empty($items) && $sum == 0) {
    
                foreach($items as $key => $value) {
                    $item = $value;
                }
    
                foreach ($item as $key => $value) {
                    $data = $value;
                    $poNumber = $data['PoNumber'];
                    $numR = new Contratos();
                    $numRowsXL = $numR->numPxL($poNumber);
                    $cmDI = new StatusCMDI();
                    $poNR = $cmDI->getCM1($poNumber);
                    if ($poNR == FALSE){
                        $cmDI->setPoNnumber($poNumber);
                        $save = $cmDI->saveCMDI();
                        //new StatusCMDI();
                    }
    
                    if ($data['RelStatus'] == 'X') {
                        $cmDI->setStep1('X');
                        $update = $cmDI->updateCMDI($poNumber);
                    }
    
                    $poNR2 = $cmDI->getCM2($poNumber,$where);

                    $getContratoR = new Rechazos();
                    $contratoR = $getContratoR->getrechazos($poNumber);

                    if ($poNR2 != FALSE){
                        if (empty($contratoR)) {
                            if ($numRowsXL >= 1) {
                                $DATAHEADER[] = array(
                                'PO_NUMBER' => $data['PoNumber'], 'CO_CODE' => $data['CoCode'], 'DOC_TYPE' => $data['DocType'], 'CREATED_ON' => $data['CreatedOn'],
                                'VPER_START' =>$data['VperStart'],'VPER_END' =>$data['VperEnd'],'TARGET_VAL' => $data['TargetVal'], 'CURRENCY' => $data['Currency'],
                                'REL_GROUP' => $data['RelGroup'], 'REL_STRAT' => $data['RelStrat'],'CREATED_BY' => $data['CreatedBy'],'VEND_NAME' => $data['VendName']
                                );
                                $numRows++;
                            }
                        }
                    }
                }
            } else {
    
            }

        }elseif ($tipo == "2") {

            if(!empty($items) && $sum == 1) {
                foreach ($items as $key => $value) {
                    $item = $value;
                    $poNumber = $item['PoNumber'];
                    $numR = new Contratos();
                    $numRowsXL = $numR->numPxL($poNumber);
                    $cmDI = new StatusCMDI();
                    $poNR = $cmDI->getCM1($poNumber);
                    if ($poNR == FALSE){
                        $cmDI->setPoNnumber($poNumber);
                        $save = $cmDI->saveCMDI();
                    }
                    $poNR2 = $cmDI->getCM2($poNumber,$where);

                    $getContratoR = new Rechazos();
                    $contratoR = $getContratoR->getrechazos($poNumber);

                    if ($poNR2 != FALSE){
                        if (!empty($contratoR)) {
                            $motivo = $contratoR[0]["motivo"];
                            if ($numRowsXL >= 1) {
                                $DATAHEADER[] = array(
                                'PO_NUMBER' => $item['PoNumber'], 'CO_CODE' => $item['CoCode'], 'DOC_TYPE' => $item['DocType'], 'CREATED_ON' => $item['CreatedOn'], 'TARGET_VAL' => $item['TargetVal'], 'CURRENCY' => $item['Currency'],
                                'REL_GROUP' => $item['RelGroup'], 'REL_STRAT' => $item['RelStrat'], 'VEND_NAME' => $item['VendName'], 'MOTIVO' => $motivo
                                );
                                $numRows++;
                            }
                        }
                    }
                }
    
            }elseif(!empty($items) && $sum == 0) {
    
                foreach($items as $key => $value) {
                    $item = $value;
                }
    
                foreach ($item as $key => $value) {
                    $data = $value;
                    $poNumber = $data['PoNumber'];
                    $numR = new Contratos();
                    $numRowsXL = $numR->numPxL($poNumber);
                    $cmDI = new StatusCMDI();
                    $poNR = $cmDI->getCM1($poNumber);
                    if ($poNR == FALSE){
                        $cmDI->setPoNnumber($poNumber);
                        $save = $cmDI->saveCMDI();new StatusCMDI();
                    }
    
                    if ($data['RelStatus'] == 'X') {
                        $cmDI->setStep1('X');
                        $update = $cmDI->updateCMDI($poNumber);
                    }
    
                    $poNR2 = $cmDI->getCM2($poNumber,$where);

                    $getContratoR = new Rechazos();
                    $contratoR = $getContratoR->getrechazos($poNumber);
                    if ($poNR2 != FALSE){
                        if (!empty($contratoR)) {
                            $motivo = $contratoR[0]["motivo"];
                            //var_dump($motivo);
                            if ($numRowsXL >= 1) {
                                $DATAHEADER[] = array(
                                'PO_NUMBER' => $data['PoNumber'], 'CO_CODE' => $data['CoCode'], 'DOC_TYPE' => $data['DocType'], 'CREATED_ON' => $data['CreatedOn'],
                                'VPER_START' =>$data['VperStart'],'VPER_END' =>$data['VperEnd'],'TARGET_VAL' => $data['TargetVal'], 'CURRENCY' => $data['Currency'],
                                'REL_GROUP' => $data['RelGroup'], 'REL_STRAT' => $data['RelStrat'],'CREATED_BY' => $data['CreatedBy'],'VEND_NAME' => $data['VendName'], 'MOTIVO' => $motivo
                                );
                                $numRows++;
                            }
                        }
                    }
                }
            } else {
    
            }
        }

        $tablesData = array('DATAHEADER' => $DATAHEADER, 'DATARETURN' => $DATARETURN, 'NUMROWS' => $numRows);
        //return ($tablesData);
        echo json_encode($tablesData);
    }

    function liberaContrato()
    {

        $codigo_liberacion = $_POST['codigo_liberacion'];
        $orden_compra = $_POST['orden_compra'];
        //$orden_compra = '7700000013';
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
        //var_dump($xml);
        //echo "<br/><hr/>";
        if (!empty($array)) {
            $step = "";
            switch ($codigo_liberacion) {
                case "11":
                    $step = 'step1';
                    break;
                case "C1":
                    $step = 'step2';
                    break;
                case "CE":
                    $step = 'step3';
                    break;
            }

            $cmDI = new StatusCMDI();
            $cmDI->updateCMDIL($orden_compra,$step);

            $type="OK";
            $message="Liberacion correcta";
        }else{
            $type="ER";
            $message="No se pudo realizar la liberacion";
        }
        echo json_encode(array("TYPE"=>"$type",'MESSAGE'=>"$message",'PEDIDO'=>"$orden_compra"));
    }

    public function rechazoContrato()
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

        $rechazo = new Contratos();
        $response = $rechazo->sendMail($numPedido,$txtRechazo);

        $insertR = new Rechazos();
        $insertR->setNumeroID($numPedido);
        $insertR->setPosicion(null);
        $insertR->setTipo("CONTRATO");
        $insertR->setRechazo("X");
        $insertR->setMotivo($txtRechazo);
        $insertR->setUsuarioR($usuario);
        $save = $insertR->saveRechazos();

        if($response=="S"){
            $type="OK";
            $message="Recuerde validar la informacion con su comprador";
        }else{
            $type="ERROR";
            $message="Mensaje No Enviado";
        }
            
        echo json_encode(array('TYPE'=>"$type",'MESSAGE'=>"$message"));

    }

    function getItemsCM()
    {
        $orden_compra = $_POST['numPedido'];

        $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped7/300/zsn_lped7/znbn_lped7";

        $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
            <soapenv:Header/>
            <soapenv:Body>
            <urn:ContractGetdetail>
                <!--Optional:-->
                <ItemData>X</ItemData>
                <Purchasingdocument>$orden_compra</Purchasingdocument>
            </urn:ContractGetdetail>
            </soapenv:Body>
        </soapenv:Envelope>";

        $action = "ContractGetdetail";
        $headers = [
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: Content-Type: text/xml;charset=UTF-8',
            'SOAPAction: "ContractGetdetail"'
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
        $items = $array["n0ContractGetdetailResponse"]["Item"];
        $sum = count(array_column($items, 'ItemNo'));
        //var_dump($items);
        //$DATAITEMS[] = array();
        $numRows = 0;
        
        if (!empty($items) && $sum == 1) {
            
            foreach($items as $key => $value){
                $item = $value;
                $DATAITEMS[] = array(
                'ITEM_NO' => $item['ItemNo'], 'MATERIAL' => $item['Material'], 'TARGET_QTY' => $item['TargetQty'],
                'SHORT_TEXT' => utf8_encode($item['ShortText']), 'PO_UNIT' => $item['PoUnit'],'NET_PRICE' => $item['NetPrice'],
                'PRICE_UNIT' => $item['PriceUnit']
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
                'ITEM_NO' => $data['ItemNo'], 'MATERIAL' => $data['Material'], 'TARGET_QTY' => $data['TargetQty'],
                'SHORT_TEXT' => utf8_encode($data['ShortText']), 'PO_UNIT' => $data['PoUnit'],'NET_PRICE' => $data['NetPrice'],
                'PRICE_UNIT' => $data['PriceUnit']
                );
                $numRows++;
            }

        }else{

        }

        $tablesData = $DATAITEMS;
        
        echo json_encode($tablesData);
    }

}