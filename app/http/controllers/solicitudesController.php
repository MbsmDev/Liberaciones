<?php

require_once MODELS . 'Solicitudes.php';
require_once MODELS . 'Rechazos.php';

class solicitudesController
{
    public function index()
    {
        require_once VIEWS . 'solicitudes/index.php';
    }

    public function indexR()
    {
        require_once VIEWS . 'solicitudes/indexR.php';
    }

    public function indexP()
    {
        require_once VIEWS . 'solicitudes/indexOLD.php';
    }

    public function table()
    {
        require_once VIEWS . 'solicitudes/table.php';
    }

    public function getHeaderS()
    {
        $numPedido = $_POST['numPedido'];
        $tipo = $_POST['tipo'];
        $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped5/300/zsn_lped5/znbn_lped5";

        $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:RequisitionGetitemsrel>
                <!--Optional:-->
                <ItemsForRelease>X</ItemsForRelease>
                <RelCode>$numPedido</RelCode>
                <RelGroup>01</RelGroup>
            </urn:RequisitionGetitemsrel>
        </soapenv:Body>
        </soapenv:Envelope>";

        $action = "RequisitionGetitemsrel";
        $headers = [
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: Content-Type: text/xml;charset=UTF-8',
            'SOAPAction: "RequisitionGetitemsrel"'
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
        $items = $array["n0RequisitionGetitemsrelResponse"]["RequisitionItems"];//["item"];
        $messages = $array["n0RequisitionGetitemsrelResponse"]["Return"];
        $sum = count(array_column($items, 'PREQ_NO'));
        $DATARETURN = $messages;
        //var_dump($sum);//echo "<br/><hr/>";
        $DATAHEADER = array();
        $numRows = 0;

        if ($tipo == "1") {
            
            if(!empty($items) && $sum == 1) {

                foreach ($items as $key => $value) {
                    $item = $value;
                    $poNumber = $item['PreqNo'];
                    $posicion = $item['PreqItem'];
    
                    $getSolicitudR = new Rechazos();
                    //$solicitudR = $getSolicitudR->getrechazos($poNumber);
                    $solicitudR = $getSolicitudR->getRechazosS($poNumber,$posicion);
                    //var_dump($solicitudR);
                    //$numID = $solicitudR[0]["numeroID"];
                    //$posicion = $solicitudR[0]["posicion"];
                    //if (($numID != $poNumber) && ($posicion != $item['PreqItem'])) {
                    if (empty($solicitudR)) {
                        $DATAHEADER[] =array('PREQ_NO'=>$item['PreqNo'],'PREQ_ITEM'=>$item['PreqItem'],'C_AMT_BAPI'=> $item['CAmtBapi'],'PRICE_UNIT'=> $item['PriceUnit'],'PLANT'=> $item['Plant'],'DOC_TYPE'=>$item['DocType']
                        ,'PREQ_DATE'=>$item['PreqDate'],'MATERIAL'=>$item['Material'],'SHORT_TEXT'=> $item['ShortText'],
                        'QUANTITY'=> $item['Quantity'],'UNIT'=>$item['Unit'],'PREQ_NAME'=>$item['PreqName'],'CURRENCY_ISO'=>$item['CurrencyIso'],'PUR_GROUP'=>$item['PurGroup']);
                        $numRows++;

                    }
                }
                $data_row = $numRows;
    
            }elseif(!empty($items) && $sum == 0) {
    
                foreach($items as $key => $value) {
                    $item = $value;
                }
    
                foreach ($item as $key => $value) {
                    $data = $value;
                    $poNumber = $data['PreqNo'];
                    $posicion = $data['PreqItem'];
    
                    $getSolicitudR = new Rechazos();
                    $solicitudR = $getSolicitudR->getRechazosS($poNumber,$posicion);
                    //var_dump($solicitudR);
                    //$numID = $solicitudR[0]["numeroID"];
                    //$posicion = $solicitudR[0]["posicion"];
                    //if (($numID != $poNumber) && ($posicion != $item['PreqItem'])) {
                    if (empty($solicitudR)) {
                        $DATAHEADER[] =array('PREQ_NO'=>$data['PreqNo'],'PREQ_ITEM'=>$data['PreqItem'],'C_AMT_BAPI'=> $data['CAmtBapi'],'PRICE_UNIT'=> $data['PriceUnit'],'PLANT'=> $data['Plant'],'DOC_TYPE'=>$data['DocType']
                        ,'PREQ_DATE'=>$data['PreqDate'],'MATERIAL'=>$data['Material'],'SHORT_TEXT'=> $data['ShortText'],
                        'QUANTITY'=> $data['Quantity'],'UNIT'=>$data['Unit'],'PREQ_NAME'=>$data['PreqName'],'CURRENCY_ISO'=>$data['CurrencyIso'],'PUR_GROUP'=>$data['PurGroup']);
                        $numRows++;
                    }
                }
                $data_row = $numRows;
            }else{
                $data_row = $numRows;
            }

        }elseif ($tipo == "2") {

            if(!empty($items) && $sum == 1) {

                foreach ($items as $key => $value) {
                    $item = $value;
                    $poNumber = $item['PreqNo'];
    
                    $getSolicitudR = new Rechazos();
                    $solicitudR = $getSolicitudR->getrechazos($poNumber);

                    if (!empty($solicitudR)) {
                        $motivo = $solicitudR[0]["motivo"];
                        $numID = $solicitudR[0]["numeroID"];
                        $posicion = $solicitudR[0]["posicion"];
                        //var_dump($posicion);
                        if (($numID == $poNumber) && ($posicion == $item['PreqItem'])) {
                        
                        $DATAHEADER[] =array('PREQ_NO'=>$item['PreqNo'],'PREQ_ITEM'=>$item['PreqItem'],'C_AMT_BAPI'=> $item['CAmtBapi'],'PRICE_UNIT'=> $item['PriceUnit'],'PLANT'=> $item['Plant'],'DOC_TYPE'=>$item['DocType']
                        ,'PREQ_DATE'=>$item['PreqDate'],'MATERIAL'=>$item['Material'],'SHORT_TEXT'=> $item['ShortText'],
                        'QUANTITY'=> $item['Quantity'],'UNIT'=>$item['Unit'],'PREQ_NAME'=>$item['PreqName'],'CURRENCY_ISO'=>$item['CurrencyIso'],'PUR_GROUP'=>$item['PurGroup'],'MOTIVO' => $motivo);
                        $numRows++;

                        }
                        
                    }
                }
                $data_row = $numRows;
    
            }elseif(!empty($items) && $sum == 0) {
    
                foreach($items as $key => $value) {
                    $item = $value;
                }
    
                foreach ($item as $key => $value) {
                    $data = $value;
                    $poNumber = $data['PreqNo'];
    
                    $getSolicitudR = new Rechazos();
                    $solicitudR = $getSolicitudR->getrechazos($poNumber);
                    
                    if (!empty($solicitudR)) {
                        $motivo = $solicitudR[0]["motivo"];
                        $numID = $solicitudR[0]["numeroID"];
                        $posicion = $solicitudR[0]["posicion"];
                        
                        if (($numID == $poNumber) && ($posicion == $data['PreqItem'])) {

                            $DATAHEADER[] =array('PREQ_NO'=>$data['PreqNo'],'PREQ_ITEM'=>$data['PreqItem'],'C_AMT_BAPI'=> $data['CAmtBapi'],'PRICE_UNIT'=> $data['PriceUnit'],'PLANT'=> $data['Plant'],'DOC_TYPE'=>$data['DocType']
                            ,'PREQ_DATE'=>$data['PreqDate'],'MATERIAL'=>$data['Material'],'SHORT_TEXT'=> $data['ShortText'],
                            'QUANTITY'=> $data['Quantity'],'UNIT'=>$data['Unit'],'PREQ_NAME'=>$data['PreqName'],'CURRENCY_ISO'=>$data['CurrencyIso'],'PUR_GROUP'=>$data['PurGroup'],'MOTIVO' => $motivo);
                            $numRows++;

                        }
                    }
                }
                $data_row = $numRows;
            }else{
                $data_row = $numRows;
            }
        }
        
        $tablesData=array('DATAHEADER'=>$DATAHEADER, 'DATARETURN' => $DATARETURN ,'NUMROWS' => $data_row  );

        $tablesData = $tablesData;
        
        echo json_encode($tablesData);
    }

    public function rechazoSolicitud()
    {
        //var_dump($_POST);
        if(isset($_POST['numSolicitud'])){
        $numSolicitud=$_POST['numSolicitud'];
        }

        if(isset($_POST['posicion'])){
        $posicion=$_POST['posicion'];
        }
        
        if(isset($_POST['grupoLib'])){
        $grupoLib=$_POST['grupoLib'];
        }
        
        if(isset($_POST['txtRechazo'])){
        $txtRechazo = $_POST['txtRechazo'];
        }

        if(isset($_POST['usuario'])){
        $usuario = $_POST['usuario'];
        }

        $rechazo = new Solicitudes();
        $response = $rechazo->sendMail($numSolicitud,$txtRechazo);

        $insertR = new Rechazos();
        $insertR->setNumeroID($numSolicitud);
        $insertR->setPosicion($posicion);
        $insertR->setTipo("SOLICITUD");
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

    function liberaSolicitud()
    {
        $codigo_liberacion = $_POST['codigo_liberacion'];
        $num_solicitud = $_POST['num_solicitud'];
        $posicion = $_POST['posicion'];
        //var_dump("Codigo: ".$codigo_liberacion." Orden :".$num_solicitud);

        $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped6/300/zsn_lped6/znbn_lped6";

        $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
            <soapenv:Header/>
            <soapenv:Body>
            <urn:RequisitionRelease>
                <Item>$posicion</Item>
                <!--Optional:-->
                <NoCommitWork></NoCommitWork>
                <Number>$num_solicitud</Number>
                <RelCode>$codigo_liberacion</RelCode>
                <!--Optional:-->
                <UseExceptions>X</UseExceptions>
            </urn:RequisitionRelease>
            </soapenv:Body>
        </soapenv:Envelope>";

        $action = "RequisitionRelease";
        $headers = [
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: Content-Type: text/xml;charset=UTF-8',
            'SOAPAction: "RequisitionRelease"'
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
        //var_dump($response);
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

        echo json_encode(array("TYPE"=>"$type",'MESSAGE'=>"$message",'SOLICITUD'=>"$num_solicitud"));
    }

    public function getTextoS()
    {
        $numSolicitud = $_POST['orden_compra'];
        $posicion = $_POST['posicion'];

        $NumsolicitudPosicion = "$numSolicitud$posicion";

        //var_dump($NumsolicitudPosicion);
        $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped4/300/zsn_lped4/znbn_lped4";

        $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:ZexReadText>
                <IArchiveHandle>0</IArchiveHandle>
                <!--Optional:-->
                <IClient>300</IClient>
                <IId>B03</IId>
                <ILanguage>S</ILanguage>
                <IName>$NumsolicitudPosicion</IName>
                <IObject>EBAN</IObject>
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
        $text0 = $array["n0ZexReadTextResponse"]["Lines"];
        $exist = array_key_exists('item', $text0);
        //var_dump($exist);

        if($exist == true){
            
            $item = $array["n0ZexReadTextResponse"]["Lines"]["item"];
            $exist = array_key_exists('Tdline', $item);

            if ($exist == 1) {
                $data = $array["n0ZexReadTextResponse"]["Lines"]["item"]["Tdline"];
            } else {
                $data = "SND";
            }

        }else{
            $data = "SND";
        }

        echo json_encode( array('dataItems' =>  utf8_encode($data)));

    }

}