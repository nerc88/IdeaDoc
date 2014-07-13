<?php
/**
 * Smarty jstimestamp modifier plugin
 *
 * Type:     modifier<br>
 * Name:     jstimestamp<br>
 * Purpose:  Получение временной метки для javascript
 * 
 * @param string $string строка даты времени
 * @return string
 */
function smarty_modifier_jstimestamp ($string)
{
    return strtotime($string)*1000;
}
?>
