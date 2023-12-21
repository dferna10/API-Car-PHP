<?php
class HeartRateModel extends Conection
{

    private $table = "heart_rate";

    /**
     * Function to insert new heart rate test
     *
     * @param mixed $data json object with all data
     * @return bool
     */
    public function insertNewHeartRate($data)
    {
        $sql = "INSERT INTO " . $this->table . " (`date`, `max_heart`, `min_heart`, 
        `average_heart`, `max_time`, `init_timestamp`, `user_id`) VALUES 
        (:date, :max_heart, :min_heart, :average_heart, :max_time, :init_timestamp, :user_id )";

        $this->connect();
        $connection = $this->getConection();
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":date", $data->date);
        $stmt->bindParam(":max_heart", $data->max_heart);
        $stmt->bindParam(":min_heart", $data->min_heart);
        $stmt->bindParam(":average_heart", $data->average_heart);
        $stmt->bindParam(":max_time", $data->max_time);
        $stmt->bindParam(":init_timestamp", $data->init_timestamp);
        $stmt->bindParam(":user_id", $data->user_id);
        $result = $stmt->execute();

        $this->disconnect();

        return $result ? true : false;
    }

    /**
     * Function to get the last id register by user
     *
     * @param mixed $user_id
     * @return array
     */
    public function getLastRegisterId($user_id)
    {
        $sql = "SELECT heart_rate_id FROM " . $this->table . " 
        WHERE user_id = :user_id ORDER BY heart_rate_id DESC";

        $this->connect();
        $connection = $this->getConection();
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        $this->disconnect();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Function to remove a register from  db
     *
     * @param mixed $heart_rate_id
     * @return bool
     */
    public function removeRegister($heart_rate_id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE heart_rate_id = :heart_rate_id";
        $this->connect();
        $connection = $this->getConection();
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":heart_rate_id", $heart_rate_id);
        $result = $stmt->execute();

        $this->disconnect();

        return $result ? true : false;
    }
}