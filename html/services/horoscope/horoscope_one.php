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
						<h1 class="heading-title clearfix">Гороскоп Овен на сегодня</h1>
						
						<div class="horoscope-one">
						
						<div class="block-in">
						  
							<div class="img">
							 
							  <div class="in"><img src="/images/widget/horoscope/big/1.png" /></div>
							  <div class="date"><span>Скорпион</span>22.01 - 3.02</div>
							  
							</div>
							
							<div class="dates">
								<ul>
									<li class="active"><a href="">На сегодня</a></li>
									<li><a href="">На завтра</a></li>
									<li><a href="">На месяц</a></li>
									<li><a href="">На 2013</a></li>
								</ul>
							</div>
							
							
							<div class="text clearfix">
								<div class="date">
									<span>28</span>янв
								</div>
								<div class="holder">
									  <p>Сегодня лучше всего было бы заниматься любимым делом, творческими проектами и не попадаться на глаза людям, которым от вас что-то бесконечно нужно. Но, к сожалению, велика вероятность, что вас все равно отыщут. Воздержитесь, по крайней мере, от деловых разговоров. К тому же, этот день может преподнести приятный сюрприз в личной жизни, и вам потребуется время, чтобы побыть с любимым человеком, детьми, насладиться счастьем.</P>
									  <p>Сегодня лучше всего было бы заниматься любимым делом, творческими проектами и не попадаться на глаза людям, которым от вас что-то бесконечно нужно. Но, к сожалению, велика вероятность, что вас все равно отыщут. Воздержитесь, по крайней мере, от деловых разговоров. К тому же, этот день может преподнести приятный сюрприз в личной жизни, и вам потребуется время, чтобы побыть с любимым человеком, детьми, насладиться счастьем.s</p>
									  
									  <!-- для гороскопа на определенный день -->
										<div class="dates clearfix">
											<span class="a-left"><a href="" > 27 января</a></span>
											<span class="a-right"><a href="" > 29 января</a></span>
										 
										</div>
								</div>
								
							</div>
							
							<div class="text clearfix">
								<div class="date">
									<span class="year">ноя</span>2012
								</div>
								<div class="holder">
									  <p>Сегодня лучше всего было бы заниматься любимым делом, творческими проектами и не попадаться на глаза людям, которым от вас что-то бесконечно нужно. Но, к сожалению, велика вероятность, что вас все равно отыщут. Воздержитесь, по крайней мере, от деловых разговоров. К тому же, этот день может преподнести приятный сюрприз в личной жизни, и вам потребуется время, чтобы побыть с любимым человеком, детьми, насладиться счастьем.</P>
									  <p>Сегодня лучше всего было бы заниматься любимым делом, творческими проектами и не попадаться на глаза людям, которым от вас что-то бесконечно нужно. Но, к сожалению, велика вероятность, что вас все равно отыщут. Воздержитесь, по крайней мере, от деловых разговоров. К тому же, этот день может преподнести приятный сюрприз в личной жизни, и вам потребуется время, чтобы побыть с любимым человеком, детьми, насладиться счастьем.s</p>
									  
									  <!-- для гороскопа на определенный день -->
										<div class="dates clearfix">
											<span class="a-left"><a href="" > 27 января</a></span>
											<span class="a-right"><a href="" > 29 января</a></span>
										 
										</div>
								</div>
								
							</div>
							
							<!-- для гороскопа на вчера -->
							<div class="horoscope-daylist clearfix">
								<ul>
									<li><a href="">21 сентября</a></li>
									<li><a href="">22 сентября</a></li>
									<li><a href="">23 сентября</a></li>
									<li><a href="">24 сентября</a></li>
									<li><a href="">25 сентября</a></li>
									<li><a href="">26 сентября</a></li>
									<li><a href="">27 сентября</a></li>
									<li><a href="">28 сентября</a></li>
									<li><a href="">29 сентября</a></li>
									<li><a href="">30 сентября</a></li>
								</ul>
							</div>
							<!-- для гороскопа на месяц -->
							<div class="horoscope-month clearfix">
								<table cellpadding="0" cellspacing="0" >
									<tr>
										<td><span class="day">1</span></td>
										<td><span class="day good">2</span></td>
										<td><span class="day">3</span></td>
										<td><span class="day">4</span></td>
										<td><span class="day bad">5</span></td>
										<td><span class="day">6</span></td>
										<td><span class="day">7</span></td>
									</tr>
									<tr>
										<td><span class="day">8</span></td>
										<td><span class="day good">9</span></td>
										<td><span class="day">10</span></td>
										<td><span class="day bad">11</span></td>
										<td><span class="day">12</span></td>
										<td><span class="day good">13</span></td>
										<td><span class="day good">14</span></td>
									</tr>
									<tr>
										<td><span class="day bad">15</span></td>
										<td><span class="day">16</span></td>
										<td><span class="day good">17</span></td>
										<td><span class="day">18</span></td>
										<td><span class="day bad">19</span></td>
										<td><span class="day good">20</span></td>
										<td><span class="day">21</span></td>
									</tr>
									<tr>
										<td><span class="day">22</span></td>
										<td><span class="day good">23</span></td>
										<td><span class="day">24</span></td>
										<td><span class="day">25</span></td>
										<td><span class="day bad">26</span></td>
										<td><span class="day">27</span></td>
										<td><span class="day">28</span></td>
									</tr>
									<tr>
										<td><span class="day">29</span></td>
										<td><span class="day">30</span></td>
										<td><span class="day">31</span></td>
										<td><span class="day"></span></td>
										<td><span class="day"></span></td>
										<td><span class="day"></span></td>
										<td><span class="day"></span></td>
									</tr>
								</table>
								<div class="legend">
									<div class="row">
										<span class="day good"></span> - благоприятные дни
									</div>
									<div class="row">
										<span class="day bad"></span> - неблагоприятные дни
									</div>
								</div>
							</div>
							<!-- для гороскопа на год -->
							<div class="horoscope-year">
								<div class="horoscope-year_item health">
									<p><span class="red">Здоровье.</span> На состояние здоровья Овнам в год черного дракона жаловаться не придется. Особенно в том случае, если они успели в прошлом году избавиться от вредных привычек. Тогда их точно минует обычный для завершения зимы и первой половины весны всплеск простудных заболеваний и гриппа. Для Овнов, страдающих какими-либо хроническими заболеваниями, лето можно назвать весьма подходящим временем для начала очередного курса лечения.</p>
								</div>
								<div class="horoscope-year_item career">
									<p><span class="red">Карьера.</span> В 2012 году Овнов ожидает карьерный рост. Тем не менее, не нужно ждать повышения по службе сложа руки. Дисциплина и труд – вот лучшие друзья Овна в текущем году. Нельзя пренебрегать и новыми деловыми знакомствами (их вероятность особенно велика в 1-й половине года). Правда, отношений со старыми партнерами тоже разрывать не стоит.</p>
								</div>
								<div class="horoscope-year_item fin">
									<p><span class="red">Финансы.</span> В год черного дракона Овнам лучше всего избегать сомнительных операций и авантюр. Их биржевая деятельность вряд ли окажется удачной. Рост доходов у представителей этого знака наиболее вероятен во второй половине весны. Ноябрь и последние недели декабря – это время, когда Овнам потребуется соблюдать повышенную осторожность в финансовых вопросах.</p>
								</div>
								<div class="horoscope-year_item home">
									<p><span class="red">Личная жизнь. </span> Мощная волна любви в этом году захватит Овнов без остатка. Существует большая вероятность того, что одинокие Овны наконец-то найдут свою вторую половинку. Удача в любви наверняка окажется залогом успеха во всех прочих сферах жизни.</p>
								</div>
							</div>
							
							<div class="custom-likes-b">
								<div class="custom-likes-b_slogan">Поделитесь с друзьями! </div>
								<a href="" class="custom-like">
									<span class="custom-like_icon odnoklassniki"></span>
									<span class="custom-like_value">0</span>
								</a>
								<a href="" class="custom-like">
									<span class="custom-like_icon vkontakte"></span>
									<span class="custom-like_value">1900</span>
								</a>
							
								<a href="" class="custom-like">
									<span class="custom-like_icon facebook"></span>
									<span class="custom-like_value">150</span>
								</a>
							
								<a href="" class="custom-like">
									<span class="custom-like_icon twitter"></span>
									<span class="custom-like_value">10</span>
								</a>
							</div>
							
						</div>
							
						</div>
						
						<div class="horoscope-fast-list clearfix">
							<ul>
								<li><div class="other">Смотреть другие знаки</div></li>
								<li><a href=""><img src="/images/widget/horoscope/small/2.png" /><br/><span>Телец</span><br/>22.01 - 3.02</a></li>
								<li><a href=""><img src="/images/widget/horoscope/small/3.png" /><br/><span>Близнецы</span><br/>22.01 - 3.02</a></li>
								<li><a href=""><img src="/images/widget/horoscope/small/4.png" /><br/><span>Рак</span><br/>22.01 - 3.02</a></li>
								<li><a href=""><img src="/images/widget/horoscope/small/5.png" /><br/><span>Лев</span><br/>22.01 - 3.02</a></li>
								<li><a href=""><img src="/images/widget/horoscope/small/6.png" /><br/><span>Дева</span><br/>22.01 - 3.02</a></li>
								<li><a href=""><img src="/images/widget/horoscope/small/7.png" /><br/><span>Весы</span><br/>22.01 - 3.02</a></li>
								<li><a href=""><img src="/images/widget/horoscope/small/8.png" /><br/><span>Скорпион</span><br/>22.01 - 3.02</a></li>
								<li><a href=""><img src="/images/widget/horoscope/small/9.png" /><br/><span>Стрелец</span><br/>22.01 - 3.02</a></li>
								<li><a href=""><img src="/images/widget/horoscope/small/10.png" /><br/><span>Козерог</span><br/>22.01 - 3.02</a></li>
								<li><a href=""><img src="/images/widget/horoscope/small/11.png" /><br/><span>Водолей</span><br/>22.01 - 3.02</a></li>
								<li><a href=""><img src="/images/widget/horoscope/small/12.png" /><br/><span>Рыбы</span><br/>22.01 - 3.02</a></li>
							</ul>
						</div>
						
            
						<div class="wysiwyg-content">
							
							<p>Этот день открывает массу возможностей, но воспользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким. К профессиональным разногласиям относитесь спокойно, сегодня они являются всего лишь частью нормального рабочего процесса. Даже с руководством можно поспорить от души – и без всяких далеко идущих последствий. </p>
							
							<p>Этот день открывает массу возможностей, но воспользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким. К профессиональным разногласиям относитесь спокойно, сегодня они являются всего лишь частью нормального рабочего процесса. Даже с руководством можно поспорить от души – и без всяких далеко идущих последствий. </p>
							
							<p>Этот день открывает массу возможностей, но воспользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким.</p>
							
						</div>
						<!-- для гороскопа на сегодня -->
						<div class="horoscope-otherday">
							А еще гороскоп Овна на: <a href="">завтра</a>
						</div>
						<!-- для гороскопа на завтра -->
						<div class="horoscope-otherday">
							А еще гороскоп Овна на: <a href="">5 ноября</a> <a href="">6 ноября</a>
						</div>
						<!-- для гороскопа на месяц -->
						<div class="horoscope-otherday">
							А еще гороскоп Овна на: 
							<div class="row">
								<span><a href="">декабрь 2012</a> &larr;</span>
								<span>&rarr; <a href="">январь 2013</a></span>
								<a href="">февраль 2013</a>
								<a href="">март 2013</a>
								<a href="">апрель 2013</a>
								<a href="">май 2013</a>
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
