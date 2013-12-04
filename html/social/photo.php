<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>

</head>
<body class="body-gray">

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
					<div class="user-add-record user-add-record__small clearfix">
						<div class="user-add-record_ava-hold">
							<a href="" class="ava male middle">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
							</a>
						</div>
						<div class="user-add-record_hold">
							<div class="user-add-record_tx">Я хочу добавить</div>
							<a href="#popup-user-add-article"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy powertip" title="Статью"></a>
							<a href="#popup-user-add-photo"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy powertip" title="Фото"></a>
							<a href="#popup-user-add-video"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy active powertip" title="Видео"></a>
							<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy powertip" title="Статус"></a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="crumbs-small clearfix">
				<ul class="crumbs-small_ul">  
					<li class="crumbs-small_li">Я здесь:</li>
					<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Главная</a></li> &gt;
					<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Наш дом</a></li> &gt;
					<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Цветы в доме</a></li> &gt;
					<li class="crumbs-small_li"><span class="crumbs-small_last">Форум</span></li>
				</ul>
			</div>
			<div class="content-cols clearfix">
				<div class="col-1">
					<div class="b-user-info margin-t15 clearfix">
						<a class="ava male" href="">
							<span class="icon-status status-online"></span>
							<img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
						</a>
						<div class="b-user-info_hold">
							<a class="b-user-info_name" href="">Ангелина Богоявленская</a>
							<div class="b-user-info_date">16 июн 2013</div>
						</div>
					</div>
					<div class="title-blue">Новогодняя ночь - фото 1</div>
					<div class="">Практически нет девушки, которая не переживала бы за отношения героев "Сумерек" как в на экранах, так и в жизни. Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, что у них невероятный роман и в рельной жизни, а не только лишь на экране, все же Роберт Паттинсон и Кристен Стюарт расстались и пока решили взять паузу в своих отношениях.</div>
				</div>
				<div class="col-23-middle">
					<div class="photo-view clearfix">
						<div class="photo-view_top clearfix">
							
							<div class="meta-gray">
								<a class="meta-gray_comment" href="">
									<span class="ico-comment ico-comment__gray"></span>
									<span class="meta-gray_tx">35456</span>
								</a>
								<div class="meta-gray_view">
									<span class="ico-view ico-view__gray"></span>
									<span class="meta-gray_tx">305</span>
								</div>
							</div>
							<div class="photo-view_tx">18 из 56</div>
							<div class="photo-view_tx"><a href="">Места моих путешествий</a></div>
							
						</div>
						<div class="photo-view_c">
							<div class="photo-view_img">
								<!-- Отлавливать клик или на ссылку или на изображение (тогда ссылка не нужна) -->
								<a href="">
									<img src="/images/example/w680-h450.jpg" alt="">
								</a>
							</div>
							<a href="" class="photo-view_arrow photo-view_arrow__l"></a>
							<a href="" class="photo-view_arrow photo-view_arrow__r"></a>
							<div class="like-control clearfix">
					            <a href="" class="like-control_ico like-control_ico__like">865</a>
					            <div class="position-rel float-l">
									<a class="favorites-control_a" href="">12365</a>
									<!-- <div class="favorites-add-popup favorites-add-popup__right">
										<div class="favorites-add-popup_t">Добавить запись в избранное</div>
										<div class="favorites-add-popup_i clearfix">
											<img src="/images/example/w60-h40.jpg" alt="" class="favorites-add-popup_i-img">
											<div class="favorites-add-popup_i-hold">Неравный брак. Смертельно опасен или жизненно необходим?</div>
										</div>
										<div class="favorites-add-popup_row">
											<label for="" class="favorites-add-popup_label">Теги:</label>
											<span class="favorites-add-popup_tag">
												<a href="" class="favorites-add-popup_tag-a">отношения</a>
												<a href="" class="ico-close"></a>
											</span>
											<span class="favorites-add-popup_tag">
												<a href="" class="favorites-add-popup_tag-a">любовь</a>
												<a href="" class="ico-close"></a>
											</span>
										</div>
										<div class="favorites-add-popup_row margin-b10">
											<a class="textdec-none" href="">
												<span class="ico-plus2 margin-r5"></span>
												<span class="a-pseudo-gray color-gray">Добавить тег</span>
											</a>
										</div>
										<div class="favorites-add-popup_row">
											<label for="" class="favorites-add-popup_label">Комментарий:</label>
											<div class="float-r color-gray">0/150</div>
										</div>
										<div class="favorites-add-popup_row">
											<textarea name="" id="" cols="25" rows="2" class="favorites-add-popup_textarea" placeholder="Введите комментарий"></textarea>
										</div>
										<div class="favorites-add-popup_row textalign-c margin-t10">
											<a href="" class="btn-gray-light">Отменить</a>
											<a href="" class="btn-green">Добавить</a>
										</div>
									</div> -->
								</div>
					        </div>
						</div>
						<div class="photo-view_row clearfix">
							<a href="" class="i-more float-r">Смотреть все</a>
							<a href="" class="photo-view_fullscreen">
								<span class="photo-view_fullscreen-in">Полный размер</span>
							</a>
						</div>

						<div class="custom-likes-b">
							<div class="custom-likes-b_slogan">Поделитесь с друзьями!</div>
						
							<div class="like-block fast-like-block">
														
								<div class="box-1">
									<div class="share_button">
										<a href=""><img alt="" src="/images/share_button__odkl.png"></a>
									</div>
									<div class="share_button">
										<div class="vk_share_button">
											<a href=""><img alt="" src="/images/share_button__vk.png"></a>
										</div>
									</div>

									<div class="share_button">
										<div class="fb-custom-like">
											<a class="fb-custom-text" onclick="return Social.showFacebookPopup(this);" href="http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdev.happy-giraffe.ru%2Fuser%2F13217%2Fblog%2Fpost22589%2F">
												<i class="pluginButtonIcon img sp_like sx_like_fav"></i>Мне нравится</a>
											<div class="fb-custom-share-count">0</div>
											<script type="text/javascript">
												$.getJSON("http://graph.facebook.com", { id : document.location.href }, function(json){
													$('.fb-custom-share-count').html(json.shares || '0');
												});
											</script>
										</div>
									</div>
									
									<div class="share_button">
										<div class="tw_share_button">
											<iframe scrolling="no" frameborder="0" id="twitter-widget-0" allowtransparency="true" src="http://platform.twitter.com/widgets/tweet_button.1381275758.html#_=1381902509957&amp;count=horizontal&amp;id=twitter-widget-0&amp;lang=ru&amp;original_referer=http%3A%2F%2F109.87.248.203%2Fhtml%2Fsocial%2Fclubs%2Fclub-contest-photo_open.php&amp;size=m&amp;text=Happy%20Giraffe&amp;url=http%3A%2F%2Fdev.happy-giraffe.ru%2Fuser%2F13217%2Fblog%2Fpost22589%2F" class="twitter-share-button twitter-tweet-button twitter-count-horizontal" title="Twitter Tweet Button" data-twttr-rendered="true" style="width: 138px; height: 20px;"></iframe>
											<script charset="utf-8" type="text/javascript">
													if (typeof twttr == 'undefined')
														window.twttr = (function (d,s,id) {
															var t, js, fjs = d.getElementsByTagName(s)[0];
															if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
															js.src="//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
															return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
														}(document, "script", "twitter-wjs"));
											</script>
										</div>
									</div>
															
								</div>
							
							</div>
						</div>
							
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
				</div>
			</div>
		</div>
		



    </div>
		
    <div class="footer-push"></div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

</body>
</html>
