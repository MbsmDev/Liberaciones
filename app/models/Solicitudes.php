<?php

class Solicitudes
{
    public function sendMail($numSolicitud,$txtRechazo)
    {
        //echo "Hola";
        $email="DDIC@carnotapps.com";
        $nombre="Liberaciones en SAP via web";
        $maildest="mbsanchez@carnot.com";

        $contenido = '<html><body>';
		$contenido .= '<h2>Solicitudes en SAP Rechazados</h2>';	
		$contenido .= '<hr />';
		$contenido .= '<p>El numero de Solicitud <span style="color: #0000FF; font-size: 12pt">'. $numSolicitud. '</span>  ha sido rechazada debido a :</p>';
		$contenido .= '<p style="color: #5823a3; font-size: 12pt">'    . $txtRechazo . '</p>';
		$contenido .= '<hr />';
		$contenido .= '<p style="color: #EA4667; font-size: 12pt">El documento fue rechazado, favor de aplicar rechazo en SAP</p>';
		$contenido .= '<p>No responder, mail enviado Automaticamente</p>';
		$contenido .= '</body></html>';

        $msgMail=mail ($maildest, "Liberacion de Solicitudes", $contenido, "From: $email\nContent-Type: text/html; charset=iso-8859-1\nContent-Transfer-Encoding: 8bit");
        if($msgMail){
            $msg="S";
        }else{
            $msg="E";
        }

        return($msg);
    
    }
    
}
