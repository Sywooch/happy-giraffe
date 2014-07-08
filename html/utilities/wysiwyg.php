<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="top-nav-fixed ie7"> <![endif]-->
<!--[if IE 8]>         <html class="top-nav-fixed ie8"> <![endif]-->
<!--[if IE 9]>         <html class="top-nav-fixed ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="top-nav-fixed"> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>

</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">

		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
			
		<div id="content" class="layout-content clearfix">

			<div class="content-cols clearfix">
					
				<div class="col-23">
										
	<script type="text/javascript">
	//<![CDATA[

		$(function(){

			/* skin hgru-comment */
			CKEDITOR.replace( 'editor',
				{
					skin : 'hgrucomment',
					toolbar : [	
						['Bold','Italic','Underline','-','Image', 'Smiles']
					],
					toolbarCanCollapse: false,
					disableObjectResizing: true,
					height: 80
				});

			/* js дважды для двух редакторов на стр. */
			/* skin hgru-comment */
			CKEDITOR.replace( 'editor2',
				{
					skin : 'hgrucomment',
					toolbar : [	
						['Bold','Italic','Underline','-','Image', 'Smiles']
					],
					toolbarCanCollapse: false,
					disableObjectResizing: false,
					height: 80
				});
			});

	//]]>
	</script>
						
								
					<div class="comment-add clearfix">
						<div class="comment-add_user">
							<a href="">Авторизируйтесь</a>
							<div class="social-small-row clearfix">
								<em>или войти с помощью</em> <br />
								<ul class="social-list-small">
									<li class="odnoklasniki"><a href="#"></a></li>
									<li class="mailru"><a href="#"></a></li>
									<li class="vkontakte"><a href="#"></a></li>
									<li class="facebook"><a href="#"></a></li>
								</ul>
							</div>
						</div>
						<div class="comment-add_form-holder">
							<input type="text" name="" class="input-text" placeholder="Введите ваш комментарий"/>
						</div>
					</div>
					
					<div class="comment-add active clearfix">
						<div class="comment-add_user">
							<a href="">Авторизируйтесь</a>
							<div class="social-small-row clearfix">
								<em>или войти с помощью</em> <br />
								<ul class="social-list-small">
									<li><a href="#" class="odnoklasniki"></a></li>
									<li><a href="#" class="mailru"></a></li>
									<li><a href="#" class="vk"></a></li>
									<li><a href="#" class="fb"></a></li>
								</ul>
							</div>
						</div>
						<div class="comment-add_form-holder">
							<textarea cols="80" id="editor" name="editor" rows="10"></textarea>
							<div class="a-right">
						        <button class="btn-gray medium cancel">Отмена</button>
						        <button class="btn-green medium">Добавить</button>
						    </div>
						</div>
					</div>
					
					<div class="comment-add active clearfix">
						<div class="comment-add_user">
							<div class="comment-add_user-ava">
   								 <a href="" class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/13623/ava/7acd577045e2014b4d26ecd33f6ce6d2.jpeg"></a>
					              <span class="comment-add_username">Татьяна Пахоменко </span>
                   			</div>
						</div>
						<div class="comment-add_form-holder">
							<textarea cols="40" id="editor2" name="editor2" rows="5"></textarea>
							<div class="a-right">
						        <button class="btn-gray medium cancel">Отмена</button>
						        <button class="btn-green medium">Добавить</button>
						    </div>
						</div>
					</div>
							
				</div>
			</div>
			
			
			
			
			<a href="#wysiwygAddLink" class="fancy">Визивиг: создание ссылки</a><br/>
			
			<a href="#wysiwygRemoveLink" class="fancy">Визивиг: удаление ссылки</a><br/>
			
			<a href="#photoPick" class="fancy">Визивиг: вставка изображения, шаг 1</a><br/>
			
			<a href="#photoPick.v2" class="fancy">Визивиг: вставка изображения, шаг 2</a><br/>
			
			<a href="#wysiwygAddSmile" class="fancy">Визивиг: вставка смайла</a><br/>
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />	
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<div style="position:relative;">
				<div id="wysiwygSmile" class="popup">
				
					<a href="javascript:void(0);" class="popup-close" >закрыть</a>
				
					<div class="tabs">
						<div class="title-row clearfix">
							<span class="title">Вставить смайл</span>
							<ul class="nav-smile">
								<li class="active">
									<a onclick="setTab(this, 1);" href="javascript:void(0);"><img src="/images/smiles-default.png" alt="" /><span>Обычные</span></a>
								</li>
								<li><a onclick="setTab(this, 2);" href="javascript:void(0);"><img src="/images/smiles-new.png" alt="" /><span>Новые</span></a></li>
								<li><a onclick="setTab(this, 3);" href="javascript:void(0);"><img src="/images/smiles-mega.png" alt="" /><span>Мега</span></a></li>
							</ul>
						</div>
						<div class="tab-box tab-box-1" style="display:block;">
							<table class="hg-smiles">
								<tbody>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/acute (1).gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/acute.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/air_kiss.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/angel.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/bad.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/beach.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/beee.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/blush2.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/Cherna-girl_on_weight.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/connie_1.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/connie_33.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/connie_36.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/connie_6.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/connie_feedbaby.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/cray.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/dance.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/dash2.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/diablo.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/dirol.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/dntknw.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/drinks.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/d_coffee.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/d_lovers.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/facepalm.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/fie.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/first_move.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/fool.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/girl_cray2.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/girl_dance.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/girl_drink1.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/girl_hospital.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/girl_prepare_fish.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/girl_sigh.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/girl_wink.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/girl_witch.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/give_rose.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/good.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/help.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/JC_hiya.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/JC_hulahoop-girl.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/kirtsun_05.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/kuzya_01.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/LaieA_052.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/Laie_16.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/Laie_50.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/Laie_7.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/lazy2.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/l_moto.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/mail1.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/Mauridia_21.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/mosking.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/music2.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/negative.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/pardon.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/phil_05.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/phil_35.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/popcorm1.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/preved.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/rofl.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/sad.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/scratch_one-s_head.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/secret.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/shok.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/smile3.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/sorry.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/tease.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/to_become_senile.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/viannen_10.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/wacko2.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/wink.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/yahoo.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/yes3.gif"></a></td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div class="tab-box tab-box-2">
							<table class="hg-smiles">
							
								<tbody>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/acute (1).gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/acute.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/air_kiss.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/angel.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/bad.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/beach.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/beee.gif"></a></td>
									</tr>
									<tr>
										<td><a href=""><img src="/images/widget/smiles/blush2.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/Cherna-girl_on_weight.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/connie_1.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/connie_33.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/connie_36.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/connie_6.gif"></a></td>
										<td><a href=""><img src="/images/widget/smiles/connie_feedbaby.gif"></a></td>
									</tr>
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
			</div>

			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<div style="margin: 100px 50px;width:600px;" class="position-rel"><br>
              <!-- style для примера-->
              <div id="redactor_modal" style="top:0;left:0;">
                <div id="redactor_modal_close">×</div>
                <header id="redactor_modal_header" style="cursor: move;">Video</header>
                <div id="redactor_modal_inner">
                  <div class="redactor-popup">
                    <!-- Кнопка закрыть, можно использовать базовую от скрипта попапа-->
                    <!-- a.redactor-popup_close.ico-close3.powertip(href='', title='Закрыть')-->
                    <div class="redactor-popup_tale"></div>
                    <div class="redactor-popup_t">Загрузите видео</div>
                    <!-- Добавление видео-->
                    <div class="redactor-popup_add-video">
                      <div class="redactor-popup_add-video-hold">
                        <div class="redactor-popup_video-serv">
                          <div class="redactor-popup_video-serv-tx">Поддерживаемые сервисы:</div>
                          <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__youtube"></div>
                          <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__rutube"></div>
                          <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__vimeo"></div>
                        </div>
                        <!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования-->
                        <input type="text" name="" placeholder="Введите ссылку на видео" class="itx-simple itx-simple__blue w-350 float-l">
                        <button class="btn-green btn-medium btn-inactive">Загрузить  видео</button>
                      </div>
                    </div>
                    <!-- Добавление видео с ошибкой-->
                    <div class="redactor-popup_add-video active">
                      <div class="redactor-popup_add-video-hold">
                        <div class="redactor-popup_video-serv">
                          <div class="redactor-popup_video-serv-tx">Поддерживаемые сервисы:</div>
                          <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__youtube active"></div>
                          <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__rutube"></div>
                          <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__vimeo"></div>
                        </div>
                        <!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования-->
                        <input type="text" name="" placeholder="Введите ссылку на видео" value="http://www.youtube.com/embed/pehSAUTqjRs?wmode=transparent" class="itx-simple itx-simple__blue w-350 float-l error">
                        <button class="btn-green btn-medium btn-inactive">Загрузить  видео</button>
                      </div>
                      <div class="redactor-popup_add-video-error">
                        <div class="ico-error-smile"></div>Ошибка загрузки видео. Попробуйте вставить другую ссылку
                      </div>
                    </div>
                  </div>
                </div>
              </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
              <div id="redactor_modal" style="top:800px;left:0;">
                <div id="redactor_modal_close">×</div>
                <header id="redactor_modal_header" style="cursor: move;">Video</header>
                <div id="redactor_modal_inner">
                  <!-- redactor-popup-->
                  <div class="redactor-popup">
                    <!-- a.redactor-popup_close.ico-close3.powertip(href='', title='Закрыть')-->
                    <div class="redactor-popup_tale"></div>
                    <div class="redactor-popup_t">Загрузите видео</div>
                    <div class="redactor-popup_add-video active">
                      <div class="redactor-popup_add-video-hold">
                        <div class="redactor-popup_video-serv">
                          <div class="redactor-popup_video-serv-tx">Поддерживаемые сервисы:</div>
                          <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__youtube active"></div>
                          <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__rutube"></div>
                          <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__vimeo"></div>
                        </div>
                        <!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования-->
                        <input type="text" name="" placeholder="Введите ссылку на видео" value="http://www.youtube.com/watch?v=N8ev5pkIqKY" class="itx-simple itx-simple__blue w-350 float-l">
                        <button class="btn-green btn-medium">Загрузить  видео</button>
                      </div>
                      <!-- При показе текстового сообщения на .redactor-popup_add-video добавлять класс .active-->
                      <div class="redactor-popup_add-video-load"><img src="/images/ico/ajax-loader.gif" alt=""><br>Подождите видео загружается</div>
                    </div>
                  </div>
                  <!-- /redactor-popup-->
                </div>
              </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
              <div id="redactor_modal" style="top:1500px;left:0;">
                <div id="redactor_modal_close">×</div>
                <header id="redactor_modal_header" style="cursor: move;">Video</header>
                <div id="redactor_modal_inner">
                  <div class="redactor-popup">
                    <!-- a.redactor-popup_close.ico-close3.powertip(href='', title='Закрыть')-->
                    <div class="redactor-popup_tale"></div>
                    <div class="redactor-popup_t">Загрузите видео</div>
                    <div class="redactor-popup_video clearfix">
                      <iframe width="395" height="222" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/pehSAUTqjRs?wmode=transparent"></iframe>
                    </div>
                    <div class="textalign-c margin-t15"><a href="" class="a-pseudo">Нет, загрузить другой ролик</a><a href="" class="btn-green btn-medium margin-l20">Добавить видео</a></div>
                  </div>
                </div>
              </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
              <div class="redactor-popup">
                <!-- a.redactor-popup_close.ico-close3.powertip(href='', title='Закрыть')-->
                <div class="redactor-popup_tale"></div>
                <div class="redactor-popup_t">Выберите смайл</div>
                <table class="redactor-popup_smiles">
                  <tbody>
                    <tr>
                      <td><a href=""><img src="/images/widget/smiles/acute (1).gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/acute.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/air_kiss.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/angel.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/bad.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/beach.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/beee.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/blush2.gif"></a></td>
                    </tr>
                    <tr>
                      <td><a href=""><img src="/images/widget/smiles/Cherna-girl_on_weight.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/connie_1.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/connie_33.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/connie_36.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/connie_6.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/connie_feedbaby.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/cray.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/dance.gif"></a></td>
                    </tr>
                    <tr>
                      <td><a href=""><img src="/images/widget/smiles/dash2.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/diablo.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/dirol.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/dntknw.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/drinks.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/d_coffee.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/d_lovers.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/facepalm.gif"></a></td>
                    </tr>
                    <tr>
                      <td><a href=""><img src="/images/widget/smiles/fie.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/first_move.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/fool.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/girl_cray2.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/girl_dance.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/girl_drink1.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/girl_hospital.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/girl_prepare_fish.gif"></a></td>
                    </tr>
                    <tr>
                      <td><a href=""><img src="/images/widget/smiles/girl_sigh.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/girl_wink.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/girl_witch.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/give_rose.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/good.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/help.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/JC_hiya.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/JC_hulahoop-girl.gif"></a></td>
                    </tr>
                    <tr>
                      <td><a href=""><img src="/images/widget/smiles/kirtsun_05.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/kuzya_01.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/LaieA_052.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/Laie_16.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/Laie_50.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/Laie_7.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/lazy2.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/l_moto.gif"></a></td>
                    </tr>
                    <tr>
                      <td><a href=""><img src="/images/widget/smiles/mail1.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/Mauridia_21.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/mosking.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/music2.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/negative.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/pardon.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/phil_05.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/phil_35.gif"></a></td>
                    </tr>
                    <tr>
                      <td><a href=""><img src="/images/widget/smiles/popcorm1.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/preved.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/rofl.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/sad.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/scratch_one-s_head.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/secret.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/shok.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/smile3.gif"></a></td>
                    </tr>
                    <tr>
                      <td><a href=""><img src="/images/widget/smiles/sorry.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/tease.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/to_become_senile.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/viannen_10.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/wacko2.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/wink.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/yahoo.gif"></a></td>
                      <td><a href=""><img src="/images/widget/smiles/yes3.gif"></a></td>
                    </tr>
                  </tbody>
                </table>
              </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
              <div class="redactor-popup redactor-popup_b-link">
                <!-- a.redactor-popup_close.ico-close3.powertip(href='', title='Закрыть')-->
                <div class="redactor-popup_tale"></div>
                <div class="redactor-popup_t">Ссылка</div>
                <div class="redactor-popup_holder-blue">
                  <div class="margin-b10 clearfix">
                    <label for="" class="redactor-popup_label">Отображаемый текст</label>
                    <div class="float-l w-350">
                      <input type="text" placeholder="Введите текст" name="" value="Выделенный текст" class="itx-simple itx-simple__blue">
                    </div>
                  </div>
                  <div class="clearfix">
                    <label for="" class="redactor-popup_label">Ссылка на</label>
                    <div class="float-l w-350 error">
                      <input type="text" placeholder="Введите URL страницы" name="" class="itx-simple itx-simple__blue">
                    </div>
                  </div>
                  <div class="errorSummary">Необходимо заполнить поле URL страницы.</div>
                </div>
                <div class="textalign-c margin-t15"><a href="" class="btn-gray-light btn-medium margin-r10">Отменить</a><a href="" class="btn-green btn-medium">Добавить ссылку</a></div>
              </div><br><br><br><br><br><br><br><br><br><br><br><br><br>
              <div class="redactor-control">
                        <div class="redactor-control_hold">
                          <textarea cols="40" name="redactor" rows="1" autofocus="autofocus" class="redactor error"></textarea>
                        </div>
                        <div class="redactor-control_toolbar"></div>
                        <div class="redactor-control_control">
                          <div class="redactor-control_key">
                            <input type="checkbox" name="" class="redactor-control_key-checkbox"/>
                            <label for="redactor-control-b_key-checkbox" class="redactor-control_key-label">Enter - отправить</label>
                          </div>
                          <button class="btn-green">Отправить</button>
                        </div>
                        <script>
                          $(document).ready(function () { 
                              /* Обворачиваем редактор в дополнительные блоки. Нужно выбирать текущий (инициализарующийся) редактор, а не все на странице */
                              $('.redactor').wrap('<div class="scroll"><div class="scroll_scroller"><div class="scroll_cont"></div></div></div>');
                              /* Выбор ближайшего родителя с таким классом, для добавления блоков рисующих ползунок */
                              $('.scroll_scroller').after('<div class="scroll_bar-hold"><div class="scroll_bar"><div class="scroll_bar-in"></div></div></div>');
                              
                              
                              $('.redactor').redactor({
                                  minHeight: 20,
                                  autoresize: true,
                                  focus: true,
                                  toolbarExternal: '.redactor-control_toolbar',
                                  buttons: ['image', 'video', 'smile'],
                                  buttonsCustom: {
                                      smile: 
                                      {
                                          title: 'smile',
                                          callback: function(buttonName, buttonDOM, buttonObject) 
                                          {
                                              var html = this.get();
                                          }
                                      }
                                  }
                              });
                          });
                        </script>
                      </div>
            	<br>
            	<br>
            	<br>
            	<br>
            	<br>
            	<br>
            	<br>
            	<br>
            	<br>
            	<br>
            	<br>
            	<br>
            	<br>
            	<br><br>
            	<div style="height:600px;position:relative;">
            		<div class="redactor-popup redactor-popup__vert-old redactor-popup_b-smile" style="top: 208px; left: 31px;">
        <a href="javascript:void(0)" class="redactor-popup_close ico-close3 powertip" title="Закрыть" onclick="$(this).parents('.redactor-popup').addClass('display-n');"></a>
        <div class="redactor-popup_tale"></div>
        <div class="redactor-popup_t">Выберите смайл</div>
        <table class="redactor-popup_smiles">
            <tbody>
            <tr>
                <td><a href=""><img src="/images/widget/smiles/acute (1).gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/acute.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/air_kiss.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/angel.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/bad.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/beach.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/beee.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/blush2.gif"></a></td>
            </tr>
            <tr>
                <td><a href=""><img src="/images/widget/smiles/Cherna-girl_on_weight.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/connie_1.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/connie_33.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/connie_36.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/connie_6.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/connie_feedbaby.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/cray.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/dance.gif"></a></td>
            </tr>
            <tr>
                <td><a href=""><img src="/images/widget/smiles/dash2.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/diablo.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/dirol.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/dntknw.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/drinks.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/d_coffee.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/d_lovers.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/facepalm.gif"></a></td>
            </tr>
            <tr>
                <td><a href=""><img src="/images/widget/smiles/fie.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/first_move.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/fool.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/girl_cray2.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/girl_dance.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/girl_drink1.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/girl_hospital.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/girl_prepare_fish.gif"></a></td>
            </tr>
            <tr>
                <td><a href=""><img src="/images/widget/smiles/girl_sigh.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/girl_wink.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/girl_witch.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/give_rose.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/good.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/help.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/JC_hiya.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/JC_hulahoop-girl.gif"></a></td>
            </tr>
            <tr>
                <td><a href=""><img src="/images/widget/smiles/kirtsun_05.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/kuzya_01.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/LaieA_052.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/Laie_16.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/Laie_50.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/Laie_7.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/lazy2.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/l_moto.gif"></a></td>
            </tr>
            <tr>
                <td><a href=""><img src="/images/widget/smiles/mail1.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/Mauridia_21.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/mosking.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/music2.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/negative.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/pardon.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/phil_05.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/phil_35.gif"></a></td>
            </tr>
            <tr>
                <td><a href=""><img src="/images/widget/smiles/popcorm1.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/preved.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/rofl.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/sad.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/scratch_one-s_head.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/secret.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/shok.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/smile3.gif"></a></td>
            </tr>
            <tr>
                <td><a href=""><img src="/images/widget/smiles/sorry.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/tease.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/to_become_senile.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/viannen_10.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/wacko2.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/wink.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/yahoo.gif"></a></td>
                <td><a href=""><img src="/images/widget/smiles/yes3.gif"></a></td>
            </tr>
            </tbody>
        </table>
    </div>
            	</div>
            </div>

		</div>  	
		
		<div class="footer-push"></div>
		
	</div>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
	
