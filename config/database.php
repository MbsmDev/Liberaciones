<?php
class database
{
    public static function connection()
    {
        try
        {
            $pdo = new PDO( LDB_ENGINE.':host='.LDB_HOST.';dbname='.LDB_NAME,LDB_USER,LDB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }catch (PDOException $e)
        {
            die($e->getMessage('No se logro conectar'));
        }
    }
}
