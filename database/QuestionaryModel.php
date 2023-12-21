<?php
class QuestionaryModel extends Conection
{

    private $table = "questionary";

    /**
     * Function to add new questionary data
     *
     * @param mixed $data
     * @param mixed $heart_rate_id
     * @return bool
     */
    public function insertNewQuestionary($data, $heart_rate_id)
    {
        $sql = "INSERT INTO " . $this->table . "(`data`, `type`, `heart_rate_id`) 
        VALUES (:data, :type, :heart_rate_id)";
        
        $this->connect();
        $connection = $this->getConection();
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":data", json_encode($data->data));
        $stmt->bindParam(":type", $data->type);
        $stmt->bindParam(":heart_rate_id", $heart_rate_id);
        $result = $stmt->execute();

        $this->disconnect();
        
        return $result ? true: false;
    }

}