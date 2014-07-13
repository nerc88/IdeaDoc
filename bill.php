<?php
include_once('template.config.php');
include('config.php');
include('func.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

// генерируем номер счета: получаем номер последнего счета в БД и прибавляем 1. Если счетов в БД еще нет, ставим 1 по умолчанию
$last_bill = select_last_bill();
if (!empty($last_bill)) {
	$id_bill = $last_bill + 1;
} else {
	$id_bill = 1;
}


if (isset($_POST['new_bill'])){

	if (!empty($_POST['name_company']) && !empty($_POST['date_bill'])) {
		# code...
	}

	// если форма собственности компании — ИП, значит кавычки в названии нам не нужны, а в остальных случаях добавляем кавычки
	if ($_POST['form_company']=='ИП') {
		$name_company = $_POST['name_company'];
	} else {
		$name_company = '«'.$_POST['name_company'].'»';
	}
	// составляем полное наименование компании из формы собственности + названия компании (например, ООО «Идея Пикс»)
	$company  = $_POST['form_company'].' '.$name_company;

	// преобразовываем числовое значение общей суммы — в текстовое
	$sum_text = mb_ucfirst(num2str($_POST['pay_sum2']));
	
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

		<h1>СЧЕТ №'.$_POST['id_bill'].' от '.$_POST['date_bill'].'</h1>
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
					<td class="cell-border">'.$_POST['all_sum'].'</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td class="cell-border">Без налога (НДС):</td>
					<td class="cell-border">—</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td class="cell-border"><b>Всего к оплате:</b></td>
					<td class="cell-border"><b>'.$_POST['pay_sum'].'</b></td>
				</tr>
			</tfoot>
			<tbody>';

					$i = 1;

					// проверяем в цикле наличие всех значений work_name, чтобы понять сколько строк всего нужно сформировать
					while (!empty($_POST['work_name_'.$i])) {
					$html = $html.'
					<tr>
					<td>'.$_POST['num_'.$i].'</td>
					<td>'.$_POST['work_name_'.$i].'</td>
					<td>'.$_POST['work_items_'.$i].'</td>
					<td>'.$_POST['work_count_'.$i].'</td>
					<td>'.$_POST['work_price_'.$i].'</td>
					<td>'.$_POST['sum_'.$i].'</td>
					</tr>';
						$i++;
					}

					// на данном этапе $i на 1 больше, чем кол-во строк в счете, поэтому уменьшаем значение $i на единицу для использования в строке "Всего наименований..."
					$i--;

			$html = $html.'
			</tbody>
		</table>

		<p>Всего наименований '.$i.', на сумму '.$_POST['pay_sum2'].' руб.</p>
		<p><b>'.$sum_text.'</b></p>

		<br /><br /><br /><br /><br />

		<table>
			<tr>
				<td colspan="2">Руководитель предприятия _______________ (Степанов А. А.)</td>
			</tr>
			<tr>
				<td colspan="2" style="height: 30px;"></td>
			</tr>
			<tr>
				<td colspan="2">Бухгалтер _______________ (Степанов А. А.)</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;М.П.</td>
			</tr>
		</table>
	';


	//создаем массив со значениями строк счета, для передачи в функцию
	$i = 1;
	// проверяем в цикле наличие всех значений work_name, чтобы понять сколько сколько будет элементов массива
	while (!empty($_POST['work_name_'.$i])) {
		$row_arr[$i]['num'] = $_POST['num_'.$i];
		$row_arr[$i]['work_name'] = $_POST['work_name_'.$i];
		$row_arr[$i]['work_items'] = $_POST['work_items_'.$i];
		$row_arr[$i]['work_count'] = $_POST['work_count_'.$i];
		$row_arr[$i]['work_price'] = $_POST['work_price_'.$i];
		$row_arr[$i]['sum'] = $_POST['sum_'.$i];
		$i++;
	}

	// генерируем PDF, используя созданную переменную $html
	// gen_pdf_bill($html);

	add_new_bill($_POST['date_bill'], $_POST['name_company'], 'not_pay', $row_arr);

}

if (isset($_POST['select_by_form'])) {
	$all_company = select_company('', $_POST['form_company']);
	echo json_encode($all_company);
	die;
}

$date = date("d.m.Y");
$title = 'Создание нового счета';

$Tpl->assign('title', $title);
$Tpl->assign('id_bill', $id_bill);
$Tpl->assign('date', $date);

$Tpl->display('bill.tpl');

?>