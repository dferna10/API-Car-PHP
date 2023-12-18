<?php
require_once PROJECT_ROOT_PATH . "/database/Conection.php";

class UserModel extends Conection {

    private $tabla = "users";

    public function getUsersList () {
        $sql = "SELECT * FROM " . $this->tabla;
        
        $this->connect();
        $conection = $this->getConection();
        $stmt = $conection->prepare($sql);
        $stmt->execute();

        $this->disconnect();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

?>