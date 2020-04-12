<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

// Create a new controller and Model called “DOSCG”
class DoscgController extends Controller
{
    // X, Y, 5, 9, 15, 23, Z - Please create a new function for finding X, Y, Z value
    public function findXYZ($param) {

        $arr_param = explode(',', $param);

        $arr_default = [
            'X',
            'Y',
            'Z'
        ];

        foreach($arr_param as $key => $param) {
            if (is_numeric(array_search($param, $arr_default))) {
                echo "Found $param in Key $key <br>";
            }
        }
    }

    // If A = 21, A + B = 23, A + C = -21 - Please create a new function for finding B and C value
    public function findBC() {

        $a = 21;

        $b = $this->foundB($a);
        $c = $this->foundC($a);

        return "a = $a, b = $b, c = $c";
    }

    // If A = 21, A + B = 23, A + C = -21 - Please create a new function for finding B and C value
    public function foundB ($a) {

        $b = 23 - $a;
        return $b;
    }

    // If A = 21, A + B = 23, A + C = -21 - Please create a new function for finding B and C value
    public function foundC ($a) {

        $c = -21 - $a;
        return $c;
    }

    // Send Data Final Step from dialog flow to our system.
    public function webhook () {

        $json = file_get_contents('php://input');

        Log::info($json);

        $update_response = file_get_contents("php://input");
        $update = json_decode($update_response, true);
        if (isset($update["queryResult"]["action"]) && $update["queryResult"]["action"] ==  "home.final-question") {
            $this->processMessage($update);

        } else {
            $this->sendMessage(array(
                "source" => $update["responseId"],
                "fulfillmentText" => "Hello from Nut",
                "payload" => array(
                    "items" => [
                        array(
                            "simpleResponse" =>
                                array(
                                    "textToSpeech" => "Bad request"
                                )
                        )
                    ],
                ),

            ));
        }
    }

    // Send Data Final Step from dialog flow to our system.
    function processMessage($update)
    {
        $home_type = $update["queryResult"]["parameters"]["home_type"];
        $budget = $update["queryResult"]["parameters"]["budget"];
        $phone_number = $update["queryResult"]["parameters"]["phone_number"];
        $email = $update["queryResult"]["parameters"]["email"];
        $name = $update["queryResult"]["parameters"]["name"];

        DB::table('leads')->create([
            'home_type' => $home_type,
            'budget' => $budget,
            'phone_number' => $phone_number,
            'email' => $email,
            'name' => $name
        ]);

    }

    function sendMessage($parameters)
    {
        echo json_encode($parameters);
    }
}
