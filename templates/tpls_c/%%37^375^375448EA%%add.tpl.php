<?php /* Smarty version 2.6.13, created on 2014-06-03 15:48:41
         compiled from add.tpl */ ?>
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

		<?php if ($this->_tpl_vars['errors'] != ''): ?>
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['error']):
?>
				<p><?php echo $this->_tpl_vars['error']; ?>
</p>
			<?php endforeach; endif; unset($_from); ?>
		</div>
		<?php endif; ?>

		<?php if ($this->_tpl_vars['success_msg'] != ''): ?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<p><?php echo $this->_tpl_vars['success_msg']; ?>
</p>
		</div>
		<?php endif; ?> 
		
		<form action="add.php" method="post" class="form-horizontal col-md-6 col-md-offset-3">

			<div class="form-group">
				<label for="name_company" class="col-md-2 control-label">Наименование компании</label>
				<div class="col-md-2">
					<select name="form_company" class="form-control">
						<option>ООО</option>
						<option>ИП</option>
						<option>ЗАО</option>
						<option>ОАО</option>
					</select>
				</div>
				<div class="col-md-8">
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