<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty declension modifier plugin
 *
 * Type:     modifier<br>
 * Name:     declension<br>
 * Purpose:  Подставляет окончания для склонений
 * @author   Arsenichev Sergey (ar-sen@mail.ru, ICQ 465-745)
 
 * @param integer число по которому происходит склонение
 * @param string сторока корень слова
 * @param string окончание 1
 * @param string окончание 2
 * @param string окончание 3
 
 * @return string
 */
function smarty_modifier_declension($num, $string, $end1='', $end2='а', $end3='ов')
{
	$num100 = $num % 100;
    if (($num >= 10 && $num <=20) || ($num100 >= 10 && $num100 <=20)) {
		$letter = $end3;
	} else {
		switch ($num%10) {
			case 1:
			$letter = $end1;
				break;
			case 2:
			case 3:
			case 4:
			$letter = $end2;
				break;
			default:
			$letter = $end3;
		}
	}
	return $string.$letter;
}

/* vim: set expandtab: */

?>
