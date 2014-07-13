<?php
/**
 * Smarty round modifier plugin
 *
 * Type:     modifier<br>
 * Name:     round<br>
 * Purpose:  округляет дробное числоо до заданной точности
 * 
 * @param string $string передаваемое в модификатор значение
 * @param int $precision точность округления
 * @return string
 */
function smarty_modifier_round($string, $precision=2)
{
    return number_format($string, $precision, '.', '');
}
?>
