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
								<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Сервисы</a></li> &gt;
								<li class="crumbs-small_li"><span class="crumbs-small_last">Гороскоп</span></li>
							</ul>
						</div>
					</div>
				</div>
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
												<img src="/images/widget/horoscope/horoscope-title-w130.png" alt="" class="club-list_img">
											</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-23-middle">
							<div class="padding-l20">
								<div class="b-section_t">Гороскопы <br> от Веселого Жирафа</div>
								<div class="margin-t10 color-gray-dark clearfix">
									Здесь собрано все что нужно для цветоводов. Растения, удобрения <br> чувство юмора имеется, на шею не сажусь, проблемами не загружаю. 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
			
			<div class="content-cols">
				<div class="col-1">

					<div class="readers2">
						<a class="btn-green btn-medium" href="">Подписаться</a>
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
							<div class="readers2_count">Все подписчики (129)</div>
						</div>
					</div>
				
					<div class="menu-simple">
						<ul class="menu-simple_ul">
							<li class="menu-simple_li">
								<a class="menu-simple_a" href="">Гороскоп на сегодня</a>
							</li>
							<li class="menu-simple_li">
								<a class="menu-simple_a" href="">Гороскоп на завтра</a>
							</li>
							<li class="menu-simple_li">
								<a class="menu-simple_a" href="">Гороскоп на месяц </a>
							</li>
							<li class="menu-simple_li">
								<a class="menu-simple_a" href="">Гороскоп на год  </a>
							</li>
							<li class="menu-simple_li active">
								<a class="menu-simple_a" href="">Гороскоп совместимости </a>
							</li>
						</ul>
					</div>

					<div class="banner-box padding-t20"><a href=""><img src="/images/horoscope_sidebar_banner.jpg" /></a></div>
				
				</div>
				
				<div class="col-23-middle clearfix">

	                <div class="col-gray padding-20"> 
						
					<div id="horoscope">
						
						<div class="horoscope-compatibility clearfix">
							
							<div class="margin-t20 margin-b20 color-gray font-big">Посмотрите совместимость других знаков</div>
							
							<div class="sign">
								<div class="img"><img class="horoscope-zodiac-img" src="/images/widget/horoscope/big/10.png"></div>
								<div class="chzn-gray">
									<select class="chzn" onchange="Horoscope.ZodiacChange(this)">
										<option value="0">--</option>
										<option value="1" selected="selected">Овен</option>
										<option value="2">Телец</option>
										<option value="3">Близнецы</option>
										<option value="4">Рак</option>
										<option value="5">Лев</option>
										<option value="6">Дева</option>
										<option value="7">Весы</option>
										<option value="8">Скорпион</option>
										<option value="9">Стрелец</option>
										<option value="10">Козерог</option>
										<option value="11">Водолей</option>
										<option value="12">Рыбы</option>
									</select>
								</div>
								<!-- 
								Изменение изображений знака зодиака
								js взят с нашего сайта и не изменялся 
								http://www.happy-giraffe.ru/assets/72c6d72d/script.js 
								-->
<script>
 /**
 * Author: alexk984
 * Date: 25.04.12
 */

