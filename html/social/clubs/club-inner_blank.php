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
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
		
		<div class="layout-content clearfix">
		<div class="content-cols clearfix">
			<div class="col-1">
				<div class="sidebar-search clearfix">
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
				<div class="padding-l20">
					<div class="crumbs-small clearfix">
						<ul class="crumbs-small_ul">  
							<li class="crumbs-small_li">Я здесь:</li>
							<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Главная</a></li> &gt;
							<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Наш дом</a></li> &gt;
							<li class="crumbs-small_li"><span class="crumbs-small_last">Выходные с семьей</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div class="b-section">
			<div class="b-section_hold">
				<div class="content-cols clearfix">
					<div class="col-1">
					</div>
					<div class="col-23-middle">
						<div class="padding-l20">
							<h1 class="b-section_t">Выходные с семьей</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="content-cols clearfix">
			<div class="col-1">
				
				<div class="menu-simple">
					<ul class="menu-simple_ul">
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Обо всем</a>
						</li>
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Свадьба - прекрасный миг</a>
						</li>
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Прикольное видео </a>
						</li>
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Школа восточного танца  </a>
						</li>
						<li class="menu-simple_li active">
							<a class="menu-simple_a" href="">Мой мужчина </a>
						</li>
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Детские передачи </a>
						</li>
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Свадьбы </a>
						</li>
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Кормление ребенка </a>
						</li>
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Воспитание детей </a>
						</li>
					</ul>
				</div>
				
			</div>
			<div class="col-23-middle ">
				
				<div class="col-gray">
					<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/articles.php'; ?>

				</div>
			</div>
		</div>
		</div>
		
		<a href="#layout" id="btn-up-page"></a>
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

<div class="display-n">
	
</div>
</body>
</html>