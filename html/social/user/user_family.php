<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="top-nav-fixed ie7"> <![endif]-->
<!--[if IE 8]>         <html class="top-nav-fixed ie8"> <![endif]-->
<!--[if IE 9]>         <html class="top-nav-fixed ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="top-nav-fixed"> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	<script type="text/javascript">
		
		function setFamilyRadiogroup(el){
			
			$(el).parents('.radiogroup').find('.radio-label').removeClass('checked');
			$(el).addClass('checked').find('input').attr('checked', 'checked');
			
		}
		
		$(function(){
			$('.tooltip').tooltip({
				delay: 100,
				track: false,
				showURL: false,
				showBody: false,
				top: -20,
				left: 10
			});
			
      var $container = $('.gallery-photos-new');
      
      var items = $('.gallery-photos-new li');

			$container.imagesLoaded( function(){
        
        $container.masonry({
          itemSelector : 'li',
          columnWidth: 240,
          isAnimated: false,
          animationOptions: { queue: false, duration: 500 }
        });
        
			});
		})
		
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
						
						<div class="clearfix user-info-big">
							<div class="user-info">
								<div class="ava female"></div>
								<div class="details">
									<span class="icon-status status-online"></span>
									<a href="" class="username">Александр Богоявленский</a>
								</div>
								<div class="user-fast-nav">
										<ul>
											<a href="">Анкета</a>&nbsp;|&nbsp;<a href="">Блог</a>&nbsp;|&nbsp;<a href="">Фото</a>&nbsp;|&nbsp;<a href="">Что нового</a>&nbsp;|&nbsp;<span class="drp-list"><a href="" class="more">Еще</a><ul><li><a href="">Семья</a></li><li><a href="">Друзья</a></li></ul>
											</span>
											
										</ul>
									</div>
								<div class="text-status">
									<p>Привет всем! У меня все ok! Единственное, что имеет значение.</p>
									<span class="tale"></span>
								</div>
							</div>
						</div>
						
						<div class="user-family">
							<div class="t"></div>
							<div class="c">
								<ul>
									<li>
										<big>Катя <small>-&nbsp;моя&nbsp;невеста</small></big>
										<div class="comment blue">
											Очень любит готовить, заниматься с детьми, очень добрая и отзывчивая
											<span class="tale"></span>
										</div>
										<div class="img">
											<img src="/images/example/ex1.png" />
										</div>
									</li>
									<li>
										<big>Вильгельмина <small>-&nbsp;моя&nbsp;невеста</small></big>
										<div class="comment">
											Очень любит готовить, заниматься с детьми, очень добрая и отзывчивая
											<span class="tale"></span>
										</div>
										<div class="img">
											<img src="/images/example/ex2.png" />
										</div>
									</li>
									<li>
										<big>Артем <small>- мой сын, 10 лет</small></big>
										<div class="comment">
											Очень любит готовить, заниматься с детьми, очень добрая и отзывчивая
											<span class="tale"></span>
										</div>
										<div class="img">
											<img src="/images/example/ex3.jpg" />
										</div>
									</li>
									<li class="waiting clearfix">
										<i class="icon"></i>
										<div class="in">
											<big>Ждем еще</big>
											<div class="gender">Девочку <i class="icon-female"></i></div>
											<div class="time">7-я неделя</div>
										</div>
									</li>
									
								</ul>
								
								<a href="" class="watch-album">Смотреть семейный<br/>альбом</a>
								
							</div>
							<div class="b"></div>
						</div>
						
					</div>
					
					<div class="col-23 clearfix">
						
						<div class="family">
						
							<div class="content-title-new">Моя семья</div>
							
							<div class="family-radiogroup">
								<div class="title">Семейное положение</div>
								<div class="subtitle">Выберите один из вариантов вашего семейного положения.</div>
								<div class="radiogroup">
									<div class="radio-label" onclick="setFamilyRadiogroup(this);"><span>Женат</span><input type="radio" name="radio-1" /></div>
									<div class="radio-label" onclick="setFamilyRadiogroup(this);"><span>Не женат</span><input type="radio" name="radio-1" /></div>
									<div class="radio-label checked" onclick="setFamilyRadiogroup(this);"><span>Жених</span><input type="radio" name="radio-1" /></div>
									<div class="radio-label" onclick="setFamilyRadiogroup(this);"><span>Есть подруга</span><input type="radio" name="radio-1" /></div>
								</div>
							</div>							
							
							<div class="family-radiogroup">
								<div class="title">Семейное положение <span>Жених</span> <a href="" class="pseudo">Изменить</a></div>
							</div>							
							
							<div class="family-member">
								
								<p>Расскажите немного о вашей невесте и загрузите её фото (по желанию)</p>
								
								<div class="data clearfix">
									<div class="d-text">Имя моей невесты:</div>
									<div class="name">
										<div class="input"><input type="text" placeholder="Введите имя" /> <button class="btn btn-green-small"><span><span>Ok</span></span></button></div>
									</div>
								</div>
								
								<div class="data clearfix">
									<div class="d-text">Имя моей невесты:</div>
									<div class="name">
										<div class="text">Светлана</div>
										<a href="javascript:void(0);" class="edit tooltip" title="Редактировать имя"></a>
									</div>
								</div>
								
								<div class="data clearfix">
									<div class="d-text">О моей невесте:</div>
									Добавьте короткий рассказ (не более 100 знаков)
									<div class="comment">
										<span class="tale"></span>
										<div class="input">
											
											<textarea></textarea>
											<button class="btn btn-green-small"><span><span>Ok</span></span></button>
										</div>
									</div>
									<div class="comment">
										<span class="tale"></span>
										<div class="text">
											Очень любит готовить, заботливая, умная, решительная, добрая!
											<a href="javascript:void(0);" class="edit tooltip" title="Редактировать"></a>
											<a href="javascript:void(0);" class="remove tooltip" title="Удалить"></a>
										</div>
									</div>
								</div>
								
								<div class="data clearfix">
									
									<div class="d-text">Фото моей невесты:</div>
									Загрузите фото, нажав на кнопку “+” 
									
									<div class="gallery-photos-new cols-3 clearfix">
										<ul>
											
											<li class="add">
												<a href="">
													<i class="icon"></i>
													<span>Загрузить  еще фото</span>
												</a>
											</li>
											
											<li>
												<div class="img">
													<a href="">
														<img src="/images/example/gallery_album_img_01.jpg">
														<span class="btn">Посмотреть</span>
													</a>
													<div class="actions">
														<a href="" class="edit tooltip" title="Редактировать"></a>
														<a href="" class="remove tooltip" title="Удалить"></a>
													</div>
												</div>
												<div class="item-title">Разнообразие десертов сицилийского стиля</div>
											</li>
											
											<li>
												<div class="img">
													<a href="">
														<img src="/images/example/gallery_album_img_02.jpg">
														<span class="btn">Посмотреть</span>
													</a>
													<div class="actions">
														<a href="" class="edit tooltip" title="Редактировать"></a>
														<a href="" class="remove tooltip" title="Удалить"></a>
													</div>
												</div>
												<div class="item-title">Разнообразие десертов сицилийского стиля</div>
											</li>
											
											<li>
												<div class="img">
													<a href="">
														<img src="/images/example/gallery_album_img_03.jpg">
														<span class="btn">Посмотреть</span>
													</a>
													<div class="actions">
														<a href="" class="edit tooltip" title="Редактировать"></a>
														<a href="" class="remove tooltip" title="Удалить"></a>
													</div>
												</div>
												<div class="item-title">Разнообразие десертов сицилийского стиля</div>
											</li>
											
											<li>
												<div class="img">
													<a href="">
														<img src="/images/example/gallery_album_img_04.jpg">
														<span class="btn">Посмотреть</span>
													</a>
													<div class="actions">
														<a href="" class="edit tooltip" title="Редактировать"></a>
														<a href="" class="remove tooltip" title="Удалить"></a>
													</div>
												</div>
												<div class="item-title">Разнообразие десертов сицилийского стиля</div>
											</li>
											
										</ul>
									</div>
							
								</div>
								
							</div>
							
							<div class="family-radiogroup">
								<div class="title">Мои дети <small>(а также планирование и беременность)</small></div>
								<div class="subtitle">Выберите один или два варианта ответа (если у вас более 3-х детей нажмите на кнопку "+")</div>
								<div class="radiogroup">
									<div class="radio-label" onclick="setFamilyRadiogroup(this);"><span>Планируем</span><input type="radio" name="radio-1" /></div>
									<div class="radio-label" onclick="setFamilyRadiogroup(this);"><span>Ждем<i class="icon-waiting"></i></span><input type="radio" name="radio-1" /></div>
									<div class="radio-label" onclick="setFamilyRadiogroup(this);"><span>1 ребенок</span><input type="radio" name="radio-1" /></div>
									<div class="radio-label checked" onclick="setFamilyRadiogroup(this);"><span>2 ребенка</span><input type="radio" name="radio-1" /></div>
									<div class="radio-label" onclick="setFamilyRadiogroup(this);"><span>3 ребенка</span><input type="radio" name="radio-1" /></div>
									<div class="radio-label" onclick="setFamilyRadiogroup(this);"><span>+</span><input type="radio" name="radio-1" /></div>
								</div>
							</div>							
							
							<div class="family-radiogroup">
								<div class="title">Мои дети <span>2 ребенка + Ждем</span> <a href="" class="pseudo">Изменить</a></div>
							</div>							
							
							<div class="family-member">
								
								<p>Расскажите немного о ваших детях и  кого ждете, загрузите их фото (по желанию)</p>
								
								<div class="member-title">1-ый ребенок:</div>
								
								<div class="data clearfix">
									Пол и дата рождения ребенка:
									<a href="javascript:void(0);" class="gender male"><span class="tip">Мальчик</span></a>
									<a href="javascript:void(0);" class="gender female"><span class="tip">Девочка</span></a>
									<div class="date">
									
										<span class="chzn-v2">
											<select class="chzn w-1">
												<option>28</option>
												<option>29</option>
												<option>30</option>
											</select>
										</span>
										&nbsp;
										<span class="chzn-v2">
											<select class="chzn w-2">
												<option>января</option>
												<option>февраля</option>
												<option>марта</option>
											</select>
										</span>
										&nbsp;
										<span class="chzn-v2">
											<select class="chzn w-3">
												<option>1981</option>
												<option>1982</option>
												<option>1982</option>
											</select>
										</span>
										&nbsp;
										<button class="btn btn-green-small"><span><span>Ok</span></span></button>
									
									</div>
								</div>
								
								<div class="data clearfix">
									Пол и дата рождения ребенка:
									<a href="javascript:void(0);" class="gender male active"><span class="tip">Мальчик</span></a>
									<a href="javascript:void(0);" class="gender female"><span class="tip">Девочка</span></a>
									<div class="date">
										<div class="text">7 лет <a href="javascript:void(0);" class="edit tooltip" title="Редактировать имя"></a></div>
									</div>
								</div>
								
								<div class="data clearfix">
									<div class="d-text">Имя ребенка:</div>
									<div class="name">
										<div class="input"><input type="text" placeholder="Введите имя" /> <button class="btn btn-green-small"><span><span>Ok</span></span></button></div>
									</div>
								</div>
								
								<div class="data clearfix">
									<div class="d-text">Имя ребенка:</div>
									<div class="name">
										<div class="text">Светлана</div>
										<a href="javascript:void(0);" class="edit tooltip" title="Редактировать имя"></a>
									</div>
								</div>
								
								<div class="data clearfix">
									Добавьте короткий рассказ (не более 100 знаков)
									<div class="comment">
									<span class="tale"></span>
										<div class="input">
											
											<textarea></textarea>
											<button class="btn btn-green-small"><span><span>Ok</span></span></button>
										</div>
									</div>
									<div class="comment">
										<span class="tale"></span>
										<div class="text">
											Очень любит готовить, заботливая, умная, решительная, добрая!
											<a href="javascript:void(0);" class="edit tooltip" title="Редактировать"></a>
											<a href="javascript:void(0);" class="remove tooltip" title="Удалить"></a>
										</div>
									</div>
								</div>
								
								<div class="data">
									Загрузите фото, нажав на кнопку “+”
									
									<div class="gallery-photos-new cols-3 clearfix">
										<ul>
											
											<li class="add">
												<a href="">
													<i class="icon"></i>
													<span>Загрузить  еще фото</span>
												</a>
											</li>
											
										</ul>
									</div>
								</div>
								
								<div class="member-title">2-ый ребенок:</div>
								
								...<br/><br/>
								
								<div class="member-title"><i class="icon-waiting"></i> Ждем еще</div>
								
								
								<div class="data clearfix">
									Пол будущего ребенка:
									<a href="javascript:void(0);" class="gender male tooltip" title="Мальчик"></a>
									<a href="javascript:void(0);" class="gender female tooltip" title="Девочка"></a>
									<a href="javascript:void(0);" class="gender question tooltip" title="Пока не знаем"></a>
									
								</div>
								
								
								<div class="data clearfix">
									
									Приблизительная дата родов ребенка:
									
									<div class="date">
									
										<span class="chzn-v2">
											<select class="chzn w-1">
												<option>28</option>
												<option>29</option>
												<option>30</option>
											</select>
										</span>
										&nbsp;
										<span class="chzn-v2">
											<select class="chzn w-2">
												<option>января</option>
												<option>февраля</option>
												<option>марта</option>
											</select>
										</span>
										&nbsp;
										<span class="chzn-v2">
											<select class="chzn w-3">
												<option>1981</option>
												<option>1982</option>
												<option>1982</option>
											</select>
										</span>
										&nbsp;
										<button class="btn btn-green-small"><span><span>Ok</span></span></button>
									
									</div>
								</div>
								
								<div class="data clearfix">
									Пол и дата рождения ребенка:
									<a href="javascript:void(0);" class="gender male active"><span class="tip">Мальчик</span></a>
									<a href="javascript:void(0);" class="gender female"><span class="tip">Девочка</span></a>
									<div class="date">
										<div class="text">18 недель <a href="javascript:void(0);" class="edit tooltip" title="Редактировать дату"></a></div>
									</div>
								</div>
								
								<p><a href="" class="couple"></a> Нажмите "+" если двойня</p>
								
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


</body>
</html>
