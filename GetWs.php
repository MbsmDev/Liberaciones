<?php
/// CALIDAD
$location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped1/300/zsn_lped1/znbn_lped1";

$request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
<soapenv:Header/>
<soapenv:Body>
   <urn:PoGetitemsrel>
      <!--Optional:-->
      <ItemsForRelease>X</ItemsForRelease>
      <!--Optional:-->
      <RelCode>11</RelCode>
      <!--Optional:-->
      <RelGroup>CO</RelGroup>
   </urn:PoGetitemsrel>
</soapenv:Body>
</soapenv:Envelope>";

print("Request:<br>");
print("<pre>" . htmlentities($request) . "</pre>");
echo "<br/><hr/>";

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
print("Response: <br>");
print("<pre>".$response."</pre>");
echo "<br/><hr/>";

/* Conversion de respuesta de ws en array */

$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//soap-env:Body')[0];
$array = json_decode(json_encode((array)$body), TRUE);
print_r($array);
echo "<br/><hr/>";

/*******************************************/

/* Validacion de array dimension array */

$items = $array["n0PoGetitemsrelResponse"]["PoHeaders"];
$validaArray = array_column($items, 'PoNumber');
print_r($validaArray);
echo "<br/><hr/>";

/*******************************************/

/* Return de data para vista */

$DATAHEADER[] = array();

if (!empty($validaArray)) { 

    //echo "Varible no vacia";
    foreach ($items as $key => $value) {
       // obtiene fila de array actual
       $item = $value; 
       $DATAHEADER[] =array('PO_NUMBER'=>$item['PoNumber'],'CO_CODE'=> $item['CoCode'],'DOC_TYPE'=>$item['DocType']
          ,'CREATED_ON'=>$item['CreatedOn'],'TARGET_VAL'=>$item['TargetVal'],'CURRENCY'=> $item['Currency'],
          'REL_GROUP'=> $item['RelGroup'],'REL_STRAT'=>$item['RelStrat'],'VEND_NAME'=>$item['VendName']);
       print_r($DATAHEADER);
    }
 }else{
    //echo "Varible Vacia";
    foreach ($items as $key => $value) {
       // obtiene fila de array actual
       $item = $value;
    }
 
    foreach ($item as $key => $value) {
       $data=$value;
       $DATAHEADER[] =array('PO_NUMBER'=>$data['PoNumber'],'CO_CODE'=> $data['CoCode'],'DOC_TYPE'=>$data['DocType']
          ,'CREATED_ON'=>$data['CreatedOn'],'TARGET_VAL'=>$data['TargetVal'],'CURRENCY'=> $data['Currency'],
          'REL_GROUP'=> $data['RelGroup'],'REL_STRAT'=>$data['RelStrat'],'VEND_NAME'=>$data['VendName']);
    }
    var_dump($DATAHEADER);
 
 
 }

/*******************************************/







?>