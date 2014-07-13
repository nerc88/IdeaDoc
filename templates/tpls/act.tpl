<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Core CSS - Include with every page -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<link href="css/template.css" rel="stylesheet">
	<link href="css/pre_bill_style.css" rel="stylesheet">

	<title>{$title}</title>
</head>
<body class="page-act">

	<div class="starter-template">

		<form action="act.php" method="post">

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

			<h1>АКТ №1231 от <input type="text" name="date_act" value="{$date}" readonly tabindex="-1"></h1>

			<div class="left_side">
				<p><span class="soft_grey">Основание:</span> <b>По счету №{$bill.0.id_bill} от {$bill.0.date_bill}</b></p>
			</div>

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
						<td class="cell-border"><input type="text" id="all_sum" name="all_sum" value="0" readonly tabindex="-1"></td>
					</tr>
					<tr>
						<td colspan="4"></td>
						<td class="cell-border">Без налога (НДС):</td>
						<td class="cell-border">—</td>
					</tr>
					<tr>
						<td colspan="4"></td>
						<td class="cell-border"><b>Всего к оплате:</b></td>
						<td class="cell-border"><b><input type="text" id="pay_sum" name="pay_sum" value="0" readonly tabindex="-1"></b></td>
					</tr>
				</tfoot>
				<tbody>
					{foreach from=$all_rows item=rows_item name=rows_item}
					<tr>
						<td><input type="text" size="3" name="num_1" value="{$smarty.foreach.rows_item.iteration}" readonly tabindex="-1"></td>
						<td>
							<input type="text" name="work_name_1" style="width:100%;" value="{$rows_item.work_name}" placeholder="Наименование товара, работ, услуги" readonly tabindex="-1">
						</td>
						<td>
							<input type="text" name="work_items" value="{$rows_item.work_items}" readonly tabindex="-1">
						</td>
						<td>
							<input type="text" name="work_count_1" value="{$rows_item.work_count}" readonly tabindex="-1">
						</td>
						<td><input type="text" name="work_price_1" value="{$rows_item.work_price}" readonly tabindex="-1"></td>
						<td><input type="text" class="sum" name="sum_1" value="{$rows_item.work_count*$rows_item.work_price}" readonly tabindex="-1"></td>
					</tr>
					{/foreach}
				</tbody>
			</table>

			<div class="left_side"><p>Всего наименований <span id="counts-name">1</span>, на сумму <input type="text" id="pay_sum2" name="pay_sum2" value="0" readonly tabindex="-1"> руб.</p></div>

			<hr>
			<div class="left_side"><p>Вышеперечисленные услуги выполнены в полном объеме, в установленные сроки и с надлежащим качеством. Стороны претензий друг к другу не имеют.</p></div>

			<br /><br /><br /><br /><br />

			<table>
				<tr>
					<td>Исполнитель _______________ </td>
					<td>Заказчик _______________ </td>
				</tr>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;М.П.</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;М.П.</td>
				</tr>
			</table>

			<button type="submit" name="new_act" class="btn btn-success">Закрыть актом</button>

		</form>

	</div>
	{literal}
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {

			$('#counts-name').text($('table.schet tbody').find('tr').length);

			commonPrice()

			function commonPrice() {
				var x = $('.sum');
				var y = 0;
				$.each(x, function(index, val) {
					y += parseInt(($(val).val()), 10);
				});
				$('#all_sum, #pay_sum, #pay_sum2').val(y);
			}


		});
	</script>
	{/literal}
	
</body>
</html>