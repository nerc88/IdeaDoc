<?php
include_once('template.config.php');
include('config.php');
include('func.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_POST['new_company'])) {

	$errors = array();
	
	if (!($_POST["name_company"])) {
		$errors[] = 'Не указано название компании';
	}
	if (!($_POST["address"])) {
		$_POST["address"] = '';
	}
	if (!($_POST["inn"])) {
		$_POST["inn"] = '';
	}
	if (!($_POST["kpp"])) {
		$_POST["kpp"] = '';
	}
	if (!($_POST["r_schet"])) {
		$_POST["r_schet"] = '';
	}
	if (!($_POST["cor_schet"])) {
		$_POST["cor_schet"] = '';
	}
	if (!($_POST["bank"])) {
		$_POST["bank"] = '';
	}
	if (!($_POST["bik"])) {
		$_POST["bik"] = '';
	}

	if (empty($errors)) {

		$add_company = add_new_company($_POST['form_company'], $_POST['name_company'], $_POST['address'], $_POST['inn'], $_POST['kpp'], $_POST['r_schet'], $_POST['cor_schet'], $_POST['bank'], $_POST['bik']);

		if ($add_company) {
			$success_msg = 'Успех! Новая компания добавлена в список.';
		}

	}
	
	
}

$title = 'Добавить новую компанию';

if (!empty($errors)) {
	$Tpl->assign('errors', $errors);
}
if (!empty($success_msg)) {
	$Tpl->assign('success_msg', $success_msg);
}

$Tpl->assign('title', $title);

$Tpl->display('add.tpl');

?>