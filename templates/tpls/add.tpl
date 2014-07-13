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
<body>

	<div class="starter-template">

		{if $errors neq ''}
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			{foreach from=$errors item=error}
				<p>{$error}</p>
			{/foreach}
		</div>
		{/if}

		{if $success_msg neq ''}
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<p>{$success_msg}</p>
		</div>
		{/if} 
		
		<form action="add.php" method="post" class="form-horizontal col-md-12">

			<div class="form-group">
				<label for="name_company" class="col-md-2 control-label">Наименование компании</label>
				<div class="col-md-4">
					<select name="form_company" class="form-control">
						<option>ООО</option>
						<option>ИП</option>
						<option>ЗАО</option>
						<option>ОАО</option>
					</select>
				</div>
				<div class="col-md-6">
					<input type="text" class="form-control" id="name_company" name="name_company" placeholder="Наименование компании">
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="col-md-2 control-label">Адрес</label>
				<div class="col-md-10">
					<input type="text" class="form-control" id="address" name="address" placeholder="Адрес">
				</div>
			</div>
			<div class="form-group">
				<label for="inn" class="col-md-2 control-label">ИНН</label>
				<div class="col-md-10">
					<input type="text" class="form-control" id="inn" name="inn" maxlength="12" placeholder="ИНН">
				</div>
			</div>
			<div class="form-group">
				<label for="kpp" class="col-md-2 control-label">КПП</label>
				<div class="col-md-10">
					<input type="text" class="form-control" id="kpp" name="kpp" placeholder="КПП">
				</div>
			</div>
			<div class="form-group">
				<label for="r_schet" class="col-md-2 control-label">Расчетный счет</label>
				<div class="col-md-10">
					<input type="text" class="form-control" id="r_schet" name="r_schet" placeholder="Расчетный счет">
				</div>
			</div>
			<div class="form-group">
				<label for="cor_schet" class="col-md-2 control-label">Корр. счет</label>
				<div class="col-md-10">
					<input type="text" class="form-control" id="cor_schet" name="cor_schet" laceholder="Корр. счет">
				</div>
			</div>
			<div class="form-group">
				<label for="bank" class="col-md-2 control-label">Банк</label>
				<div class="col-md-10">
					<input type="text" class="form-control" id="bank" name="bank" placeholder="Банк">
				</div>
			</div>
			<div class="form-group">
				<label for="bik" class="col-md-2 control-label">БИК</label>
				<div class="col-md-10">
					<input type="text" class="form-control" id="bik" name="bik" placeholder="БИК">
				</div>
			</div>

			<button type="submit" name="new_company" class="btn btn-success">Сохранить данные</button>

		</form>

	</div>
	
</body>
</html>