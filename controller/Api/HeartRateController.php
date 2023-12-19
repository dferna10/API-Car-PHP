<?php

class HeartRateController extends BaseController
{


    /** *****************************************************
     *                  GET  ACTIONS                        *
     ****************************************************** */


    /** *****************************************************
     *                  POST  ACTIONS                       *
     ****************************************************** */

     /**
      * Function to create a new register in heart rate and heart reate meaures
      * /heart-rate/new and post action
      */
    public function post_new_action($data)
    {
        $strErrorDesc = '';
        if (isset($data->heart_rate_measures) && isset($data->heart_rate)) {
            try {
                $heartRate = new HeartRateModel();
                $heartRegister = $heartRate->insertNewHeartRate($data->heart_rate);
                if($heartRegister){
                    $heartRateId = $heartRegister->heart_rate_id;
                    $hearRateMeasure = new HeartRateMeasuresModel();
                    foreach ($data->heart_rate_measures as $measure) {
                        $hearRateMeasure->insertNewMeasure($data->heart_rate_measures, $heartRateId);
                    }
                    // Posibilidad de añadir el cuestionario
                    $responseData = array(
                        "status" => "success",
                        "message" => "Todos los datos de la medición han sido registrados",
                    );
                    $responseData = json_encode($responseData);
                }
                else{
                    $responseData = array(
                        "status" => "error",
                        "message"=> "Hemos tenido problemas para registrar los datos."
                    );
                }
            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage() . ' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = "We don't have request data";
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }

        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}
?>