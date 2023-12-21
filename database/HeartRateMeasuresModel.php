<?php
class HeartRateMeasuresModel extends Conection
{

    private $table = "heart_rate_measures";

    /**
     * Function to add new heart rate measure
     *
     * @param mixed $data json object
     * @param mixed $heart_rate_id
     * @return bool
     */
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
        $result = $stmt->execute();

        $this->disconnect();

        return $result ? true : false;
    }

}