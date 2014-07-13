<?php
mb_internal_encoding("UTF-8");

function gen_pdf_bill($html){

	$num = rand(100, 5);

	include("mPDF/mpdf.php");

	$mpdf = new mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
	$mpdf->charset_in = 'utf-8'; /*не забываем про русский*/

	$stylesheet = file_get_contents('css/bill_style.css'); /*подключаем css*/
	$mpdf->WriteHTML($stylesheet, 1);

	$mpdf->list_indent_first_level = 0; 
	$mpdf->WriteHTML($html, 2); /*формируем pdf*/
	$mpdf->Output('upload/mpdf.pdf', 'I');

}


/**
* Добавляем созданный счет в БД
*/
function add_new_bill($date_bill, $company_name, $status, $row_arr){
	$sql_cid = "SELECT `id_company` FROM `company` WHERE `name_company`='$company_name'";
	$result_cid = mysql_query($sql_cid);
	$cid = mysql_fetch_assoc($result_cid);
	$company_id = $cid['id_company'];
	$hash = md5($company_id.mktime().'dzhigurda_salt');
	
	$date_bill = date("Y-m-d", strtotime($date_bill));
	

	$sql="INSERT INTO `bills` (`date_bill`, `company_id`, `status`, `hash`) VALUES ('$date_bill', '$company_id', '$status', '$hash')";
	$result = mysql_query($sql);

	$bill_id = mysql_insert_id();

	$i = 1;
	while (!empty($row_arr[$i])) {
		add_new_row_bill($bill_id, $row_arr[$i]['work_name'], $row_arr[$i]['work_items'], $row_arr[$i]['work_count'], $row_arr[$i]['work_price'], $row_arr[$i]['sum']);
		$i++;
	}
	
	
}

/**
* Добавляем строку счета в соответствующую таблицу БД
*/
function add_new_row_bill($bill_id, $work_name, $work_items, $work_count, $work_price, $work_sum){
	$sql="INSERT INTO `bills_row` (`bill_id`, `work_name`, `work_items`, `work_count`, `work_price`, `work_sum`) VALUES ('$bill_id', '$work_name', '$work_items', '$work_count', '$work_price', '$work_sum')";
	$result = mysql_query($sql);
}

/**
* Выбираем все данные о счете, кроме строк счета
*/
function get_data_bill($id_bill){
	$sql = "SELECT * FROM `bills` WHERE `id_bill`='$id_bill'";
	$result = mysql_query($sql);

	$data_bill = mysql_fetch_assoc($result);

	return $data_bill;
}

/**
* Выбираем строки счета по ID счета
*/
function select_row_by_id_bill($id_bill){
	$sql = "SELECT * FROM `bills_row` WHERE `bill_id`='$id_bill' ORDER BY `id_bills_row`";
	$result = mysql_query($sql);

	$all_rows = array();
	while ($res = mysql_fetch_assoc($result)) {
		$all_rows[] = $res;
	}

	return $all_rows;
}

/**
* Выбираем номер последнего счета
*/
function select_last_bill(){
	$sql_last = "SELECT `id_bill` FROM `bills` ORDER BY `id_bill` DESC LIMIT 1";
	$result_last = mysql_query($sql_last);
	$last_num = mysql_fetch_assoc($result_last);
	$last_num_bill = $last_num['id_bill'];

	return $last_num_bill;
}

/**
* Выбираем все счета
*/
function select_all_bills($id_bill=''){
	if (!empty($id_bill)) {
		$sql_all = "SELECT * FROM `bills` WHERE `id_bill`='$id_bill' ORDER BY `id_bill` DESC";
	} else {
		$sql_all = "SELECT * FROM `bills` ORDER BY `id_bill` DESC";
	}
	
	$result_all = mysql_query($sql_all);

	$i=0;
	while ($res = mysql_fetch_assoc($result_all)) {

		$id_bill = $res['id_bill'];

		$date_from_database = $res['date_bill'];
		$date = date("d/m/Y", strtotime($date_from_database));

		$company = select_company($res['company_id'], '');

		$sql_sum = "SELECT SUM(work_sum) FROM `bills_row` WHERE `bill_id`='$id_bill'";
		$result_sum = mysql_query($sql_sum);
		$sum = mysql_fetch_array($result_sum);
		// разделяем сумму на тысячные разряды, чтобы было не "123456", а "123 456"
		$sum = number_format($sum[0],0,'',' ');

		$all_bills[] = array(
			'id_bill' => $id_bill,
			'date_bill' => $date,
			'company_id' => $res['company_id'],
			'company_name' => $company[$i]['name_company'],
			'sum_bill' => $sum,
			'status' => $res['status'],
			'hash' => $res['hash']

		);
	}

	return $all_bills;
}

/**
* Изменяем статус счета
*/
function status_bill($id_bill, $status){
	$sql = "UPDATE `bills` SET `status`='$status' WHERE `id_bill`='$id_bill'";
	$result = mysql_query($sql);

	return true;
}

/**
* Добавляем новую компанию
*/
function add_new_company($form_company, $name_company, $address, $inn, $kpp, $r_schet, $cor_schet, $bank, $bik){
	$sql="INSERT INTO `company` (`form_company`, `name_company`, `address`, `inn`, `kpp`, `r_schet`, `cor_schet`, `bank`, `bik`) VALUES ('$form_company', '$name_company', '$address', '$inn', '$kpp', '$r_schet', '$cor_schet', '$bank', '$bik')";
	$result = mysql_query($sql);

	return true;
}

/**
* Выбираем все организации по типу или по ID
*/
function select_company($id_company='', $form_company=''){
	if (!empty($id_company)) {
		$sql = "SELECT * FROM `company` WHERE `id_company`='$id_company' ORDER BY `id_company`";
	} elseif (!empty($form_company)) {
		$sql = "SELECT * FROM `company` WHERE `form_company`='$form_company' ORDER BY `id_company`";
	} else {
		return false;
	}
	
	$result = mysql_query($sql);

	$all_company = array();
	while ($res = mysql_fetch_assoc($result)) {
		$all_company[] = $res;
	}

	return $all_company;
}


/**
 * Возвращает сумму прописью
 */
function num2str($num) {
	$nul='ноль';
	$ten=array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	);
	$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	$unit=array( // Units
		array('копейка' ,'копейки' ,'копеек',	 1),
		array('рубль'   ,'рубля'   ,'рублей'    ,0),
		array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
		array('миллион' ,'миллиона','миллионов' ,0),
		array('миллиард','милиарда','миллиардов',0),
	);
	//
	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
			if (!intval($v)) continue;
			$uk = sizeof($unit)-$uk-1; // unit key
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
			// mega-logic
			$out[] = $hundred[$i1]; # 1xx-9xx
			if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
			else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
			// units without rub & kop
			if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		} //foreach
	}
	else $out[] = $nul;
	$out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n>10 && $n<20) return $f5;
	$n = $n % 10;
	if ($n>1 && $n<5) return $f2;
	if ($n==1) return $f1;
	return $f5;
}

function mb_ucfirst($text) {
	return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}

?>