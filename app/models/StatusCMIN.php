<?php

class StatusCMIN
{
    private $poNumber;
    private $step1;
    private $step2;
    private $step3;
    private $step4;
        
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

    public function getStep4(){
		return $this->step4;
	}

	public function setStep4($step4){
		$this->step4 = $step4;
	}

    public function getCM1($ordenCompra)
    {
        try
        {
            $stmt = database::connection()->query("SELECT * FROM statuscmin WHERE poNumber='$ordenCompra'");
            $result = $stmt->fetch();

            return $result;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function saveCMIN()
    {
        try
        {
            $stmt = database::connection()->prepare("INSERT INTO statuscmin (poNumber) VALUES (:poNumber)");
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
            $stmt = database::connection()->query("SELECT poNumber FROM statuscmin WHERE poNumber='$ordenCompra' $where");
            $result = $stmt->fetch();
            return $result;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function updateCMIN($ordenCompra)
    {
        try
        {
            $stmt = database::connection()->prepare("UPDATE statuscmin SET step1=:step1 WHERE poNumber=:poNumber ");
            $stmt->bindValue(':poNumber',$ordenCompra,PDO::PARAM_INT);
            $stmt->bindValue(':step1',$this->getStep1(), PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function updateCMINL($numContrato,$step)
    {
        try
        {
            $stmt = database::connection()->prepare("UPDATE statuscmin SET $step = 'X' WHERE poNumber='$numContrato'");
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

}