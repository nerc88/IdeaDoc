<?php
include_once('template.config.php');
include('config.php');
include('func.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

// показываем счет онлайн
if (isset($_GET['bid']) && isset($_GET['sig'])) {

	$data_bill = select_all_bills($_GET['bid']); // получаем ID счета, дату счета, ID компании, статус, уникальный хэш-код

	if (empty($data_bill[0]['hash']) || $data_bill[0]['hash']!==$_GET['sig']) {
		echo "Nothing on request!";
		die;
	} else {

		$rows_bill = select_row_by_id_bill($_GET['bid']); // получаем строки счета;
		$company = select_company($data_bill[0]['company_id']); // получаем данные о компании по ID

		// если форма собственности компании — ИП, значит кавычки в названии нам не нужны, а в остальных случаях добавляем кавычки
		if ($company[0]['form_company']=='ИП') {
			$name_company = $company[0]['name_company'];
		} else {
			$name_company = '«'.$company[0]['name_company'].'»';
		}

		// составляем полное наименование компании из формы собственности + названия компании (например, ООО «Идея Пикс»)
		$company  = $company[0]['form_company'].' '.$name_company;

		// складываем общую сумму всех работ
		$all_sum = 0;
		for ($i=0; $i < count($rows_bill) ; $i++) { 
			$all_sum += $rows_bill[$i]['work_sum'];
		}

		// переводит общую сумму в текст
		$sum_text = mb_ucfirst(num2str($all_sum));

		// сумма к оплате. Пока просто равна общей сумме, потом будет зависеть от наличия НДС
		$pay_sum = $all_sum;

	}

}

$title = 'IdeaPix ActDoc';

$Tpl->assign('title', $title);
$Tpl->assign('data_bill', $data_bill);
$Tpl->assign('all_rows', $rows_bill);
$Tpl->assign('company', $company);
$Tpl->assign('all_sum', $all_sum);
$Tpl->assign('pay_sum', $pay_sum);

$Tpl->display('doc.tpl');

?>