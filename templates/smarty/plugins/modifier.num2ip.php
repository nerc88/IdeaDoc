<?php
/**
 * Smarty num2ip modifier plugin
 *
 * Type:     modifier<br>
 * Name:     num2ip<br>
 * Purpose:  преобразует ip адрес в формате int в общепринятое обозначение
 * 
 * @param string $string передаваемое в модификатор значение
 * @return string
 */
function smarty_modifier_num2ip($string)
{
	$ipnum = (double)$string;
    $ip     = array(0,0,0,0);
    $index     = 3;
    do
    {
        $mod = $ipnum % 256;
        $mod = ($mod < 0)? 256 + $mod : $mod;
        $ipnum = floor($ipnum/256);
        
        $ip[$index] = $mod;
        $index--;
    }
    while ($ipnum >= 256);
    $ip[$index] =  $ipnum;
    return implode('.', $ip);
}
?>