<div style="display:none">
	
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
	
	<div id="wysiwygAddSmile" class="popup">
			
		<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>
		
		<div class="title">Вставить смайл</div>
		<table>
			<tr>
				<td><a href=""><img src="/images/widget/smiles/acute.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/beach.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/beee.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/fie.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/fool.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/beee.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/fie.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/fool.gif" /></a></td>
				
			</tr>
			<tr>
				<td><a href=""><img src="/images/widget/smiles/help.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/mail1.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/music2.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/pardon.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/rofl.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/music2.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/pardon.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/rofl.gif" /></a></td>
				
			</tr>
			<tr>
				<td><a href=""><img src="/images/widget/smiles/sorry.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/tease.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/wink.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/yes3.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/yahoo.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/wink.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/yes3.gif" /></a></td>
				<td><a href=""><img src="/images/widget/smiles/yahoo.gif" /></a></td>
				
			</tr>
			
		</table>
	</div>
	
	<div id="wysiwygAddLink" class="popup">
			
		<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>
		
		<div class="title">Вставить ссылку</div>
		
		<div class="row">
			<label>Адрес ссылки</label><br/>
			<input type="text" placeholder="Вставьте ссылку" />
		</div>
		
		<div class="row">
			<label>Название ссылки</label><br/>
			<input type="text" placeholder="Введите название" />
		</div>	
		<div class="bottom"><a href="" class="btn btn-green-medium"><span><span>Ok</span></span></a></div>
			
	</div>
	
	<div id="wysiwygRemoveLink" class="popup">
			
		<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>
		
		
		<br/>
		
		<div class="title">Удалить ссылку?</div>		
		
		<div class="bottom"><a href="" class="btn btn-green-medium"><span><span>Ok</span></span></a></div>
			
	</div>
	
	<div id="photoPick" class="popup">
		
		<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>
		
		<div class="title">Загрузить изображение</div>
		
		<div class="nav default-nav ajax-nav">
			<ul>
				<li class="active"><a href="">С компьютера</a></li>
				<li><a href="">Из моих альбомов</a></li>
			</ul>
		</div>
		
		<form>
			<div class="form">
				<div class="photo-upload clearfix">
					
					<div class="photo">
						<div class="in">
							<div class="file-fake">
								<button class="btn btn-orange"><span><span>Обзор...</span></span></button>
								<input type="file" />
							</div>
						</div>
					</div>
					
					<div class="note">Загрузите файл<br/>(jpg, gif, png не более 4 МБ)</div>
					
				</div>
				
				<div class="photo-upload clearfix">
					
					<div class="photo">
						<div class="in">
							<img src="/images/example/ex3.jpg" />
						</div>
						<a href="" class="remove"></a>
					</div>
					
					<div class="note">
						
						<label>Название изображения</label><br/>
						<input type="text" placeholder="Введите название" />
						
					</div>
					
				</div>
				
				<div class="form-bottom">
					
					<button class="btn btn-green-medium"><span><span>Продолжить</span></span></button>
				</div>
				
			</div>
		</form>
		
	</div>
	
	<div id="photoPick" class="popup v2">
		
		<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>
		
		<div class="title">Загрузить изображение</div>
		
		<div class="nav default-nav ajax-nav">
			<ul>
				<li><a href="">С компьютера</a></li>
				<li class="active"><a href="">Из моих альбомов</a></li>
			</ul>
		</div>
		
		<div class="nav v-nav default-v-nav">
			<ul>
				<li class="active">
					<div class="in">
						<a href="">Отдых в Турции</a>
						<span class="tale"><img src="/images/default_v_nav_active.png"></span>
					</div>
				</li>
				<li>
					<div class="in">
						<a href="">Поездка на Алтай</a>
					</div>
				</li>
				<li>
					<div class="in">
						<a href="">Домашние фото</a>
					</div>
				</li>
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
											<a href="" class="btn btn-green-medium"><span><span>Выбрать</span></span></a>
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
											<a href="" class="btn btn-green-medium"><span><span>Выбрать</span></span></a>
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
											<a href="" class="btn btn-green-medium"><span><span>Выбрать</span></span></a>
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

		</div>

	</div>
	
	
</div>
</body>
</html>
