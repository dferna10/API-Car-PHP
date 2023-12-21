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
                    $heart_rate_id = $heartRate->getLastRegisterId($data->heart_rate->user_id);
                    $heart_rate_id = $heart_rate_id[0];
                    $hearRateMeasure = new HeartRateMeasuresModel();
                    foreach ($data->heart_rate_measures as $measure) {
                        
                        $result = $hearRateMeasure->insertNewMeasure($measure, $heart_rate_id->heart_rate_id);
                        // Comprobar si se añaden, y sino saltar error
                        if(!$result){
                            $heartRate->removeRegister($heart_rate_id->heart_rate_id);
                            $strErrorDesc = "Problemas para añadir los datos. Intentelo de nuevo.";
                            break;
                        }
                    }
                    // Posibilidad de añadir el cuestionario
                    if(!$strErrorDesc){
                        // Añadir el cuestionario
                        $questionary = new QuestionaryModel();
                        $result = $questionary->insertNewQuestionary($data->questionary, $heart_rate_id->heart_rate_id);
                        if(!$result){
                            $heartRate->removeRegister($heart_rate_id->heart_rate_id);
                            $strErrorDesc = "Problemas para añadir los datos. Intentelo de nuevo.";
                        }
                    }

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
                $strErrorDesc = $e->getMessage() . " ". $e->getLine() .  ' \n Something went wrong! Please contact support.';
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