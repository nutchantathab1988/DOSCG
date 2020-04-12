<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
