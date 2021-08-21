<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtcController extends Controller
{
    private $maxLength = 4;

    public function index(Request $request)
    {
        extract($request->all());

        if(!isset($x) || !isset($y)) {
            echo 'please use correct url parameters';
            exit;
        }

        if (!is_numeric($x) || !is_numeric($y)) {
            echo 'please use integers';
            exit;
        }

        //convert to binary
        $string1 = decbin($x);
        $string2 = decbin($y);

        // format length of both strings to make sure they are the same length
        $string1 = str_pad($string1,max(strlen($string2), strlen($string1)),'0', STR_PAD_LEFT);
        $string2 = str_pad($string2,max(strlen($string2), strlen($string1)),'0', STR_PAD_LEFT);
        
        $hammingDistance = count(
            array_diff_assoc(
                str_split($string1),
                str_split($string2)
            )
        );
        echo 'Input: x = '.$x.', y = '.$y.'<br />';
        echo 'Output: '.$hammingDistance.'<br /><br />';

        echo $x.' ('.$string1.')<br />';
        echo $y.' ('.$string2.')';
    }

    public function second(Request $request)
    {
        extract($request->all());

        if(!isset($x) || !isset($y)) {
            echo 'please use correct url parameters';
            exit;
        }

        if (!is_numeric($x) || !is_numeric($y)) {
            echo 'please use integers';
            exit;
        }
        
        $string1 = decbin($x);
        $string2 = decbin($y);

        $this->maxLength = max(max(strlen($string1), strlen($string2)), $this->maxLength);
        $formattedFirstNum = $this->formatToMaxLength($string1);
        $formattedSecondNum = $this->formatToMaxLength($string2);
        $hammingDistance = 0;

        $errorKeys = [];
        for ($a = 0; $a < $this->maxLength; $a++) {
            if ($formattedFirstNum[$a] != $formattedSecondNum[$a]) {
                $hammingDistance++;
                $errorKeys[] = $a;
            }
        }

        echo 'Input: x = '.$x.', y = '.$y.'<br />';
        echo 'Output: '.$hammingDistance.'<br /><br />';

        echo '<table><tr><td>'.$x.'</td><td>(</td>';
        foreach(str_split($formattedFirstNum) AS $a) {
            echo '<td>'.$a.'</td>';
        }
        echo '<td>)</td></tr>';
        echo '<tr><td>'.$y.'</td><td>(</td>';
        foreach(str_split($formattedSecondNum) AS $a) {
            echo '<td>'.$a.'</td>';
        }
        echo '<td>)</td></tr>';
        echo '<tr><td></td><td></td>';
        echo '<tr><td></td><td></td>';
        for($a = 0; $a < $this->maxLength; $a++) {
            echo '<td>';
            if(in_array($a, $errorKeys)) {
                echo '&#8593;';
            }
            echo '</td>';
        }
        echo '<td></td></tr>';
        echo '</table>';
    }

    private function formatToMaxLength($value)
    {
        while (strlen($value) < $this->maxLength) {
            $value = '0' . $value;
        }
        return $value;
    }

}
