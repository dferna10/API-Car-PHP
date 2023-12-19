<?php
class HeartRateMeasuresModel extends Conection
{

    private $table = "heart_rate_measures";

    public function insertNewMeasure($data, $heart_rate_id)
    {
        $sql = "INSERT INTO " . $this->table . "(`heart_rate`, `timestamp`, `variability`, `heart_rate_id`) VALUES 
        (:heart_rate, :timestamp, :variability, :heart_rate_id)";
        
        $this->connect();
        $connection = $this->getConection();
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":heart_rate", $data->heart_rate);
        $stmt->bindParam(":timestamp", $data->timestamp);
        $stmt->bindParam(":variability", $data->variability);
        $stmt->bindParam(":heart_rate_id", $heart_rate_id);
        $stmt->execute();
        
        $this->disconnect();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
        
    }

}