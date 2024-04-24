<?php

class StatusCMDI
{
    private $poNumber;
    private $step1;
    private $step2;
    private $step3;
    
    public function getPoNumber(){
		return $this->poNumber;
	}

	public function setPoNnumber($poNumber){
		$this->poNumber = $poNumber;
	}

    public function getStep1(){
		return $this->step1;
	}

	public function setStep1($step1){
		$this->step1 = $step1;
	}

    public function getStep2(){
		return $this->step2;
	}

	public function setStep2($step2){
		$this->step2 = $step2;
	}

    public function getStep3(){
		return $this->step3;
	}

	public function setStep3($step3){
		$this->step3 = $step3;
	}

    public function getCM1($ordenCompra)
    {
        try
        {
            $stmt = database::connection()->query("SELECT * FROM statuscmdi WHERE poNumber='$ordenCompra'");
            $result = $stmt->fetch();

            return $result;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function saveCMDI()
    {
        try
        {
            $stmt = database::connection()->prepare("INSERT INTO statuscmdi (poNumber) VALUES (:poNumber)");
            $stmt->bindValue(':poNumber',$this->getPoNumber(),PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function getCM2($ordenCompra,$where)
    {
        try
        {
            $stmt = database::connection()->query("SELECT poNumber FROM statuscmdi WHERE poNumber='$ordenCompra' $where");
            $result = $stmt->fetch();
            return $result;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function updateCMDI($ordenCompra)
    {
        try
        {
            $stmt = database::connection()->prepare("UPDATE statuscmdi SET step1=:step1 WHERE poNumber=:poNumber ");
            $stmt->bindValue(':poNumber',$ordenCompra,PDO::PARAM_INT);
            $stmt->bindValue(':step1',$this->getStep1(), PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function updateCMDIL($numContrato,$step)
    {
        try
        {
            $stmt = database::connection()->prepare("UPDATE statuscmdi SET $step = 'X' WHERE poNumber='$numContrato'");
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

}