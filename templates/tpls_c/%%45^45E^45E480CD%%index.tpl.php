<?php /* Smarty version 2.6.13, created on 2014-06-03 16:00:35
         compiled from index.tpl */ ?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Core CSS - Include with every page -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<link href="css/template.css" rel="stylesheet">
	<link href="css/pre_bill_style.css" rel="stylesheet">

	<title><?php echo $this->_tpl_vars['title']; ?>
</title>
</head>
<body>

	<div class="starter-template">
		
		<!-- <form action="index.php" method="post">
			<div class="form-group">
				<select name="form_client" class="form-control">
					<option>ООО</option>
					<option>ИП</option>
					<option>ЗАО</option>
					<option>ОАО</option>
				</select>
			</div>
			<div class="form-group">
				<input type="text" name="name_client" placeholder="Название компании" class="form-control">
			</div>
			<div class="form-group">
				<button type="submit" name="new_bill2" class="btn btn-success">Создать счет</button>
			</div>
		</form> -->

		<form action="index.php" method="post">

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

			<h1>СЧЕТ №1231 от <input type="text" name="date_bill" value="<?php echo $this->_tpl_vars['date']; ?>
"></h1>

			<div class="left_side">
				<p><span class="soft_grey">Плательщик:</span>
					<b>
						<select name="form_client">
							<option>ООО</option>
							<option>ИП</option>
							<option>ЗАО</option>
							<option>ОАО</option>
						</select>

						<input type="text" name="name_client" placeholder="Название компании">
					 </b>
				<br>
				<span class="soft_grey">Получатель:</span> <b>ИП Степанов А. А.</b></p>
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
					<tr>
						<td><input type="text" size="3" name="num_1" value="1" readonly tabindex="-1"></td>
						<td>
							<input type="text" name="work_name_1" style="width:100%;" placeholder="Наименование товара, работ, услуги">
						</td>
						<td>
							<select name="work_items">
								<option>шт.</option>
								<option>мес.</option>
							</select>
						</td>
						<td>
							<input type="number" pattern="^[ 0-9]+$" class="work_count" min="0" name="work_count_1" placeholder="Кол-во">
						</td>
						<td><input type="number" pattern="^[ 0-9]+$" class="work_price" min="0" name="work_price_1" placeholder="Цена за ед."></td>
						<td><input type="text" class="sum" name="sum_1" value="0" readonly tabindex="-1"> <button class="btn btn__add-row btn-success">+</button></td>
					</tr>
				</tbody>
			</table>

			<div class="left_side"><p>Всего наименований <span id="counts-name">1</span>, на сумму <input type="text" id="pay_sum2" name="pay_sum2" value="0" readonly tabindex="-1"> руб.</p></div>

			<br /><br /><br /><br /><br />

			<table>
				<tr>
					<td colspan="2">Руководитель предприятия _______________ (Степанов А. А.)</td>
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

			<button type="submit" name="new_bill" class="btn btn-success">Создать счет</button>

		</form>

	</div>
	<?php echo '
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$(\'table.schet\').on(\'keyup change\', \'input.work_count\', recalculation);
			$(\'table.schet\').on(\'keyup change\', \'input.work_price\', recalculation);

			function recalculation() {
				var summa = $(this).parents(\'tr\').find(\'input.work_count\').val() * $(this).parents(\'tr\').find(\'input.work_price\').val();

				$(this).parents(\'tr\').find(\'.sum\').val(summa);
				console.log($(this).val());
				console.log($(this).parents(\'tr\').find(\'input.work_count\').val());
				commonPrice();
			}

			function commonPrice() {
				var x = $(\'.sum\');
				var y = 0;
				$.each(x, function(index, val) {
					y += parseInt(($(val).val()), 10);
					// console.log($(val).val())
				});
				$(\'#all_sum, #pay_sum, #pay_sum2\').val(y);
				// console.log(x);
			}

			$(\'table.schet\').on(\'click\', \'.btn__add-row\', function(event) {
				event.preventDefault();
				$(this).parents(\'tr\').after(\'<tr><td><input type="text" size="3" name="num_1" value="1" readonly tabindex="-1"></td><td><input type="text" name="work_name_1" style="width:100%;" placeholder="Наименование товара, работ, услуги"></td><td><select name="work_items"><option>шт.</option><option>мес.</option></select></td><td><input type="number" pattern="^[ 0-9]+$" class="work_count" min="0" name="work_count_1" placeholder="Кол-во"></td><td><input type="number" pattern="^[ 0-9]+$" class="work_price" min="0" name="work_price_1" placeholder="Цена за ед."></td><td><input type="text" class="sum" name="sum_1" value="0" readonly tabindex="-1"> <button class="btn btn__add-row btn-success">+</button></td></tr>\');

				var $countsTr = $(\'table.schet tbody\').find(\'tr\');

				$.each($countsTr, function(index, val) {
					$(val)
						.find(\'td:first\')
						.find(\'input\')
							.val(index + 1)
							.attr(\'name\', \'num_\' + (+index +1));
					// $(val).find(\'td:eq(0)\').find(\'input\');
					$(val)
						.find(\'td:eq(1)\')
						.find(\'input\')
							.attr(\'name\', \'work_name_\' + (+index +1));
					$(val)
						.find(\'td:eq(3)\')
						.find(\'input\')
							.attr(\'name\', \'work_count_\' + (+index +1));
					$(val)
						.find(\'td:eq(4)\')
						.find(\'input\')
							.attr(\'name\', \'work_price_\' + (+index +1));
					$(val)
						.find(\'td:eq(5)\')
						.find(\'input\')
							.attr(\'name\', \'sum_\' + (+index +1));
				});

				$(\'#counts-name\').text($countsTr.length);

			});
		});
	</script>
	'; ?>

	
</body>
</html>