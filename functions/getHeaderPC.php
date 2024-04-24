<?php

function getHeader($codigo_liberacion, $grupoLibera)
{

   $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped1/300/zsn_lped1/znbn_lped1";

   $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
<soapenv:Header/>
<soapenv:Body>
   <urn:PoGetitemsrel>
      <!--Optional:-->
      <ItemsForRelease>X</ItemsForRelease>
      <!--Optional:-->
      <RelCode>$codigo_liberacion</RelCode>
      <!--Optional:-->
      <RelGroup>$grupoLibera</RelGroup>
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
   /*var_dump($array);
   echo "<br/><hr/>";*/
   $items = $array["n0PoGetitemsrelResponse"]["PoHeaders"];
   $messages = $array["n0PoGetitemsrelResponse"]["Return"];
   $DATARETURN = $messages;
   //var_dump($messages);
   //var_dump($items);
   /*echo "<br/><hr/>";*/
   $sum = count(array_column($items, 'PoNumber'));
   //echo($sum);
   //$validaArray = array_column($items, 'PoNumber');
   //echo "validacion de array ". $validaArray . " And sum is " . $sum."</br>";
   $DATAHEADER[] = array();
   $numRows = 0;
   if (!empty($items) && $sum == 1) {

      foreach ($items as $key => $value) {
         $item = $value;
         $poNumber = $item['PoNumber'];
         $numRowsXL = numPxL($poNumber);
         if ($numRowsXL >= 1) {
            $DATAHEADER[] = array(
               'PO_NUMBER' => $item['PoNumber'], 'CO_CODE' => $item['CoCode'], 'DOC_TYPE' => $item['DocType'], 'CREATED_ON' => $item['CreatedOn'], 'TARGET_VAL' => $item['TargetVal'], 'CURRENCY' => $item['Currency'],
               'REL_GROUP' => $item['RelGroup'], 'REL_STRAT' => $item['RelStrat'], 'VEND_NAME' => $item['VendName']
            );
            $numRows++;
         }
      }
   } elseif (!empty($items) && $sum == 0) {

      foreach ($items as $key => $value) {
         $item = $value;
      }

      foreach ($item as $key => $value) {
         $data = $value;
         $poNumber = $data['PoNumber'];
         $numRowsXL = numPxL($poNumber);
         if ($numRowsXL >= 1) {
            $DATAHEADER[] = array(
               'PO_NUMBER' => $data['PoNumber'], 'CO_CODE' => $data['CoCode'], 'DOC_TYPE' => $data['DocType'], 'CREATED_ON' => $data['CreatedOn'], 'TARGET_VAL' => $data['TargetVal'], 'CURRENCY' => $data['Currency'],
               'REL_GROUP' => $data['RelGroup'], 'REL_STRAT' => $data['RelStrat'], 'VEND_NAME' => $data['VendName']
            );
            $numRows++;
         }
      }
   } else {
      //echo 'array vacio';
   }

   $tablesData = array('DATAHEADER' => $DATAHEADER, 'DATARETURN' => $DATARETURN, 'NUMROWS' => $numRows);

   return ($tablesData);
}

function getItems($codigo_liberacion, $orden_compra, $grpLiberacion)
{
   //var_dump($orden_compra);
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
   //var_dump($array);
   $DATAITEMS[] = array();
   $numRows = 0;
   $numRowsXL = 0;
   foreach ($items as $key => $value) {
      $item = $value;
      $DATAITEMS[] = array(
         'PO_NUMBER' => $item['PO_NUMBER'], 'PO_ITEM' => $item['PO_ITEM'], 'PUR_MAT' => $item['PUR_MAT'], 'SHORT_TEXT' => utf8_encode($item['SHORT_TEXT']), 'DISP_QUAN' => $item['QUANTITY'], 'UNIT' => $item['UNIT'],
         'NET_PRICE' => $item['NET_PRICE'], 'PRICE_UNIT' => $item['PRICE_UNIT']
      );
      $numRows++;
   }
   //var_dump($DATAITEMS);

   $tablesData = $DATAITEMS;

   return ($tablesData);
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

function getHeaderS()
{
   //$orden_compra = $_POST['numPedido'];

   $location = "http://techsapqas.techsphere.com.mx:8001/sap/bc/srt/rfc/sap/zmm_lped5/300/zsn_lped5/znbn_lped5";

   $request = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:urn=\"urn:sap-com:document:sap:soap:functions:mc-style\">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:RequisitionGetitemsrel>
         <!--Optional:-->
         <ItemsForRelease>X</ItemsForRelease>
         <RelCode>13</RelCode>
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
   //echo "<br/><hr/>";
   $items = $array["n0RequisitionGetitemsrelResponse"]["RequisitionItems"]["item"];
   $messages = $array["n0RequisitionGetitemsrelResponse"]["Return"];
   $DATARETURN = $messages;
   //var_dump($items);
   //echo "<br/><hr/>";
   $DATAHEADER[] = array();
   $numRows = 0;
   foreach ($items as $key => $value) {
      $item = $value;
      //$poNumber = $item['PreqNo'];
      //var_dump($poNumber);
      //$numRowsXL = numPxL($poNumber);
      //if ($numRowsXL >= 1) {
      $DATAHEADER[] =array('PREQ_NO'=>$item['PreqNo'],'PREQ_ITEM'=>$item['PreqItem'],'C_AMT_BAPI'=> $item['CAmtBapi'],'PRICE_UNIT'=> $item['PriceUnit'],'PLANT'=> $item['Plant'],'DOC_TYPE'=>$item['DocType']
		,'PREQ_DATE'=>$item['PreqDate'],'MATERIAL'=>$item['Material'],'SHORT_TEXT'=> $item['ShortText'],
		'QUANTITY'=> $item['Quantity'],'UNIT'=>$item['Unit'],'PREQ_NAME'=>$item['PreqName'],'CURRENCY_ISO'=>$item['CurrencyIso'],'PUR_GROUP'=>$item['PurGroup']);
      $numRows++;
      //}
   }
   //var_dump($DATAHEADER);
   $data_row = $numRows;
   $tablesData=array('DATAHEADER'=>$DATAHEADER, 'DATARETURN' => $DATARETURN ,'NUMROWS' => $data_row  );

   return($tablesData);
}
