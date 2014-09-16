<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	
</head>
<body class="body-gray theme__adfox theme__kinder-umbrella" style="">
<!-- 
	adFox настройки
	1. URL перехода - полная ссылка для перехода (http://...) на сайт рекламодателя. Если не указывать ссылку для перехода, то баннер будет некликабельным.

	2. Цвет фона - #a1d9f4

	3. Фоновое изображение - загрузите фоновое изображение (BackGround); У нас слишком большой файл вставлять через URL, url(/images/branding/kinder/theme__adkinder.jpg)

	4. Фиксировать фон на странице - scroll - фон прокручивается вместе с сайтом;

	5. Повторять фон - no-repeat

	6. Расположение фона по горизонтали - по умолчанию задано 50%

	7. Сдвигать контент сайта вниз (px) - 0. Сдвину вниз с помощью своих свойств.

	8. Возвращать фон через (в сек.) - 

	
	1. Id главного дива (div замена body) - возможно прийдется задать id на <div class="layout-container">

	1. Id дивов исключений (псевдо-прозрачные) - id на <div class="cover cover__adkinder" > 
	2. Id дивов исключений (прозрачные) - ничего
-->
<!-- 
	Отличия от обычной страницы
	1. Классы на body <body class="body-gray theme__adfox theme__adkinder">
	2. Перемещен на вложенность выше <div class="footer-push"></div>   можно сделать на всех страницах сайта
	3. Добавлен в конце блок <div class="cover cover__adkinder">
 -->

<!--AdFox START-->
<!--giraffe-->
<!--Площадка: Весёлый Жираф / * / *-->
<!--Тип баннера: Брендирование-->
<!--Расположение: бэкграунд-->
<script type="text/javascript">
<!--
if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 1000000); }
if (typeof(document.referrer) != 'undefined') {
  if (typeof(afReferrer) == 'undefined') {
    afReferrer = escape(document.referrer);
  }
} else {
  afReferrer = '';
}
var addate = new Date(); 
var scrheight = '', scrwidth = '';
if (self.screen) {
scrwidth = screen.width;
scrheight = screen.height;
} else if (self.java) {
var jkit = java.awt.Toolkit.getDefaultToolkit();
var scrsize = jkit.getScreenSize();
scrwidth = scrsize.width;
scrheight = scrsize.height;
}
document.write('<scr' + 'ipt type="text/javascript" src="http://ads.adfox.ru/211012/prepareCode?pp=dtx&amp;ps=bkqy&amp;p2=ewfb&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
// -->
</script>
<!--AdFox END-->


	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-fix.php'; ?>

<div  class="layout-w1">
<div id="layout-container" class="layout-container">

	<div class="layout-wrapper">
	<div class="layout-wrapper_hold">
		
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
				<li class="crumbs-small_li"><span class="crumbs-small_last">Форум</span></li>
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
			
				<div class="readers2">
					<a class="btn-green btn-medium" href="">Вступить в клуб</a>
					<ul class="readers2_ul clearfix">
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
					</ul>
					<div class="clearfix">
						<div class="readers2_count">Все участники клуба (129)</div>
					</div>
				</div>
							
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
				<div class="clearfix margin-r20 margin-b20">
					<a href="" class="btn-blue btn-h46 float-r">Добавить в клуб</a>
				</div>
				<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/articles.php'; ?>

			</div>
		</div>
		</div>

	</div>
	</div>
	<!-- Перемещен -->
	<div class="footer-push"></div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>

	<script>
	$(window).load(function () {
		$(".theme__adfox").append("<div id='cover' class='cover cover__kinder-umbrella'><div class='cover_b'></div></div>");
	});
	</script> 
	
</div>
</div>

</body>
</html>