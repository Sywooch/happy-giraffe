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
							
							<div class="block-title">Совместимость знаков</div>
							
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
							<div class="errorSummary">
								<p>Необходимо исправить следующие ошибки:</p>
								<ul><li>Укажите 2-й знак зодиака</li></ul>
							</div>
							
						</div>
						
						
						<div class="wysiwyg-content">
							
							<h1>Гороскоп совместимости знаков Зодиака</h1>
							
							<p>Эффект взаимного притяжения очень хорошо просматривается на примере этой пары. Самое большое удовольствие для них – духовное общение и обмен мнениями. Оба знака очень интеллектуальны и интересуются всем на свете. Это шумные создания, и одно из любимейших их занятий – подискутировать на интересную тему. Оба не переносят малейшее ограничение их свободы. А вот в постели ничего яркого они продемонстрировать не смогут, так как оба будут ждать инициативы от партнера.</p>
							<p>Глядя на них со стороны, не сразу поймешь, какие отношения их связывают: то ли это любовники, то ли хорошие друзья, а может, это старые враги, которые лишь скрывают свою неприязнь? Они и сами порой не уверены до конца, кем приходятся друг другу.</p>
							
						</div>
						
						<div class="clearfix">
							
							<div class="horoscope-compatibility-list">
								<ul>
									<li>
										<div class="img">
											<img src="/images/widget/horoscope/smaller/1.png" />
											<div class="date"><span>Овен</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<div class="date"><span>Телец</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<img src="/images/widget/horoscope/smaller/3.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<img src="/images/widget/horoscope/smaller/4.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<img src="/images/widget/horoscope/smaller/5.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<img src="/images/widget/horoscope/smaller/6.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<img src="/images/widget/horoscope/smaller/7.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<img src="/images/widget/horoscope/smaller/8.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<img src="/images/widget/horoscope/smaller/9.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<img src="/images/widget/horoscope/smaller/10.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<img src="/images/widget/horoscope/smaller/11.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
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
											<img src="/images/widget/horoscope/smaller/12.png" />
											<div class="date"><span>Близнецы</span>22.01 - 3.02</div>
										</div>
										<ul>
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
