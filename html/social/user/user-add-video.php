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
					<span class="user-add-record_ico user-add-record_ico__video active"></span>
					Редактировать видеопост
				</div>
				<!-- popup-user-add-video -->
				<div id="popup-user-add-video" class="popup-user-add-record">
					<!-- <a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a> -->
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
									<a href="#popup-user-add-video" class="user-add-record_ico user-add-record_ico__video active fancy-top">Видео</a>
									<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy-top">Статус</a>
								</div>
							</div> -->
							
							<div class="b-settings-blue b-settings-blue__video">
								<div class="b-settings-blue_tale"></div>
								<div class="b-settings-blue_head">
									<div class="b-settings-blue_row clearfix">
										<div class="clearfix margin-t-10">
											<div class="float-r font-small color-gray margin-3">0/50</div>
										</div>
										<label for="" class="b-settings-blue_label">Заголовок</label>
										<div class="w-400  float-l error">
											<input type="text" name="" id="" class="itx-simple" placeholder="Введите заголовок видео">
											<div class="errorMessage">Введите заголовок</div>
										</div>
									</div>
									<div class="b-settings-blue_row clearfix">
										<label for="" class="b-settings-blue_label">Рубрика</label>
										<div class="w-400 float-l error">
											<div class="chzn-itx-simple">
												<select class="chzn">
													<option selected="selected">0</option>
													<option>Россия</option>
													<option>2</option>						
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
											<div class="errorMessage">Введите рубрику</div>
										</div>
									</div>
								</div>
								<div class="b-settings-blue_add-video clearfix">
									<!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования -->
									<input type="text" name="" id="" class="itx-simple w-400 float-l" placeholder="Введите ссылку на видео">
									<button class="btn-green btn-inactive">Загрузить  видео</button>
									<div class="b-settings-blue_add-video-load">
										<img src="/images/ico/ajax-loader.gif" alt=""> <br>
										Подждите видео загружается
									</div>
								</div>
								<div class="b-settings-blue_add-video clearfix">
									<!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования -->
									<input type="text" name="" id="" class="itx-simple w-400 float-l" placeholder="Введите ссылку на видео">
									<button class="btn-green btn-inactive">Загрузить  видео</button>
									<div class="errorMessage">
										Не удалось загрузить видео. <br>
										Возможно, URL указан неправильно либо ведет на неподдерживаемый сайт.
									</div>
								</div>
								<div class="b-settings-blue_video clearfix">
									<a href="" class="b-settings-blue_video-del ico-close2 powertip" title="Удалить"></a>
									<iframe width="580" height="320" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/pehSAUTqjRs?wmode=transparent"></iframe>
								</div>
								<div class="b-settings-blue_row clearfix">
									<textarea name="" id="" cols="80" rows="5" class="b-settings-blue_textarea itx-simple" placeholder="Ваш комментарий"></textarea>
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
				<!-- /popup-user-add-video -->
				

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


</body>
</html>