<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="top-nav-fixed ie7"> <![endif]-->
<!--[if IE 8]>         <html class="top-nav-fixed ie8"> <![endif]-->
<!--[if IE 9]>         <html class="top-nav-fixed ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="top-nav-fixed"> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	<script type="text/javascript">
		function addMenuToggle(el){
			$(el).parents('.add-menu').find('ul').toggle();
			$(el).parents('.add-menu').find('.btn i').toggleClass('arr-t');
		}
	</script>
</head>
<body class="body-club">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
		
		<div id="content" class="layout-content clearfix">
			
			<div id="user">
				
				<div class="user-cols clearfix">
					
					<div class="col-1">
						
						<div class="user-name nofloat">
							<h1>Ден Ижецкий</h1>
							<div class="online-status offline"><i class="icon"></i>Был на сайте <span class="date">Сегодня 16:39</span></div>
							<div class="location clearfix">
                   				<div title="Россия" class="flag-big flag-big-ru"></div>
                   				<span>Переславль-Залесский, Астраханская область</span>
                   			</div>
						</div>					
						
						<div class="ava big male">
							<a href="#photoPick" class="fancy renew">Обновить<br/>фото</a>
						</div>
						
						<div class="details">
							Зарегистрирван  25 февраля 2012
						</div>
						
						<div class="user-lvl user-lvl-1"></div>
						
						
						<div class="user-family">
							<div class="t"></div>
							<div class="c">
								<div class="user-family_staff">
									<span>Женат,</span>
									<div class="icon-boy"></div>
									<div class="icon-girl"></div>
									<div class="icon-baby"></div>
								</div>
								<ul>
									<li>
										<big>Катя &nbsp; <small>Моя&nbsp;невеста</small></big>
										<div class="comment blue">
											Очень любит готовить, заниматься с детьми, очень добрая и отзывчивая
											<span class="tale"></span>
										</div>
										<div class="img">
											<img src="/images/example/ex1.png" />
										</div>
									</li>
									<li>
										<big>Вильгельмина &nbsp; <small>Моя&nbsp;невеста</small></big>
										<div class="comment purple">
											Очень любит готовить, заниматься с детьми, очень добрая и отзывчивая
											<span class="tale"></span>
										</div>
										<div class="img">
											<img src="/images/example/ex2.png" />
										</div>
									</li>
									<li>
										<big>Артем, <span>10 лет</span></big>
										<div class="comment purple">
											Очень любит готовить, заниматься с детьми, очень добрая и отзывчивая
											<span class="tale"></span>
										</div>
										<div class="img">
											<img src="/images/example/ex3.jpg" />
										</div>
									</li>
									<li>
										<big>Настенька, <span>7 лет</span></big>
										<div class="comment pink">
											Мелкая, веселая ;)
											<span class="tale"></span>
										</div>
										<div class="img">
											<img src="/images/example/ex3.jpg" />
										</div>
									</li>
									
								</ul>
								<div class="user-family-settings clearfix">
									<div class="a-right tooltip-new">9 новых</div>
									<a class="a-right pseudo" href="">Стиль статуса</a>
								</div>
							</div>
							<div class="b"></div>
						</div>
						
						<div class="user-family user-family-cap user-family-border-8">
							<div class="t"></div>
							<div class="c">
								<a href="" class="cap"><span>Расскажите<br/>о своей семье</span></a>
							</div>
							<div class="b"></div>
						</div>
						
						<div class="user-interests">
							
							<div class="box-title">Интересы<a href="#interestsEdit" class="interest-add fancy" data-theme="second"></a> <a href="#interestsManage" class="fancy">edit</a></div>
							
							<ul>
								<li>
                  <div class="interest-cat">
                      <img src="/images/interest_icon_1.png" />
                  </div>
                  <ul class="interests-list">
                    <li><a class="interest">Бильярд</a></li>
                  </ul>
                </li>
                <li>
                  <div class="interest-cat">
										<img src="/images/interest_icon_2.png" />
									</div>
                  <ul class="interests-list">
                    <li><a class="interest">Футбол</a></li>
                    <li><a class="interest">Хоккей</a></li>
                    <li><a class="interest">Художественная гимнастика</a></li>
                    <li><a class="interest">Бокс</a></li>
                    <li><a class="interest">Бильярд</a></li>
                  </ul>
                </li>                
							</ul>
							
						</div>
						
						
						
					</div>
					
					<div class="col-23 clearfix">
						
						
						<div id="first-steps">
							
							<div class="block-title">
								
								<div class="right">
									<div class="bonus" style="display: none;">
										бонус <img src="/images/first_steps_bonus.png" />
									</div>
									<a href="javascript:void(0);" class="toggler toggled" data-title="Осталось шагов: 4" data-close="Свернуть" onclick="firstStepsToggle(this);"><span>Свернуть</span><i class="icon"></i></a>
								</div>
								
								<div class="title-in">Ваши первые шаги</div>
								
							</div>
							
							<div class="block-in clearfix">
								
								<div class="container clearfix">
									<div class="steps-list">
										<ul>
											<li>
												<div class="num">Шаг 1</div>
												<div class="text"><a href="#firstStepsEmail" class="fancy">Подтвердите ваш e-mail</a></div>
												
											</li>
											<li>
												<div class="num">Шаг 2</div>
												<div class="text"><a href="#firstStepsBirthday" class="fancy">Укажите вашу дату рождения</a></div>
											</li>
											<li>
												<div class="num">Шаг 3</div>
												<div class="text"><a href="#firstStepsLocation" class="fancy">Укажите ваше место жительства</a></div>
											</li>
											<li class="strike">
												<div class="num">Шаг 4</div>
												<div class="text">Загрузите ваше главное фото</div>
												<div class="done"><i class="icon"></i>Сделано</div>
											</li>
											<li>
												<div class="num">Шаг 5</div>
												<div class="text"><a href="">Расскажите о вашей семье</a></div>
											</li>
											<li>
												<div class="num">Шаг 6</div>
												<div class="text"><a href="">Укажите ваши интересы</a></div>
											</li>
											
										</ul>
									</div>
									
									<div class="info">
										<p><span>6 шагов</span> и вы сможете пользоваться всеми функциями сайта</p>
										<div class="bonus">
											<div class="bonus-left">
												<img src="/images/first_steps_bonus_plus.png" /> от нас бонус на
											</div>
											<img src="/images/first_steps_bonus_big.png" />
										</div>
									</div>
								</div>
							</div>							
						</div>
						
						
						<div class="clearfix">
							<div class="col-2">
								
								<div class="user-mood">
									Мое настроение<img id="userMood" src="/images/widget/mood/1.png" /> <a href="" class="pseudo small">Изменить</a>
								</div>
								
								<div class="user-status toggled">
									<div class="date">20 февраля 2012, 13:45</div>
									<p>Привет всем! У меня все ok!<br/>Единственное, что имеет значение в конце нашего пребывания на земле, - это то, как сильно мы любили. </p>
								</div>
								
								<div class="user-purpose">
									<i class="icon"></i>
									<span>Цель №1</span>
									<p>Хочу в этом году поехать с семьей на море</p>
								</div>
								
								<div class="user-blog">
									
									<div class="box-title">Блог <a href="">Все записи (25)</a></div>
									
									<ul>
										<li>
											<a href="">Профилактика атопического дерматита</a>
											<div class="date">3 сентября 2011, 08:25</div>
											<p>Детям до года врачи не рекомендуют, а точнее говоря, запрещают спать на подушке... а точнее говоря, запрещают спать на подушке...</p>
										</li>
										<li>
											<a href="">Профилактика атопического дерматита</a>
											<div class="date">3 сентября 2011, 08:25</div>
											<p>Детям до года врачи не рекомендуют, а точнее говоря, запрещают спать на подушке...</p>
										</li>
										<li>
											<a href="">Профилактика атопического дерматита</a>
											<div class="date">3 сентября 2011, 08:25</div>
											<p>Детям до года врачи не рекомендуют, а точнее говоря, запрещают спать на подушке...</p>
										</li>
										<li>
											<a href="">Профилактика атопического дерматита</a>
											<div class="date">3 сентября 2011, 08:25</div>
											<p>Детям до года врачи не рекомендуют, а точнее говоря, запрещают спать на подушке... а точнее говоря, запрещают спать на подушке... а точнее говоря, запрещают спать на подушке...</p>
										</li>
										
									</ul>
									
								</div>
								
								<div class="user-clubs clearfix">
									
									<div class="box-title">Клубы <a href="">Все клубы (105)</a></div>
									
									<ul>
										<li class="club-img kids">
											<a href="">
												<img src="/images/club_img_3.png" />
												<span>Подготовка и роды</span>
											</a>
										</li>
										<li class="club-img kids">
											<a href="">
												<img src="/images/club_img_7.png" />
												Режим и уход
											</a>
										</li>
										<li class="club-img manwoman">
											<a href="">
												<img src="/images/club_img_19.png" />
												Отношения
											</a>
										</li>
										<li class="club-img beauty">
											<a href="">
												<img src="/images/club_img_21.png" />
												Красота
											</a>
										</li>
										<li class="club-img beauty">
											<a href="">
												<img src="/images/club_img_22.png" />
												Мода и шопинг
											</a>
										</li>
										<li class="club-img home">
											<a href="">
												<img src="/images/club_img_28.png" />
												Загородная жизнь
											</a>
										</li>
										<li class="club-img hobbies">
											<a href="">
												<img src="/images/club_img_31.png" />
												За рулем
											</a>
										</li>
										<li class="club-img hobbies">
											<a href="">
												<img src="/images/club_img_32.png" />
												Цветоводство
											</a>
										</li>
										<li class="club-img rest">
											<a href="">
												<img src="/images/club_img_34.png" />
												Путешествия семьей
											</a>
										</li>
									</ul>
									
								</div>
								
								<div class="user-albums user-add">
								
									<div class="box-title">Фото</div>
									
									<a href=""><img src="/images/user_photo_add.png" /></a>
									<a href="">Загрузить<br/>фото</a>
									
								</div>
								
								<div class="user-albums">
								
									<div class="box-title">Фотоальбомы <a href="">Все альбомы (12)</a></div>
									
									<ul>
										<li>
											<big>Альбом «Поездка в Турцию»</big>
											<div class="clearfix">
												<div class="preview">
													<img src="/images/album_photo_01.jpg" class="img-1" />
													<img src="/images/album_photo_02.jpg" class="img-2" />
													<img src="/images/album_photo_03.jpg" class="img-3" />
												</div>
												<a href="" class="more"><i class="icon"></i>еще 63 фото</a>
											</div>
										</li>
										<li>
											<big>Альбом «Поездка в Турцию»</big>
											<div class="clearfix">
												<div class="preview">
													<img src="/images/album_photo_04.jpg" class="img-1" />
													<img src="/images/album_photo_05.jpg" class="img-2" />
													<img src="/images/album_photo_06.jpg" class="img-3" />
												</div>
												<a href="" class="more"><i class="icon"></i>еще 63 фото</a>
											</div>
										</li>
										
									</ul>
									
								</div>
								
							</div>
							
							<div class="col-3">
								
								<div class="user-friends clearfix">
									
									<div class="box-title">Друзья <a href="">Все друзья (105)</a></div>
									
									<ul class="clearfix">
										<li><a href="" class="ava"></a></li>
										<li><a href="" class="ava male"></a></li>
										<li><a href="" class="ava"><img src="/images/user_friends_img.jpg" /></a></li>
										<li><a href="" class="ava"><img src="/images/user_friends_img.jpg" /></a></li>
										<li><a href="" class="ava female"></a></li>
										<li><a href="" class="ava"><img src="/images/user_friends_img.jpg" /></a></li>
										<li><a href="" class="ava male"></a></li>
										<li><a href="" class="ava"></a></li>
									</ul>
									
									<div class="more-friends">
										<a href=""><i class="ico-friends-small"></i>Найти еще друзей</a>
										 <a href="" class="wannachat">Хочу общаться!</a>
									</div>
									
								</div>
								<br/><br/> <!-- этих <br/> быть не должно, просто из-за дублирования блока-->
								<div class="user-friends clearfix">
									
									<div class="box-title">Друзья <a href="">Найти друзей</a></div>
									
									<a href=""><img src="/images/cap_wannachat.png" /></a>
									
								</div>
								
								<div class="user-map">
									<div class="header">
										<div class="box-title">Я здесь</div>
										<div class="sep"><img src="/images/map_marker.png" /></div>
									</div>
									<form>
										<div class="row">
											<label>Место жительства</label>
											<select class="chzn w-100" data-placeholder="Страна">
												<option></option>
												<option>Россия</option>
												<option>Украина</option>
											</select>
											&nbsp;&nbsp;
											<span class="with-search">
												<select class="chzn w-200" data-placeholder="Регион">
													<option></option>
													<option>Россия</option>
													<option>Украина</option>
												</select>
											</span>
										</div>
										<div class="row">
											<label>Населенный пункт</label>
											<input type="text" /><br/>
											<small>Введите свой город, поселок, село или деревню</small>
										</div>
										<div class="row" style="text-align:right;">
											<button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
										</div>
									</form>
								</div>
								
								<div class="user-map">
									<div class="header">
										<a href="#locationEdit" class="edit fancy"><span class="tip">Изменить</span></a>
										<div class="box-title">Я здесь</div>
										<div class="sep"><img src="/images/map_marker.png" /></div>
										<div class="location">
											<div class="flag flag-ru"></div> Россия
											<p>Ярославская облась Гаврилов-Ямский р-он п. Великое</p>
										</div>
									</div>
									<img src="/images/user_map_img.jpg" />
								</div>
								
								<div class="user-map user-add">
									<a href="javascript:void(0);" class="flip('#userMapForm);"><big>Я живу<br/>здесь</big><img src="/images/user_map_cap.png" /></a>
								</div>
								
								<div class="user-weather">
									
									<div class="box-title"><a href="" class="a-right pseudo">Еще на три дня</a>Моя погода</div>
									
									<div class="clearfix">
										
										<div class="img"><img src="/images/widget/weather/big/3.png" /></div>
										
										<div class="text">
											<big>-16</big>
											<div class="row hl"><span>Ночью</span>-22</div>
											<div class="row"><span>Завтра</span>-17</div>
										</div>

									</div>
									
								</div>
								
								<div class="user-weather">
									
									<div class="box-title"><a href="" class="a-right pseudo">Погода сейчас</a>Моя погода</div>
									
									<table>
										<thead>
											<tr>
												<td>Завтра</td>
												<td>Пн</td>
												<td>Вт</td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><img src="/images/widget/weather/small/1.png" /></td>
												<td><img src="/images/widget/weather/small/2.png" /></td>
												<td><img src="/images/widget/weather/small/3.png" /></td>
											</tr>
											<tr>
												<td>-16</td>
												<td>-19</td>
												<td>-25</td>												
											</tr>
											<tr class="hl">
												<td>-16</td>
												<td>-19</td>
												<td>-25</td>											
											</tr>											
										</tbody>
									</table>
									
								</div>
								
								<div class="user-horoscope-2">
									
									<div class="title-row clearfix">
										<div class="user-horoscope-2_img"><img src="/images/widget/horoscope/middle/10.png" /></div>
										<div class="user-horoscope-2_date">2<span>апр</span></div>
										<div class="user-horoscope-2_title">Близнецы <em>22.01 - 3.02</em></div>
									</div>
									
									<p>Вы настроены на игривый лад – Вам больше хочется развлекаться, чем работать. Да и работа отвечает Вам взаимностью – дела стоят на месте, приходится возвращаться к, казалось бы, уже решенным вопросам и переделывать многое  
									Вам хотелось бы организовать эффективное взаимодействие в совместных проектах. Однако идеи, которые придут к Вам сегодня, могут оказаться не слишком продуманными.</p>
									
									<div class="user-horoscope-2_likes">
										<div class="user-horoscope-2_likes-title">Отметь, если понравился!</div>
										<div class="custom-likes-small">
											<a href="" class="custom-like-small">
												<span class="custom-like-small_icon odkl"></span>
												<span class="custom-like-small_value">0</span>
											</a>
											<a href="" class="custom-like-small">
												<span class="custom-like-small_icon mailru"></span>
												<span class="custom-like-small_value">15 900</span>
											</a>
										
											<a href="" class="custom-like-small">
												<span class="custom-like-small_icon vk"></span>
												<span class="custom-like-small_value">154 900</span>
											</a>
										
											<a href="" class="custom-like-small">
												<span class="custom-like-small_icon fb"></span>
												<span class="custom-like-small_value">15 900</span>
											</a>
										</div>
									</div>
									
									<div class="user-horoscope-2_tomorrow">
										<div class="icon-zodiac"><img src="/images/widget/horoscope/icon-h36/10.png" /></div>
										<a href="">Узнай что будет завтра</a>
									</div>
									
								</div>
								
								<div class="user-horoscope-prev">
									<div class="user-horoscope-prev_holder">
										<div class="clearfix">
											<div class="user-horoscope-prev_img"><img src="/images/widget/horoscope/big/5.png" /></div>
											<div class="user-horoscope-prev_title">Близнецы <em>22.01 - 3.02</em></div>	
										</div>
										<div class="user-horoscope-prev_date">2<span>апр</span></div>
										<div class="btn-green twolines">
											<span class="big">Посмотреть</span>
											<span class="small">гороскоп</span>
										</div>
									</div>
								</div>
								
								<div class="user-duel">
									
									<div class="box-title">Моя <span>дуэль</span></div>
									
									<div class="question">
										<p>Почему одна строка?</p>
									</div>
									
									<div class="my-votes clearfix">
										<a href="" class="ava male"></a>
										<div class="in">
											<span class="tale"></span>
											<div class="label">Увы, проигрываю!</div>
											<img src="/images/user_duel_smile_losing.png" />
											<div class="count">
												<span>86</span>
												голосов
											</div>
											<br/>
											<a href="#duel-takeapart" class="pseudo fancy">Посмотреть дуэль</a>
										</div>
									</div>
									
									<div class="my-votes clearfix">
										<a href="" class="ava male"></a>
										<div class="in">
											<span class="tale"></span>
											<div class="label">Ништяк, побеждаем!</div>
											<img src="/images/user_duel_smile_winning.png" />
											<div class="count">
												<span>86</span>
												голосов
											</div>
											<br/>
											<a href="#duel-takeapart" class="pseudo fancy">Посмотреть дуэль</a>
										</div>
									</div>
									
									<div class="my-votes clearfix">
										<a href="" class="ava male"></a>
										<div class="in">
											<span class="tale"></span>
											<div class="label">Хех, ничья!</div>
											<img src="/images/user_duel_smile_draw.png" />
											<div class="count">
												<span>86</span>
												голосов
											</div>
											<br/>
											<a href="#duel-takeapart" class="pseudo fancy">Посмотреть дуэль</a>
										</div>
									</div>
									
									<div class="opponent clearfix">
										Мой противник
										<div class="count">
											<span>116</span>
											голосов
										</div>
										<div class="user-info clearfix">
											<a class="ava small female"></a>
											<div class="details">
												<span class="icon-status status-online"></span>
												<a href="" class="username">Даша Ефросинина</a>
											</div>
										</div>
									</div>
									
								</div>
								
							</div>					
						
						</div>
						
						<div class="broadcast-widget">
							<div class="broadcast-title-box">
								<ul class="broadcast-widget-menu-r">
									<li>
										<a href="">В прямом эфире</a>
									</li>
									<li>
										<a href="">В клубах</a>
									</li>
									<li>
										<a href="">В блогах</a>
									</li>
								</ul>
								
								<div class="title">
									<span class="icon-boradcast-small" ></span> Что нового у моих друзей
								</div>
							</div>

							<div  class="masonry-news-list clearfix ">
							<script>
  $(function(){

        $(".masonry-news-list").masonry({
          itemSelector : '.masonry-news-list_item',
          columnWidth: 240,
          isAnimated: false,
          animationOptions: { queue: false, duration: 500 }
        });

  })
						</script>
								<ul>
									
								<li class="masonry-news-list_item">
									<div class="masonry-news-list_friend-info clearfix">
										<a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
										<div class="details">
											<a class="username" href="">Александр</a>
											<span class="date">Сегодня 13:25</span>
											<p>Добавила комментарий  в клубе </p>
										</div>
									</div>
									<div class="masonry-news-list_comment">
										<div class="masonry-news-list_comment-text">
											Проблема в том, что на 2006-ой год игры еще толком не было, Роды — отправная точка для самых важных изменений и судьбоносных. Осень. Я ее люблю, но когда начинается непонятная погода, хочется лезть на стенку. Сегодня на улице вот +8, вроде тепло, но вот туман.
										</div>
									</div>
									<div class="masonry-news-list_meta-info clearfix">к записи</div>
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука 123 123</a>
									</h3>
									<div class="masonry-news-list_meta-info clearfix">
										
										<div class="meta">
											<div class="views"><span class="icon" href="#"></span> <span>11265</span></div>
											<div class="comments">
												<a class="icon" href="#"></a>
												<a href="">155</a>
											</div>
										</div>
										
										<a href="" class="textdec-onhover">Вступить <br />в беседу!</a>
									</div>
								</li>
								
								<li class="masonry-news-list_item blog">
									<div class="masonry-news-list_friend-info clearfix">
										<a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
										<div class="details">
											<a class="username" href="">Александр</a>
											<span class="date">Сегодня 13:25</span>
											<p>Добавила комментарий  в блоге </p>
										</div>
									</div>
									<div class="masonry-news-list_comment">
										<div class="masonry-news-list_comment-text">
											<a href="">Проблема в том, что на 2006-ой год игры еще толком не было... </a>
										</div>
									</div>
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука 123 123</a>
									</h3>
									<div class="masonry-news-list_meta-info clearfix">
										
										<div class="meta">
											<div class="views"><span class="icon" href="#"></span> <span>5</span></div>
											<div class="comments">
												<a class="icon" href="#"></a>
												<a href="">5</a>
											</div>
										</div>
										
										<a href="" class="textdec-onhover">Вступить <br />в беседу!</a>
									</div>
								</li>
								
								<li class="masonry-news-list_item">
									<div class="masonry-news-list_friend-info clearfix">
										<a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
										<div class="details">
											<a class="username" href="">Александр</a>
											<span class="date">Сегодня 13:25</span>
											<p>Добавила запись</p>
										</div>
									</div>
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука. Раннее развитие и обучение.</a>
									</h3>
									<div class="clearfix">
										<a href="" class="club-category manwoman">Раннее развитие и обучение.</a>
									</div>
									<div class="masonry-news-list_content">
										<a href=""><img src="/images/example/gallery_album_img_10.jpg" alt="" /></a>
										<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Читать</a></p>
									</div>
									
									<div class="masonry-news-list_meta-info clearfix">
										<div class="meta">
											<div class="views"><span class="icon" href="#"></span> <span>265</span></div>
											<div class="comments">
												<a class="icon" href="#"></a>
												<a href="">152</a>
											</div>
										</div>
										
										<a href="" class="textdec-onhover">Добавить <br />комментарий</a>
									</div>
								</li>
								
								<li class="masonry-news-list_item blog">
									<div class="masonry-news-list_friend-info clearfix">
										<a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
										<div class="details">
											<a class="username" href="">Александр</a>
											<span class="date">Сегодня 13:25</span>
											<p>Добавила запись </p>
										</div>
									</div>
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука. Раннее развитие и обучение.</a>
									</h3>
									<div class="clearfix">
										<a class="sub-category" href=""><span class="icon-blog"></span>Личный блог</a>
									</div>
									<div class="masonry-news-list_content">
										<a href=""><img src="/images/example/gallery_album_img_10.jpg" alt="" /></a>
										<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Читать</a></p>
									</div>
									
									<div class="masonry-news-list_meta-info clearfix">
										<div class="meta">
											<div class="views"><span class="icon" href="#"></span> <span>265</span></div>
											<div class="comments">
												<a class="icon" href="#"></a>
												<a href="">152</a>
											</div>
										</div>
										
										<a href="" class="textdec-onhover">Добавить <br />комментарий</a>
									</div>
								</li>
								
								<li class="masonry-news-list_item">
									<div class="masonry-news-list_friend-info clearfix">
										<a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
										<div class="details">
											<a class="username" href="">Александр</a>
											<span class="date">Сегодня 13:25</span>
											<p>Изменила цель </p>
										</div>
									</div>
									<div class="user-purpose">
									    <i class="icon"></i>
									    <div class="purpose-container">
										<span>Цель №1</span><p>На море с дочкой летом</p>
										</div>
									</div>
								</li>
								
								<li class="masonry-news-list_item">
									<div class="masonry-news-list_friend-info clearfix">
										<a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
										<div class="details">
											<a class="username" href="">Александр</a>
											<span class="date">Сегодня 13:25</span>
											<p>Изменила статус </p>
										</div>
									</div>
									<div class="clearfix user-info-big">
										<div class="text-status">
									        <p>Родители всегда говорили мне, что я могу добиться чего угодно! Родители всегда говорили мне...</p>
									        <span class="tale"></span>
									        <div class="meta nofloat">
												<span class="views"><span class="icon" href="#"></span> <span>265</span></span>
												<span class="comments">
													<a class="icon" href="#"></a>
													<a href="">15233</a>
												</span>
											</div>
									    </div>
									</div>
									<div class="comments-all clearfix">
										<a href="">Добавить комментарий</a>
									</div>
								</li>
								
								<li class="masonry-news-list_item">
									<div class="masonry-news-list_friend-info clearfix">
										<a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
										<div class="details">
											<a class="username" href="">Алекса</a>
											<span class="date">Сегодня 13:25</span>
											<p>Участвует в фотоконкурсе </p>
										</div>
									</div>
									<div class="contest-participant">
										<img class="title-img" alt="" src="/images/broadcast/title-contest-4.jpg">
										<div class="img">
											<a href="">
												<img src="/images/example/gallery_album_img_01.jpg">
												<span class="btn">Посмотреть</span>
											</a>
										<div class="item-title">Разнообразие десертов сицилийского стиля</div>
										</div>
										<div class="clearfix">
											<div class="position">
												<strong>18</strong> место
											</div>
											<div class="ball">
												<div class="ball-count">186</div>
												<div class="ball-text">баллов</div>
											</div>
										</div>
									</div>
									<div class="comments-all">
										<a href="" class="textdec-onhover">Поддержите друга!</a>
									</div>
								</li>
								
								</ul>
							</div>
						</div>
						
						<div class="default-comments">
							
							<div class="comments-meta clearfix">
								<div class="add-menu">
									<a href="javascript:void(0);" class="btn btn-orange a-right" onclick="addMenuToggle(this);"><span><span>Добавить запись<i class="arr-b"></i></span></span></a>
									<ul style="display:none;">
										<li><a href="javascript:void(0);" onclick="addMenuToggle(this);">Текст</a></li>
										<li><a href="javascript:void(0);" onclick="addMenuToggle(this);">Картинка</a></li>
									</ul>
								</div>
								<div class="title">Гостевая</div>
								<div class="count">55</div>
							</div>
							
							<ul>
								<li class="author-comment">
									<div class="comment-in clearfix">
										<div class="header clearfix">
											<div class="user-info clearfix">
												<div class="ava female"></div>
												<div class="details">
													<span class="icon-status status-online"></span>
													<a href="" class="username">Дарья</a>
													<div class="user-fast-buttons clearfix">
														<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
														<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
													</div>
													
												</div>
											</div>
										</div>
										<div class="content">
											<div class="meta">
												<span class="date">Сегодня, 20:45</span>
											</div>
											<div class="content-in">
												<div class="wysiwyg-content">
													<h2>Как выбрать детскую коляску</h2>
									
													<p>Как правило, кроватку новорожденному приобретают незадолго до его появления на свет. При этом многие молодые <b>родители</b> обращают внимание главным <u>образом</u> на ее <strike>внешний</strike> вид. Но, прельстившись яркими красками, многие платят баснословные суммы, даже не поинтересовавшись, из чего сделано это покорившее вас чудо.</p>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="comment-in clearfix">
										<div class="header clearfix">
											<div class="user-info clearfix">
												<div class="ava female"></div>
												<div class="details">
													<span class="icon-status status-online"></span>
													<a href="" class="username">Дарья</a>
													<div class="user-fast-buttons clearfix">
														<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
														<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
													</div>
													
												</div>
											</div>
										</div>
										<div class="content">
											<div class="meta">
												<span class="date">Сегодня, 20:45</span>
											</div>
											<div class="content-in">
												<p>Коляска просто супер!!! Очень удобная и функциональная. Ни разу не пожалели, что купили именно эту коляску. Это маленький вездеход :)</p>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="comment-in clearfix">
										<div class="header clearfix">
											<div class="user-info clearfix">
												<div class="ava female"></div>
												<div class="details">
													<span class="icon-status status-online"></span>
													<a href="" class="username">Дарья</a>
													<div class="user-fast-buttons clearfix">
														<span class="friend">друг</span>
														<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
													</div>
													
												</div>
											</div>
										</div>
										<div class="content">
											<div class="meta">
												<span class="date">Сегодня, 20:45</span>
											</div>
											<div class="content-in">
												<p>Коляска просто супер!!! Очень удобная и функциональная. Ни разу не пожалели, что купили именно эту коляску. Это маленький вездеход :)</p>
											</div>
										</div>
									</div>
								</li>
								
							</ul>
							
						</div>
						
					</div>
					
				</div>
	
			</div>
			
		</div>  	
		
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

