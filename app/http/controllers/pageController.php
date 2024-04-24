<?php
require_once MODELS . 'User.php';
class pageController
{
    public function index()
    {
        
        require_once VIEWS.'user/index.php';
    }

    public function login()
    {
        
        require_once VIEWS.'user/login.php';
    }

    public function store()
    {
        $user = new User();
        $user->setNombre($_POST['nombre']);
        $user->setApellidos($_POST['apellidos']);
        $user->setEmail($_POST['email']);
        $save = $user->save();
        if($save)
        {
            echo json_encode(array('status' => 200));
        }else{
            echo json_encode(array('status' => 400));
        }
    }
    
    public function list()
    {
        echo  json_encode($data = utils::list('User','getAll'));
    }

    public function show()
    {
        echo json_encode($data = utils::find('User','find',$_POST['id']));
    }

    public function update()
    {
        $user = new User();
        $user->setNombre($_POST['nombre']);
        $user->setApellidos($_POST['apellidos']);
        $user->setEmail($_POST['email']);
        $save = $user->update($_POST['id']);
        if($save)
        {
            echo json_encode(array('status' => 200));
        }else{
            echo json_encode(array('status' => 400));
        }
    }

    public function destroy()
    {
        echo json_encode($data = utils::find('User','delete',$_POST['id']));
    }

    public function control()
    {
        header("Content-Type: text/html; charset=utf-8"); 
        $usr = $_POST["usuario"]; 
        $pass = $_POST["clave"];
        //print_r("user: ".$usr." clave: ".$pass);
        $user = new User();
        $usuario = $user->mailboxpowerloginrd($usr,$pass); 
        if($usuario == "0" || $usuario == ''){ 
            $_SERVER = array(); 
            $_SESSION = array();
            //echo "<script> Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!'}); window.location.href='".URL."page/login'; </script>";
            echo"<script> alert('Usuario o clave incorrecta. Vuelva a digitarlos por favor.'); window.location.href='".URL."page/login'; </script>";
        }else{
            
            $datos = json_encode(Utils::find('User','find',$usuario));

            if ($datos == "false") {
                echo"<script> alert('Usted no cuenta con los permisos para ingresar al sistema.'); window.location.href='".URL."page/login'; </script>";
            } else {

                $datos = json_decode($datos,true);
                
                session_start();
                
                $_SESSION['user'] = $usuario;
                $_SESSION["autentica"] = "SIP";
                $_SESSION['nombre'] = $datos['nombre'];
                $_SESSION['rol'] = $datos['rol'];
                $_SESSION['codigo'] = $datos['codigo'];
                
                header("Location:".URL."pedidos/index");
            }
        }
    }

    public function logout(){

        session_start();
        session_destroy();
        header("Location:".URL."page/login");

    }
}
