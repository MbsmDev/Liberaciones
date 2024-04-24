<?php
class User
{
    private $nombre;
    private $apellidos;
    private $usuario;
    private $email;
    private $codigo;
    private $rol;

    public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getApellidos(){
		return $this->apellidos;
	}

	public function setApellidos($apellidos){
		$this->apellidos = $apellidos;
	}

    public function getUsuario(){
		return $this->usuario;
	}

	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

    public function getCodigo(){
		return $this->codigo;
	}

	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}

    public function getRol(){
		return $this->rol;
	}

	public function setRol($rol){
		$this->rol = $rol;
	}

    public function getAll()
    {
        try
        {
            $stmt  = database::connection()->prepare("SELECT rol, UPPER(denominacion) as 'denominacion' FROM reporte ORDER BY rol ASC");
            if($stmt->execute())
            {
                return $stmt->fetchAll();
            }
            throw new Exception('Hubo un error al solicitar los datos');
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function save()
    {
        try
        {
            $stmt = database::connection()->prepare("INSERT INTO usuarios (nombre,apellidos,email) VALUES (:nombre,:apellidos,:email)");
            $stmt->bindValue(':nombre',$this->getNombre(),PDO::PARAM_STR);
            $stmt->bindValue(':apellidos',$this->getApellidos(),PDO::PARAM_STR);
            $stmt->bindValue(':email',$this->getEmail(),PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function find($usuario)
    {
        try
        {
            $stmt = database::connection()->prepare("SELECT CONCAT(nombre,' ',apellidos) AS nombre, codigoLiberacion AS codigo,r.rol FROM usuarios u LEFT JOIN roles r ON r.id_rol = u.id_rol WHERE usuario=:usuario");
            $stmt->bindValue(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchObject();
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function delete($id)
    {
        try
        {
            $stmt = database::connection()->prepare("DELETE FROM usuarios WHERE id=:id");
            $stmt->bindValue(':id',$id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function update($id)
    {
        try
        {
            $stmt = database::connection()->prepare("UPDATE usuarios SET nombre=:nombre , apellidos=:apellidos , email =:email WHERE id=:id ");
            $stmt->bindValue(':id',$id,PDO::PARAM_INT);
            $stmt->bindValue(':nombre',$this->getNombre(), PDO::PARAM_STR);
            $stmt->bindValue(':apellidos',$this->getApellidos(),PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->getEmail(),PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function mailboxpowerloginrd($user,$pass)
    {
        $ldaprdn = trim($user).'@'.DOMINIO;  
        $ldappass = trim($pass);  
        $ds = DOMINIO;  
        $dn = DN;   
        $puertoldap = 389;  
        $ldapconn = ldap_connect($ds,$puertoldap); 
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3);  
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0);  
        $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);  
        if ($ldapbind){ 
            $filter="(|(SAMAccountName=".trim($user)."))"; 
            $fields = array("SAMAccountName");  
            $sr = @ldap_search($ldapconn, $dn, $filter, $fields);  
            $info = @ldap_get_entries($ldapconn, $sr);  
            $array = $info[0]["samaccountname"][0]; 
        }else{  
            $array=0; 
        }  
        ldap_close($ldapconn);  
        return $array; 
    }

    public function getCategorias()
    {
        try
        {
            $stmt  = database::connection()->prepare("SELECT * FROM `categorias` ");
            if($stmt->execute())
            {
                return $stmt->fetchAll();
            }
            throw new Exception('Hubo un error al solicitar los datos');
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function getSelectCS($codigo)
    {

        try
        {
            $stmt  = database::connection()->prepare("SELECT * FROM `multicodigo` WHERE id_codigo = $codigo");
            if($stmt->execute())
            {
                return $stmt->fetchAll();
            }
            throw new Exception('Hubo un error al solicitar los datos');
        }catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


}