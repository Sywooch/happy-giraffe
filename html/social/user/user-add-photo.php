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
			<div class="col-23-middle">
				<div class="heading-xl">
					<span class="user-add-record_ico user-add-record_ico__photo active"></span>
					Редактировать фотопост
				</div>


				<!-- popup-user-add-photo -->
				<div id="popup-user-add-photo" class="popup-user-add-record">
					<a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
					<div class="clearfix">
						<div class="w-720 float-r">
															
							<!-- <div class="b-settings-blue b-settings-blue__photo display-n">
								<div class="b-settings-blue_tale"></div>
								<div class="clearfix">
									<div class="b-settings-blue_photo-record">
										<div class="b-settings-blue_photo-record-t">Личные <br> фотоальбомы</div>
										<div class="b-settings-blue_photo-record-img">
											<img src="/images/b-settings-blue_photo-record-img1.png" alt="" class="">
										</div>
										<div class="clearfix">
											<a href="" class="btn-blue btn-h46">Загрузить фото</a>
										</div>
									</div>
									<div class="b-settings-blue_photo-record">
										<div class="b-settings-blue_photo-record-t">Фотопост <br> в блоге</div>
										<div class="b-settings-blue_photo-record-img">
											<img src="/images/b-settings-blue_photo-record-img2.png" alt="" class="">
										</div>
										<div class="clearfix">
											<a href="" class="btn-blue btn-h46">Создать фотопост</a>
										</div>
									</div>
									
								</div>
							</div> -->
							
							<div class="b-settings-blue b-settings-blue__photo">
								<div class="b-settings-blue_tale"></div>
								<div class="b-settings-blue_head">
									<div class="b-settings-blue_row clearfix">
										<div class="clearfix">
											<div class="float-r font-small color-gray margin-3">0/50</div>
										</div>
										<label for="" class="b-settings-blue_label">Заголовок</label>
										<div class="float-l w-400">
											<input type="text" name="" id="" class="itx-simple w-400" placeholder="Введите заголовок фото">
										</div>
									</div>
									<div class="b-settings-blue_row clearfix">
										<label for="" class="b-settings-blue_label">Рубрика</label>
										<div class="w-400 float-l">
											<div class="chzn-itx-simple">
												<select class="chzn" data-placeholder="Выберите рубрику">
													<option></option>
													<option>Россия</option>
													<option>2</option>
													<option>32</option>						
													<option>32</option>						
													<option>32</option>						
													<option>32</option>						
													<option>132</option>						
													<option>132</option>						
													<option>132</option>						
												</select>
												<!--
												<div class='chzn-itx-simple_add clearfix'>
													<button class='btn-green'>Ok</button>
													<div class='chzn-itx-simple_add-hold'>
														<input type='text' name='' id='' class='chzn-itx-simple_add-itx'>
														<a href='' class='chzn-itx-simple_add-del'></a>
													</div>
												</div>
												-->
											</div>
										</div>
									</div>
								</div>
								
								
								<!-- .dragover - класс добавлять, когда курсер мыши с файлами находится над блоком -->
								<div class="b-add-img b-add-img__for-multi">
									<div class="b-add-img_hold">
										<div class="b-add-img_t">
											Загрузите фотографии с компьютера
											<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
										</div>
										<div class="file-fake">
											<button class="btn-green btn-medium file-fake_btn">Обзор</button>
											<input type="file" name="">
										</div>
									</div>
									<div class="b-add-img_html5-tx">или перетащите фото сюда</div>
								</div>
								
								<div class="b-settings-blue_row clearfix">
									<textarea name="" id="" cols="80" rows="5" class="b-settings-blue_textarea itx-simple" placeholder="Ваш текст к фотопосту "></textarea>
								</div>
								<div class=" clearfix">
									<a href="" class="btn-blue btn-h46 float-r">Добавить</a>
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
							
							<div class="b-settings-blue b-settings-blue__photo ">
								<div class="b-settings-blue_tale"></div>
								<div class="b-settings-blue_head">
									<div class="b-settings-blue_row clearfix">
										<label for="" class="b-settings-blue_label">Фотоальбом</label>
										<div class="w-400 float-l">
											<div class="chzn-itx-simple">
												<select class="chzn" data-placeholder="Выберите рубрику">
													<option></option>
													<option>Россия</option>
													<option>2</option>
													<option>32</option>						
													<option>32</option>						
													<option>32</option>						
													<option>32</option>						
													<option>132</option>						
													<option>132</option>						
													<option>132</option>						
												</select>
												<!--
												<div class='chzn-itx-simple_add clearfix'>
													<button class='btn-green'>Ok</button>
													<div class='chzn-itx-simple_add-hold'>
														<input type='text' name='' id='' class='chzn-itx-simple_add-itx'>
														<a href='' class='chzn-itx-simple_add-del'></a>
													</div>
												</div>
												-->
											</div>
										</div>
									</div>
								</div>
										
								<div class="b-add-img b-add-img__single">
									<div class="b-add-img_hold">
										<div class="b-add-img_t">
											Загрузите фотографии с компьютера
											<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
										</div>
										<div class="file-fake">
											<button class="btn-green btn-medium file-fake_btn">Обзор</button>
											<input type="file" name="">
										</div>
									</div>
									<div class="textalign-c clearfix">
										<div class="b-add-img_i b-add-img_i__single">
											<img class="b-add-img_i-img" src="/images/example/w440-h340.jpg" alt="">
											<div class="b-add-img_i-vert"></div>
											<div class="b-add-img_i-overlay">
												<a href="" class="b-add-img_i-del ico-close4"></a>
											</div>
										</div>
									</div>
									<!-- Текст приглашения для перетаскивания можно скрыть или удалить при наличии фото -->
									<div class="b-add-img_html5-tx display-n">или перетащите фото сюда</div>
								</div>
								
								<div class=" clearfix">
									<a href="" class="btn-blue btn-h46 float-r">Добавить</a>
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
												<div class="privacy-select_drop display-b">
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
							
							<div class="b-settings-blue b-settings-blue__photo">
								<div class="b-settings-blue_tale"></div>
								<div class="b-settings-blue_head">
									<div class="b-settings-blue_row clearfix">
										<label for="" class="b-settings-blue_label">Фотоальбом</label>
										<div class="w-400 float-l">
											<div class="chzn-itx-simple">
												<select class="chzn" data-placeholder="Выберите или создайте рубрику">
													<option></option>
													<option>Россия</option>
													<option>2</option>
													<option>32</option>						
													<option>32</option>						
													<option>32</option>						
													<option>32</option>						
													<option>132</option>						
													<option>132</option>						
													<option>132</option>						
												</select>
												<!--
												<div class='chzn-itx-simple_add clearfix'>
													<button class='btn-green'>Ok</button>
													<div class='chzn-itx-simple_add-hold'>
														<input type='text' name='' id='' class='chzn-itx-simple_add-itx'>
														<a href='' class='chzn-itx-simple_add-del'></a>
													</div>
												</div>
												-->
											</div>
										</div>
									</div>
								</div>
										
								<div class="b-add-img b-add-img__for-multi">
									<div class="b-add-img_hold">
										<div class="b-add-img_t">
											Загрузите фотографии с компьютера
											<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
										</div>
										<div class="file-fake">
											<button class="btn-green btn-medium file-fake_btn">Обзор</button>
											<input type="file" name="">
										</div>
									</div>
									<div class="textalign-c clearfix">
										<div class="b-add-img_i">
											<img class="b-add-img_i-img" src="/images/example/w440-h340.jpg" alt="">
											<!-- b-add-img_i-vert для вертикального позиционирования маленькой каритнки -->
											<div class="b-add-img_i-vert"></div>
											<div class="b-add-img_i-overlay">
												<a href="" class="b-add-img_i-del ico-close4"></a>
											</div>
										</div>
										<div class="b-add-img_i">
											<img class="b-add-img_i-img" src="/images/example/w64-h61-2.jpg" alt="">
											<div class="b-add-img_i-vert"></div>
											<div class="b-add-img_i-overlay">
												<a href="" class="b-add-img_i-del ico-close4"></a>
											</div>
										</div>
										<div class="b-add-img_i">
											<img class="b-add-img_i-img" src="/images/example/11.jpg" alt="">
											<div class="b-add-img_i-vert"></div>
											<div class="b-add-img_i-overlay">
												<a href="" class="b-add-img_i-del ico-close4"></a>
											</div>
										</div>
										<div class="b-add-img_i">
											<img class="b-add-img_i-img" src="/images/example/w220-h309-1.jpg" alt="">
											<div class="b-add-img_i-vert"></div>
											<div class="b-add-img_i-overlay">
												<a href="" class="b-add-img_i-del ico-close4"></a>
											</div>
										</div>
										<div class="b-add-img_i">
											<img class="b-add-img_i-img" src="/images/example/w720-h128.jpg" alt="">
											<div class="b-add-img_i-vert"></div>
											<div class="b-add-img_i-overlay">
												<a href="" class="b-add-img_i-del ico-close4"></a>
											</div>
										</div>
										<div class="b-add-img_i error">
											<div class="b-add-img_i-error-tx">файл мотик.jpg не удалось загрузить, более 10 Мб</div>
											<div class="b-add-img_i-vert"></div>
											<div class="b-add-img_i-overlay">
												<a href="" class="b-add-img_i-del ico-close4"></a>
											</div>
										</div>
										<div class="b-add-img_i">
											<img class="b-add-img_i-img opacity-20" src="/images/example/w720-h128.jpg" alt="">
											<div class="b-add-img_i-vert"></div>
											<div class="b-add-img_i-load">
												<div class="b-add-img_i-load-progress" style="width:20%;"></div>
											</div>
											<div class="b-add-img_i-overlay">
												<a href="" class="b-add-img_i-del ico-close4"></a>
											</div>
										</div>
									</div>
									<!-- Текст приглашения для перетаскивания можно скрыть или удалить при наличии фото -->
									<div class="b-add-img_html5-tx display-n">или перетащите фото сюда</div>
								</div>
								
								<div class=" clearfix">
									<a href="" class="btn-blue btn-h46 float-r">Добавить</a>
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
												<div class="privacy-select_drop display-b">
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
				<!-- /popup-user-add-photo -->

			</div>
			<div class="col-1">
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