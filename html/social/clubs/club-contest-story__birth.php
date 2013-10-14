<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	
</head>
<body class="body-gray theme-contest theme-contest__birth1 body-guest">

<div class="layout-container">
	<div class="layout-wrapper">
		<div class="layout-header layout-header__nologin clearfix">
			<div class="content-cols clearfix">
				<div class="col-1">
					<h1 class="logo">
						<a href="/" class="logo_i" title="Веселый жираф - сайт для все семьи">Веселый жираф - сайт для все семьи</a>
						<strong class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</strong>
					</h1>
					<div class="sidebar-search clearfix">
						<input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx" id="" name="">
						<!-- 
						В начале ввода текста, скрыть sidebar-search_btn добавить класс active"
						 -->
						<button class="sidebar-search_btn"></button>
					</div>
				</div>
				<div class="col-23">
					<div class="b-join clearfix">
						<div class="b-join_left">
							<div class="b-join_tx"> Более <span class="b-join_tx-big"> 20 000 000</span> мам и пап</div>
							<div class="b-join_slogan">уже посетили Веселый Жираф!</div>
						</div>
						<div class="b-join_right">
							<a href="" class="btn-green btn-big">Присоединяйтесь!</a>
							<div class="clearfix">
								<a href="" class="display-ib verticalalign-m">Войти</a>
								<span class="i-or">или</span>
								<ul class="display-ib verticalalign-m">
									<li class="display-ib">
										<a class="custom-like" href="">
											<span class="custom-like_icon odnoklassniki"></span>
										</a>
									</li>
									<li class="display-ib">
										<a class="custom-like" href="">
											<span class="custom-like_icon vkontakte"></span>
										</a>
									</li>
									<li class="display-ib">
										<a class="custom-like" href="">
											<span class="custom-like_icon facebook"></span>
										</a>
									</li>
									<li class="display-ib">
										<a class="custom-like" href="">
											<span class="custom-like_icon twitter"></span>
										</a>
									</li>
								</ul>
								
							
								
							
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
			$(window).load(function() {
				/*
				block - элемент, что фиксируется
				elementStop - до какого элемента фиксируется
				blockIndent - отступ
				*/
				function bJoinRowFixed() {

					var block = $('.js-b-join-row');
					var blockTop = block.offset().top;

					var startTop = $('.layout-header').height();
					

					$(window).scroll(function() {
				        var windowScrollTop = $(window).scrollTop();
				        if (windowScrollTop > startTop) {
				        	block.fadeIn();
				        } else {

							block.fadeOut();

				        }
				    });
				}

				bJoinRowFixed('.js-b-join-row');
			})
			</script>
			<div class="b-join-row js-b-join-row">
				<div class="b-join-row_hold">
					<div class="b-join-row_logo"></div>
					<div class="b-join-row_tx">Более <span class="b-join-row_tx-big"> 20 000 000</span> мам и пап</div>
					<div class="b-join-row_slogan">уже посетили Веселый Жираф!</div>
					<a href="" class="btn-green btn-h46">Присоединяйтесь!</a>
				</div>
			</div>


		</div>
		
		<div class="layout-content clearfix">

		<div class="b-club-back clearfix">
			<div class="b-club-back_ico">
				<img src="/images/club/2-w40.png" alt="">
			</div>
			<div class="b-club-back_i">
				<a href="" class="b-club-back_a">В клуб Беременность и роды</a>
			</div>
		</div>
		
		<div class="b-section">
			<div class="b-section_hold">
				<div class="content-cols clearfix">
					<div class="col-1">
						<div class="textalign-c">
							<img src="/images/contest/club/birth1/big.png" alt="">
						</div>
					</div>
					<div class="col-23-middle">
						<div class="b-section_contest">
							<div class="b-section_t-contest clearfix">
								<span class="b-section_t-contest-small">Конкурс</span>
								Рассказ о родах
							</div>
							<div class="b-section_contest-tx clearfix">
								<p>Поделитесь с нами небольшим рассказом и фотосюжетом о вашем любимчике в семье. И его увидят все ваши друзья и знакомые, выскажут свои мнения о его воспитании, кормлении и поделятся с вами своими рассказами.</p>
							</div>
							<div class="clearfix">
								<a href="#popup-contest-rule" class="b-section_contest-rule fancy">Правила конкурса</a>
								<a href="#popup-contest" class="float-r btn-green btn-h46 fancy">Принять участие!</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="content-cols clearfix">
			<div class="col-1">
			
				<div class="readers2 margin-t0">
					<div class="clearfix">
						<div class="heading-small textalign-c margin-b10">Участники <span class="color-gray">(156)</span> </div>
					</div>
					<ul class="readers2_ul clearfix">
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava female small" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
							</a>
						</li>
						<li class="readers2_li clearfix">
							<a class="ava male small" href="">
								<span class="icon-status status-online"></span>
							</a>
						</li>
					</ul>
					<a class="btn-green btn-medium readers2_btn-inline" href="">Принять участие!</a>
				</div>
							
				<div class="contest-aside-prizes">
					<div class="contest-aside-prizes_t">Призы конкурса</div>
					<a href="" class="contest-aside-prizes_sponsor">
						<img src="/images/contest/club/birth1/aside-sponsor-logo.png" alt="">
					</a>
					<ul class="contest-aside-prizes_ul">
						<li class="contest-aside-prizes_li">
							<div class="contest-aside-prizes_img">
								<a href="#popup-contest-prize" class="fancy"><img src="/images/contest/club/birth1/prize-1.png" alt=""></a>
							</div>
							<div class="place place-1-1"></div>
							<div class="contest-aside-prizes_name">
								Детский автомобиль<br>
								<strong>Neo Trike Mini Porshe</strong>
							</div>
							<a href="#popup-contest-prize" class="contest-aside-prizes_more fancy">Подробнее</a>
						</li>
						<li class="contest-aside-prizes_li">
							<div class="contest-aside-prizes_img">
								<a href="#popup-contest-prize" class="fancy"><img src="/images/contest/club/birth1/prize-2.png" alt=""></a>
							</div>
							<div class="place place-2"></div>
							<div class="contest-aside-prizes_name">
								Развивающая игрушка<br>
								<strong>Обучающий глобус VTech</strong>
							</div>
							<a href="#popup-contest-prize" class="contest-aside-prizes_more fancy">Подробнее</a>
						</li>
						<li class="contest-aside-prizes_li">
							<div class="contest-aside-prizes_img">
								<a href="#popup-contest-prize" class="fancy"><img src="/images/contest/club/birth1/prize-3.png" alt=""></a>
							</div>
							<div class="place place-3"></div>
							<div class="contest-aside-prizes_name">
								Развивающая игрушка<br>
								<strong>Веселый автомобиль VTech</strong>
							</div>
							<a href="#popup-contest-prize" class="contest-aside-prizes_more fancy">Подробнее</a>
						</li>
					</ul>
				</div>


				<div class="fast-articles2 js-fast-articles2">
					<div class="fast-articles2_t-ico"></div>
					<div class="fast-articles2_t">Тройка лидеров</div>

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
							<span class="fast-articles2_i-t-count">456</span>
						</div>
						<div class="fast-articles2_i-desc">Практически нет девушки, которая не переживала я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных. </div>
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
							<span class="fast-articles2_i-t-count">456</span>
						</div>
						<div class="fast-articles2_i-desc">Практически нет девушки, которая не переживала </div>
						<div class="fast-articles2_i-img-hold">
							<a href=""><img src="/images/example/w190-h166.jpg" alt="" class="fast-articles2_i-img"></a>
						</div>
					</div>
				</div>
				
				
			</div>
			<div class="col-23-middle ">
				<div class="col-gray">
					
					<div class="clearfix">
						<div class="float-r margin-t20 margin-r20">
							<div class="chzn-itx-simple chzn-itx-simple__small">
								<select name="" id="" class="chzn">
									<!-- список option не точный -->
									<option value="">По дате добавления</option>
									<option value="">По количеству голосов</option>
								</select>
							</div>
							
						</div>
					</div>
					<div class="b-article clearfix">
						<div class="float-l">
							<div class="like-control like-control__small-indent clearfix">
								<a href="" class="ava male">
									<span class="icon-status status-online"></span>
									<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
								</a>
							</div>
							<div class="like-control clearfix">
								<a href="" class="like-control_ico like-control_ico__like">865</a>
								<div class="position-rel">
									<a href="" class="like-control_ico like-control_ico__repost">5</a>
								</div>
								<div class="position-rel">
									<a href="" class="favorites-control_a active">123865</a>
									
								</div>
							</div>
							<div class="contest-meter">
								<div class="contest-meter_count">
									<div class="contest-meter_count-num">356</div>
									<div class="contest-meter_count-tx">баллов</div>
								</div>
								<a href="" class="contest-meter_a-vote">Голосовать</a>
								<div class="contest-meter_vote">
									<div class="contest-meter_vote-tx">Вы можете проголосовать за участника нажав на кнопки соцсетей</div>
									<div class="contest-meter_vote-hold">
										<div class="like-block fast-like-block">
														
											<div class="box-1">
												<div class="share_button">
													<div class="fb-custom-like">
														<a href="http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdev.happy-giraffe.ru%2Fuser%2F13217%2Fblog%2Fpost22589%2F"
														   onclick="return Social.showFacebookPopup(this);" class="fb-custom-text">
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
													<div class="vk_share_button"></div>
												</div>
												
												<div class="share_button">
													<a class="odkl-klass-oc"
													   href="http://dev.happy-giraffe.ru/user/13217/blog/post22589/"
													   onclick="Social.updateLikesCount('ok'); ODKL.Share(this);return false;"><span>0</span></a>
												</div>
												
												<div class="share_button">
													<div class="tw_share_button">
														<a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru" data-url="http://dev.happy-giraffe.ru/user/13217/blog/post22589/">Твитнуть</a>
														<script type="text/javascript" charset="utf-8">
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
							<h2 class="b-article_t">
								<a href="" class="b-article_t-a">Самое лучшее утро - просыпаюсь, а ты рядом</a>
							</h2>
							<div class="b-article_in clearfix">
								<div class="wysiwyg-content clearfix">
									<p>	Недавно посмотрел фильм "Убить Дракона" снятый в 1988 году с Абдуловым в главной роли. По мотивам пьесы Евгения Шварца «Дракон».</p>
									<div class="b-article_in-img">
										<a href="">
											<img alt="" src="http://img.dev.happy-giraffe.ru/thumbs/580x/16534/f464362269821285b5b2aa67855267da.jpeg">
										</a>
									</div>
								</div>
							</div>
							<div class="textalign-r">					
								<a href="" class="b-article_more">Смотреть далее</a>
							</div>
							
							<div class="comments-gray">
								<div class="comments-gray_t">
									<a href="" class="comments-gray_t-a">
										<span class="comments-gray_t-a-tx">Все комментарии (28)</span>
									</a>
								</div>
								<div class="comments-gray_hold">
									<div class="comments-gray_i comments-gray_i__self">
										<div class="comments-gray_ava">
											<a href="" class="ava small male"></a>
										</div>
										<div class="comments-gray_frame">
											<div class="comments-gray_header clearfix">
												<a href="" class="comments-gray_author">Ангелина Богоявленская </a>
												<span class="font-smallest color-gray">Сегодня 13:25</span>
											</div>
											<div class="comments-gray_cont wysiwyg-content">
												<p>	<a href="">Вася Пупкин,</a> Мне безумно жалко всех женщин, но особенно Тину Кароль, я просто представить себе не могу <a href="">как она все это переживет</a> как она все это переживет(</p>
												<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
											</div>
										</div>
										<div class="comments-gray_control comments-gray_control__self">
											<div class="comments-gray_control-hold">
												<div class="clearfix">
													<a href="" class="message-ico message-ico__edit powertip" title="Редактировать"></a>
												</div>
												<div class="clearfix">
													<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
												</div>
											</div>
										</div>
									</div>
									<div class="comments-gray_i">
										<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">7918</a>
										<div class="comments-gray_ava">
											<a href="" class="ava small female"></a>
										</div>
										<div class="comments-gray_frame">
											<div class="comments-gray_header clearfix">
												<a href="" class="comments-gray_author">Анг Богоявлен </a>
												<span class="font-smallest color-gray">Сегодня 14:25</span>
											</div>
											<div class="comments-gray_cont wysiwyg-content">
												<p>я не нашел, где можно поменять <img src="/images/widget/smiles/beach.gif"> название трека. </p>
											</div>
										</div>
										
										<div class="comments-gray_control">
											<div class="comments-gray_control-hold">
												<div class="clearfix">
													<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
												</div>
												<div class="clearfix">
													<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
												</div>
											</div>
											<div class="clearfix">
												<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
											</div>
										</div>
									</div>
									
									<div class="comments-gray_i">
										<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
										<div class="comments-gray_ava">
											<a href="" class="ava small female"></a>
										</div>
										<div class="comments-gray_frame">
											<div class="comments-gray_header clearfix">
												<a href="" class="comments-gray_author">Анг Богоявлен </a>
												<span class="font-smallest color-gray">Сегодня 14:25</span>
											</div>
											<div class="comments-gray_cont wysiwyg-content">
												<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту </p>
												<p>
													<a href="" class="comments-gray_cont-img-w">
														<!--    max-width: 170px;  max-height: 110px; -->
														<img src="/images/example/w170-h110.jpg" alt="">
													</a>
													<a href="" class="comments-gray_cont-img-w">
														<img src="/images/example/w220-h309-1.jpg" alt="">
													</a>
													<a href="" class="comments-gray_cont-img-w">
														<img src="/images/example/w200-h133-1.jpg" alt="">
													</a>
												</p>
												<p>и подцепляет естественно студийные версии песен <img src="/images/widget/smiles/l_moto.gif"> вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
											</div>
										</div>
										
										<div class="comments-gray_control">
											<div class="comments-gray_control-hold">
												<div class="clearfix">
													<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
												</div>
											</div>
											<div class="clearfix">
												<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
											</div>
										</div>
									</div>
								</div>
								<div class="comments-gray_add clearfix">
									
									<div class="comments-gray_ava">
										<a href="" class="ava small female"></a>
									</div>
									
									<div class="comments-gray_frame">
										<input type="text" name="" id="" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий">
										
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="b-article clearfix">
						<div class="float-l">
							<div class="like-control like-control__small-indent clearfix">
								<a href="" class="ava male">
									<span class="icon-status status-online"></span>
									<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
								</a>
							</div>
							<div class="like-control clearfix">
								<a href="" class="like-control_ico like-control_ico__like">865</a>
								<div class="position-rel">
									<a href="" class="like-control_ico like-control_ico__repost">5</a>
								</div>
								<div class="position-rel">
									<a href="" class="favorites-control_a active">123865</a>
									
								</div>
							</div>
							<div class="contest-meter">
								<div class="contest-meter_count">
									<div class="contest-meter_count-num">356</div>
									<div class="contest-meter_count-tx">баллов</div>
								</div>
								<a href="" class="contest-meter_a-vote">Голосовать</a>
								<div class="contest-meter_vote display-b">
									<div class="contest-meter_vote-tx">Вы можете проголосовать за участника нажав на кнопки соцсетей</div>
									<div class="contest-meter_vote-hold">
										<div class="like-block fast-like-block">
														
											<div class="box-1">
												<div class="share_button">
													<div class="fb-custom-like">
														<a href="http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdev.happy-giraffe.ru%2Fuser%2F13217%2Fblog%2Fpost22589%2F"
														   onclick="return Social.showFacebookPopup(this);" class="fb-custom-text">
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
													<div class="vk_share_button"></div>
												</div>
												
												<div class="share_button">
													<a class="odkl-klass-oc"
													   href="http://dev.happy-giraffe.ru/user/13217/blog/post22589/"
													   onclick="Social.updateLikesCount('ok'); ODKL.Share(this);return false;"><span>0</span></a>
												</div>
												
												<div class="share_button">
													<div class="tw_share_button">
														<a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru" data-url="http://dev.happy-giraffe.ru/user/13217/blog/post22589/">Твитнуть</a>
														<script type="text/javascript" charset="utf-8">
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
							<h2 class="b-article_t">
								<a href="" class="b-article_t-a">Самое лучшее утро - просыпаюсь, а ты рядом</a>
							</h2>
							<div class="b-article_in clearfix">
								<div class="wysiwyg-content clearfix">
									<p>	Недавно посмотрел фильм "Убить Дракона" снятый в 1988 году с Абдуловым в главной роли. По мотивам пьесы Евгения Шварца «Дракон».</p>
									<div class="b-article_in-img">
										<a href="">
											<img alt="" src="http://img.dev.happy-giraffe.ru/thumbs/580x/16534/f464362269821285b5b2aa67855267da.jpeg">
										</a>
									</div>
								</div>
							</div>
							<div class="textalign-r">					
								<a href="" class="b-article_more">Смотреть далее</a>
							</div>
							
							<div class="comments-gray">
								<div class="comments-gray_t">
									<a href="" class="comments-gray_t-a">
										<span class="comments-gray_t-a-tx">Все комментарии (28)</span>
									</a>
								</div>
								<div class="comments-gray_hold">
									<div class="comments-gray_i comments-gray_i__self">
										<div class="comments-gray_ava">
											<a href="" class="ava small male"></a>
										</div>
										<div class="comments-gray_frame">
											<div class="comments-gray_header clearfix">
												<a href="" class="comments-gray_author">Ангелина Богоявленская </a>
												<span class="font-smallest color-gray">Сегодня 13:25</span>
											</div>
											<div class="comments-gray_cont wysiwyg-content">
												<p>	<a href="">Вася Пупкин,</a> Мне безумно жалко всех женщин, но особенно Тину Кароль, я просто представить себе не могу <a href="">как она все это переживет</a> как она все это переживет(</p>
												<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
											</div>
										</div>
										<div class="comments-gray_control comments-gray_control__self">
											<div class="comments-gray_control-hold">
												<div class="clearfix">
													<a href="" class="message-ico message-ico__edit powertip" title="Редактировать"></a>
												</div>
												<div class="clearfix">
													<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
												</div>
											</div>
										</div>
									</div>
									<div class="comments-gray_i">
										<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">7918</a>
										<div class="comments-gray_ava">
											<a href="" class="ava small female"></a>
										</div>
										<div class="comments-gray_frame">
											<div class="comments-gray_header clearfix">
												<a href="" class="comments-gray_author">Анг Богоявлен </a>
												<span class="font-smallest color-gray">Сегодня 14:25</span>
											</div>
											<div class="comments-gray_cont wysiwyg-content">
												<p>я не нашел, где можно поменять <img src="/images/widget/smiles/beach.gif"> название трека. </p>
											</div>
										</div>
										
										<div class="comments-gray_control">
											<div class="comments-gray_control-hold">
												<div class="clearfix">
													<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
												</div>
												<div class="clearfix">
													<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
												</div>
											</div>
											<div class="clearfix">
												<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
											</div>
										</div>
									</div>
									
									<div class="comments-gray_i">
										<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
										<div class="comments-gray_ava">
											<a href="" class="ava small female"></a>
										</div>
										<div class="comments-gray_frame">
											<div class="comments-gray_header clearfix">
												<a href="" class="comments-gray_author">Анг Богоявлен </a>
												<span class="font-smallest color-gray">Сегодня 14:25</span>
											</div>
											<div class="comments-gray_cont wysiwyg-content">
												<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту </p>
												<p>
													<a href="" class="comments-gray_cont-img-w">
														<!--    max-width: 170px;  max-height: 110px; -->
														<img src="/images/example/w170-h110.jpg" alt="">
													</a>
													<a href="" class="comments-gray_cont-img-w">
														<img src="/images/example/w220-h309-1.jpg" alt="">
													</a>
													<a href="" class="comments-gray_cont-img-w">
														<img src="/images/example/w200-h133-1.jpg" alt="">
													</a>
												</p>
												<p>и подцепляет естественно студийные версии песен <img src="/images/widget/smiles/l_moto.gif"> вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
											</div>
										</div>
										
										<div class="comments-gray_control">
											<div class="comments-gray_control-hold">
												<div class="clearfix">
													<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
												</div>
											</div>
											<div class="clearfix">
												<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
											</div>
										</div>
									</div>
								</div>
								<div class="comments-gray_add clearfix">
									
									<div class="comments-gray_ava">
										<a href="" class="ava small female"></a>
									</div>
									
									<div class="comments-gray_frame">
										<input type="text" name="" id="" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий">
										
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="yiipagination margin-l100">
					    <div class="pager">
					        <ul class="yiiPager" id="yw1">
					            <li class="page"><a href="">1</a></li>
					            <li class="page"><a href="">2</a></li>
					            <li class="page selected"><a href="">3</a></li>
					            <li class="page"><a href="">4</a></li>
					            <li class="page"><a href="">5</a></li>
					            <li class="page"><a href="">6</a></li>
					            <li class="page"><a href="">7</a></li>
					            <li class="page"><a href="">8</a></li>
					            <li class="page"><a href="">9</a></li>
					            <li class="page"><a href="">10</a></li>
					        </ul>
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

	<!-- Задний фон  -->
	<div class="cover cover-contest cover-contest__birth1">
		
	</div>
</div>

<div class="display-n">
		
	<!-- popup-contest -->
	<div id="popup-contest" class="popup-contest popup-contest__birth1">
		<a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-720 float-r">

				<div class="b-settings-blue">
					<div class="b-settings-blue_head">
						<div class="b-settings-blue_row clearfix">
							<div class="clearfix margin-t-10 ">
								<div class="float-r font-small color-gray margin-3">0/50</div>
							</div>
							<label for="" class="b-settings-blue_label">Заголовок</label>
							<div class="b-settings-blue_row-tx">
								<input type="text" name="" id="" class="itx-simple w-100p" placeholder="Введите заголовок фото">
							</div>
						</div>
					
					
						<div class="wysiwyg-v wysiwyg-pink clearfix">
							<label for="" class="b-settings-blue_label">Рассказ</label>
	<script src="/redactor/plugins/toolbarVerticalFixed/toolbarVerticalFixed.js"></script>	
							<script>
	$(document).ready(function () { 
	  $('.wysiwyg-redactor-v').redactor({
	      plugins: ['toolbarVerticalFixed'],
	      minHeight: 410,
	      autoresize: true,
	      toolbarExternal: '.wysiwyg-toolbar-btn',

	      /* В базовом варианте нет кнопок 'h2', 'h3', 'link_add', 'link_del' но их функции реализованы с помощью выпадающих списков */
	      buttons: ['bold', 'italic', 'underline', 'deleted', 'h2', 'h3', 'unorderedlist', 'orderedlist', 'link_add', 'link_del', 'image', 'video', 'smile'],
	      buttonsCustom: {
	          smile: {
	              title: 'smile',
	              callback: function(buttonName, buttonDOM, buttonObject) {
	                  // your code, for example - getting code
	                  var html = this.get();
	              }
	          },
	          link_add: {
	              title: 'link_add',
	              callback: function(buttonName, buttonDOM, buttonObject) {
	                  // your code, for example - getting code
	                  var html = this.get();
	              }
	          },
	          link_del: {
	              title: 'link_del',
	              callback: function(buttonName, buttonDOM, buttonObject) {
	                  // your code, for example - getting code
	                  var html = this.get();
	              }
	          },
	          h2: {
	              title: 'h2',
	              callback: function(buttonName, buttonDOM, buttonObject) {
	                  // your code, for example - getting code
	                  var html = this.get();
	              }
	          },
	          h3: {
	              title: 'h3',
	              callback: function(buttonName, buttonDOM, buttonObject) {
	                  // your code, for example - getting code
	                  var html = this.get();
	              }
	          }
	      }
	  });
	});
							</script>
						<div class="wysiwyg-toolbar">
							<div class="wysiwyg-toolbar-btn"></div>
							<div class="redactor-popup redactor-popup_b-photo display-n" >
								<a href="" class="redactor-popup_close ico-close3 powertip" title="Закрыть"></a>
								<div class="redactor-popup_tale"></div>
								<div class="redactor-popup_t">Загрузите фото</div>
								<div class="b-add-img b-add-img__single">
									<div class="b-add-img_hold">
										<div class="b-add-img_t">
											Загрузите фотографии с компьютера
											<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
										</div>
										<div class="file-fake">
											<button class="btn-green btn-medium file-fake_btn btn-inactive">Обзор</button>
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
								<div class="textalign-c margin-t15">
									<a href="" class="btn-gray-light btn-medium margin-r10">Отменить</a>
									<a href="" class="btn-green btn-medium">Добавить видео</a>
								</div>
							</div>
							
							
							<div class="redactor-popup redactor-popup_b-video display-n" >
								<a href="" class="redactor-popup_close ico-close3 powertip" title="Закрыть"></a>
								<div class="redactor-popup_tale"></div>
								<div class="redactor-popup_t">Загрузите видео</div>
								<div class="redactor-popup_add-video active">
									<div class="redactor-popup_add-video-hold">
										<!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования -->
										<input type="text" name="" id="" class="itx-simple w-350 float-l" placeholder="Введите ссылку на видео">
										<button class="btn-green btn-medium btn-inactive">Загрузить  видео</button>
									</div>
									<div class="redactor-popup_add-video-error">
										Не удалось загрузить видео. <br>
										Возможно, URL указан неправильно либо ведет на неподдерживаемый сайт.
									</div>
								</div>
								<div class="textalign-c margin-t15">
									<a href="" class="btn-gray-light btn-medium margin-r10">Отменить</a>
									<a href="" class="btn-green btn-medium btn-inactive">Добавить видео</a>
								</div>
							</div>
							
							<div class="redactor-popup redactor-popup_b-smile display-n">
								<a href="" class="redactor-popup_close ico-close3 powertip" title="Закрыть"></a>
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
							
							<div class="redactor-popup redactor-popup_b-link">
									<a href="" class="redactor-popup_close ico-close3 powertip" title="Закрыть"></a>
									<div class="redactor-popup_tale"></div>
									<div class="redactor-popup_t">Ссылка</div>
									
									<div class="redactor-popup_holder-blue">
										<div class="margin-b10 clearfix">
											<label class="redactor-popup_label" for="">Отображаемый текст</label>
											<div class="float-l w-350">
												<input type="text" placeholder="Введите текст" class="itx-simple" id="" name="" value="Выделенный текст">
											</div>
										</div>
										<div class="clearfix">
											<label class="redactor-popup_label" for="">Ссылка на</label>
											<div class="float-l w-350 error">
												<input type="text" placeholder="Введите URL страницы" class="itx-simple" id="" name="">
												<div class="errorMessage">Необходимо заполнить поле URL страницы.</div>
											</div>
										</div>
									</div>
									
									<div class="textalign-c margin-t15">
										<a href="" class="btn-gray-light btn-medium margin-r10">Отменить</a>
										<a href="" class="btn-green btn-medium">Добавить ссылку</a>
									</div>
								</div>
						</div>
							<textarea name="" class="wysiwyg-redactor-v" placeholder="Расскажите о своих родах"></textarea>
						</div>
					
					</div>
					
					
					<div class=" clearfix">
						<a href="" class="btn-blue btn-h46 float-r">Добавить</a>
						<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
						
						<div class="float-l margin-t15 margin-l90">
							<a href="" class="a-checkbox active"></a>
							<span class="color-gray">Я ознакомлен с</span> <a href="">Правилами конкурса</a>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- /popup-contest -->

	<!-- popup-contest -->
	<div id="popup-contest-rule" class="popup-contest popup-contest__birth1">
		<a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-720 float-r">

				<div class="b-settings-blue">
					
					<div class="contest-rule">
						<div class="heading-title">Правила конкурса</div>
						<ol>
							<li>Принимай участие в фотоконкурсе «Рассказ о родах».</li>
							<li>С 15 сентября по 31 октября 2013 года разместите свою фотографию на тему «Как я провел лето» на промо-сайте leto.bystrobank.ru. Напишите поясняющий комментарий — как БыстроБанк помог Вам этим летом.</li>
							<li>От одного участника допускается размещение не более 5 фотографий.</li>
							<li>За размещенные фотографии с 15 сентября по 14 ноября 2013 года будет организовано голосование посетителей сайта.</li>
							<li>За одно фото посетитель может проголосовать только 1 раз.</li>
							<li>Вы можете приглашать к голосованию своих друзей и знакомых.</li>
							<li>Авторы 8 фотографий, набравших наибольшее количество голосов, получат призы фотоконкурса. Авторы фотографий, занявшие места с 1-го по 8-ое будут награждены мультиварками либо автомобильными регистраторами. Один участник конкурса сможет получить только один приз.</li>
							<li>Для участия в конкурсе необходимо быть действующим клиентом БыстроБанка или клиентом, имевшим действующий договор с банком в течение 2012–2013 гг. Каждый участник должен указать ФИО, город, дату рождения и номер телефона.</li>
							<li>Проведение итогов голосования и публикация на сайте Банка www.bystrobank.ru списка победителей будет 15 ноября 2013 года. В течении 10 дней после публикации сотрудник Банка свяжется с победителями по телефону и пригласит в Банк для вручения приза.</li>
						</ol>
						<div class="textalign-c clearfix">
							<a href="" class="btn-green btn-h46">Принять участие!</a>
						</div>
					</div>
					
				</div>

			</div>
		</div>
	</div>
	<!-- /popup-contest -->

	<!-- popup-contest -->
	<div id="popup-contest-prize" class="popup-contest popup-contest__birth1">
		<a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">

				<div class="b-settings-blue">
					
					<div class="contest-prizes">
						<div class="heading-title">Призы конкурса</div>
						<div class="contest-prizes_i clearfix">
							<div class="contest-prizes_l">
								<div class="contest-prizes_img">
									<img src="/images/contest/club/birth1/prize-1-big.jpg" alt="">
								</div>
								<div class="place place-1-1"></div>
							</div>
							<div class="contest-prizes_r">
								<div class="contest-prizes_i-top">
									<span class="contest-prizes_heart"></span>
									<span class="contest-prizes_i-t">Детский электромобиль <strong>NeoTrike Mini Porsche</strong> </span>
								</div>
								<div class="contest-prizes_desc">
									<p>NeoTrike Mini Porsche - стильный белый Порше, новая модель 2013 года. Автомашину NeoTrike Mini Порше можно использовать и как электромобиль, а также в виде игрушки-каталки, при этом кроха будет катить ее впереди себя. Еще один вариант использования машинки - залезть верхом, оттолкнуться от плоскости ногами и вперед! Резиновые накладки колес машинки не только сделают езду тихой и бесшумной, но и защитят покрытие пола от механических царапин, если вы будете кататься прямо дома.</p>
									<p>Этот подарок станет незаменимой игрушкой для вашего ребенка! </p>
									<p>
										<span class="contest-color">Подробнее: </span> 
										<a href="http://www.neopod.ru/products/neotrike_mini_porsche_white/">www.neopod.ru/products/neotrike_mini_porsche_white/</a>
									</p>
								</div>
							</div>
						</div>

						<div class="contest-prizes_i clearfix">
							<div class="contest-prizes_l">
								<div class="contest-prizes_img">
									<img src="/images/contest/club/birth1/prize-2-big.jpg" alt="">
								</div>
								<div class="place place-2"></div>
							</div>
							<div class="contest-prizes_r">
								<div class="contest-prizes_i-top">
									<span class="contest-prizes_heart"></span>
									<span class="contest-prizes_i-t">Развивающая игрушка <strong>Обучающий глобус VTech </strong> </span>
								</div>
								<div class="contest-prizes_desc">
									<p>Развивающий глобус от Vtech может помочь молодым исследователям и искателям приключений, не выходя из жилищу, осуществить кругосветное странствие. Занятный самолёт, джойстик и лупа будут его ассистентами в этом странствии. Ребенок сумеет узреть новые города и державы, он познакомится с традициями различных народов и выяснит о нашем мире большое количество нового и увлекательного.</p>
									<p>5 обучающих программ познакомят молодого странника с океанами, континентами, народами различных государств и наиболее знаменитыми достопримечательностями. Режим вопросов может помочь малышу укрепить познания. </p>
									<p>Этот подарок станет незаменимой игрушкой для вашего ребенка! </p>
									<p>
										<span class="contest-color">Подробнее: </span>
										<a href="http://www.neopod.ru/products/vtech_globus/">wwww.neopod.ru/products/vtech_globus/</a>
									</p>
								</div>
							</div>
						</div>

						<div class="contest-prizes_i clearfix">
							<div class="contest-prizes_l">
								<div class="contest-prizes_img">
									<img src="/images/contest/club/birth1/prize-3-big.jpg" alt="">
								</div>
								<div class="place place-3"></div>
							</div>
							<div class="contest-prizes_r">
								<div class="contest-prizes_i-top">
									<span class="contest-prizes_heart"></span>
									<span class="contest-prizes_i-t">Развивающая игрушка <strong>Веселый автомобиль VTech </strong> </span>
								</div>
								<div class="contest-prizes_desc">
									<p>С помощью двух обучающих программ эта яркая интерактивная игрушка "Веселый автомобиль" проведет Вашего ребенка в увлекательный мир знаний. Она научит малыша различать цвета и геометрические фигуры, познакомит с цифрами и правилами дорожного движения. Обучение не будет скучным: игрушка умеет проигрывать забавные мелодии, издавать веселые звуки и даже мигать фарами. Кроме того, яркие клавиши и геометрический сортер привлекут внимание и вызывут интерес у ребенка. Также эту машинку легко взять с собой в дорогу или на прогулку - ее можно везти за собой при помощи шнурка для катания. </p>
									<p>Этот подарок станет незаменимой игрушкой для вашего ребенка! </p>
									<p>
										<span class="contest-color">Подробнее: </span> 
										<a href="http://www.neopod.ru/products/avtomob_umka_katalka/">wwww.neopod.ru/products/avtomob_umka_katalka/</a>
									</p>
								</div>
							</div>
						</div>

						<div class="contest-prizes_sponsor-tx">
							<p><a href="" class="display-ib verticalalign-m"><img src="/images/contest/club/birth1/sponsor-logo.png" alt=""></a> - детский интернет-магазин c широким ассортиментом игрушек и товаров для детей от 0 до 9 лет.</p>
							<p><strong class="contest-color">Neopod</strong> работает напрямую с производителями и за счет постоянного наличия товаров обеспечивает очень быструю доставку и отличные цены.Все товары сертифицированы и тщательно отбираются по качеству и безопасности.Развивающие игрушки, детские ноутбуки, куклы, конструкторы из экологически чистых материалов, детский транспорт, одежда и средства гигиены для малышей, лучшие европейские производители. <br>
							<b class="contest-color">Все игрушки и товары для детей – в одном магазине!</b> <br>
							<b class="contest-color">Наши преимущества:</b> надежная репутация, качественные игрушки, выгодные условия для покупки, удобный выбор товара, быстрая доставка.</p>
							<p>
								<span class="contest-color">Подробнее: </span>
								<a href="http://www.neopod.ru/">www.neopod.ru/</a>
							</p>
						</div>

						<div class="contest-prizes_bottom clearfix">
							<div class="contest-prizes_bottom-tx clearfix">
								<span class="ico-giraffe-r"></span>
								<span class="">
									Будьте активны! Ваш рассказ будет лучшим.
								</span>
							</div>
							<a href="" class="btn-green btn-h46">Принять участие!</a>
						</div>
					</div>
					
				</div>

		</div>
	</div>
	<!-- /popup-contest -->
	
	
</div>
</body>
</html>