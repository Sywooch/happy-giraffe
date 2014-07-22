<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>



<script>
/* Height block comment scroll in photo-window */
function photoWindColH () {
	var colCont = $(".photo-window_cont");
	var bannerH = document.getElementById('photo-window_banner').offsetHeight;
	colCont.height($(window).height() - bannerH - 24);

}

/* Позиция блока с лайками */
function likePos () {
	var likeBottom = ($('.photo-window_img-hold').height() - $('.photo-window_img').height()) / 2 + 30;
	$('.photo-window .like-control').css({'bottom' : likeBottom});
}

$(document).ready(function () {
	photoWindColH();
	likePos();

  /* custom scroll */
  var scroll = $('.scroll').baron({
    scroller: '.scroll_scroller',
    barOnCls: 'scroll__on',
    container: '.scroll_cont',
    track: '.scroll_bar-hold',
    bar: '.scroll_bar'
  });

});
$(window).resize(function () {
	photoWindColH();
	likePos();
});

</script>
</head>
<body class="body-club" style="overflow:hidden;">

	<div class="layout-container">
		<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/layout-header.php'; ?>
			
			<div id="content" class="clearfix">
				.content
			</div>  	
			
		
		<div class="footer-push"></div>
		
		</div>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
	</div>
	
<div class="photo-window">
<div class="photo-window_w">
	<a href="" class="photo-window_close"></a>
	
	<div class="photo-window_top">
		<div class="photo-window_count">25 из 52</div>

	</div>
	<!-- Обрабатывать клик на .photo-window_c для листания следующего изображения -->
	<div class="photo-window_c">
		<div class="photo-window_img-hold">
			<img src="/images/example/photo-window-2.jpg" alt="" class="photo-window_img">
			<div class="verticalalign-m-help"></div>
		</div>
		<a href="#photo-window-end" class="photo-window_arrow photo-window_arrow__l fancy" data-theme="white-simple"></a>
		<a href="#photo-window-end" class="photo-window_arrow photo-window_arrow__r fancy" data-theme="white-simple"></a>
		
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
	


	<div class="photo-window_col">
	
	<div class="photo-window_col-hold scroll">
		<div class="scroll_scroller  photo-window_cont">
			<div class="scroll_cont">
				<div class="photo-window_cont-t clearfix">
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
					<div class="b-user-info b-user-info__middle float-l">
						<a href="" class="ava middle female"></a>
						<div class="b-user-info_hold">
							<a href="" class="b-user-info_name">Ангелина Богоявленская</a>
							<div class="b-user-info_date">16 июн 2013</div>
						</div>
					</div>

				</div>
				<div class="photo-window_about"> Фотопост <a href="">Места моих путешествий</a> </div>
				<div class="photo-window_t">Детский лагерь «Зеркальный». Ленинградская область. <a class="ico-edit powertip" href=""></a></div>


				<div class="photo-window_desc-hold">
					<div class="photo-window_desc clearfix display-n">
						<p>В круглогодичном лечебно-развлекательном лагере «Зеркальный» ежедневно проводятся разнообразные мероприятия и программы - тематические, творческие и интеллектуальные конкурсы, концерты, викторины, активные и спокойные игры, спокойные игры  В круглогодичном лечебно-развлекательном лагере «Зеркальный» ежедневно проводятся разнообразные мероприятия и программы - тематические, творческие и интеллектуальные конкурсы, концерты, викторины, активные и спокойные игры, эстафеты, соревнования В круглогодичном лечебно-развлекательном лагере «Зеркальный» ежедневно проводятся разнообразные мероприятия и программы - тематические, творческие и интеллектуальные конкурсы, концерты, викторины, активные и спокойные игры, эстафеты и спокойные игры.  <a class="ico-edit powertip" href=""></a></p>
					</div>

					<textarea name=" " id="" cols="15" rows="2" class="itx-gray" placeholder="Введите описание фото и нажмите Enter"></textarea>
				</div>
				<div class="comments-gray comments-gray__small">
					
					<div class="comments-gray_add active clearfix">
						
						<div class="comments-gray_frame">
							<textarea name=" " id="" cols="15" rows="2" class="itx-gray" placeholder="Введите ваш комментарий и нажмите Enter"></textarea>
						</div>
					</div>
					<div class="comments-gray_t">
						<span class="comments-gray_t-tx">Комментарии <span class="color-gray">(28)</span></span>
						<a href="" class="font-small" id="comments-show">Показать </a>
						<!-- <a href="" class="float-r font-small">Статистика (14)</a> -->
					</div>
				</div>
				
			</div>
		</div>
		<div class="scroll_bar-hold">
            <div class="scroll_bar">
            	<div class="scroll_bar-in"></div>
            </div>
        </div>
	</div>

		<div id="photo-window_banner" class="photo-window_banner clearfix">
			<div class="display-ib">
				<img src="/images/banners/9.jpg" alt="">
			</div>
		</div>
	</div>

</div>
</div>

<div class="display-n">
	<div class="photo-window-end" id="photo-window-end">
		<a class="photo-window-end_close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="photo-window-end_top">
			<div class="photo-window-end_desc">Это последнее фото из альбома</div>
			<a class="photo-window-end_t" href="javascript:void(0)">
				<span class="photo-window-end_t-tx">Жареный картофель с беконом...</span>
				<span class="re-watch" >
		            <span class="re-watch_tx">Посмотреть еще раз</span>
		        </span>
			</a>
			<div class="photo-window-end_like-t"></div>
			<div class="custom-likes-b">
				<div class="custom-likes-b_slogan">Понравилось?  Поделитесь с друзьями! </div>
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
		<div class="photo-window-end_hold clearfix">
			<div class="textalign-c">
				<div class="photo-window-end_t-other">Посмотрите еще альбомы</div>
			</div>
				
			<div class="such-post">
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
					<div class="such-post_i  such-post_i__photopost">
						<a href="" class="such-post_img-hold">
							<img src="/images/example/w335-h230.jpg" alt="" class="such-post_img">
						</a>
						<div class="such-post_type-hold">
							<div class="such-post_type  such-post_type__photopost"></div>
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
									<a href="" class="such-post_author-name">ТатьянаАлександровна</a>
									<div class="such-post_date">Сегодня 13:25</div>
								</div>
								
							</div>
							<a href="" class="such-post_t">Готовим  Торт Сметанник в домашних условиях</a>
						</div>
					</div>
				</div>
			</div>

                
		</div>
	</div>
	
</div>
</body>
</html>
