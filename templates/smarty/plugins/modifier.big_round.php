<?php
function smarty_modifier_big_round($number)
{
	if ($number > 1000000) {
        $string = substr($number, 0, (strlen($number) - 5));
        if (strlen($string) > 1) {
            if ($string{strlen($string)-1} == '0') {
                $string = substr($string, 0, (strlen($string) - 1)).' млн.';
            } else {
                $string = substr($string, 0, (strlen($string) - 1)).','.$string{strlen($string)-1}.' млн.';
            }
        }
        return $string;
    } else if ($number > 100000) {
        $string = substr($number, 0, (strlen($number) - 2));
        if (strlen($string) > 1) {
            if ($string{strlen($string)-1} == '0') {
                $string = substr($string, 0, (strlen($string) - 1)).' тыс.';
            } else {
                $string = substr($string, 0, (strlen($string) - 1)).','.$string{strlen($string)-1}.' тыс.';
            }
        }
        return $string;
    } else if ($number > 1000) {
        $string = substr($number, 0, (strlen($number) - 2));
        if (strlen($string) > 1) {
            if ($string{strlen($string)-1} == '0') {
                $string = substr($string, 0, (strlen($string) - 1)).' тыс.';
            } else {
                $string = substr($string, 0, (strlen($string) - 1)).','.$string{strlen($string)-1}.' тыс.';
            }
        }
        return $string;
    } else {
        return $number;
    }    
}
?>