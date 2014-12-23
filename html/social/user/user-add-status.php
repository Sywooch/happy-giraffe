<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin,cyrillic-ext,cyrillic">
	
	<script type="text/javascript">
	$(".chzn").chosen().ready(function(){
	    
	    $('.chzn-itx-simple').find('.chzn-drop').append("<div class='chzn-itx-simple_add clearfix'><button class='btn-green'>Ok</button><div class='chzn-itx-simple_add-hold'> <input type='text' name='' id='' class='chzn-itx-simple_add-itx' placeholder="Создать новую рубрику"> <a href='' class='chzn-itx-simple_add-del'></a> </div>  </div>");

	  });
	</script>

	<script>
	$(document).ready(function () {


	    $('body').delegate('a.fancy-top', 'click', function () {
	        var onComplete_function = function () {

	            var scTop = $(document).scrollTop();
	            var box = $('#fancybox-wrap');

	            boxTop = parseInt(Math.max(scTop + 40));
	            box
	                .stop()
	                .animate({
	                    'top' : boxTop
	                }, 200);
	            
	        };

	        $(this).clone().fancybox({
	            overlayColor:'#2d1a3f',
	            overlayOpacity:'0.6',
	            padding:0,
	            hideOnOverlayClick:false,
	            showCloseButton:false,
	            centerOnScroll:false,
	            onComplete:onComplete_function
	        }).trigger('click');
	        return false;
	    });
	})
	</script>

