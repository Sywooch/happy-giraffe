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
					
					<div class="banner-box padding-t20"><a href=""><img src="/images/horoscope_sidebar_banner.jpg" /></a></div>
					
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
					
					<div class="horoscope-subscribe">
						<img src="/images/horoscope_subscribe_banner.jpg" />
						<p>Этот день открывает массу возможностей,  пользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким.</p>
						<div class="margin-15">
							<input type="text" name="" id="" class="itx-simple" placeholder="Введите ваш e-mail">
						</div>
						<button class="btn-blue btn-big" >Хочу!</button>
						<!-- или 
						<a href="" class="btn-blue btn-big">Хочу!</a>
						<input type="submit" value="Хочу!" class="btn-blue btn-big" /> 
						-->
					</div>
					
				
				</div>
				
				<div class="col-23-middle clearfix">
	                <div class="col-white padding-20"> 
						
						
					<div id="horoscope">
						
						<div class="horoscope-compatibility clearfix">
							
							<!-- <div class="block-title">Совместимость знаков</div> -->
							<div class="margin-20 color-gray font-big">Посмотрите совместимость других знаков</div>
							
							<div class="sign">
								<div class="img"><img class="horoscope-zodiac-img" src="/images/widget/horoscope/big/10.png"></div>
								<div class="chzn-v2-lilac">
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
}</script>
							</div>
							<div class="plus"></div>
							<div class="sign zodiac-empty">
								<div class="img"><img class="horoscope-zodiac-img" src="/images/widget/horoscope/big/0.png"></div>
								<div class="chzn-v2-lilac">
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
		</div>  	
		
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
</div>


</body>
</html>
