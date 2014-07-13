<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Core CSS - Include with every page -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<link href="css/template.css" rel="stylesheet">
	<link href="css/pre_bill_style.css" rel="stylesheet">
	<!-- font Awesome -->
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

	<title>{$title}</title>
</head>
<body class="page-act">

	<div class="starter-template">

		<div class="navbar navbar-default">
			<div class="row">
				<div class="col-lg-8 left-side">Распечатайте счет на листе А4.</div>
				<div class="col-lg-4 pull-right">
						<a href="doc.php?bid={$smarty.get.bid}&sig={$smarty.get.sig}&print" class="btn btn-success btn-md"><i class="fa fa-print"></i> Распечатать счет</a>
				</div>
			</div>
		</div>

		<table class="header_block">
			<tr>
				<td>
					<b>Интерактивное агентство «Идея Пикс»</b>
					<br>
					241013, г.Брянск, ул.Ульянова, 103, оф.9
					<br>
					Телефон: +7 (915) 8000-300
					<br>
					Сайт: <a href="http://ideapix.ru">www.ideapix.ru</a>
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

		<h1>СЧЕТ №{$data_bill.0.id_bill} от {$data_bill.0.date_bill}</h1>
		<p class="left_side"><span class="soft_grey">Плательщик:</span> <b>{$company}</b>
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
					<td class="cell-border">{$all_sum}</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td class="cell-border">Без налога (НДС):</td>
					<td class="cell-border">—</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td class="cell-border"><b>Всего к оплате:</b></td>
					<td class="cell-border"><b>{$pay_sum}</b></td>
				</tr>
			</tfoot>
			<tbody>
				{foreach from=$all_rows item=rows_item name=rows_item}
				<tr>
					<td>{$smarty.foreach.rows_item.iteration}</td>
					<td>{$rows_item.work_name}</td>
					<td>{$rows_item.work_items}</td>
					<td>{$rows_item.work_count}</td>
					<td>{$rows_item.work_price}</td>
					<td>{$rows_item.work_count*$rows_item.work_price}</td>
				</tr>
				{/foreach}
			</tbody>
		</table>

		<div class="left_side"><p>Всего наименований {$all_rows|@count}, на сумму {$pay_sum} руб.</p></div>

		<hr>

		<br><br>

		<div class="left_side"><img src="img/stamp.jpg" style="margin-left: 130px;"></div>

		<table style="margin-top: -180px;">
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
		</table>

	</div>
	{if isset($smarty.get.print)}
	{literal}
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			print();
		})
	</script>
	{/literal}
	{/if}
	
</body>
</html>