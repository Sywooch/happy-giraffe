﻿<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	
<script>
/* Height block comment scroll in photo-window */
function commentSrcH () {
	var comment = $(".comments-gray_hold");
	var bannerH = document.getElementById('photo-window_banner').offsetHeight;
	comment.height($(window).height() - bannerH - 93);
}

/* Позиция блока с лайками */
function likePos () {
	var likeBottom = ($('.photo-window_img-hold').height() - $('.photo-window_img').height()) / 2 + 30;
	$('.like-control').css({'bottom' : likeBottom});
	console.log(likeBottom);
}

$(document).ready(function () {
	commentSrcH();
	likePos();

	/* Сворачивается блок с рекламой, подгружаются оосбщения, обновляется позиция скролла */
	$('.comments-gray_t .a-pseudo-icon__blue').click(function(){
		$('.photo-window_banner').slideToggle("slow", function() {
			commentSrcH();
			});
		
		return false;
	})
});
$(window).resize(function () {
	commentSrcH();
	likePos();
});

/* Кастомный скролл */
window.onload = function() {
  /* custom scroll */
  var scroll = $('.scroll').baron({
    scroller: '.scroll_scroller',
    container: '.scroll_cont',
    track: '.scroll_bar-hold',
    bar: '.scroll_bar'
  });
  
}

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
	<div class="photo-window_top clearfix">
		<a href="" class="photo-window_close"></a>
		<div class="b-user-small float-l">
			<a href="" class="ava small male"></a>
			<div class="b-user-small_hold">
				<a href="" class="b-user-small_name">Регина</a>
				<div class="b-user-small_date">16 июн 2013</div>
			</div>
		</div>
		<div class="photo-window_top-hold">
			<div class="photo-window_t">
				<input type="text" name="" id="" class="itx-simple" placeholder="Введите заголовок фото, и нажмите Enter">
			</div>
		</div>
		<div class="photo-window_desc-hold">
			
			<textarea name="" id="" cols="30" rows="1" class="itx-simple photo-window_desc-text" id="photo-window_desc-text" placeholder="Введите описание фото, и нажмите Enter"></textarea>
			<script>
