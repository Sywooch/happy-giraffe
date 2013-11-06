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
			</div>
		</div>
		
		<div class="crumbs-small clearfix">
			<ul class="crumbs-small_ul">  
				<li class="crumbs-small_li">Я здесь:</li>
				<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Главная</a></li> &gt;
				<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Наш дом</a></li> &gt;
				<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Цветы в доме</a></li> &gt;
				<li class="crumbs-small_li"><span class="crumbs-small_last">Фото 1</span></li>
			</ul>
		</div>
		
		<div class="b-section">
			<div class="b-section_hold">
				<div class="content-cols clearfix">
					<div class="col-1">
						<div class="club-list club-list__big clearfix">
							<ul class="club-list_ul textalign-c clearfix">
								<li class="club-list_li">
									<a href="" class="club-list_i">
										<span class="club-list_img-hold">
											<img src="/images/club/2-w130.png" alt="" class="club-list_img">
										</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-23-middle">
						<div class="padding-l20">
							<div class="b-section_t"><a href="">Цветы в доме</a></div>
							<div class="clearfix">
								<ul class="b-section_ul clearfix">
									<li class="b-section_li"><span class="b-section_li-a active">Форум</span></li>
									<li class="b-section_li"><a href="" class="b-section_li-a">Сервисы</a></li>
									<li class="b-section_li"><a href="" class="b-section_li-a">Конкурсы</a></li>
									<li class="b-section_li"><a href="" class="b-section_li-a">Вопросы-ответы</a></li>
									<li class="b-section_li"><a href="" class="b-section_li-a">Специалисты</a></li>
									<li class="b-section_li"><a href="" class="b-section_li-a">Онлайн-курсы</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="content-cols clearfix">
			<div class="col-1">
				<div class="margin-t10 clearfix">
					<a class="ava male margin-r10" href="">
						<span class="icon-status status-online"></span>
						<img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
					</a>
					<a href="" class="ava-name">Ангелина <br>Богоявленская</a>
				</div>
			</div>
			<div class="col-23-middle ">
				<div class="col-white margin-l20 margin-r20">
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