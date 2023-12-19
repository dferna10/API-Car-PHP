<?php
class HeartRateModel extends Conection
{

    private $table = "heart_rate";

    public function insertNewHeartRate($data)
    {
        $sql = "INSERT INTO " . $this->table . "(`date`, `max_heart`, `min_heart`, 
        `average_heart`, `max_time`, `user_id`) VALUES 
        (:date, :max_heart, :min_heart, :average_heart, :max_time, :user_id )";

        $this->connect();
        $connection = $this->getConection();
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":date", $data->date);
        $stmt->bindParam(":max_heart", $data->max_heart);
        $stmt->bindParam(":min_heart", $data->min_heart);
        $stmt->bindParam(":average_heart", $data->average_heart);
        $stmt->bindParam(":max_time", $data->max_time);
        $stmt->bindParam(":user_id", $data->user_id);
        $stmt->execute();
        
        $this->disconnect();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // public function insertNewHeartRate(array $data)
    // {
    //     $sql = "INSERT INTO " . $this->table . "(`date`, `max_heart`, `min_heart`, 
    //     `average_heart`, `max_time`, `dream_hours`, `bed_time`, 
    //     `getup_time`, `position`, `user_id`) VALUES" .
    //     "(:date, :max_heart, :min_heart, :avergage_heart, :max_time, :dream_hours, :bed_time,
    //      :getup_time, :position, :user_id )";
    //     $this->connect();
    //     $connection = $this->getConection();
    //     $stmt = $connection->prepare($sql);
    //     $stmt->bindParam(":date", $data->date);
    //     $stmt->bindParam(":max_heart", $data->max_heart);
    //     $stmt->bindParam(":min_heart", $data->min_heart);
    //     $stmt->bindParam(":average_heart", $data->average_heart);
    //     $stmt->bindParam(":max_time", $data->max_time);
    //     $stmt->bindParam(":dream_hours", $data->dream_hours);
    //     $stmt->bindParam(":bed_time", $data->bed_time);
    //     $stmt->bindParam(":getup_time", $data->getup_time);
    //     $stmt->bindParam(":position", $data->position);
    //     $stmt->bindParam(":user_id", $data->user_id);

    //     $this->disconnect();

    //     return $stmt->execute();
    // }
}