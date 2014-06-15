<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	
</head>
<body class="body-gray">
	
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-fix.php'; ?>
<div class="layout-container">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
	<div class="layout-wrapper">
		

		<div class="layout-content clearfix">
		<div class="content-cols clearfix">
			<div class="col-1">
				<div class="sidebar-search sidebar-search__big clearfix">
					<input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx" id="" name="">
					<!-- 
					В начале ввода текста, скрыть sidebar-search_btn добавить класс active"
					 -->
					<button class="sidebar-search_btn"></button>
				</div>
			</div>
			<div class="col-23-middle">
				<div class="user-add-record user-add-record__small clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male middle">
							<span class="icon-status status-online"></span>
							<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy powertip" title="Статью"></a>
						<a href="#popup-user-add-photo"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy powertip" title="Фото"></a>
						<a href="#popup-user-add-video"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy active powertip" title="Видео"></a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy powertip" title="Статус"></a>
					</div>
				</div>
			</div>
		</div>
		<!-- 
		<div class="crumbs-small clearfix">
			<ul class="crumbs-small_ul">  
				<li class="crumbs-small_li">Я здесь:</li>
				<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Главная</a></li> &gt;
				<li class="crumbs-small_li"><span class="crumbs-small_last">Прямой эфир</span></li>
			</ul>
		</div>
		
		<div class="b-section">
			<div class="b-section_hold">
				<div class="content-cols clearfix">
					<div class="col-1">
					</div>
					<div class="col-23-middle">
						<div class="b-section_t b-section_t__onair"><a href="">Прямой эфир</a></div>
					</div>
				</div>
			</div>
		</div>
		 -->
		<div class="content-cols clearfix">
			<div class="col-1">
			
				<div class="readers2 readers2__no-btn">
					<div class="readers2_t-sm heading-small">
						<span class="icon-status icon-status__small status-online"></span>
						Сейчас на сайте 345
					</div>
					<ul class="readers2_ul clearfix">
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/139790/small/66f1497c1937b445f3c93c12dae00150.jpg" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
					</ul>
				</div>
				
				<div class="fast-articles2">
					<div class="fast-articles2_t-ico"></div>
					<div class="fast-articles2_i">
						<div class="fast-articles2_header clearfix">
						
							<div class="meta-gray">
								<a href="" class="meta-gray_comment">
									<span class="ico-comment ico-comment__gray"></span>
									<span class="meta-gray_tx">35</span>
								</a>
								<div class="meta-gray_view">
									<span class="ico-view ico-view__gray"></span>
									<span class="meta-gray_tx">305</span>
								</div>
							</div>
							
							<div class="float-l">
								<span class="font-smallest color-gray">Сегодня 13:25</span>
							</div>
						</div>
						<div class="fast-articles2_i-t">
							<a href="" class="fast-articles2_i-t-a"> О моем первом бойфренде</a>
						</div>
						<div class="fast-articles2_i-desc">Практически нет девушки, которая не переживала </div>
						<div class="fast-articles2_i-img-hold">
							<a href=""><img src="/images/example/w205-h154.jpg" alt="" class="fast-articles2_i-img"></a>
						</div>
					</div>
					<div class="fast-articles2_i">
						<div class="fast-articles2_header clearfix">
						
							<div class="meta-gray">
								<a href="" class="meta-gray_comment">
									<span class="ico-comment ico-comment__gray"></span>
									<span class="meta-gray_tx">35</span>
								</a>
								<div class="meta-gray_view">
									<span class="ico-view ico-view__gray"></span>
									<span class="meta-gray_tx">305</span>
								</div>
							</div>
							
							<div class="float-l">
								<span class="font-smallest color-gray">Сегодня 13:25</span>
							</div>
						</div>
						<div class="fast-articles2_i-t">
							<a href="" class="fast-articles2_i-t-a"> Как мне предлагали руку и сердце</a>
						</div>
						<div class="fast-articles2_i-desc">Практически нет девушки, которая не переживала </div>
						<div class="fast-articles2_i-img-hold">
							<a href=""><img src="/images/example/w205-h154.jpg" alt="" class="fast-articles2_i-img"></a>
						</div>
					</div>
				</div>
				
			</div>
			<div class="col-23-middle ">

				<div class="tabs-simple">
					<ul class="tabs-simple_ul">
						<li class="tabs-simple_li active">
							<a href="" class="tabs-simple_a">Весь прямой эфир 999</a>
						</li>
						<li class="tabs-simple_li">
							<a href="" class="tabs-simple_a">Эфир клубов 779</a>
						</li>
						<li class="tabs-simple_li">
							<a href="" class="tabs-simple_a">Эфир блогов 220</a>
						</li>
					</ul>
				</div>
				<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/articles.php'; ?>

			</div>
		</div>
		</div>
		
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

<div class="display-n">
	
</div>
</body>
</html>