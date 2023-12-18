<?php
class UserController extends BaseController
{

    /** *****************************************************
     *                  GET  USERS ACTIONS                  *
     ****************************************************** */
    /** 
     * "/user/list" Endpoint - Get list of users 
     */
    public function get_list_action()
    {
        $strErrorDesc = '';
        // $requestMethod = $_SERVER["REQUEST_METHOD"];
        // $arrQueryStringParams = $this->getQueryStringParams();
        // if (strtoupper($requestMethod) == 'GET') {
        try {
            $userModel = new UserModel();

            $arrUsers = $userModel->getUsersList();
            $responseData = json_encode($arrUsers);
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        // } else {
        //     $strErrorDesc = 'Method not supported';
        //     $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        // }
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

    /** *****************************************************
     *                  POST  USERS ACTIONS                 *
     ****************************************************** */

    public function post_login_action($post_data)
    {
        $strErrorDesc = '';
        if (isset($post_data["username"]) && isset($post_data["password"])) {
            try {
                $userModel = new UserModel();

                $user = $userModel->getUserByUsername($post_data["username"]);
                if ( password_verify(htmlspecialchars($post_data['password']), $user->password)) {
                    $responseData = array(
                        "verified" => "verified",
                        "user_id" => $user->user_id,
                        "username" => $user->username,
                        "name" => $user->name,
                        "surname"  => $user->surname,
                        "email"=> $user->email,
                        "birthdate" => $user->birthdate
                    );
                }
                else{
                    $responseData = array(
                        "verified" => "error",
                        "user_id" => $user->user_id,
                        "username" => $user->username,
                        "name" => $user->name,
                        "surname"  => $user->surname,
                        "email"=> $user->email,
                        "birthdate" => $user->birthdate
                    );
                }
                $responseData = json_encode($responseData);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = "We need don't have request data";
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