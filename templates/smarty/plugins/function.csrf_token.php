<?php
function smarty_function_csrf_token ($params, &$smarty) {
	// имя переменной токена для формы
	if (empty($params['input_name'])) {
		$params['input_name'] = 'f_token';
	}
	
	if (session_id() != "") {
		return '<input type="hidden" '.(!empty($params['input_id']) ? 'id="'.$params['input_id'].'" ' : '').'name="'.$params['input_name'].'" value="'.session_id().'"/>';
	}
	
	return '';
}
?>