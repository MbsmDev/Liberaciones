<?php
class Pedidos
{
    public function numPxL($orden_compra)
    {
        
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

    public function liberaP($codigo_liberacion,$orden_compra)
    {

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
        //echo "<br/><hr/>";
    }

    public function sendMail($numPedido,$txtRechazo)
    {
        //echo "Hola";
        $email="DDIC@carnotapps.com";
        $nombre="Liberaciones en SAP via web";
        $maildest="mbsanchez@carnot.com";

        $contenido = '<html><body>';
		$contenido .= '<h2>Pedidos en SAP Rechazados</h2>';	
		$contenido .= '<hr />';
		$contenido .= '<p>El numero de Pedido <span style="color: #0000FF; font-size: 12pt">'. $numPedido. '</span>  ha sido rechazada debido a :</p>';
		$contenido .= '<p style="color: #5823a3; font-size: 12pt">'    . $txtRechazo . '</p>';
		$contenido .= '<hr />';
		$contenido .= '<p style="color: #EA4667; font-size: 12pt">El documento fue rechazado, favor de aplicar rechazo en SAP</p>';
		$contenido .= '<p>No responder, mail enviado Automaticamente</p>';
		$contenido .= '</body></html>';

        $msgMail=mail ($maildest, "Liberacion de Pedidos", $contenido, "From: $email\nContent-Type: text/html; charset=iso-8859-1\nContent-Transfer-Encoding: 8bit");
        if($msgMail){
            $msg="S";
        }else{
            $msg="E";
        }

        return($msg);
    
    }

}