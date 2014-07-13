<?php
/** CLASS GZSmarty
	Author: 		Arsenichev Sergey (icq: 465745, mailto:ar-sen@mail.ru)
	Date create:	09.07.2007
	Modified:		17.08.2009 0:56
	*************************
	Класс GZSmarty v2.0
	*************************
	Changelog
	v1.1 	добавлена функция добавления ошиьок на страницу addError(), addMessage(), addSessionMessage()
			добавленны константы в шаблоне SESSION_NAME и SID
	v1.2	Исправлен механизм подстановки SID к ссылкам, добавлен парамерт transSid полностью аналогичный работе session.trans_sid
*/
require ('smarty/Smarty.class.php');

class GZSmarty extends Smarty {
	public $useGZip = false; // включение компрессии
	public $stripWhiteSpaces = true; // включение удаления лишних символов
	public $gzLevel = 6; // уровень сжатия от 1 - 9
	public $start_time;
	public $encodingType;
	public $transSid = true; // трансляция SID в URL
	
	public $errors = array(); // ошибки страницы
	public $messages = array(); // сообщения страницы
	
	/** Конструктор класса
	*/
	function __construct ($pamams = null) {
		$this->start_time = $this->curTime();
		parent::Smarty($pamams);
	}
	/** Текущее время исполнения
	*/
	private function curTime () {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	/** Фильтр - удаление лишних символов
	*/
	private function stripWhiteSpaces ($buffer) {
	  	return preg_replace('#[\r\n \t]+#i', ' ', $buffer);
	}
	/** Подстановка SID
	*/
	private function urlReWrite ($buffer) {
  		$search = array(
	        '/(\<a[^\>]+)href=["](?!javascript:)([^"?]+\?[^"?]*)["]/i',
	        '/(\<a[^\>]+)href=["](?!javascript:)([^"?]+)["]/i'
	        );
	    $replace = array(
	    	'\\1href="\\2&amp;'.session_name().'='.session_id().'"',
	        '\\1href="\\2?'.session_name().'='.session_id().'"'
	        );
  		return preg_replace($search, $replace, $buffer);
	}
	/** Фильтр - Компрессия страницы GZip
	*/
	private function gz_compress($buffer) {
		if (session_id() && $this->transSid) {
	  		$buffer = $this->urlReWrite ($buffer);
	  	}
		// временная заглушка
		//$size_before = strlen($buffer);//round(strlen($buffer) / 1024, 2);
	    //$size_after = $size_before / 3;//round($size_before / 3, 2);//round(strlen(gzencode($buffer, $this->gzLevel))/1024, 2);
	    //$buffer = str_replace('#GZ_SIZE_BEFORE#', round($size_before / 1024, 2), $buffer);
	    //$buffer = str_replace('#GZ_SIZE_AFTER#', round($size_after / 1024, 2), $buffer);
	    // степень сжатия
	    //$compression = $size_before ? round($size_after / $size_before * 100, 1) : 0;
	    //$buffer = str_replace('#GZ_COMPRESS#', $compression, $buffer);
	    
	    header("Content-Encoding: ".$this->encodingType);
	    //header("Content-Length: ".strlen());
	    return gzencode($buffer, $this->gzLevel);
	}
	/** Проверка поддержки сжатия
		возвращает поддерживаемый тип, в случае не поддержки false
	*/
	private function supportGZip () {
		// если не поддерживаем сжатие то возвращаем немодиф код
	    $encoding = '';
	    $encoding = strpos(@$_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false ? 'gzip' : false;
	    $encoding = strpos(@$_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false ? 'x-gzip' : $encoding;
	    
	    return $encoding;
	}
	/** Добавление ошибок на страницу
		@param string $error - текст ошибки
	*/
	public function addError($error) {
		$this->errors[] = $error;
	}
	/**	Добавление массива ошибок
		@param array $errors
	*/
	public function addErrors (Array $errors, $save_keys=false) {
		if (!$save_keys) {
			$errors = array_values($errors);
		}
		$this->errors = array_merge($this->errors, $errors);
	}
		/** Добавление сообщений на страницу
		@param string $messages - текст сообщения
	*/
	public function addMessage($messages) {
		$this->messages[] = $messages;
	}
	/**	Добавление массива сообщений
		@param array $messages
	*/
	public function addMessages (Array $messages) {
		$this->messages = array_merge($this->messages, array_values($messages));
	}
	/** Добавление сообщения посредством сохранения в сессии
	*/
	public function addSessionMessage($messages) {
		@$_SESSION['gzSmarty']['messages'][] = $messages;
		return true;
	}
	public function addSessionMessages(Array $messages) {
		$_SESSION['gzSmarty']['messages'] = array_merge((array)@$_SESSION['gzSmarty']['messages'], array_values($messages));
	}
	/** Добавление сообщения об ошибке посредством сохранения в сессии
	*/
	public function addSessionError($error) {
		$this->errors[] = $error;
		@$_SESSION['gzSmarty']['errors'][] = $error;
		return true;
	}
	public function addSessionErrors(Array $errors) {
		$_SESSION['gzSmarty']['errors'] = array_merge((array)@$_SESSION['gzSmarty']['errors'], array_values($errors));
	}
	/** Чтение сообщений из сессии
	*/
	public function readSessionMessages() {
		if (is_array(@$_SESSION['gzSmarty']['messages']) && count($_SESSION['gzSmarty']['messages'])) {
			$this->messages = array_merge($this->messages, $_SESSION['gzSmarty']['messages']);
			unset($_SESSION['gzSmarty']['messages']);
		}
		if (is_array(@$_SESSION['gzSmarty']['errors']) && count($_SESSION['gzSmarty']['errors']))  {
			$this->errors = array_merge($this->errors,$_SESSION['gzSmarty']['errors']);
			unset($_SESSION['gzSmarty']['errors']);
		}
		return true;
	}
	public function redirect ($url) {
		header('Location: '.$url);
		exit();
	}
	/** Вывод шаблона
	*/
	public function display ($tpl) {
		// если включенно сжатие то проверяем какой тип поддерживается
		if ($this->useGZip) {
			$this->encodingType = $this->supportGZip();
			if ($this->encodingType === false) $this->useGZip = false; // если сжатие не поддерживается, отключаем его
		}
		
		$this->assign(
		array(
			'RAND' 			=> rand(0, 9999),
			'SCRIPT_TIME' 	=> round($this->curTime() - $this->start_time, 4),
			'SESSION_NAME' 	=> session_name(),
			'SESSION_ID' 	=> session_id(),
			'SID' 			=> session_name().'='.session_id(),
			'USE_GZIP'		=> $this->useGZip,
			'MESSAGES'		=> $this->messages,
			'ERRORS'		=> $this->errors,
			'ERRORS_HAS_KEY' => (array_keys($this->errors) !== range(0, count($this->errors) - 1))
		));
		
		// данные шаблона
		$display_data = $this->fetch($tpl);
		
		// удаление пробелов
		if ($this->stripWhiteSpaces) {
			$display_data = $this->stripWhiteSpaces($display_data);
		}
		// сжатие страницы
		if ($this->useGZip){ 
			$display_data = $this->gz_compress($display_data);
		}
		//print_r(apache_response_headers());
		// вывод страницы
		echo $display_data;
	}
}
?>