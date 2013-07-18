<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin,cyrillic-ext,cyrillic">

</head>
<body class="body-gray">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
			
		<div id="content" class="layout-content clearfix">
			<div class="content-cols clearfix">
				<div class="col-1">
					<div class="b-ava-large">
						<div class="b-ava-large_ava-hold clearfix">
							<a class="ava large" href="">
								<img alt="" src="/images/example/ava-large.jpg">
							</a>
							<span class="b-ava-large_online">На сайте</span>
							<a href="" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
								<span class="b-ava-large_ico b-ava-large_ico__mail"></span>
								<span class="b-ava-large_bubble-tx">+5</span>
							</a>
							<a href="" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
								<span class="b-ava-large_ico b-ava-large_ico__photo"></span>
								<span class="b-ava-large_bubble-tx">+50</span>
							</a>
							<a href="" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
								<span class="b-ava-large_ico b-ava-large_ico__blog"></span>
								<span class="b-ava-large_bubble-tx">+999</span>
							</a>
						</div>
						<div class="textalign-c">
							<a href="" class="b-ava-large_a">Александр Богоявленский</a>
						</div>
					</div>
					
				</div>
				<div class="col-23-middle">
					<div class="heading-title clearfix">
						Мои уведомления 
					</div>
				<div class="col-gray">
					<div class="user-notice clearfix">
						<div class="user-notice_t-hold clearfix">
							<div class="cont-nav">
								<div class="cont-nav_i active">
									<a href="" class="cont-nav_a">Новые</a>
								</div>
								<div class="cont-nav_i">
									<a href="" class="cont-nav_a">Прочитанные</a>
								</div>
							</div>
						</div>
						<div class="cap-empty cap-empty__rel">
							<div class="cap-empty_hold">
								<div class="cap-empty_tx">У вас пока нет новых уведомлений.</div>
								<span class="cap-empty_gray" href="">Начать новый поиск</span>
							</div>
						</div>
						
					</div>
				</div>
				</div>
		</div>  	
		
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>


</body>
</html>