$(document).ready(function () { 
  $('.photo-window_desc-text').redactor({
      minHeight: 37,
      autoresize: true,
      buttons: [],
      focus: true
  });
});
			</script>
		</div>
		
	</div>
	<!-- Обрабатывать клик на .photo-window_c для листания следующего изображения -->
	<div class="photo-window_c">
		<div class="photo-window_img-hold">
			<img src="/images/example/w960-h537-1.jpg" alt="" class="photo-window_img">
			<div class="verticalalign-m-help"></div>
		</div>
		<a href="#photo-window-end" class="photo-window_arrow photo-window_arrow__l fancy" data-theme="white-simple"></a>
		<a href="#photo-window-end" class="photo-window_arrow photo-window_arrow__r fancy" data-theme="white-simple"></a>
		
        <div class="like-control clearfix">
            <a href="" class="like-control_ico like-control_ico__like">865</a>
            <div class="position-rel float-l">
				<a class="favorites-control_a" href="">12365</a>
				<div class="favorites-add-popup favorites-add-popup__br">
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
				</div>
			</div>
        </div>
	</div>
	


	<div class="photo-window_r">
		<div id="photo-window_banner" class="photo-window_banner clearfix">
			<img src="/images/example/w300-h250.jpg" alt="">
		</div>
		<div class="comments-gray">
			<div class="comments-gray_t">
				<div class="float-r">
					<a href="" class="a-pseudo-icon a-pseudo-icon__blue">
						<span class="a-pseudo-icon_tx">Показать все</span>
						<span class="i-arrow-t"></span>
					</a>
				</div>
				<span class="comments-gray_t-a-tx">Все комментарии (28)</span>
			</div>
			<div class="scroll ">
				<div class="scroll_scroller comments-gray_hold">
				
				
					<div class="scroll_cont">
						<div class="comments-gray_i comments-gray_i__self">
							<div class="comments-gray_ava">
								<a href="" class="ava small male"></a>
							</div>
							<div class="comments-gray_control">
								<a href="" class="message-ico message-ico__edit powertip" title="Редактировать"></a>
								<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
							</div>
							<div class="comments-gray_frame">
								<div class="comments-gray_header clearfix">
									<a href="" class="comments-gray_author">Ангелина Богоявленская </a> <br>
									<span class="font-smallest color-gray">Сегодня 13:25</span>
									<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
								</div>
								<div class="comments-gray_cont wysiwyg-content">
									<p>	Мне безумно жалко всех женщин, но особенно Тину Кароль, я просто представить себе не могу <a href="">как она все это переживет</a> как она все это переживет(</p>
									<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
								</div>
							</div>
						</div>
						<div class="comments-gray_i">
							<div class="comments-gray_ava">
								<a href="" class="ava small female"></a>
							</div>
							<div class="comments-gray_control">
								<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
								<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
								<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
							</div>
							<div class="comments-gray_frame">
								<div class="comments-gray_header clearfix">
									<a href="" class="comments-gray_author">Анг Богоявлен </a> <br>
									<span class="font-smallest color-gray">Сегодня 14:25</span>
									<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
								</div>
								<div class="comments-gray_cont wysiwyg-content">
									<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
								</div>
							</div>
						</div>
						<div class="comments-gray_i">
							<div class="comments-gray_ava">
								<a href="" class="ava small female"></a>
							</div>
							<div class="comments-gray_control">
								<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
								<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
							</div>
							<div class="comments-gray_frame">
								<div class="comments-gray_header clearfix">
									<a href="" class="comments-gray_author">Анг Богоявлен </a> <br>
									<span class="font-smallest color-gray">Сегодня 14:25</span>
									<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
								</div>
								<div class="comments-gray_cont wysiwyg-content">
									<p>я не нашел, где можно поменять название трека. </p>
								</div>
							</div>
							
						</div>
						
						<div class="comments-gray_i comments-gray_i__recovery">
							<div class="comments-gray_ava">
								<a href="" class="ava small female"></a>
							</div>
							<div class="comments-gray_frame">
								<div class="comments-gray_header clearfix">
									<a href="" class="comments-gray_author">Анг Богоявлен </a> <br>
									<span class="font-smallest color-gray">Сегодня 14:25</span>
								</div>
								<div class="comments-gray_cont wysiwyg-content">
									<p>Комментарий успешно удален.<a href="" class="comments-gray_a-recovery">Восстановить?</a> </p>
								</div>
							</div>
						</div>
						
						<div class="comments-gray_i">
							<div class="comments-gray_ava">
								<a href="" class="ava small female"></a>
							</div>
							<div class="comments-gray_control">
								<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
								<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
							</div>
							<div class="comments-gray_frame">
								<div class="comments-gray_header clearfix">
									<a href="" class="comments-gray_author">Анг Богоявлен </a> <br>
									<span class="font-smallest color-gray">Сегодня 14:25</span>
									<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
								</div>
								<div class="comments-gray_cont wysiwyg-content">
									<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту </p>
									<p>и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="scroll_bar-hold">
		            <div class="scroll_bar"></div>
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
		<div class="photo-window-end_hold clearfix">
			<div class="textalign-c">
				Другие альбомы  -  <a href="">Регина Поплавская </a>
			</div>
				
            <div class="photo-preview-row clearfix">
            	<div class="textalign-l clearfix">
            		<a class="photo-preview-row_t">Style Me Pretty - Цветы и свадьбы</a>
            	</div>
                <div class="photo-preview-row_hold">
	                <div class="photo-grid clearfix">
	                    <div class="photo-grid_row clearfix" >
	                        <!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-7.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-8.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-9.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-10.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-11.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-12.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="photo-preview-row_last">
	                    <a href="" class="photo-preview-row_a">18 558 <br> <span class="font-middle">фото</span></a>
	                </div>
                </div>
            </div>
				
            <div class="photo-preview-row clearfix">
            	<div class="textalign-l clearfix">
            		<a class="photo-preview-row_t">Style Me Pretty - Цветы и свадьбы</a>
            	</div>
                <div class="photo-preview-row_hold">
	                <div class="photo-grid clearfix">
	                    <div class="photo-grid_row clearfix" >
	                        <!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-7.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-8.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-9.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-10.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-11.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                        <div class="photo-grid_i">
	                            <img class="photo-grid_img" src="/images/example/photo-grid-12.jpg" alt="">
	                            <div class="photo-grid_overlay">
	                                <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="photo-preview-row_last">
	                    <a href="" class="photo-preview-row_a">18 558 <br> <span class="font-middle">фото</span></a>
	                </div>
                </div>
            </div>
                
		</div>
	</div>
	
</div>
</body>
</html>