<div style="display:none" class="popup-container">
	
	<div id="login" class="popup">
		
		<a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close"><span class="tip">Закрыть</span></a>
		
		<div class="popup-title">Вход на сайт</div>
		
		<form>
			<div class="form">
				
				<div class="a-right login-btn">
					
					<div class="remember">
						<label><input type="checkbox" /><br/>Запомнить меня</label>
					</div>
					
					<button class="btn btn-green-arrow-big"><span><span>Войти</span></span></button>
					
				</div>
				
				<div class="row">
					<div class="row-title">Ваш e-mail:</div>
					<div class="row-elements"><input type="text" /></div>
				</div>
				
				<div class="row">
					<div class="row-title">Ваш пароль:</div>
					<div class="row-elements"><input type="password" /></div>
					<div class="row-bottom"><a href="">Забыли пароль?</a></div>
				</div>
				
				<div class="row row-social">
					Быстрый вход:
					&nbsp;
					<a href=""><img src="/images/icon_social_odnoklassniki.png" /></a>
					<a href=""><img src="/images/icon_social_vkontakte.png" /></a>
					<a href=""><img src="/images/icon_social_mailru.png" /></a>
				</div>
				
				<div class="reg-link">
					
					<div class="a-right">
						<a class="btn btn-orange" href=""><span><span>Зарегистрироваться</span></span></a>
					</div>
					
					<div class="row"><span>Еще нет учетной записи?</span></div>
					
				</div>
				
			</div>
		</form>
		
	</div>
	
	<div id="interestsEdit" class="popup">
		
		<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>
		
		<div class="title">Ваши интересы</div>
		
		<div class="clearfix">
			
			<div class="nav">
				<ul>
					<li class="active"><a href="">Дети</a></li>
					<li><a href="">Мужчина и женщина</a></li>
					<li><a href="">Красота и здоровье</a></li>
					<li><a href="">Дом</a></li>
					<li><a href="">Интересы и увлечения</a></li>
					<li><a href="">Отдых</a></li>
				</ul>
			</div>
			
			<div class="interests-list">
				<ul>
					<li><a href="" class="interest kids selected">Планирование</a></li>
					<li><a href="" class="interest kids">Беременность</a></li>
					<li><a href="" class="interest manwoman selected">Свадьба</a></li>
					<li><a href="" class="interest beauty">Красота</a></li>
					<li><a href="" class="interest beauty selected">Мода</a></li>
					<li><a href="" class="interest home">Кухня</a></li>
					<li><a href="" class="interest hobbies selected">Спорт</a></li>
					<li><a href="" class="interest rest">Праздники</a></li>
					<li><a href="" class="interest rest selected">Путешествия</a></li>
				</ul>
			</div>
			
		</div>
		
		<div class="bottom">
			<button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
		</div>
		
	</div>
	
  <div id="interestsManage" class="popup">
		
		<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>
		
		<div class="title">Интересы</div>
    
    <div class="interests-steps clearfix">
      
      <div class="step-1"> 
        
        <div class="step-title clearfix">
          <span class="num">1</span>
          <span class="text">Выберите категорию</span>
        </div>
        
        <ul>
          <li><a href="">Еда и напитки</a></li>
          <li><a href="">Животные</a></li>
          <li><a href="">Игры</a></li>
          <li><a href="">Кино</a></li>
          <li><a href="">Музыка</a></li>
          <li><a href="">Книги и культура</a></li>
          <li><a href="">Компьютеры</a></li>
          <li><a href="">Культура</a></li>
          <li><a href="">Мода и красота</a></li>
          <li><a href="">Карьера и образование</a></li>
          <li><a href="">Религия</a></li>
          <li class="active"><a href="">Спорт</a></li>
          <li><a href="">Увлечения</a></li>
          <li><a href="">Ручная работа</a></li>
          <li><a href="">Телевидение</a></li>
          <li><a href="">Путешествия</a></li>
          <li><a href="">Литература</a></li>
          <li><a href="">Авиация</a></li>
          <li><a href="">Архитектура</a></li>
          <li><a href="">Дети</a></li>
        </ul>
        
      </div>
      
      <div class="step-2"> 
        
        <div class="step-title clearfix">
          <span class="num">2</span>
          <span class="text">Выберите интересы *</span>
        </div>
        
        <div class="interests-drag-list clearfix">
          
          <div class="interest-drag"><i class="icon"></i>Футбол</div>
          <div class="interest-drag"><i class="icon"></i>Хоккей</div>
          <div class="interest-drag"><i class="icon"></i>Дзюдо</div>
          <div class="interest-drag"><i class="icon"></i>Синхронное плавание</div>
          <div class="interest-drag"><i class="icon"></i>Велоспорт</div>
          <div class="interest-drag"><i class="icon"></i>Теннис</div>
          <div class="interest-drag"><i class="icon"></i>Фигурное катание</div>
          <div class="interest-drag"><i class="icon"></i>Бейсбол</div>
          <div class="interest-drag"><i class="icon"></i>Бокс</div>
          
        </div>
        
        <div class="note">
          <span>*</span> Подведи курсор, хватай и тащи
        </div>
        <img src="/images/interests_drag_note.png" />
        
      </div>
      
      <div class="step-3"> 
        
        <div class="step-title clearfix">
          <span class="num">3</span>
          <span class="text">Мои<br/>интересы</span>
        </div>
        
        <div class="drag-in-area clearfix">
          
          <span class="small">Выберите  от 1 до 10 ваших интересов</span>
            
          <span class="text clearfix"><img src="/images/interests_drag_in_arrow.gif" />Перетащите сюда интерес</span>
            
        </div>
        
        <div class="selected-interests-list">
          <ul>
            <li>
              <span class="img"><a href=""><img src="/images/interest_icon_1.png" /></a></span>
              <span class="text">
                <a href="">Футбол</a>
                <a href="" class="remove tooltip" title="Убрать"></a>
              </span>              
            </li>
            <li>
              <span class="img"><a href=""><img src="/images/interest_icon_2.png" /></a></span>
              <span class="text">
                <a href="">Компьютеры, интернет, гаджеты</a>
                <a href="" class="remove tooltip" title="Убрать"></a>
              </span>
            </li>
            <li>
              <span class="img"><a href=""><img src="/images/interest_icon_3.png" /></a></span>
              <span class="text">
                <a href="">Профессии</a>
                <a href="" class="remove tooltip" title="Убрать"></a>
              </span>
              
            </li>
            <li>
              <span class="img"><a href=""><img src="/images/interest_icon_4.png" /></a></span>
              <span class="text">
                <a href="">Лекарственные препараты</a>
                <a href="" class="remove tooltip" title="Убрать"></a>
              </span>
              
            </li>
            <li>
              <span class="img"><a href=""><img src="/images/interest_icon_5.png" /></a></span>
              <span class="text">
                <a href="">Детективы</a>
                <a href="" class="remove tooltip" title="Убрать"></a>
              </span>
              
            </li>
            <li>
              <span class="img"><a href=""><img src="/images/interest_icon_6.png" /></a></span>
              <span class="text">
                <a href="">Ландшафтная архитектура</a>
                <a href="" class="remove"></a>
              </span>
              
            </li>
          </ul>
          
          <div class="btn-box"><a href="" class="btn-finish">Завершить</a></div>
          
        </div>
        
        
        
      </div>
      
    </div>
	
  </div>
  
	<div id="locationEdit" class="popup">
		
		<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>
		
		<div class="popup-title">Место жительства</div>
		
		<form>
			<div class="form">
				<div class="row clearfix">
					<div class="row-title">Страна</div>
					<div class="row-elements">
						<select class="chzn w-300">
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							
						</select>
					</div>
				</div>
				<div class="row clearfix">
					<div class="row-title">Регион</div>
					<div class="row-elements">
						<select class="chzn w-300">
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							<option>Украина</option>
							<option>Россия</option>
							
						</select>
					</div>
				</div>
				<div class="row clearfix">
					<div class="row-title">Населенный пункт</div>
					<div class="row-elements">
						<input type="text" class="w-300" /><br/>
						Введите свой город, поселок, село или деревню
					</div>
				</div>
				<div class="row">
					<button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
				</div>
			</div>
		</form>
		
	</div>
	
	<div id="photoPick" class="popup v2">

		<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>

		<div class="title">Фотография для конкурса «Осенние прогулки»</div>

		<div class="nav">
			<ul>
				<li><a href="">С компьютера</a></li>
				<li class="active"><a href="">Из моих альбомов</a></li>
			</ul>
		</div>

		<div class="nav v-nav">
			<ul>
				<li class="active"><a href="">Отдых в Турции</a></li>
				<li><a href="">Поездка на Алтай</a></li>
				<li><a href="">Домашние фото</a></li>
			</ul>
		</div>

		<div id="gallery">

			<div class="gallery-photos clearfix">

				<ul>
					<li>
						<table>
							<tr>
								<td class="img">
									<div>
										<a href=""><img src="/images/example/ex1.png" /></a>
										<div class="contest-send">
											<a href="" class="btn btn-green-medium"><span><span>Сделать<br/>главным</span></span></a>
										</div>
									</div>									
								</td>
							</tr>
							<tr class="rank"><td><span>117</span> баллов</td></tr>
							<tr class="title">
								<td align="center"><div>Наш дайвинг</div></td>
							</tr>

						</table>
					</li>
					<li>
						<table>
							<tr>
								<td class="img">
									<div>
										<a href=""><img src="/images/example/ex2.png" /></a>
										<div class="contest-send">
											<a href="" class="btn btn-green-medium"><span><span>Сделать<br/>главным</span></span></a>
										</div>
									</div>
								</td>
							</tr>
							<tr class="rank"><td><span>7</span> баллов</td></tr>
							<tr class="title">
								<td align="center" width="1%"><div>Наш дайвинг и еще много много текста</div></td>									
							</tr>

						</table>
					</li>
					<li>
						<table>
							<tr>
								<td class="img">
									<div>
										<a href=""><img src="/images/example/ex3.jpg" /></a>
										<div class="contest-send">
											<a href="" class="btn btn-green-medium"><span><span>Сделать<br/>главным</span></span></a>
										</div>
									</div>
								</td>
							</tr>
							<tr class="rank"><td><span>17</span> баллов</td></tr>
							<tr class="title">
								<td align="center"><div>Наш дайвинг</div></td>
							</tr>

						</table>
					</li>

				</ul>

			</div>

			<div class="pagination pagination-center clearfix">
				<div class="pager">
					Страницы:
					<ul>
						<li class="previous"><a href=""></a></li>
						<li><a href=""><span>1</span></a></li>
						<li><a href=""><span>2</span></a></li>
						<li class="selected"><a href=""><span>321</span></a></li>
						<li><a href=""><span>4</span></a></li>
						<li><a href=""><span>5</span></a></li>
						<li><a href=""><span>6</span></a></li>
						<li><a href=""><span>7</span></a></li>
						<li class="next"><a href=""></a></li>
					</ul>
				</div>
			</div>

		</div>

	</div>
	
	
	<div id="duel-takeapart" class="popup">
		
		<a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close"><span class="tip">Закрыть</span></a>
		
		<div class="activity-duel">
			
			<div class="title">Дуэль</div>
			
			<div class="question">
				<p>Давно интересующий всех вопрос. Что раньше появилось яйцо или курица?</p>
				<span class="tale tale-1"></span>
				<span class="tale tale-2"></span>
			</div>
			
			<div class="answers clearfix">
				
				<div class="clearfix">
					<div class="answer-1">
						<div class="user-info clearfix">
							<a class="ava female"></a>
							<div class="details">
								<span class="icon-status status-online"></span>
								<a href="" class="username">Богоявленский</a>
								<div class="user-fast-buttons clearfix">
									<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
									<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
								</div>
							</div>
						</div>
					</div>
					<div class="answer-2">
						<div class="user-info clearfix">
							<a class="ava female"></a>
							<div class="details">
								<span class="icon-status status-online"></span>
								<a href="" class="username">Богоявленский</a>
								<div class="user-fast-buttons clearfix">
									<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
									<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="clearfix">
					<div class="answer-1">
						<p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из нескольких показателей: вес ребенка, мат Желательно, чтобы набор веса при беременности происходил постепенно.</p>
					</div>
					<div class="answer-2">
						<p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из вных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из нескольких показателей: вес ребенка, мат Желательно, чтобы набор веса при беременности происходил постепенно.</p>
					</div>
				</div>
				
				<div class="clearfix">
					<div class="answer-1">
						<div class="vote">
							<div class="count">
								<span class="count-in">56</span>
								голосов
							</div>
							<div class="button">
								<a href="">Голосовать</a>
							</div>
						</div>
					</div>
					<div class="answer-2">
						<div class="vote">
							<div class="count">
								<span class="count-in">826</span>
								голосов
							</div>
							<div class="button">
								<a href="">Голосовать</a>
							</div>
						</div>
					</div>
				</div>										
				
			</div>
		
		</div>
		
		
	</div>
	
	<div id="firstStepsBirthday" class="popup">
		
		<div class="clearfix">
			
			<div class="left">
				<img src="/images/first_steps_birthday.png" />
			</div>
			
			<div class="right">
				
				<div class="title">Укажите вашу дату рождения</div>
				
				<div class="select-box">
					Дата рождения:
					<span class="chzn-v2 error">
						<select class="chzn w-1"><option>День</option><option>28</option><option>28</option><option>28</option><option>28</option><option>28</option><option>28</option><option>28</option><option>28</option><option>28</option><option>28</option></select>
					</span>
					<span class="chzn-v2">
						<select class="chzn w-2"><option>Месяц</option><option>января</option><option>января</option><option>января</option><option>января</option><option>января</option><option>января</option><option>января</option><option>января</option></select>
					</span>
					<span class="chzn-v2">
						<select class="chzn w-3"><option>Год</option><option>1973</option><option>1973</option><option>1973</option><option>1973</option><option>1973</option><option>1973</option><option>1973</option><option>1973</option><option>1973</option><option>1973</option><option>1973</option><option>1973</option></select>
					</span>
					
				</div>
				
				<span class="hl">И мы подарим вам виджет с гороскопом на каждый день!</span>
				
			</div>
			
		</div>	
		
		<div class="bottom">
			<button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
		</div>
		
	</div>
  
	<div id="firstStepsLocation" class="popup">
		
		<div class="clearfix">
			
			<div class="left">
				<img src="/images/first_steps_location.png" />
			</div>
			
			<div class="right">
				
				<div class="title">Укажите ваше место жительства!</div>
				
				<div class="select-box">
					<div class="row">
						Место жительства:<br/>
						<span class="chzn-v2">
							<select class="chzn w-1" data-placeholder="Страна"><option>28</option></select>
						</span>
						&nbsp;&nbsp;
						<span class="chzn-v2">
							<select class="chzn w-2" data-placeholder="Регион"><option>28</option></select>
						</span>					
					</div>
					<div class="row">
						Населенный пункт:<br/>
						<input type="text" class="w-3" />
						<br/>
						<small>Введите свой город, поселок, село или деревню</small>
					</div>
										
				</div>
				
				<span class="hl">Наш подарок: виджет с погодой на каждый день!</span>
				
			</div>
			
		</div>	
		
		<div class="bottom">
			<button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
		</div>
		
	</div>
  
	<div id="firstStepsEmail" class="popup">
		
		<div class="clearfix">
			
			<div class="left">
				<img src="/images/first_steps_email.png" />
			</div>
			
			<div class="right">
				
				<div class="title">Вам отправлено письмо!</div>
				
				<p>Мы отправили вам письмо, для <br/> <span class="hl">подтверждения адреса электронной почты</span></p>
				
				<p>Просим вас открыть ваш почтовый ящик,<br/> <span class="hl">найти наше письмо и нажать на кнопку <span>«Подтвердить e-mail»</span></span></p>
				
				<p>Если вы не обнаружили письмо, <span class="note">*</span><br/> мы можем отправить его еще раз <a href="" class="orange">Отправить письмо</a></p>
				
			</div>
			
		</div>	
		
		<div class="bottom">
			<div><span class="note">*</span> Просим вас проверить папку "Спам"</div>
		</div>
		
	</div>
  
</div>
</body>
</html>