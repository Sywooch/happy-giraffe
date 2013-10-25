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
									<option selected='selected'>32</option>						
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
				
					<div class="cap-empty cap-empty__rel">
						<div class="cap-empty_hold">
							<div class="cap-empty_tx">По данным параметрам ни чего не найдено.</div>
							<span class="color-gray">Измените параметры поиска</span>
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
