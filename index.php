<?php
include_once('template.config.php');
include('config.php');
include('func.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$all_bills = select_all_bills();

if (isset($_POST['status_bill'])) {
	$status_bill = status_bill($_POST['id_bill'], $_POST['new_status']);
	die;
}

if (isset($_GET['do'])) {

	$data_bill = select_all_bills($_GET['id_bill']); // получаем ID счета, дату счета, ID компании, статус, уникальный хэш-код
	$rows_bill = select_row_by_id_bill($_GET['id_bill']); // получаем строки счета;
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

	// -------------------- Start PDF ---------------------
	if ($_GET['do']=='pdf') {

		// создаем переменную $html, на основе которой будет сформирован PDF
		$html = '
			<table class="header_block">
				<tr>
					<td>
						<b>Интерактивное агентство «Идея Пикс»</b>
						<br>
						241013, г.Брянск, ул.Ульянова, 103, оф.9
						<br>
						Телефон: +7 (915) 8000-300
						<br>
						Сайт: <a href="#">www.ideapix.ru</a>
					</td>
					<td style="text-align: right;">
						<img src="img/ideapix_logo.png" alt="">
					</td>
				</tr>
			</table>

			<table border="0" cellspacing="0" class="example">
				<tbody>
					<tr>
						<td><span class="soft_grey">ИНН </span>325400209102</td>
						<td><span class="soft_grey">КПП </span></td>
						<td rowspan="2"><span class="soft_grey">Сч. №</span></td>
						<td rowspan="2">408028106106600048484</td>
					</tr>
					<tr>
						<td colspan="2"><span class="soft_grey">Получатель</span><br>ИП Степанов Александр Александрович</td>
					</tr>
					<tr>
						<td colspan="2" rowspan="2"><span class="soft_grey">Банк Получателя</span><br>ФИЛИАЛ №3652 ВТБ 24 (ЗАО) Г. ВОРОНЕЖ</td>
						<td><span class="soft_grey">БИК</span></td>
						<td>042007738</td>
					</tr>
					<tr>
						<td><span class="soft_grey">Сч. №</span></td>
						<td>30101810100000000738</td>
					</tr>
				</tbody>
			</table>

			<h1>СЧЕТ №'.$data_bill[0]['id_bill'].' от '.$data_bill[0]['date_bill'].'</h1>
			<p><span class="soft_grey">Плательщик:</span> <b>'.$company.'</b>
			<br>
			<span class="soft_grey">Получатель:</span> <b>ИП Степанов А. А.</b></p>

			<table class="schet">
				<thead>
					<tr>
						<th scope="col">№</th>
						<th scope="col">Наименование товара, работ, услуг</th>
						<th scope="col">Ед. изм.</th>
						<th scope="col">Кол-во</th>
						<th scope="col">Цена</th>
						<th scope="col">Сумма</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="4"></td>
						<td class="cell-border">Итого:</td>
						<td class="cell-border">'.$all_sum.'</td>
					</tr>
					<tr>
						<td colspan="4"></td>
						<td class="cell-border">Без налога (НДС):</td>
						<td class="cell-border">—</td>
					</tr>
					<tr>
						<td colspan="4"></td>
						<td class="cell-border"><b>Всего к оплате:</b></td>
						<td class="cell-border"><b>'.$pay_sum.'</b></td>
					</tr>
				</tfoot>
				<tbody>';

						$i = 0;
						while (!empty($rows_bill[$i]['work_name'])) { 
							$html = $html.'
							<tr>
							<td>'.($i+1).'</td>
							<td>'.$rows_bill[$i]['work_name'].'</td>
							<td>'.$rows_bill[$i]['work_items'].'</td>
							<td>'.$rows_bill[$i]['work_count'].'</td>
							<td>'.$rows_bill[$i]['work_price'].'</td>
							<td>'.$rows_bill[$i]['work_sum'].'</td>
							</tr>';
							$i++;
						}

				$html = $html.'
				</tbody>
			</table>

			<p>Всего наименований '.count($rows_bill).', на сумму '.$all_sum.' руб.</p>
			<p><b>'.$sum_text.'</b></p>

			<br /><br /><br /><br /><br />

			<img src="img/stamp.jpg" style="margin-left: 50px;">

			<table style="margin-top: -165px;">
				<tr>
					<td colspan="2">
						Руководитель предприятия _______________ (Степанов А. А.)</td>
				</tr>
				<tr>
					<td colspan="2" style="height: 30px;"></td>
				</tr>
				<tr>
					<td colspan="2">Бухгалтер _______________ (Степанов А. А.)</td>
				</tr>
				<tr>
					<td colspan="2">
					</td>
				</tr>
			</table>
		';

		// генерируем PDF, используя созданную переменную $html
		gen_pdf_bill($html);

		die;

	}
	// -------------------- END PDF ---------------------

	// -------------------- Start EMAIL ---------------------
	if ($_GET['do']=='email') {
		// пока просто "Счет", потом этот функционал можно расширить и использовать для отправки Актов, Счетов-фактур и так далее и, соответственно, будет автоматически подставляться тип документа в шаблон письма
		$document_type = 'Счет';

		$document_link = 'http://032.pw/schet/doc.php?bid='.$data_bill[0]['id_bill'].'&sig='.$data_bill[0]['hash'];

		$email = 'gorbachev_r@mail.ru';

		$subject = '=?UTF-8?B?'.base64_encode('Бухгалтерские документы от «Идеи Пикс»').'?=';

		$message = 'Уважаемый клиент!<br><br>
					Вам выставлен документ ('.$document_type.') за оказанные услуги интерактивным агентством «Идея Пикс».<br>
					Посмотреть и распечатать копию этого документа вы можете с нашего сайта по следующей ссылке:<br><a href="'.$document_link.'">'.$document_link.'</a><br><br>
					С уважением,<br>
					интерактивное агентство «Идея Пикс».';
		$headers  = "Content-type: text/html; charset=windows-1251 \r\n";
		$message = iconv('utf-8', 'windows-1251', $message);
		mail($email, $subject, $message, $headers);

		die;
	}
	// -------------------- END EMAIL ---------------------

}

$title = 'Все счета';

$Tpl->assign('title', $title);
$Tpl->assign('all_bills', $all_bills);

$Tpl->display('index.tpl');

?>