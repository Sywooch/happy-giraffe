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
			
			<div class="content-cols">
				<div class="col-1">
					<div class="b-ava-large">
						<div class="b-ava-large_ava-hold clearfix">
							<a href="" class="ava large female">
							</a>
							<span class="b-ava-large_online">На сайте</span>
							<a class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" href="">
								<span class="b-ava-large_ico b-ava-large_ico__mail"></span>
								<span class="b-ava-large_bubble-tx">+5</span>
							</a>
							<a class="b-ava-large_bubble b-ava-large_bubble__photo powertip" href="">
								<span class="b-ava-large_ico b-ava-large_ico__photo"></span>
								<span class="b-ava-large_bubble-tx">+50</span>
							</a>
							<a class="b-ava-large_bubble b-ava-large_bubble__blog powertip" href="">
								<span class="b-ava-large_ico b-ava-large_ico__blog"></span>
								<span class="b-ava-large_bubble-tx">+999</span>
							</a>
						</div>
						<div class="textalign-c">
							<a class="b-ava-large_a" href="">Александр Богоявленский</a>
						</div>
					</div>
				</div>
				
				<div class="col-23-middle clearfix">
	                <div class="heading-title clearfix">
						Мои настройки 
					</div>
	                <div class="col-gray"> 
						<div class="cont-nav textalign-l">
							<div class="cont-nav_i">
								<a class="cont-nav_a" href="">Личные данные</a>
							</div>
							<div class="cont-nav_i">
								<a class="cont-nav_a" href="">Социальные сети</a>
							</div>
							<div class="cont-nav_i active">
								<a class="cont-nav_a" href="">Пароль </a>
							</div>
						</div>
						
						<div class="form-settings">
							<div class="margin-b20 clearfix">
								<div class="form-settings_label">Текущий пароль</div>
								<div class="form-settings_elem">
									<div class="w-300">
										<input type="password" name="" id="" class="itx-gray" value="password">
									</div>
								</div>
							</div>
							<div class="margin-b20 clearfix">
								<div class="form-settings_label">Новый пароль</div>
								<div class="form-settings_elem">
									<div class="w-300">
										<input type="password" name="" id="" class="itx-gray" value="">
									</div>
									<div class="form-settings_desc w-300">Придумайте сложный пароль, котрый нельзя подобрать, от 6 до 12 символов - цифры и английские буквы.</div>
								</div>
							</div>
							<div class="margin-b40 clearfix">
								<div class="form-settings_label">Повторите новый пароль</div>
								<div class="form-settings_elem">
									<div class="w-300">
										<input type="password" name="" id="" class="itx-gray" value="">
									</div>
								</div>
							</div>
							<div class="margin-b20 clearfix">
								<div class="form-settings_label">Код</div>
								<div class="form-settings_elem">
									<div class="float-l w-130 margin-r10">
										<div class="form-settings_capcha">
											<!-- Размеры капчи 128*46 -->
											<img src="/images/captcha.png" alt="">
										</div>
										<div class="form-settings_desc">
											Обновить картинку 
											<a href="" class="ico-refresh"></a>
										</div>
									</div>
									<div class="float-l">
										<div class="w-160">
											<input type="text" name="" id="" class="itx-gray margin-t20" value="">
										</div>
										<div class="form-settings_desc">Введите цифры, которые вы видите на картинке.</div>
									</div>
								</div>
							</div>
							<div class="margin-b20 clearfix">
								<div class="form-settings_label">&nbsp;</div>
								<div class="form-settings_elem">
									<button class="btn-blue btn-medium">Изменить</button>
									<!-- .msg-win - успешно (зеленый цвет), .msg-error - ошибка (красный) -->
									<span class="msg-win display-ib margin-l20">Пароль успешно изменён</span>
								</div>
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
</div>


</body>
</html>
