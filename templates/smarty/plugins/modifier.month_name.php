<?php
/**
 * Smarty country_name modifier plugin
 *
 * Type:     modifier<br>
 * Name:     month_name<br>
 * Purpose:  Возвращает имя месяца по  индексу
 * 
 * @param string $code индекс месяца
 * @param int $default значение если месяц не найден
 * @return string
 */
function smarty_modifier_month_name($code, $lang='rus', $default=null)
{
	$code = intval($code);
	$monthEngNames = array(
		1 => 'January', 'February', 'March', 'April', 'May', 'June', 'Jule', 'August' ,'September' ,'October', 'November' , 'December'
	);
    $monthNames    = array(
        1 => 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
    );
    $monthNames2    = array(
        1 => 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'
    );
    $default = ($default === null) ? $code : $default;
    if ($lang=='eng') {
    	return (array_key_exists($code, $monthEngNames)) ? $monthEngNames[$code] : $default;
    } elseif ($lang=='rus2') {
    	return (array_key_exists($code, $monthNames2)) ? $monthNames2[$code] : $default;
    }
    return (array_key_exists($code, $monthNames)) ? $monthNames[$code] : $default;
}
?>
