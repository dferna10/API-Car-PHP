<?php
require_once PROJECT_ROOT_PATH . "/database/Conection.php";

class UserModel extends Conection
{

    private $tabla = "users";

    public function getUsersList()
    {
        $sql = "SELECT * FROM " . $this->tabla;

        $this->connect();
        $conection = $this->getConection();
        $stmt = $conection->prepare($sql);
        $stmt->execute();

        $this->disconnect();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM " . $this->tabla . " WHERE username = :username";
        $this->connect();
        $conection = $this->getConection();
        $stmt = $conection->prepare($sql);
        $stmt->bindParam(':username', $username);

        $stmt->execute();
        $this->disconnect();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

}

?>