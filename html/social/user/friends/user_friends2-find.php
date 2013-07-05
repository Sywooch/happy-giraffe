<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin,cyrillic-ext,cyrillic">

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
					&nbsp;
				</div>
				<div class="col-23">
					<ul class="breadcrumbs-big clearfix">
	                    <li class="breadcrumbs-big_i">
	                        <a class="breadcrumbs-big_a" href="">Мои друзья (268)</a>
	                    </li>
	                    <li class="breadcrumbs-big_i">Найти друзей </li>
	                </ul>
				</div>
			</div>
			<div class="content-cols">
				<div class="col-1">
					<div class="aside-filter">
						<form action="">
						<div class="aside-filter_search clearfix">
							<input type="text" name="" id="" class="aside-filter_search-itx" placeholder="Имя и/или фамилия">
							<!-- 
							В начале ввода текста, скрыть aside-filter_search-btn добавить класс active"
							 -->
							<button class="aside-filter_search-btn active"></button>
						</div>
						<div class="aside-filter_sepor"></div>
						<div class="aside-filter_row clearfix">
							<div class="aside-filter_t">Местоположение</div>
							<div class="display-ib">
								<input type="radio" name="b-radio1" id="radio1" class="aside-filter_radio" checked>
								<label for="radio1" class="aside-filter_label-radio">везде</label>
							</div>
							<input type="radio" name="b-radio1" id="radio2" class="aside-filter_radio">
							<label for="radio2" class="aside-filter_label-radio">указать где</label>
							<div class="aside-filter_toggle">
								<div class="chzn-bluelight">
									<select class="chzn">
										<option selected="selected">0</option>
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
								</div>
							</div>
						</div>
						<div class="aside-filter_sepor"></div>
						<div class="aside-filter_row clearfix">
							<div class="aside-filter_t">Пол</div>
							<input type="radio" name="b-radio2" id="radio3" class="aside-filter_radio" checked>
							<label for="radio3" class="aside-filter_label-radio">
								любой
							</label>
							<input type="radio" name="b-radio2" id="radio4" class="aside-filter_radio" checked>
							<label for="radio4" class="aside-filter_label-radio">
								<span class="ico-male"></span>
							</label>
							<input type="radio" name="b-radio2" id="radio5" class="aside-filter_radio">
							<label for="radio5" class="aside-filter_label-radio">
								<span class="ico-female"></span>
							</label>
						</div>
						<div class="aside-filter_sepor"></div>
						<div class="aside-filter_row margin-b20 clearfix">
							<div class="aside-filter_t">Возраст</div>
							<div class="aside-filter_label">от</div>
							<div class="chzn-bluelight chzn-textalign-c w-75">
								<select class="chzn">
									<option selected="selected">16</option>
									<option>1</option>
									<option>2</option>
									<option>32</option>						
									<option>32</option>						
									<option>32</option>						
									<option>32</option>						
									<option>132</option>						
									<option>132</option>						
									<option>132</option>						
								</select>
							</div>
							<div class="aside-filter_label">до</div>
							<div class="chzn-bluelight chzn-textalign-c w-75">
								<select class="chzn">
									<option selected="selected">100</option>
									<option>1</option>
									<option>2</option>
									<option>32</option>						
									<option>32</option>						
									<option>32</option>						
									<option>32</option>						
									<option>132</option>						
									<option>132</option>						
									<option>132</option>						
								</select>
							</div>
						</div>
						<div class="aside-filter_sepor"></div>
						<div class="aside-filter_row  margin-b20 clearfix ">
							<div class="aside-filter_t">Семейное положение</div>
							<div class="chzn-bluelight">
								<select class="chzn">
									<option selected="selected">женат / замужем</option>
									<option>женат / замужем</option>
									<option>женат / замужем</option>
									<option>женат / замужем</option>								
								</select>
							</div>
						</div>
						<div class="aside-filter_sepor"></div>
						<div class="aside-filter_row clearfix">
							<div class="aside-filter_t">Дети</div>
							<div class="margin-b10 clearfix">
								<input type="radio" name="b-radio3" id="radio6" class="aside-filter_radio" checked>
								<label for="radio6" class="aside-filter_label-radio">не имеет значения</label>
							</div>
							<div class="margin-b10 clearfix">
								<input type="radio" name="b-radio3" id="radio7" class="aside-filter_radio">
								<label for="radio7" class="aside-filter_label-radio">срок беременности (недели)</label>
								<div class="aside-filter_toggle">
									<div class="aside-filter_label">от</div>
									<div class="chzn-bluelight chzn-textalign-c w-75">
										<select class="chzn">
											<option selected="selected">0</option>
											<option>1</option>
											<option>2</option>
											<option>32</option>						
											<option>32</option>						
											<option>32</option>						
											<option>32</option>						
											<option>132</option>						
											<option>132</option>						
											<option>132</option>						
										</select>
									</div>
									<div class="aside-filter_label">до</div>
									<div class="chzn-bluelight chzn-textalign-c w-75">
										<select class="chzn">
											<option selected="selected">0</option>
											<option>1</option>
											<option>2</option>
											<option>32</option>						
											<option>32</option>						
											<option>32</option>						
											<option selected='selected'>32</option>						
											<option>132</option>						
											<option>132</option>						
											<option>132</option>						
										</select>
									</div>
								</div>
							</div>
							<div class="margin-b10 clearfix">
								<input type="radio" name="b-radio3" id="radio8" class="aside-filter_radio">
								<label for="radio8" class="aside-filter_label-radio">возраст ребенка (лет)</label>
								<div class="aside-filter_toggle">
									<div class="chzn-bluelight chzn-textalign-c w-75">
										<select class="chzn">
											<option selected="selected">0</option>
											<option>1</option>
											<option>2</option>
											<option>32</option>						
											<option>32</option>						
											<option>32</option>						
											<option>32</option>						
											<option>132</option>						
											<option>132</option>						
											<option>132</option>						
										</select>
									</div>
								</div>
							</div>
							<div class="margin-b10 clearfix">
								<input type="radio" name="b-radio3" id="radio9" class="aside-filter_radio">
								<label for="radio9" class="aside-filter_label-radio">многодетная семья</label>
							</div>
							
						</div>
						
					</form>
					</div>
					<div class="clearfix">
						<a href="" class="a-pseudo-gray float-r margin-r5">Сбросить все</a>
					</div>
				</div>
				
				<div class="col-23-middle col-gray clearfix">
				
					<div class="friends-list friends-list__family margin-t20">
						<div class="friends-list_i">
							<div class="b-ava-large">
								<div class="b-ava-large_ava-hold clearfix">
									<a class="ava large" href="">
										<img alt="" src="/images/example/ava-large.jpg">
									</a>
									<span class="b-ava-large_online">На сайте</span>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
										<span class="b-ava-large_ico b-ava-large_ico__mail"></span>
										<span class="b-ava-large_bubble-tx">+5</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
										<span class="b-ava-large_ico b-ava-large_ico__photo"></span>
										<span class="b-ava-large_bubble-tx">+50</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
										<span class="b-ava-large_ico b-ava-large_ico__blog"></span>
										<span class="b-ava-large_bubble-tx">+999</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__friend-add powertip" title="Добавить в друзья">
										<span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
									</a>
								</div>
								<div class="textalign-c">
									<a href="" class="b-ava-large_a">Александр Богоявленский</a>
									<span class="font-smallest color-gray"> 139 лет</span>
								</div>
							</div>
							<div class="friends-list_location clearfix">
                   				<div class="flag flag-ua" title="Украина"></div>
                   				Украина, Астраханская область
                   			</div>
							<div class="find-friend-famyli">
								<ul class="find-friend-famyli-list">
									<li>
										<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
										<span class="">Жена</span> <br>
										<span>Елизаветушка</span>
									</li>
									<li>
										<div class="img ico-child ico-child__boy-19"></div>
										<span class="">Сын</span> <br>
										<span>Евгений</span> <br>
										<span class="">20 лет</span>
									</li>
									<li>
										<div class="img ico-child ico-child__girl-19"></div>
										<span class="">Дочь</span> <br>
										<span>Евгения</span> <br>
										<span class="">19 лет</span>
									</li>
									<li>
										<div class="img ico-child ico-child__boy-14"></div>
										<span class="">Сын</span> <br>
										<span>Евгений</span> <br>
										<span class="">18 лет</span>
									</li>
									<li>
										<div class="img ico-child ico-child__girl-14"></div>
										<span class="">Дочь</span> <br>
										<span>Евгения</span> <br>
										<span class="">13 лет</span>
									</li>
									<li>
										<a href="" class="find-friend-famyli_other">еще 3</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="friends-list_i">
							<div class="b-ava-large">
								<div class="b-ava-large_ava-hold clearfix">
									<a class="ava large" href="">
										<img alt="" src="/images/example/ava-large.jpg">
									</a>
									<span class="b-ava-large_online">На сайте</span>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
										<span class="b-ava-large_ico b-ava-large_ico__mail"></span>
										<span class="b-ava-large_bubble-tx">+5</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
										<span class="b-ava-large_ico b-ava-large_ico__photo"></span>
										<span class="b-ava-large_bubble-tx">+50</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
										<span class="b-ava-large_ico b-ava-large_ico__blog"></span>
										<span class="b-ava-large_bubble-tx">+999</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__friend-added powertip" title="Отменить приглашение">
										<span class="b-ava-large_ico b-ava-large_ico__friend-added"></span>
									</a>
								</div>
								<div class="textalign-c">
									<a href="" class="b-ava-large_a">Александр Богоявленский</a>
									<span class="font-smallest color-gray"> 19 лет</span>
								</div>
							</div>
							<div class="friends-list_location clearfix">
                   				<div class="flag flag-ru" title="Россия"></div>
                   				Россия, Переславль-Залесский, Астраханская область
                   			</div>
						</div>
						<div class="friends-list_i">
							<div class="b-ava-large">
								<div class="b-ava-large_ava-hold clearfix">
									<a class="ava large" href="">
										<img alt="" src="/images/example/ava-large.jpg">
									</a>
									<span class="b-ava-large_online">На сайте</span>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
										<span class="b-ava-large_ico b-ava-large_ico__mail"></span>
										<span class="b-ava-large_bubble-tx">+5</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
										<span class="b-ava-large_ico b-ava-large_ico__photo"></span>
										<span class="b-ava-large_bubble-tx">+50</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
										<span class="b-ava-large_ico b-ava-large_ico__blog"></span>
										<span class="b-ava-large_bubble-tx">+999</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__friend-add powertip" title="Добавить в друзья">
										<span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
									</a>
								</div>
								<div class="textalign-c">
									<a href="" class="b-ava-large_a">Александр Богоявленский</a>
									<span class="font-smallest color-gray"> 19 лет</span>
								</div>
							</div>
							<div class="friends-list_location clearfix">
                   				<div class="flag flag-kz" title="Россия"></div>
                   				Казахстан, Переславль-Залесский, Астраханская область
                   			</div>
							<div class="find-friend-famyli">
								<ul class="find-friend-famyli-list">
									<li>
										<div class="img"><img alt="" src="/images/example/w52-h34-1.jpg"></div>
										<span class="">Жена</span> <br>
										<span>Светлана</span>
									</li>
									<li>
										<div class="img">
										<img src="http://img.happy-giraffe.ru/thumbs/66x66/83/2d77cb16aa563469aeb8af25ad69e436.JPG" alt="Настюня"></div>
										<span class="">Дочь</span> <br>
										<span>Евгения</span> <br>
										<span class="">3 мес.</span>
									</li>
									<li>
										<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
										<span class="">Дочь</span> <br>
										<span>Евгения</span> <br>
										<span class="">3 мес.</span>
									</li>
								</ul>
							</div>
						</div>
						<div class="friends-list_i">
							<div class="b-ava-large">
								<div class="b-ava-large_ava-hold clearfix">
									<a class="ava large" href="">
										<img alt="" src="/images/example/ava-large.jpg">
									</a>
									<span class="b-ava-large_online">На сайте</span>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
										<span class="b-ava-large_ico b-ava-large_ico__mail"></span>
										<span class="b-ava-large_bubble-tx">+5</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
										<span class="b-ava-large_ico b-ava-large_ico__photo"></span>
										<span class="b-ava-large_bubble-tx">+50</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
										<span class="b-ava-large_ico b-ava-large_ico__blog"></span>
										<span class="b-ava-large_bubble-tx">+999</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__friend-add powertip" title="Добавить в друзья">
										<span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
									</a>
								</div>
								<div class="textalign-c">
									<a href="" class="b-ava-large_a">Александр Богоявленский</a>
									<span class="font-smallest color-gray"> 39 лет</span>
								</div>
							</div>
							<div class="friends-list_location clearfix">
                   				<div class="flag flag-ua" title="Россия"></div>
                   				Россия, Астраханская область
                   			</div>
							<div class="find-friend-famyli">
								<ul class="find-friend-famyli-list">
									<li>
										<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
										<span class="">Жена</span> <br>
										<span>Елизаветушка</span>
									</li>
									<li>
										<div class="img ico-child ico-child__boy-19"></div>
										<span class="">Сын</span> <br>
										<span>Евгений</span> <br>
										<span class="">20 лет</span>
									</li>
									<li>
										<div class="img ico-child ico-child__girl-19"></div>
										<span class="">Дочь</span> <br>
										<span>Евгения</span> <br>
										<span class="">19 лет</span>
									</li>
									<li>
										<div class="img ico-child ico-child__boy-14"></div>
										<span class="">Сын</span> <br>
										<span>Евгений</span> <br>
										<span class="">18 лет</span>
									</li>
									<li>
										<div class="img ico-child ico-child__girl-14"></div>
										<span class="">Дочь</span> <br>
										<span>Евгения</span> <br>
										<span class="">13 лет</span>
									</li>
									<li>
										<a href="" class="find-friend-famyli_other">еще 3</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="friends-list_i">
							<div class="b-ava-large">
								<div class="b-ava-large_ava-hold clearfix">
									<a class="ava large" href="">
										<img alt="" src="/images/example/ava-large.jpg">
									</a>
									<span class="b-ava-large_online">На сайте</span>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
										<span class="b-ava-large_ico b-ava-large_ico__mail"></span>
										<span class="b-ava-large_bubble-tx">+5</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
										<span class="b-ava-large_ico b-ava-large_ico__photo"></span>
										<span class="b-ava-large_bubble-tx">+50</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
										<span class="b-ava-large_ico b-ava-large_ico__blog"></span>
										<span class="b-ava-large_bubble-tx">+999</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__friend-add powertip" title="Добавить в друзья">
										<span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
									</a>
								</div>
								<div class="textalign-c">
									<a href="" class="b-ava-large_a">Александр Богоявленский</a>
									<span class="font-smallest color-gray"> 19 лет</span>
								</div>
							</div>
							<div class="friends-list_location clearfix">
                   				<div class="flag flag-ru" title="Россия"></div>
                   				Россия, Переславль, Астраханская область
                   			</div>
							<div class="find-friend-famyli">
								<ul class="find-friend-famyli-list">
									<li>
										<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
										<span class="">Дочь</span> <br>
										<span>Евгения</span> <br>
										<span class="">3 мес.</span>
									</li>
								</ul>
							</div>
						</div>
						<div class="friends-list_i">
							<div class="b-ava-large">
								<div class="b-ava-large_ava-hold clearfix">
									<a class="ava large" href="">
										<img alt="" src="/images/example/ava-large.jpg">
									</a>
									<span class="b-ava-large_online">На сайте</span>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
										<span class="b-ava-large_ico b-ava-large_ico__mail"></span>
										<span class="b-ava-large_bubble-tx">+5</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
										<span class="b-ava-large_ico b-ava-large_ico__photo"></span>
										<span class="b-ava-large_bubble-tx">+50</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
										<span class="b-ava-large_ico b-ava-large_ico__blog"></span>
										<span class="b-ava-large_bubble-tx">+999</span>
									</a>
									<a href="" class="b-ava-large_bubble b-ava-large_bubble__friend-add powertip" title="Добавить в друзья">
										<span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
									</a>
								</div>
								<div class="textalign-c">
									<a href="" class="b-ava-large_a">Александр Богоявленский</a>
									<span class="font-smallest color-gray"> 139 лет</span>
								</div>
							</div>
							<div class="friends-list_location clearfix">
                   				<div class="flag flag-ru" title="Россия"></div>
                   				Россия, Астраханская область
                   			</div>
							<div class="find-friend-famyli">
								<ul class="find-friend-famyli-list">
									<li>
										<div class="img"><img alt="" src="/images/example/w52-h34-1.jpg"></div>
										<span class="">Жена</span> <br>
										<span>Светлана</span>
									</li>
									<li>
										<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
										<span class="">Дочь</span> <br>
										<span>Евгения</span> <br>
										<span class="">3 мес.</span>
									</li>
								</ul>
							</div>
						</div>
						
						<div id="infscr-loading"><img src="/images/ico/ajax-loader.gif" alt="Loading..."><div>Загрузка</div></div>
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
