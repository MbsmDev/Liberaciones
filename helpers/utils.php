<?php
class utils
{
    public static function list($object,$method)
    {
        $var = new $object();
        $datos = $var->$method();
        return $datos ;
    }
    public static function find($object,$method,$post)
    {
        $var = new $object();
        $datos = $var->$method($post);
        return $datos ;
    }

}