</head>
<body class="body-gray theme__adfox">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
<div class="layout-w1">
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
				<div class="user-add-record clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male">
							<span class="icon-status status-online"></span>
							<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy-top">Статью</a>
						<a href="#popup-user-add-photo"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy-top ">Фото</a>
						<a href="#popup-user-add-video"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy-top active">Видео</a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy-top">Статус</a>
					</div>
				</div>
			</div>
		</div>

		<div class="post-add-page content-cols clearfix">
			<div class="col-1">
			</div>
			<div class="col-23-middle">
				<div class="heading-title">Редактировать статус</div>

	<!-- popup-user-add-status -->
	<div id="popup-user-add-status" class="popup-user-add-record">
		<a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-720 float-r">
				
				<!-- <div class="user-add-record user-add-record__yellow clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male">
							<span class="icon-status status-online"></span>
							<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article" class="user-add-record_ico user-add-record_ico__article fancy-top">Статью</a>
						<a href="#popup-user-add-photo" class="user-add-record_ico user-add-record_ico__photo fancy-top">Фото</a>
						<a href="#popup-user-add-video" class="user-add-record_ico user-add-record_ico__video fancy-top">Видео</a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status active fancy-top">Статус</a>
					</div>
				</div> -->
				
				<div class="b-settings-blue b-settings-blue__status">
					<div class="b-settings-blue_tale"></div>
					
					<div class="b-status-add clearfix">
						<div class="float-l">
							<a class="ava male" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
							</a>
						</div>
						<div class="b-status-add_col">
							<div class="b-status-add_hold">
								<div class="clearfix">
									<div class="float-r font-small color-gray">50/250</div>
								</div>
								<textarea name="" id="" cols="60" rows="3" class="b-status-add_textarea"></textarea>
							</div>
							<div class="margin-b10 clearfix">
								<div class="b-user-mood">
									<div class="b-user-mood_img">
										<img src="/images/widget/mood/0.png">
									</div>
									<div class="b-user-mood_hold">
										<a href="" class="a-pseudo">Прикрепить <br> мое настроение</a>
									</div>
								</div>
								
							</div>
						
							<div class=" clearfix">
								<a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
								<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
								
								<div class="float-l">
									<div class="privacy-select clearfix">
										<div class="privacy-select_hold clearfix">
											<div class="privacy-select_tx">Для кого:</div>
											<div class="privacy-select_drop-hold">
												<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend active"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
												</a>
											</div>
											<div class="privacy-select_drop">
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__all"></span>
													<span class="privacy-select_a-tx">для <br>всех</span>
													</a>
												</div>
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="b-settings-blue b-settings-blue__status display-n">
					<div class="b-settings-blue_tale"></div>
					
					<div class="b-status-add clearfix">
						<div class="float-l">
							<a class="ava male" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
							</a>
						</div>
						<div class="b-status-add_col">
							<div class="b-status-add_hold">
								<div class="clearfix">
									<div class="float-r font-small color-gray">50/250</div>
								</div>
								<textarea name="" id="" cols="60" rows="3" class="b-status-add_textarea"></textarea>
							</div>
							<div class="margin-b10 clearfix">
								<div class="b-user-mood">
									<div class="b-user-mood_img">
										<img src="/images/widget/mood/6.png">
									</div>
									<div class="b-user-mood_hold">
										<div class="b-user-mood_tx">- мое настроение</div>
										<a href="" class="a-pseudo font-small margin-l10">Изменить</a> &nbsp;
										<a href="" class="a-pseudo-gray font-small">Удалить</a>
									</div>
								</div>
							</div>
						
							<div class=" clearfix">
								<a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
								<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
								
								<div class="float-l">
									<div class="privacy-select clearfix">
										<div class="privacy-select_hold clearfix">
											<div class="privacy-select_tx">Для кого:</div>
											<div class="privacy-select_drop-hold">
												<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend active"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
												</a>
											</div>
											<div class="privacy-select_drop">
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__all"></span>
													<span class="privacy-select_a-tx">для <br>всех</span>
													</a>
												</div>
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="b-settings-blue b-settings-blue__status display-n">
					<div class="b-settings-blue_tale"></div>
					
					<div class="b-status-add clearfix">
						<div class="float-l">
							<a class="ava male" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
							</a>
						</div>
						<div class="b-status-add_col">
							<div class="b-status-add_hold">
								<div class="clearfix">
									<div class="float-r font-small color-gray">50/250</div>
								</div>
								<textarea name="" id="" cols="60" rows="3" class="b-status-add_textarea"></textarea>
							</div>
							<div class="margin-b10 clearfix">
								<div class="b-user-mood">
									<div class="b-user-mood_img">
										<div class="position-rel">
											<div class="b-moods-list" style="display: block;">
												<ul class="b-moods-list_ul">
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/1.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Ем</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/2.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Испуг</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/3.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Грустный</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/4.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Молчу</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/5.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Подозрительно</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/6.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Интересно</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/7.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Все ОК</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/8.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Голова кругом</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/9.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Любовь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/10.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Подарок</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/11.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Красотка</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/12.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Радость</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/13.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Задумался</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/14.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Смущаюсь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/15.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Праздник</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/16.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Стреляюсь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/17.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Драка</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/18.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Отстой</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/19.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Смешно</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/20.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Улыбаюсь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/21.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Шопинг</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/22.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Напеваю</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/23.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Болею</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/24.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Сплю</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/25.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Плачу</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/26.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Звезда</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/27.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Падаю со смеху</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/28.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Слушаю музыку</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/29.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Тихо</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/30.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">В поиске</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/31.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Отлично</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/32.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Дразнюсь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/33.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Боюсь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/34.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">В ярости</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/35.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Есть повод</span>
														</a>
													</li>
												</ul>
			           						 </div>
		           						 </div>
										<img src="/images/widget/mood/6.png">
									</div>
									<div class="b-user-mood_hold">
										<div class="b-user-mood_tx">- мое настроение</div>
										<a href="" class="a-pseudo font-small margin-l10">Изменить</a> &nbsp;
										<a href="" class="a-pseudo font-small color-gray">Удалить</a>
									</div>
								</div>
							</div>
						
							<div class=" clearfix">
								<a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
								<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
								
								<div class="float-l">
									<div class="privacy-select clearfix">
										<div class="privacy-select_hold clearfix">
											<div class="privacy-select_tx">Для кого:</div>
											<div class="privacy-select_drop-hold">
												<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend active"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
												</a>
											</div>
											<div class="privacy-select_drop">
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__all"></span>
													<span class="privacy-select_a-tx">для <br>всех</span>
													</a>
												</div>
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- /popup-user-add-status -->




			</div>
		</div>
		</div>
		
		<!-- <a href="#layout" id="btn-up-page"></a> -->
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
</div>

<div class="display-n">
	
</div>
</body>
</html>