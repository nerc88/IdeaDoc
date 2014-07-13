<?php
include_once('template.config.php');
include('config.php');
include('func.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

// if (isset($_POST['new_act'])) {
// 	$_POST['date_act'] // дата создания акта
// }

$all_rows = select_row_by_id_bill($_GET['id_bill']);

$bill = select_all_bills($_GET['id_bill']);

$date = date("d.m.Y");
$title = 'Акты';

$Tpl->assign('title', $title);
$Tpl->assign('all_rows', $all_rows);
$Tpl->assign('bill', $bill);
$Tpl->assign('date', $date);

$Tpl->display('act.tpl');

?>