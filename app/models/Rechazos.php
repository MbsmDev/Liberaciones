<?php
class Rechazos
{
    private $numeroID;
    private $posicion;
    private $tipo;
    private $rechazo;
    private $motivo;
    private $usuarioR;

    public function getNumeroID()
    {
        return $this->numeroID;
    }

    public function setNumeroID($numeroID)
    {
        $this->numeroID = $numeroID;

        return $this;
    }


    public function getPosicion()
    {
        return $this->posicion;
    }

    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }


    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }


    public function getRechazo()
    {
        return $this->rechazo;
    }

    public function setRechazo($rechazo)
    {
        $this->rechazo = $rechazo;

        return $this;
    }


    public function getMotivo()
    {
        return $this->motivo;
    }

    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }


    public function getUsuarioR()
    {
        return $this->usuarioR;
    }

    public function setUsuarioR($usuarioR)
    {
        $this->usuarioR = $usuarioR;

        return $this;
    }


    public function saveRechazos()
    {
        try
        {
            $stmt = database::connection()->prepare("INSERT INTO rechazos (numeroID,posicion,tipo,rechazo,motivo,usuarioR) VALUES (:numeroID,:posicion,:tipo,:rechazo,:motivo,:usuarioR)");
            $stmt->bindValue(':numeroID',$this->getNumeroID(),PDO::PARAM_STR);
            $stmt->bindValue(':posicion',$this->getPosicion(),PDO::PARAM_STR);
            $stmt->bindValue(':tipo',$this->getTipo(),PDO::PARAM_STR);
            $stmt->bindValue(':rechazo',$this->getRechazo(),PDO::PARAM_STR);
            $stmt->bindValue(':motivo',$this->getMotivo(),PDO::PARAM_STR);
            $stmt->bindValue(':usuarioR',$this->getUsuarioR(),PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function getRechazos($numeroID)
    {
        try
        {
            $stmt = database::connection()->prepare("SELECT * FROM rechazos WHERE numeroID=:numeroID AND rechazo = 'X'");
            $stmt->bindValue(':numeroID', $numeroID, PDO::PARAM_STR);
            $stmt->execute();
            //return $stmt->fetchObject();
            return $stmt->fetchAll();
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function getRechazosS($numeroID,$posicion)
    {
        try
        {
            $stmt = database::connection()->prepare("SELECT * FROM rechazos WHERE numeroID=:numeroID AND posicion=:posicion AND rechazo = 'X'");
            $stmt->bindValue(':numeroID', $numeroID, PDO::PARAM_STR);
            $stmt->bindValue(':posicion', $posicion, PDO::PARAM_STR);
            $stmt->execute();
            //return $stmt->fetchObject();
            return $stmt->fetchAll();
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

}
?>