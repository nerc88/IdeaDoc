<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{$title}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
				rel="stylesheet"><!-- font Awesome -->
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet">
<link href="css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
										class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="index.html">IdeaBilling </a>
			<div class="nav-collapse">
				<ul class="nav pull-right">
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
														class="fa fa-user"></i> Аккаунт <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="javascript:;">Settings</a></li>
							<li><a href="javascript:;">Help</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!--/.nav-collapse --> 
		</div>
		<!-- /container --> 
	</div>
	<!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<div class="subnavbar">
	<div class="subnavbar-inner">
		<div class="container">
			<ul class="mainnav">
				<li class="active"><a href="index.php"><i class="fa fa-archive"></i><span>Счета</span> </a> </li>
				<li><a href="#"><i class="fa fa-file-text"></i><span>Акты</span> </a> </li>
				<li><a href="#"><i class="fa fa-building"></i><span>Компании</span> </a></li>
			</ul>
		</div>
		<!-- /container --> 
	</div>
	<!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="fa fa-archive"></i>
							<h3>{$title}</h3>
							<span class="pull-right">
								<a href="bill.php" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Выставить счет</a>
							</span>
						</div>
						<!-- /widget-header -->
						<div class="table-responsive">
							<table id="all_bills" class="table table-bordered">
								<thead>
									<tr>
										<th>№ </th>
										<th>Дата</th>
										<th>Плательщик</th>
										<th>Сумма</th>
										<th style="width:100px">Статус</th>
										<th class="td-actions" style="width:280px"> </th>
									</tr>
								</thead>
								<tbody>
									{foreach from=$all_bills item=bill_item name=bill_item}
									{if $bill_item.status eq "not_pay"}
										{assign var="bg_row_class" value=""}
									{elseif $bill_item.status eq "close"}
										{assign var="bg_row_class" value="inactive-row"}
									{elseif $bill_item.status eq "cancel"}
										{assign var="bg_row_class" value="inactive-row"}
									{/if}
									<tr id="{$bill_item.id_bill}" class="{$bg_row_class}">
										<td>{$bill_item.id_bill}</td>
										<td>{$bill_item.date_bill}</td>
										<td>{$bill_item.company_name}</td>
										<td><b>{$bill_item.sum_bill}</b> <i class="fa fa-rub text-danger"></i></td>
										<td>
											<select class="form-control input-sm">
												{if $bill_item.status eq "not_pay"}
												<option value="not_pay" selected>Не оплачено</option>
												{else}
												<option value="not_pay">Не оплачено</option>
												{/if}

												{if $bill_item.status eq "close"}
												<option value="close" selected>Закрыт актом</option>
												{else}
												<option value="close">Закрыт актом</option>
												{/if}

												{if $bill_item.status eq "cancel"}
												<option value="cancel" selected>Отменен</option>
												{else}
												<option value="cancel">Отменен</option>
												{/if}
											</select>
										</td>
										<td class="td-actions">
											<a href="doc.php?bid={$bill_item.id_bill}&sig={$bill_item.hash}" class="btn btn-default btn-sm"><i class="fa fa-external-link"></i></a>
											<a href="act.php?id_bill={$bill_item.id_bill}" class="btn btn-success btn-sm"><i class="fa fa-file-text"></i> Акт</a>
											<a href="index.php?do=email&id_bill={$bill_item.id_bill}" class="btn btn-primary btn-sm"><i class="fa fa-send-o"></i> Email</a>
											<a href="index.php?do=pdf&id_bill={$bill_item.id_bill}" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i> PDF</a>
										</td>
									</tr>
									{/foreach}
								</tbody>
							</table>
						</div>
						<!-- /widget-content --> 
					</div>
					<!-- /widget --> 
				</div>
				<!-- /span12 --> 
			</div>
			<!-- /row --> 
		</div>
		<!-- /container --> 
	</div>
	<!-- /main-inner --> 
</div>
<!-- /main -->
<div class="footer">
	<div class="footer-inner">
		<div class="container">
			<div class="row">
				<div class="span12"> &copy; 2014 <a href="http://ideapix.ru/">Разработано в IdeaPix</a>. </div>
				<!-- /span12 --> 
			</div>
			<!-- /row --> 
		</div>
		<!-- /container --> 
	</div>
	<!-- /footer-inner --> 
</div>
<!-- /footer --> 
<!-- Скрипты
================================================== --> 
{literal}
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {

		$('#all_bills').on('change', 'select', function(){

			var data = {};

			data.status_bill = '';
			data.id_bill = $(this).parents('tr').attr('id');
			data.new_status =  $(this).val();

			switch(data.new_status){
				case "not_pay": $(this).parents('tr').removeClass(); break;
				case "close": $(this).parents('tr').removeClass().addClass("inactive-row"); break;
				case "cancel": $(this).parents('tr').removeClass().addClass("inactive-row"); break;
			}

			$.post('./index.php', data, function(data) {
				$('#status_bill').html(html);
			}, 'json');

		});

	});
</script>
{/literal}

</body>
</html>