var Horoscope = {
    zodiac_list:['aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius', 'pisces'],
    calc:function () {
        document.location.href = '/horoscope/compatibility/'+Horoscope.zodiac_list[$('#HoroscopeCompatibility_zodiac1').val()-1]+'/'+Horoscope.zodiac_list[$('#HoroscopeCompatibility_zodiac2').val()-1]+'/';
    },
    ZodiacChange:function (elem) {
        $(elem).parents('div.sign').find('.img img').attr('src', '/images/widget/horoscope/big/' + $(elem).val() + '.png');

    }
}
</script>
							</div>
							<div class="plus"></div>
							<div class="sign zodiac-empty">
								<div class="img"><img class="horoscope-zodiac-img" src="/images/widget/horoscope/big/0.png"></div>
								<div class="chzn-gray">
									<select class="chzn" onchange="Horoscope.ZodiacChange(this)">
										<option value="0" selected="selected">--</option>
										<option value="1">Овен</option>
										<option value="2">Телец</option>
										<option value="3">Близнецы</option>
										<option value="4">Рак</option>
										<option value="5">Лев</option>
										<option value="6">Дева</option>
										<option value="7">Весы</option>
										<option value="8">Скорпион</option>
										<option value="9">Стрелец</option>
										<option value="10">Козерог</option>
										<option value="11">Водолей</option>
										<option value="12">Рыбы</option>
									</select>
								</div>
								<!-- Появление дропа под знаком зодиака 
								есть проблема при повторном клике на изображенни зодиака для изменения выбора срабатывает только с второй попытки
								-->
								<script>
									$(document).ready(function($) {
										$(".horoscope-compatibility .img").live("click", function() {
											$(this).parents('div.sign').removeClass("zodiac-empty");
											$(this).parents('div.sign').find('.chzn-drop').css({
												"left" : "0"
											});
										});
									});
									
								</script>
							</div>
							<div class="equal"></div>
							<a class="button btn-green btn-large" href="">Узнать!</a>
							<div class="errorSummary">
								<p>Необходимо исправить следующие ошибки:</p>
								<ul><li>Укажите 2-й знак зодиака</li></ul>
							</div>
							
						</div>
						
						
						<div class="wysiwyg-content">
							
							<h1>Гороскоп совместимости - Близнецы и Стрелец</h1>
							
							<p>Нравится ли вам возможность ежедневно советоваться со звёздами? Наверняка вы не раз читали гороскоп для своего знака Зодиака. Что-то в нём вам казалось смешным, а что-то – полезным. Действительно, в то время как одни считают гороскоп сегодня руководством к действию, другие относятся к нему как к пустой забаве. Наверное, это связано с качеством гороскопа. Оцените работу нашего эксклюзивного астролога – прочитайте, что он написал для вас сегодня, нажав на нужный знак Зодиака.</p>
							<p>Гороскоп – это анализ влияния звёзд на нашу жизнь. Наш астролог, составивший гороскоп сегодня, пользовался специальными таблицами, звёздными картами и расчётами. Богатый опыт работы позволил ему выявить общие закономерности для каждого знака Зодиака, чтобы любой посетитель нашего сайта мог скорректировать свои планы на день. Вам кажется это ненаучным и даже где-то не очень умным? Может быть. Только как объяснить тот факт, что почти у каждого известного человека есть свой астролог, составляющий ему ежедневный и перспективный гороскоп? Расположение звёзд часто оказывается решающим для принятия ответственных решений, влияющих на жизни многих людей. Вы ещё не являетесь известным человеком? Но, может быть, именно потому, что не очень серьёзно относитесь к астрологии? Наш бесплатный гороскоп сегодня к вашим услугам – попробуйте следовать его советам и наслаждайтесь своими возможностями!</p>
							<p>Гороскоп – это анализ влияния звёзд на нашу жизнь. Наш астролог, составивший гороскоп сегодня, пользовался специальными таблицами, звёздными картами и расчётами. Богатый опыт работы позволил ему выявить общие закономерности для каждого знака Зодиака, чтобы любой посетитель нашего сайта мог скорректировать свои планы на день. Вам кажется это ненаучным и даже где-то не очень умным? Может быть. Только как объяснить тот факт, что почти у каждого известного человека есть свой астролог, составляющий ему ежедневный и перспективный гороскоп? Расположение звёзд часто оказывается решающим для принятия ответственных решений, влияющих на жизни многих людей. Вы ещё не являетесь известным человеком? Но, может быть, именно потому, что не очень серьёзно относитесь к астрологии? Наш бесплатный гороскоп сегодня к вашим услугам – попробуйте следовать его советам и наслаждайтесь своими возможностями!</p>
							
						</div>
						
						
						<div class="clearfix">
							
							<div class="fast-horoscope">
								
								<div class="block-title">
									<div class="in">Гороскоп<br/>на сегодня</div>
									<div class="date"><b>12</b><br/>АПР</div>
								</div>
								
								<ul>
									<li>
										<div class="img">
											<img src="/images/widget/horoscope/smaller/1.png">
											<div class="date"><span>Овен</span>22.01 - 3.02</div>
										</div>
										<div class="text">Вы настроены на игривый лад – Вам больше хочется развлекаться, чем работать. Да и работа отвечает Вам взаимностью <a href="">далее</a></div>
									</li>
									<li>
										<div class="img">
											<img src="/images/widget/horoscope/smaller/2.png">
											<div class="date"><span>Овен</span>22.01 - 3.02</div>
										</div>
										<div class="text">Вы настроены на игривый лад – Вам больше хочется развлекаться, чем работать. Да и работа отвечает Вам взаимностью <a href="">далее</a></div>
									</li>
									
								</ul>
								
							</div>
							
              
              
							<div class="horoscope-compatibility-list wide">
								<ul>
									<li>
										<div class="img">
											<img src="/images/widget/horoscope/smaller/1.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
											<li><a href="">Близнецы - Овен</a></li>
											<li><a href="">Близнецы - Телец</a></li>
											<li><a href="">Близнецы - Близнецы</a></li>
											<li><a href="">Близнецы - Рак</a></li>
											<li><a href="">Близнецы - Лев</a></li>
											<li><a href="">Близнецы - Дева</a></li>
                      						<li><a href="">Близнецы - Овен</a></li>
											<li><a href="">Близнецы - Телец</a></li>
											<li><a href="">Близнецы - Близнецы</a></li>
											<li><a href="">Близнецы - Рак</a></li>
											<li><a href="">Близнецы - Лев</a></li>
											<li><a href="">Близнецы - Дева</a></li>
                      
										</ul>
									</li>
									<li>
										<div class="img">
											<img src="/images/widget/horoscope/smaller/2.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
											<li><a href="">Близнецы - Овен</a></li>
											<li><a href="">Близнецы - Телец</a></li>
											<li><a href="">Близнецы - Близнецы</a></li>
											<li><a href="">Близнецы - Рак</a></li>
											<li><a href="">Близнецы - Лев</a></li>
											<li><a href="">Близнецы - Дева</a></li>
                      						<li><a href="">Близнецы - Овен</a></li>
											<li><a href="">Близнецы - Телец</a></li>
											<li><a href="">Близнецы - Близнецы</a></li>
											<li><a href="">Близнецы - Рак</a></li>
											<li><a href="">Близнецы - Лев</a></li>
											<li><a href="">Близнецы - Дева</a></li>
                      
										</ul>
									</li>
								</ul>
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
