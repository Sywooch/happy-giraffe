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
								<h1 class="b-section_t">Гороскопы <br> от Веселого Жирафа</h1>
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
						<h1 class="heading-title">Гороскоп на сегодня по знакам Зодиака</h1>
						
						<div class="horoscope-list">
															
							<p>Этот день открывает массу возможностей, но воспользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким. К профессиональным разногласиям относитесь спокойно, сегодня они являются всего лишь частью нормального рабочего процесса. Даже с руководством можно поспорить от души – и без всяких далеко идущих последствий.</p>
							
							<div class="horoscopes-big">
								
							<ul class="horoscopes-big_ul clearfix">
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/1.png" alt="">
									</div>
									<div class="horoscopes-big_t">Овен</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Овен</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. Этот день подходит для ...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/2.png" alt="">
									</div>
									<div class="horoscopes-big_t">Телец</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Телец</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. </div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/3.png" alt="">
									</div>
									<div class="horoscopes-big_t">Близнецы</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Близнецы</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. Этот день подходит для Этот день...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/4.png" alt="">
									</div>
									<div class="horoscopes-big_t">Рак</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Рак</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. Этот день подходит для ...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>

								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/5.png" alt="">
									</div>
									<div class="horoscopes-big_t">Лев</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Лев</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. Этот день подходит для ...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/6.png" alt="">
									</div>
									<div class="horoscopes-big_t">Дева</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Дева</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. Этот день подходит для ...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/7.png" alt="">
									</div>
									<div class="horoscopes-big_t">Весы</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Весы</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/8.png" alt="">
									</div>
									<div class="horoscopes-big_t">Скорпион</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Скорпион</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. Этот день подходит для ...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/9.png" alt="">
									</div>
									<div class="horoscopes-big_t">Стрелец</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Стрелец</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. Этот день подходит для ...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/10.png" alt="">
									</div>
									<div class="horoscopes-big_t">Козерог</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Козерог</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. Этот день подходит для ...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/11.png" alt="">
									</div>
									<div class="horoscopes-big_t">Водолей</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Водолей</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. Этот день подходит для ...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
								<li class="horoscopes-big_i">

									<div class="horoscopes-big_img">
										<img src="/images/widget/horoscope/big/12.png" alt="">
									</div>
									<div class="horoscopes-big_t">Рыбы</div>
									<div class="horoscopes-big_time">22.01 - 3.02</div>

									<div class="horoscopes-big_hold">
										<div class="clearfix">
											<span class="horoscopes-big_t-sub">Рыбы</span>
											<span class="horoscopes-big_time-sub">22.01 - 3.02</span>
										</div>
										<div class="horoscopes-big_desc">Сегодня ваши усилия, направленные на построение нужных и важных отношений, увенчаются успехом. Этот день подходит для ...</div>
										<div class="clearfix textalign-c">
											<a href="" class="horoscopes-big_btn btn-green btn-medium">Весь гороскоп</a>
										</div>
									</div>
								</li>
							</ul>
							
							</div>
						</div>
						
						<div class="wysiwyg-content">
														
							<p>Этот день открывает массу возможностей, но воспользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким. К профессиональным разногласиям относитесь спокойно, сегодня они являются всего лишь частью нормального рабочего процесса. Даже с руководством можно поспорить от души – и без всяких далеко идущих последствий. </p>
							
							<p>Этот день открывает массу возможностей, но воспользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким. К профессиональным разногласиям относитесь спокойно, сегодня они являются всего лишь частью нормального рабочего процесса. Даже с руководством можно поспорить от души – и без всяких далеко идущих последствий. </p>
							
							<p>Этот день открывает массу возможностей, но воспользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким.</p>
							
						</div>
						<div class="margin-t30">
						<div class="horoscope-compatibility clearfix">
							
							<div class="block-title">Совместимость знаков</div>
							
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
