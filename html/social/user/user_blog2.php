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
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
		
		<div class="layout-content clearfix">
		<div class="content-cols clearfix">
			<div class="col-23-middle">
				<div class="blog-title-b">
					<div class="blog-title-b_img-hold">
						<img src="/images/example/w720-h128.jpg" alt="" class="blog-title-b_img">
					</div>
					<h1 class="blog-title-b_t">Блог о красивой любви </h1>
				</div>
				
				<div class="b-article clearfix">
					<div class="float-l">
						<div class="like-control like-control__small-indent clearfix">
							<a href="" class="ava male">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
							</a>
						</div>
						<script>
						$(window).load(function() {
							/*
							block - элемент, что фиксируется
							elementStop - до какого элемента фиксируется
							blockIndent - отступ
							*/
							function likeControlFixedInBlock(block, inBlock, blockIndent) {

								var block = $(block);
								var blockTop = block.offset().top;
								var blockHeight = block.outerHeight();
								/*
									var stopTop = $(elementStop).offset().top;
									var blockStopTop = stopTop - blockTop - blockHeight - blockIndent;
								*/
								var inBlock = $(inBlock);
								var blockStopBottom = inBlock.offset().top + inBlock.outerHeight();

								if (blockStopBottom-blockTop-blockHeight-blockIndent > 20) {

									$(window).scroll(function() {
								        var windowScrollTop = $(window).scrollTop();
								        if (
								        	windowScrollTop > blockTop-blockIndent && 
								        	windowScrollTop + blockHeight < blockStopBottom - blockIndent
								        	) {
								        	block.css({
												'position': 'fixed', 
												'top'     : blockIndent+'px'
											});
								        } else {

											block.css({
												'position': 'relative', 
												'top'     : 'auto'
											});

								        	if (windowScrollTop + blockHeight > blockStopBottom - blockIndent) {
								        		block.css({ 
								        			/* 89 - высота блока над едущими лайками */
													'top'     : inBlock.outerHeight() - blockHeight - 89 
												});
								        	}
								        }
								    });
								}
							}

							likeControlFixedInBlock('.js-like-control', '.b-article', 80);
						})
						</script>
						<div class="js-like-control" >
							<div class="like-control like-control__self clearfix">
								<div class="position-rel">
									<a href="" class="like-control_ico like-control_ico__like">865</a>
									<div class="favorites-add-popup favorites-add-popup__right">
										<div class="">Вы не можете ставить "Нравиться" к своей записи</div>
									</div>
								</div>
								<div class="position-rel">
									<a href="" class="like-control_ico like-control_ico__repost">5</a>
									<div class="favorites-add-popup favorites-add-popup__right">
										<div class="">Вы не можете делать репост своей записи</div>
									</div>
								</div>
								<div class="position-rel">
									<a href="" class="favorites-control_a">123865</a>
									<div class="favorites-add-popup favorites-add-popup__right">
										<div class="">Вы не можете добавить свою запись в Избранное</div>
									</div>
								</div>
							</div>
							<div class="article-settings">
								<div class="article-settings_i">
									<a href="" class="article-settings_a article-settings_a__settings powertip" title="Настройки"></a>
								</div>
								<div class="article-settings_hold display-b">
									<div class="article-settings_i">
										<a href="" class="article-settings_a article-settings_a__pin powertip" title="Прикрепить вверху"></a>
									</div>
									<div class="article-settings_i">
										<a href="" class="article-settings_a article-settings_a__edit powertip"  title="Редактировать"></a>
									</div>
									<div class="article-settings_i">
										<a href="javascript:void(0)" class="ico-users ico-users__friend active powertip" title="Приватность"></a>
										<div class="article-settings_drop display-b">
											<div class="article-settings_drop-i">
												<a href="" class="article-settings_drop-a">
												<span class="ico-users ico-users__all"></span>
												Показывать всем
												</a>
											</div>
											<div class="article-settings_drop-i">
												<a href="" class="article-settings_drop-a">
												<span class="ico-users ico-users__friend"></span>
												Только друзьям
												</a>
											</div>
										</div>
									</div>
									<div class="article-settings_i">
										<a href="" class="article-settings_a article-settings_a__delete powertip"  title="Удалить"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="b-article_cont clearfix">
						<div class="b-article_cont-tale"></div>
						<div class="b-article_header clearfix">
							<div class="clearfix">
								<div class="meta-gray">
									<a href="" class="meta-gray_comment">
										<span class="ico-comment ico-comment__gray"></span>
										<span class="meta-gray_tx">35</span>
									</a>
									<div class="meta-gray_view">
										<span class="ico-view ico-view__gray"></span>
										<span class="meta-gray_tx">305</span>
									</div>
								</div>
								<div class="float-l">
									<a href="" class="b-article_author">Ангелина Богоявленская</a>
									<span class="font-smallest color-gray">Сегодня 13:25</span>
								</div>
							</div>
							<div class="user-actions">
								<!-- 
									Виды иконок друг 
									user-actions_i__friend - друг
									user-actions_i__friend-add - добавить в друзья
									user-actions_i__friend-added - приглашение выслано
									user-actions_i__friend-append - встречное приглашение в друзья, принять
								 -->
								<a href="" class="user-actions_i user-actions_i__friend-add powertip" title="Приглашение выслано">
									<span class="user-actions_ico"></span>
								</a>
								<a href="" class="user-actions_i user-actions_i__message powertip" title="Написать сообщение">
									<span class="user-actions_ico"></span>
								</a>
							</div>
						</div>
						<h2 class="b-article_t">
							Самое лучшее утро - просыпаюсь, а ты рядом
						</h2>
						<div class="b-article_in clearfix">
							<div class="wysiwyg-content clearfix">
								<div class="b-article_in-img">
									<iframe width="580" height="320" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/pehSAUTqjRs?wmode=transparent"></iframe>
								</div>
								<p>	Недавно посмотрел фильм "Убить Дракона" снятый в 1988 году с Абдуловым в главной роли. По мотивам пьесы Евгения Шварца «Дракон».</p>
								<ol>
									<li>Практически нет девушки, которая не переживала бы за отношения героев "Сумерек" как в на экранах, так и в жизни. Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, что у них невероятный роман  и в рельной жизни, а не только лишь на экране, все же <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока реши</li>
									<li>Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, что у них невероятный роман  и в рельной жизни, а не только лишь на экране, все же <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока реши</li>
									<li> <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока реши</li>
									<li>Практически нет девушки, которая не переживала бы за отношения героев "Сумерек" как в на экранах, так и в жизни. Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, что у них невероятный роман  и в рельной жизни, а не только лишь на экране, все же <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока реши</li>
								</ol>
								<p>Практически нет девушки, которая не переживала бы за отношения героев "Сумерек" как в на экранах, так и в жизни. Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, что у них невероятный роман  и в рельной жизни, а не только лишь на экране, все же <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока решили взять паузу в своих отношениях.</p>
								
								<div class="clearfix">
									<img title="Убить Дракона. Фантасмагория или сказка для взрослых. фото 1" src="http://img.happy-giraffe.ru/thumbs/700x700/16534/3733dd340b221ac3052b5cef11288870.jpg" class="content-img" alt="Убить Дракона. Фантасмагория или сказка для взрослых. фото 1">
								</div>
								<h2>H2 Где можно поменять название трека</h2>
								<p>	Недавно посмотрел фильм "Убить Дракона" снятый в 1988 году с Абдуловым в главной роли. По мотивам пьесы Евгения Шварца «Дракон».</p>
								<div class="b-article_in-img">
									<img title="Ночные гости - кто они фото 1" src="http://img.happy-giraffe.ru/thumbs/700x700/56/edad8d334a0b4a086a50332a2d8fd0fe.JPG" class="content-img" alt="Ночные гости - кто они фото 1">
								</div>
								<ul>
									<li>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </li>
									<li>я не нашел, где можно поменять название трека.</li>
									<li>Меняя название трека в <strong>Меняя название трека</strong> альбоме он автоматически производит поиск <a href="">Меняя название трека </a>по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. <b>Меняя название трека</b>  в альбоме он автоматически </li>
								</ul>
								<p>и подцепляет естественно студийные версии песен вместо нужных. и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически  и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
								<h2>H2 Где можно поменять название трека</h2>
								<p>	Недавно <i>посмотрел фильм "Убить Дракона" снятый</i>  в 1988 году с <em>Абдуловым в главной роли</em> . По мотивам <strike>пьесы Евгения Шварца</strike>  «Дракон».</p>
								<h3>H3 Где можно поменять название трека</h3>
								
								<ul>
									<li>первое </li>
									<li>второе</li>
									<li>третье </li>
								</ul>
							</div>
						</div>

						<div class="b-photopost">
							<h2 class="b-photopost_t">Цветы из бумаги объемные</h2>
                            <div class="photo-grid clearfix">
                                <div class="photo-grid_row clearfix" >
                                    <!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
                                    <div class="photo-grid_i">
                                        <img class="photo-grid_img" src="/images/example/w580-h369.jpg" alt="">
                                        <div class="photo-grid_tip">25 фото</div>
                                        <span class="ico-play-big"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="margin-20 clearfix">
                                <a href="" class="float-r btn-blue-light btn-medium">Смотреть галерею</a>
                                <div class="float-l">
                                    <a href="" class="b-article_photo-control b-article_photo-control__single powertip" title="Обложка"></a>
                                    <a href="" class="b-article_photo-control b-article_photo-control__grid active powertip" title="Плитка"></a>
                                </div>
                            </div>
						</div>
						<div class="b-photopost">
							<h2 class="b-photopost_t">Цветы из бумаги объемные</h2>
							<div class="photo-grid clearfix">
                                <div class="photo-grid_row clearfix">
                                    <!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
                                    <div class="photo-grid_i">
                                        <img alt="" src="/images/example/photo-grid-1.jpg" class="photo-grid_img">
                                        <div class="photo-grid_overlay">
                                            <span class="photo-grid_zoom powertip"></span>
                                        </div>
                                    </div>
                                    <div class="photo-grid_i">
                                        <img alt="" src="/images/example/photo-grid-2.jpg" class="photo-grid_img">
                                        <div class="photo-grid_overlay">
                                            <span class="photo-grid_zoom powertip"></span>
                                        </div>
                                    </div>
                                    <div class="photo-grid_i">
                                        <img alt="" src="/images/example/photo-grid-3.jpg" class="photo-grid_img">
                                        <div class="photo-grid_overlay">
                                            <span class="photo-grid_zoom powertip"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="photo-grid_row clearfix">
                                    <!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
                                    <div class="photo-grid_i">
                                        <img alt="" src="/images/example/photo-grid-4.jpg" class="photo-grid_img">
                                        <div class="photo-grid_overlay">
                                            <span class="photo-grid_zoom powertip"></span>
                                        </div>
                                    </div>
                                    <div class="photo-grid_i">
                                        <img alt="" src="/images/example/photo-grid-5.jpg" class="photo-grid_img">
                                        <div class="photo-grid_overlay">
                                            <span class="photo-grid_zoom powertip"></span>
                                        </div>
                                    </div>
                                    <div class="photo-grid_i">
                                        <img alt="" src="/images/example/photo-grid-6.jpg" class="photo-grid_img">
                                        <div class="photo-grid_overlay">
                                            <span class="photo-grid_zoom powertip"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="photo-grid_row clearfix">
                                    <!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
                                    <div class="photo-grid_i">
                                        <img alt="" src="/images/example/photo-grid-3.jpg" class="photo-grid_img">
                                        <div class="photo-grid_overlay">
                                            <span class="photo-grid_zoom powertip"></span>
                                        </div>
                                    </div>
                                    <div class="photo-grid_i">
                                        <img alt="" src="/images/example/photo-grid-1.jpg" class="photo-grid_img">
                                        <div class="photo-grid_overlay">
                                            <span class="photo-grid_zoom powertip"></span>
                                        </div>
                                    </div>
                                    <div class="photo-grid_i">
                                        <img alt="" src="/images/example/photo-grid-2.jpg" class="photo-grid_img">
                                        <div class="photo-grid_overlay">
                                            <span class="photo-grid_zoom powertip"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="margin-20 clearfix">
                                <a href="" class="float-r btn-blue-light btn-medium">Смотреть галерею</a>
                                <div class="float-l">
                                    <a href="" class="b-article_photo-control b-article_photo-control__single powertip" title="Обложка"></a>
                                    <a href="" class="b-article_photo-control b-article_photo-control__grid active powertip" title="Плитка"></a>
                                </div>
                            </div>
						</div>
						
						<div class="custom-likes-b">
							<div class="custom-likes-b_slogan">Поделитесь с друзьями!</div>
							<a href="" class="custom-like">
								<span class="custom-like_icon odnoklassniki"></span>
								<span class="custom-like_value">0</span>
							</a>
							<a href="" class="custom-like">
								<span class="custom-like_icon vkontakte"></span>
								<span class="custom-like_value">1900</span>
							</a>
						
							<a href="" class="custom-like">
								<span class="custom-like_icon facebook"></span>
								<span class="custom-like_value">150</span>
							</a>
						
							<a href="" class="custom-like">
								<span class="custom-like_icon twitter"></span>
								<span class="custom-like_value">10</span>
							</a>
						</div>
						<div class="nav-article clearfix">
							<div class="nav-article_left">
								<a href="" class="nav-article_a">Очень красивые пропорции у нашего ведущего</a>
							</div>
							<div class="nav-article_right">
								<a href="" class="nav-article_a">Очень красивые пропорции Очень красивые пропорции у нашего ведущего у нашего ведущего</a>
							</div>
						</div>
						
						<div class="article-banner">
							<a href="">
								<img border="0" title="" alt="" src="/images/example/w540-h285.jpg">
							</a>
						</div>
						
					</div>
				</div>
				<div class="article-banner">
					<a href="">
						<img border="0" title="" alt="" src="/images/example/yandex-direct_wide.jpg">
					</a>
				</div>
				
				<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/comments-gray-open.php'; ?>
				
				<div class="article-users">
					<div class="article-users_t">Запись понравилась </div>
					<div class="ava-list">
						<ul class="ava-list_ul clearfix">
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/204378/avaa0ef048c9ef438ec6dd90b42018a6723.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/204378/avaa0ef048c9ef438ec6dd90b42018a6723.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/204378/avaa0ef048c9ef438ec6dd90b42018a6723.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/204378/avaa0ef048c9ef438ec6dd90b42018a6723.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava-list_last">
									<span class="ava-list_like-hg"></span>
									3251
								</a>
							</li>
						</ul>
					</div>
					<div class="article-users_t">Запись добавили в избранное </div>
					<div class="ava-list">
						<ul class="ava-list_ul clearfix">
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/204378/avaa0ef048c9ef438ec6dd90b42018a6723.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/204378/avaa0ef048c9ef438ec6dd90b42018a6723.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/204378/avaa0ef048c9ef438ec6dd90b42018a6723.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small"></a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<img src="http://img.happy-giraffe.ru/avatars/162805/small/b54f360d2dde78da71753933930b03b0.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/204378/avaa0ef048c9ef438ec6dd90b42018a6723.jpg" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava small">
									<span class="icon-status"></span>
									<img src="http://img.happy-giraffe.ru/thumbs/24x24/24525/ava0c20b2a907729c1f6b671ebf2e31eac3.JPG" alt="">
								</a>
							</li>
							<li class="ava-list_li">
								<a href="" class="ava-list_last">
									<span class="ava-list_favorite active"></span>
									3251 и вы 
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- На будущее для авторов -->
				<!-- <div class="clearfix margin-r20">
					<div class="float-r">
						<a href="" class="a-pseudo-gray">Полная статистика действий</a>
					</div>
				</div> -->
				
				<!-- Пример открытого статуса юзера -->
				<div class="b-article b-article__user-status clearfix">
					<div class="float-l">
						<div class="like-control like-control__small-indent clearfix">
							<a href="" class="ava male">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
							</a>
						</div>
						<div class="like-control clearfix">
							<a href="" class="like-control_ico like-control_ico__like">865</a>
							<a href="" class="like-control_ico like-control_ico__repost">5</a>
							<a href="" class="like-control_ico like-control_ico__favorites active">123865</a>
						</div>
					</div>
					<div class="b-article_cont clearfix">
						<div class="b-article_cont-tale"></div>
						<div class="b-article_header clearfix">
							<div class="meta-gray">
								<a href="" class="meta-gray_comment">
									<span class="ico-comment ico-comment__gray"></span>
									<span class="meta-gray_tx">35</span>
								</a>
								<div class="meta-gray_view">
									<span class="ico-view ico-view__gray"></span>
									<span class="meta-gray_tx">305</span>
								</div>
							</div>
							<div class="float-l">
								<a href="" class="b-article_author">Ангелина Богоявленская</a>
								<span class="font-smallest color-gray">Сегодня 13:25</span>
							</div>
						</div>
						<div class="b-article_in clearfix">
							<div class="b-article_user-status clearfix">
								<span class="b-article_user-status-a">	Говори </span>
								
								<div class="textalign-r clearfix">
									<div class="b-user-mood">
										<div class="b-user-mood_hold">
											<div class="b-user-mood_tx">Мое настроение -</div>
										</div>
										<div class="b-user-mood_img">
											<img src="/images/widget/mood/6.png">
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="bg-white clearfix">
							<div class="custom-likes-b custom-likes-b__like-white">
								<div class="custom-likes-b_slogan">Поделитесь с друзьями!</div>
								<a href="" class="custom-like">
									<span class="custom-like_icon odnoklassniki"></span>
									<span class="custom-like_value">0</span>
								</a>
								<a href="" class="custom-like">
									<span class="custom-like_icon vkontakte"></span>
									<span class="custom-like_value">1900</span>
								</a>
							
								<a href="" class="custom-like">
									<span class="custom-like_icon facebook"></span>
									<span class="custom-like_value">150</span>
								</a>
							
								<a href="" class="custom-like">
									<span class="custom-like_icon twitter"></span>
									<span class="custom-like_value">10</span>
								</a>
							
							</div>
						</div>
						
					</div>
				</div>
				
				<!-- Для примера, так не прикручивать верстку -->
				<div class="margin-20">
					<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/comments-gray-empty.php'; ?>
				</div>

				<div class="such-post">
					<div class="such-post_title">Смотрите также</div>
					<div class="clearfix">
						<div class="such-post_i such-post_i__photopost">
							<a href="" class="such-post_img-hold">
								<img src="/images/example/w335-h230.jpg" alt="" class="such-post_img">
								<span class="such-post_img-overlay"></span>
								<span class="such-post_tip">25 фото</span>
							</a>
							<div class="such-post_type-hold">
								<div class="such-post_type such-post_type__photopost"></div>
							</div>
							<div class="such-post_cont">
								<div class="clearfix">
									<div class="meta-gray">
										<a class="meta-gray_comment" href="">
											<span class="ico-comment ico-comment__white"></span>
											<span class="meta-gray_tx color-gray-light">35</span>
										</a>
										<div class="meta-gray_view">
											<span class="ico-view ico-view__white"></span>
											<span class="meta-gray_tx color-gray-light">305</span>
										</div>
									</div>
									<div class="such-post_author">
										<a href="" class="ava female middle">
											<span class="icon-status status-online"></span>
											<img src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" alt="">
										</a>
										<a href="" class="such-post_author-name">Татьяна</a>
										<div class="such-post_date">Сегодня 13:25</div>
									</div>
									
								</div>
								<a href="" class="such-post_t">Креативная сервисная</a>
							</div>
						</div>
						<div class="such-post_i">
							<a href="" class="such-post_img-hold">
								<img src="/images/example/w335-h230.jpg" alt="" class="such-post_img">
							</a>
							<div class="such-post_type-hold">
								<div class="such-post_type such-post_type__post"></div>
							</div>
							<div class="such-post_cont">
								<div class="clearfix">
									<div class="meta-gray">
										<a class="meta-gray_comment" href="">
											<span class="ico-comment ico-comment__gray"></span>
											<span class="meta-gray_tx">35</span>
										</a>
										<div class="meta-gray_view">
											<span class="ico-view ico-view__gray"></span>
											<span class="meta-gray_tx">305</span>
										</div>
									</div>
									<div class="such-post_author">
										<a href="" class="ava female middle">
											<span class="icon-status status-online"></span>
											<img src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" alt="">
										</a>
										<a href="" class="such-post_author-name">ТатьянаАлександровна</a>
										<div class="such-post_date">Сегодня 13:25</div>
									</div>
									
								</div>
								<a href="" class="such-post_t">Готовим  Торт Сметанник в домашних условиях</a>
							</div>
						</div>
					</div>
				</div>

				
				<div class="menu-simple menu-simple__after-article2">
					<div class="menu-simple_t-sub">Вам может быть интересно</div>
					<ul class="menu-simple_ul">
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Как правильно встречать мужа с работы</a>
						</li>
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Детские передачи</a>
						</li>
						<li class="menu-simple_li">
							<a class="menu-simple_a" href="">Рутина отношений убивает супружество</a>
						</li>
					</ul>
				</div>


				<table class="article-nearby clearfix" ellpadding="0" cellspacing="0">
					<tr>
						<td>
							<div class="article-nearby_hint">Предыдущая запись</div>
						</td>
						<td class="article-nearby_r">
							<div class="article-nearby_hint">Следующая запись</div>
						</td>
					</tr>
					<tr>
						<td>
							<a href="" class="article-nearby_a clearfix">
								<span class="article-nearby_img-hold">
									<img src="/images/example/w64-h61-2.jpg" alt="">
								</span>
								<span class="article-nearby_tx">Как приготовить Монастыпскую избу</span>
							</a>
						</td>
						<td class="article-nearby_r">
							<a href="" class="article-nearby_a clearfix">
								<span class="article-nearby_tx">Готовим  Торт Сметанник в домашних условиях</span>
							</a>
						</td>
					</tr>
				</table>

			</div>
			<div class="col-1">

				<div class="b-ava-large">
					<div class="b-ava-large_ava-hold clearfix">
						<a href="" class="ava powertip ava__large ava__female"><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
						<span class="b-ava-large_online">На сайте</span>
						<a class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" href="">
							<span class="b-ava-large_ico b-ava-large_ico__mail"></span>
							<span class="b-ava-large_bubble-tx">+5</span>
						</a>
						<a class="b-ava-large_bubble b-ava-large_bubble__photo powertip" href="">
							<span class="b-ava-large_ico b-ava-large_ico__photo"></span>
							<span class="b-ava-large_bubble-tx">+50</span>
						</a>
						<a class="b-ava-large_bubble b-ava-large_bubble__blog powertip" href="">
							<span class="b-ava-large_ico b-ava-large_ico__blog"></span>
							<span class="b-ava-large_bubble-tx">+999</span>
						</a>
						<a class="b-ava-large_bubble b-ava-large_bubble__friend-add-onhover powertip" href="">
							<span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
						</a>
					</div>
					<div class="textalign-c">
						<a class="b-ava-large_a" href="">Александр Богоявленский</a>
						<span class="font-smallest color-gray"> 39 лет</span>
					</div>
					<div class="b-ava-large_location">
						<div class="flag flag-ua" title="Украина"></div>
               				Украина, Астраханская область
					</div>
				</div>
				
				<div class="aside-blog-desc">
					<div class="aside-blog-desc_tx">
						Пусть кто-то будет безумно красивый Пусть кто-то будет богаче и круче Мне наплевать, ведь ты - мой любимый.	Ты навсегда. Ты мой. Самый лучший.
					</div>
				</div>
				<div class="readers2">
					<a href="" class="btn-green btn-medium">Подписаться</a>
					<ul class="readers2_ul clearfix">
						<li class="readers2_li clearfix">
							<a href="" class="ava female small">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a href="" class="ava female small">
								<img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a href="" class="ava female small">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a href="" class="ava female small">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a href="" class="ava female small">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a href="" class="ava male small">
								<span class="icon-status status-online"></span>
							</a>
						</li>
					</ul>
					<div class="clearfix">
						<div class="readers2_count">Все подписчики (129)</div>
					</div>
				</div>
				
				<div class="menu-simple">
					<ul class="menu-simple_ul">
						<li class="menu-simple_li">
							<a href="" class="menu-simple_a">Обо всем</a>
						</li>
						<li class="menu-simple_li">
							<a href="" class="menu-simple_a">Свадьба - прекрасный миг</a>
						</li>
						<li class="menu-simple_li">
							<a href="" class="menu-simple_a">Прикольное видео </a>
						</li>
						<li class="menu-simple_li">
							<a href="" class="menu-simple_a">Школа восточного танца  </a>
						</li>
						<li class="menu-simple_li active">
							<a href="" class="menu-simple_a">Мой мужчина </a>
						</li>
						<li class="menu-simple_li">
							<a href="" class="menu-simple_a">Детские передачи </a>
						</li>
						<li class="menu-simple_li">
							<a href="" class="menu-simple_a">Свадьбы </a>
						</li>
						<li class="menu-simple_li">
							<a href="" class="menu-simple_a">Кормление ребенка </a>
						</li>
						<li class="menu-simple_li">
							<a href="" class="menu-simple_a">Воспитание детей </a>
						</li>
					</ul>
				</div>
				
				<div class="fast-articles2 js-fast-articles2">
					<div class="fast-articles2_t-ico"></div>
					<div class="fast-articles2_i">
						<div class="fast-articles2_header clearfix">
						
							<div class="meta-gray">
								<a href="" class="meta-gray_comment">
									<span class="ico-comment ico-comment__gray"></span>
									<span class="meta-gray_tx">35</span>
								</a>
								<div class="meta-gray_view">
									<span class="ico-view ico-view__gray"></span>
									<span class="meta-gray_tx">305</span>
								</div>
							</div>
							
							<div class="float-l">
								<span class="font-smallest color-gray">Сегодня 13:25</span>
							</div>
						</div>
						<div class="fast-articles2_i-t">
							<a href="" class="fast-articles2_i-t-a"> О моем первом бойфренде</a>
						</div>
						<div class="fast-articles2_i-desc">Практически нет девушки, которая не переживала </div>
						<div class="fast-articles2_i-img-hold">
							<a href=""><img src="/images/example/w190-h166.jpg" alt="" class="fast-articles2_i-img"></a>
						</div>
					</div>
					<div class="fast-articles2_i">
						<div class="fast-articles2_header clearfix">
						
							<div class="meta-gray">
								<a href="" class="meta-gray_comment">
									<span class="ico-comment ico-comment__gray"></span>
									<span class="meta-gray_tx">35</span>
								</a>
								<div class="meta-gray_view">
									<span class="ico-view ico-view__gray"></span>
									<span class="meta-gray_tx">305</span>
								</div>
							</div>
							
							<div class="float-l">
								<span class="font-smallest color-gray">Сегодня 13:25</span>
							</div>
						</div>
						<div class="fast-articles2_i-t">
							<a href="" class="fast-articles2_i-t-a"> Как мне предлагали руку и сердце</a>
						</div>
						<div class="fast-articles2_i-desc">Практически нет девушки, которая не переживала </div>
						<div class="fast-articles2_i-img-hold">
							<div class="photo-grid photo-grid__indent-sm clearfix">
								<div class="photo-grid_row clearfix">
									<div class="photo-grid_i" >
										<img class="photo-grid_img" src="http://img.happy-giraffe.ru/thumbs/x93/159841/fc78476c9f5ef91684257aa1bf0ab307.jpg" alt="">
										<div class="photo-grid_overlay">
											<span class="photo-grid_zoom"></span>
										</div>
									</div>
									<div class="photo-grid_i">
										<img class="photo-grid_img" src="http://img.happy-giraffe.ru/thumbs/x93/159841/537a0df1f7c1aaa46fed45c036144365.jpg" alt="">
										<div class="photo-grid_overlay">
											<span class="photo-grid_zoom"></span>
										</div>
									</div>
								</div>
								<div class="photo-grid_row clearfix">
									<div class="photo-grid_i">
										<img class="photo-grid_img" src="http://img.happy-giraffe.ru/thumbs/x83/159841/f339bac1aef5919a08bdb43474431326.jpg" alt="">
										<div class="photo-grid_overlay">
											<span class="photo-grid_zoom"></span>
										</div>
									</div>
									<div class="photo-grid_i" >
										<img class="photo-grid_img" src="http://img.happy-giraffe.ru/thumbs/x83/159841/94b7650e47db01298d38d96f15a5ab3b.jpg" alt="">
										<div class="photo-grid_overlay">
											<span class="photo-grid_zoom"></span>
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
		
		<a href="#layout" id="btn-up-page"></a>
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

</body>
</html>