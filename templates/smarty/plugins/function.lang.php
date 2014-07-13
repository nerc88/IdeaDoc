<?php
/*
* Smarty plugin
* -------------------------------------------------------------
* File:     function.lang.php
* Type:     function
* Name:     lang
* Purpose:  В зависимости от выбранного языка в сессии, выдает нужную строку
* Author:	Arsenichev Sergey
* ICQ#		465-745
* email: 	ar-sen@mail.ru , s.arsenichev@protechs.ru
* project:  http://smsrent.ru
* -------------------------------------------------------------
*/

function smarty_function_lang ($params, &$smarty) {
	// язык по умолчанию
	if (empty($params['default'])) {
		$default_lang = 'rus';
	} else {
		$default_lang = $params['default'];
		unset($params['default']);
	}
	
	if (count($params) == 1) {
		return current($params);
	}
	
    // проверка выбранного языка
    if (empty($_SESSION['lang']) || !array_key_exists($_SESSION['lang'], $params)) {
    	return $params[$default_lang];
    }
    
    return $params[$_SESSION['lang']];
}

?>