<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	
	<script type="text/javascript" src="/javascripts/jquery.lwtCountdown-1.0.js"></script>
	
</head>
<body class="body-gray">
	
<div class="start-page">
	<div class="start-page_row start-page_row__head">
		<div class="start-page_hold">
			<div class="start-page_head">
				<h1 class="logo logo__big">
					<a href="/" class="logo_i" title="Веселый жираф - сайт для все семьи">Веселый жираф - сайт для все семьи</a>
					<strong class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</strong>
				</h1>
				<div class="start-page_head-desc">
                    <a class="btn-green btn-big" href="">Присоединяйтесь!</a>
                    <div class="clearfix">
                        <a class="display-ib verticalalign-m fancy" href="#login">Войти</a>
                        <span class="i-or">или</span>
                        <a href="" class="custom-like">
                            <span class="custom-like_icon odnoklassniki"></span>
                        </a>
                        <a href="" class="custom-like">
                            <span class="custom-like_icon vkontakte"></span>
                        </a>

                        <a href="" class="custom-like">
                            <span class="custom-like_icon facebook"></span>
                        </a>

                        <a href="" class="custom-like">
                            <span class="custom-like_icon twitter"></span>
                        </a>
                    </div>
                </div>

			</div>
		</div>
	</div>
	<div class="start-page_row start-page_row__counter">
		<div class="start-page_hold">
			<div class="start-page_counter">
				<div class="start-page_counter-desc">
					Нас посетило уже
				</div>
		<script language="javascript" type="text/javascript">
			jQuery(document).ready(function() {
				$('#countdown_dashboard').countDown({
					numberSet : '789298'
				});

			});
		</script>
				<!-- Countdown dashboard start -->
				<div id="countdown_dashboard" class="counter-users">
					<div class="counter-users_dash counter-users_dash__millions">
						<div class="counter-users_digit">0</div>
						<div class="counter-users_digit">0</div>
					</div>

					<div class="counter-users_dash counter-users_dash__thousands">
						<div class="counter-users_digit">0</div>
						<div class="counter-users_digit">0</div>
						<div class="counter-users_digit">0</div>
					</div>

					<div class="counter-users_dash counter-users_dash__hundreds">
						<div class="counter-users_digit">0</div>
						<div class="counter-users_digit">0</div>
						<div class="counter-users_digit">0</div>
					</div>

				</div>
				<!-- Countdown dashboard end -->
				<div class="start-page_counter-desc">
					мам и пап!
				</div>

			</div>
		</div>
	</div>


	<div class="layout-wrapper">

		

		<a href="#layout" id="btn-up-page"></a>
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

</body>
</html>