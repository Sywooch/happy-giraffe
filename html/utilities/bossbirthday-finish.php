<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="top-nav-fixed ie7"> <![endif]-->
<!--[if IE 8]>         <html class="top-nav-fixed ie8"> <![endif]-->
<!--[if IE 9]>         <html class="top-nav-fixed ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="top-nav-fixed"> <!--<![endif]-->
<head>

	<link rel="stylesheet" type="text/css" href="/stylesheets/bossbirthday.css" />
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>

</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div id="layout" class="wrapper">
		
		<div id="content" class="clearfix">
				
			<div class="bossbirthday">
				<div class="clearfix">
					<div class="logo-box">
						<a href="/" class="logo" title="hg.ru – Домашняя страница">Ключевые слова сайта</a>
						<span>САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
					</div>
				</div>
				<div class="bossbirthday_fact bossbirthday_fact__big">
					<p>Поздравляем! Вы прошли тестирование успешно и можете по праву носить гордое звание отца Весёлого Жирафа и шефа <br>нашего коллектива!	</p>
					<!-- Может без указания времени -->
					<div class="bossbirthday_desc">- команда Веселый Жираф, сегодня 05:25</div>
				</div>
				<div class="bossbirthday_t bossbirthday_t__finish">
					<span class="color-carrot">Мира!</span> <br>
					Поздравляем тебя с Днём рождения! <br>
					Пускай растёт и крепнет мощный траф! <br>
					Мы верим в успех! И имеет значение, <br>
					Что есть в интернете Весёлый Жираф! <br>
				</div>
				
	<script type="text/javascript">
	//<![CDATA[

		$(function(){


			/* skin hgrucomment */
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
				<div class="comment-add active clearfix">
					<div class="comment-add_user">
						<div class="comment-add_user-ava">
								 <a href="" class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/13623/ava/7acd577045e2014b4d26ecd33f6ce6d2.jpeg"></a>
				              <span class="comment-add_username"> </span>
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
		
		<div class="footer-push"></div>
		
	</div>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

</body>
</html>
