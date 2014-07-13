<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_page_control} function plugin
 *
 * Type:     function<br>
 * Name:     html_page_control<br>
 * Author: 	 ArseN ICQ: 465-745 (mailto:pisem@arsenu.net) <br>
 * Input:<br>
 * $params['count']  - суммарное количество всех элементов
 * $params['page'] - номер текущей страницы
 * $params['pageSize'] - кодличество элементов на страницу
 * $params['pageLink'] - ссылка для навигации
 * $params['delimer'] - разделитель страниц
 * $params['urlDelimer'] - разделитель параметров в ссылке для навигации
 * $params['oneLine'] - включение режима одно линейной навигации
 * $params['pageSizer'] - включение выбора количества элементов на страницу (параметр get p_size=)
 */
function smarty_function_html_page_control($params, &$smarty) {
	// проверка переменных
	if ($params['count'] == '' || $params['page']=='' || $params['pageSize']=='' || $params['pageLink']=='') { return null; }
	if (!isset($params['delimer'])) {
		$params['delimer'] = ' ';
	}
	if (!isset($params['urlDelimer'])) {
		$params['urlDelimer'] = '&amp;';
	}
	if (!isset($params['oneLine'])) {
		$params['oneLine'] = false;
	}
	if (!isset($params['pageSizer'])) {
		$params['pageSizer'] = false;
	}
	### размер всего текста и максим страница
	$max_page 	 = ceil($params['count'] / $params['pageSize']);

	### проверка правильности страницы
	$params['page'] = ($params['page'] > $max_page)? $max_page : $params['page'];
	$params['page'] = ($params['page'] < 1)? 1 : $params['page'];

	### начало и конец вывода
	$start = ($params['page'] - 1) * $params['pageSize'];

	### Формипуем массив страниц для навигации
	$pages = array();
	if ($max_page > 6)
	{
		for ($i = 1; $i <= 3; $i++)
			$pages[] = $i;
		
		if ($params['page'] > 5) $pages[] = -1;
		
		for ($i = $params['page']-1; $i <= $params['page']+1; $i++)
			if ($i > 3 && $i < $max_page - 2)
				$pages[] = $i;
		
		if ($params['page'] < $max_page - 4) $pages[] = -1;
		
		for ($i = $max_page - 2; $i <= $max_page; $i++)
			$pages[] = $i;
	}
	elseif ($max_page > 1)
	{
		for ($i = 1; $i <= $max_page; $i++)
			$pages[] = $i;
	}
	
	if (strpos($params['pageLink'], '?') === false) {
		$params['pageLink'] .= '?p=';
	} else {
		$params['pageLink'] .= $params['urlDelimer'].'p=';
	}
	// сборка шаблона 
	$page_string = '';
	if ($max_page > 1) {
		if (!$params['oneLine']) {
			$page_string .= '<div class="smarty_navigator">';
			if ($params['page'] > 1) {
				$page_string .= '&#8592;&nbsp;<a href="'.$params['pageLink'].($params['page']-1).'">сюда</a> |';
			} else {
				$page_string .= '&#8592;&nbsp;сюда |';
			}
			//$page_string .= ' | стр.<b>'.$params['page'].'</b> из '.$max_page.' | ';
			if ($params['page'] < $max_page) {
				$page_string .= ' <a href="'.$params['pageLink'].($params['page']+1).'">туда</a>&nbsp;&#8594;<br/>';
			} else {
				$page_string .= ' туда&nbsp;&#8594;<br/>';
			}
			$page_string .= '</div>';
		}
		// вывод страничек
		$count_pages_array = count($pages);
		$page_string .= '<div class="smarty_pages">';
		for ($i=0; $i<$count_pages_array; $i++){
			if ($pages[$i] == -1) {
				$page_string .= '...';
			} else {
				if ($pages[$i] != $params['page']) {
					$page_string .= '<a href="'.$params['pageLink'].$pages[$i].(intval(@$_GET['p_size']) > 0 ? '&p_size='.intval(@$_GET['p_size']) : '').'">'.$pages[$i].'</a>';
				} else {
					$page_string .= '<b>'.$pages[$i].'</b>';
				}
			}
			if ($pages[$i] != $max_page) {
				$page_string .= $params['delimer'];
			}
		}
		// пайдж сайзер
		if ($params['pageSizer']) {
			if (!empty($_GET['p_size']) && intval($_GET['p_size']) > 0) {
				$params['pageSize'] = $params['pageSize'] / intval($_GET['p_size']);
			}
			$page_string .= '<span style="float:right;" class="smarty_page_sizer">На страницу: <select onChange="document.location=\''.$params['pageLink'].'1&p_size=\'+this.value;" id="smarty_page_sizer">';
			for ($i=1; $i<=10; $i++) {
				$page_string .= '<option value="'.$i.'"'.(@$_GET['p_size']==$i ? ' selected="selected"' : '').'>'.($i*$params['pageSize']).'</option>';
			}
			$page_string .= '</select></span>';
		}
		$page_string .= '</div>';
	}
	return $page_string;
}
?>
