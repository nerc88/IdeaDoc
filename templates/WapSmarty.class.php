<?php
/**	Author: 		Arsenichev Sergey (icq: 465745, mailto:pisem@arsenu.net, mailto:ar-sen@mail.ru)
	Date create:	24.03.2007
	Modified:		24.03.2007 3:14
*/
require ('GZSmarty.class.php');

class WapSmarty extends GZSmarty {
	var $accept_wap_version = array('wml', 'xhtml'); // разрешенные версии страниц (допустимые значения html xhtml wml)
	
	function WapSmarty ($accept = null, $params = null) {
		GZSmarty::GZSmarty($params);
		if ($accept !== null) $this->_setAcceptMarkup ($accept);
		$this->_defineMarkup ();
	}
	/** Установка допустимых версий разметки страниц
		@param array $accept - спосок допустимых разметок
	*/
	function _setAcceptMarkup ($accept)
	{
		if (!count($accept) || empty($accept)) trigger_error("Error: Empty incoming parametr WapSmarty::setAcceptMarkup()", E_USER_ERROR);
		$this->accept_wap_version = $accept;
	}
	/** Определение версии разметки страниц и сохранение их в сессию
	*/
	function _defineMarkup ()
	{
		### Определение версии вапа
		if (isset($_GET['xhtml']) && in_array('xhtml', $this->accept_wap_version))
		{
			$_SESSION['wap_version'] = 'xhtml';
		}
		elseif (isset($_GET['wml']) && in_array('wml', $this->accept_wap_version))
		{
			$_SESSION['wap_version'] = 'wml';
		}
		elseif (isset($_GET['html']) && in_array('html', $this->accept_wap_version))
		{
			$_SESSION['wap_version'] = 'html';
		}
		else if (empty($_SESSION['wap_version']) || (!in_array($_SESSION['wap_version'], $this->accept_wap_version))) // если не определена версия или не является допустимой
		{
			if (count($this->accept_wap_version) == 1) // если разрешена только 1 версия то выбираем ее
			{
				$_SESSION['wap_version'] = $this->accept_wap_version[0];
			}
			else
			{
				$mobile_browser = 0;
				if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
				{
				    $mobile_browser++;
				}
				if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']))))
				{
				    $mobile_browser++;
				}
				$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
				$mobile_agents = array(
				    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
				    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
				    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
				    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
				    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
				    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
				    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
				    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
				    'wapr','webc','winw','winw','xda','xda-');


				if(in_array($mobile_ua, $mobile_agents))
				{
				    $mobile_browser++;
				}
				if (strpos(strtolower(@$_SERVER['ALL_HTTP']),'OperaMini')>0)
				{
				    $mobile_browser++;
				}

				if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0)
				{
				    $mobile_browser=0;
				}
				
				if(!$mobile_browser && in_array('html', $this->accept_wap_version))
				{
					$_SESSION['wap_version'] = 'html';
				}
				else
				{
					if (!eregi('html', $_SERVER['HTTP_ACCEPT']) && !eregi('xhtml', $_SERVER['HTTP_ACCEPT']) && !preg_match('/(opera|mozilla|MSIE)/i',$_SERVER["HTTP_USER_AGENT"]) && in_array('wml', $this->accept_wap_version))
					{
						$_SESSION['wap_version'] = 'wml';
					}
					else
					{
						$_SESSION['wap_version'] = 'xhtml';
					}
				}
			}
		}
		
	}
	
	function display ($tpl) {
		GZSmarty::display($_SESSION['wap_version'].'_'.$tpl);
		//GZSmarty::display(( (isset($_SESSION['web']))? 'html_' : 'xhtml_' ).$tpl); //!!!! на время тестов
	}
}
?>