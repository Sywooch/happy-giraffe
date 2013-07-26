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
		
		<div class="section-lilac">
			<div class="section-lilac_hold">
				<div class="section-lilac_left">
					<h1 class="section-lilac_name">Ангелина Богоявленская</h1>
				</div>
				<div class="section-lilac_center">
					<div class="b-ava-large">
						<a href="#popup-upload-ava"  class="ava large fancy" data-theme="transparent" >
							<span class="b-ava-large_photo-add " >Добавить <br>главное фото</span>
						</a>
						<span class="b-ava-large_online">На сайте</span>
						<a href="" class="b-ava-large_settings powertip" title="Настройки профиля"></a>
					</div>
					<div class="section-lilac_center-reg">с Веселым Жирафом 2 дня</div>
				</div>
				<div class="section-lilac_right">
					<div class="b-famyli">
						<div class="b-famyli_top b-famyli_top__white"></div>
						<ul class="b-famyli_ul">
							<li class="b-famyli_li">
								<a href="" class="b-famyli_add">
									<span class="b-famyli_add-b">
									</span>
									Добавить семью
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div class="content-cols clearfix">
			<div class="col-1">
			
				<div class="widget-friends clearfix">
					<div class="clearfix">
						<span class="heading-small">Мои друзья <span class="color-gray">(1)</span> </span>
					</div>
					<ul class="widget-friends_ul clearfix">
						<li class="widget-friends_find">
							<a href="" class="widget-friends_find-a"></a>
						</li>
						<li class="widget-friends_i">
							<a href="" class="ava"><img src="/images/user_friends_img.jpg"></a>
						</li>
						
					</ul>
				</div>
				
				<div class="club-list clearfix">
					<div class="clearfix">
						<span class="heading-small">Мои клубы <span class="color-gray">(1)</span> </span>
					</div>
					<ul class="club-list_ul clearfix">
						<li class="club-list_li">
							<a href="" class="club-list_add"></a>
						</li>
						<li class="club-list_li club-list_li__in">
							<a href="" class="club-list_i">
								<span class="club-list_img-hold">
									<img src="/images/club/1.png" alt="" class="club-list_img">
								</span>
								<span class="club-list_i-name">Украшаем дом</span>
							</a>
							<a href="" class="club-list_check powertip" title="Покинуть клуб"></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-23-middle">
			
				<!-- О себе -->
				<div class="about-self">
					<h3 class="heading-small margin-b5">О себе</h3>
					<div class="about-self_ctn"><a href="" class="a-pseudo-grayblue">Напишите пару слов о себе</a> </div>
				</div>
				
				<!-- Интересы -->
				<div class="b-interest">
					<h3 class="heading-small margin-b10">Мои интересы</h3>
					<div class="clearfix">
						<span class="color-gray">У вас пока нет интересов</span>
						<a href="" class="b-interest_add"></a>
					</div>
				</div>
				
				<div class="user-add-record clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male">
							<span class="icon-status status-online"></span>
							
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy">Статью</a>
						<a href="#popup-user-add-photo"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy">Фото</a>
						<a href="#popup-user-add-video"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy active">Видео</a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy">Статус</a>
					</div>
				</div>
				
				<!-- Статьи -->
				<!-- <div class="col-gray">
				
					<div class="clearfix margin-20">
						<h3 class="heading-small">Моя активность</h3>
					</div>
					
				</div> -->
			</div>
		</div>
		</div>
		
		<a href="#layout" id="btn-up-page"></a>
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

<div class="display-n">

	<!-- popup-upload-ava -->
	<div id="popup-upload-ava" class="popup-upload-ava">
		<a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-720">

				<div class="b-settings-blue">
					<div class="popup-upload-ava_t">Главное фото</div>
					<div class="clearfix">
						<div class="popup-upload-ava_left">
							<div class="b-add-img b-add-img__for-single">
								<div class="b-add-img_hold">
									<div class="b-add-img_t">
										Загрузите фотографию с компьютера
										<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
									</div>
									<div class="file-fake">
										<button class="btn-green btn-medium file-fake_btn">Обзор</button>
										<input type="file" name="">
									</div>
								</div>
								<div class="b-add-img_html5-tx">или перетащите фото сюда</div>
								<div class="b-add-img_desc">Загружайте пожалуйста свои фотографии, фото будут проверяться, <br> и если их содержание не будет соответствуют этике сайта, <br> будут удаляться</div>
							</div>
						</div>
						<div class="popup-upload-ava_right">
							<div class="popup-upload-ava_t">Просмотр</div>
							<div class="popup-upload-ava_prev">
								<div class="b-ava-large">
									<div class="ava large">
										<img src="/images/example/w440-h340.jpg" alt="">
									</div>
								</div>
							</div>
							<div class="color-gray font-small">Так будет выглядеть ваше главное фото на  страницах сайта</div>
						</div>
					</div>
					<div class="textalign-c margin-t10 clearfix">
						<a class="btn-gray-light btn-h46 margin-r15" href="">Отменить</a>
						<a class="btn-blue btn-h46 btn-inactive" href="">Добавить</a>
					</div>
					
				</div>
				
				<div class="b-settings-blue">
					<div class="popup-upload-ava_t">
						Главное фото 
						<span class="font-small color-gray">(это фото также загрузится в ваш фотоальбом "Личные фотографии")</span>
					</div>
					<div class="clearfix">
						<div class="popup-upload-ava_left">
							<div class="b-add-img b-add-img__for-single">
								<div class="b-add-img_hold display-n">
									<div class="b-add-img_t">
										Загрузите фотографию с компьютера
										<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
									</div>
									<div class="file-fake">
										<button class="btn-green btn-medium file-fake_btn">Обзор</button>
										<input type="file" name="">
									</div>
								</div>
								<div class="b-add-img_html5-tx display-n">или перетащите фото сюда</div>
								<div class="b-add-img_desc display-n">Загружайте пожалуйста свои фотографии, фото будут проверяться, <br> и если их содержание не будет соответствуют этике сайта, <br> будут удаляться</div>
								<img src="/images/example/w700-h740-1.jpg" alt="">
							</div>
						</div>
						<div class="popup-upload-ava_right">
							<div class="popup-upload-ava_t">Просмотр</div>
							<div class="popup-upload-ava_prev">
								<div class="b-ava-large">
									<div class="ava large">
										<img src="/images/example/w700-h740-1.jpg" alt="">
									</div>
								</div>
							</div>
							<div class="color-gray font-small">Так будет выглядеть ваше главное фото на  страницах сайта</div>
						</div>
					</div>
					<div class="textalign-c margin-t10 clearfix">
						<a class="btn-gray-light btn-h46 margin-r15" href="">Отменить</a>
						<a class="btn-blue btn-h46" href="">Добавить</a>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- /popup-upload-ava -->
	
	<!-- popup-user-add-status -->
	<div id="popup-user-add-status" class="popup-user-add-record">
		<a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-720 float-r">
				
				<div class="user-add-record user-add-record__yellow clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male">
							<span class="icon-status status-online"></span>
							<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article" class="user-add-record_ico user-add-record_ico__article fancy">Статью</a>
						<a href="#popup-user-add-photo" class="user-add-record_ico user-add-record_ico__photo fancy">Фото</a>
						<a href="#popup-user-add-video" class="user-add-record_ico user-add-record_ico__video fancy">Видео</a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status active fancy">Статус</a>
					</div>
				</div>
				
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

</body>
</html>