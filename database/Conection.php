<?php

class Conection
{
    private static $conection = null;

    /**
     * Function in singleton pattern 
     */
    public static function getConection()
    {
        if (self::$conection === null) {
            self::$conection = new Conection();
        }
        return self::$conection;
    }

    /**
     * Function to connect to the database
     */
    public function connect()
    {
        try {
            self::$conection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE_NAME . ';charset=UTF8',
             DB_USER, DB_PASSWORD);
            //Habilitamos el modo de errores para visualizarlos
            self::$conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo "Error al conectar la base de datos " . $e->getMessage();
        }
    }

    /**
     * Function to disconect to the database
     */
    public function disconnect()
    {
        self::$conection = null;
    }
}
?>