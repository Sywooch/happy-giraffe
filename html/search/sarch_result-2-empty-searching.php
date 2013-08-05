<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>

</head>
<body class="body-gray">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
<div class="layout-container_hold">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
			
		<div id="content" class="layout-content clearfix">
			
			<div class="content-search">
				<div class="content-search_top clearfix">
					<div class="content-search_t">
						<a href="" class="ava small"></a>
						Я ищу
					</div>
					<div class="content-search_itx-hold">
						<input type="text" name="" id="" class="content-search_itx" placeholder="Введите слово или фразу">
						<a href="" class="content-search_del" style="display:none;"></a>
						<button class="content-search_btn btn-gold btn-medium">Найти</button>
					</div>
				</div>
			</div>
			
			<div class="content-cols clearfix">
				<div class="col-1">
					<div class="menu-list menu-list__favorites padding-t20">
						<a href="" class="menu-list_i menu-list_i__all2">
							<span class="menu-list_ico"></span>
							<span class="menu-list_tx">Все</span>
							<span class="menu-list_count">0</span>
						</a>
						<a href="" class="menu-list_i menu-list_i__post">
							<span class="menu-list_ico"></span>
							<span class="menu-list_tx">Записи</span>
							<span class="menu-list_count">0</span>
						</a>
						<a href="" class="menu-list_i menu-list_i__photo active">
							<span class="menu-list_ico"></span>
							<span class="menu-list_tx">Фото</span>
							<span class="menu-list_count">0</span>
						</a>
						<a href="" class="menu-list_i menu-list_i__video">
							<span class="menu-list_ico"></span>
							<span class="menu-list_tx">Видео</span>
							<span class="menu-list_count">0</span>
						</a>
						<div class="menu-list_overlay"></div>
					</div>
				</div>
				
				<div class="col-23-middle col-gray clearfix">
					<div class="infscr-loading-hold">
						<div id="infscr-loading"><img alt="Loading..." src="/images/ico/ajax-loader.gif"><div>Загрузка</div></div>
					</div>
				</div>
			</div>
		</div>  	
		
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
</div>


</body>
</html>
