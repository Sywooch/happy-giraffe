<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="top-nav-fixed ie7"> <![endif]-->
<!--[if IE 8]>         <html class="top-nav-fixed ie8"> <![endif]-->
<!--[if IE 9]>         <html class="top-nav-fixed ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="top-nav-fixed"> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>

</head>
<body class="body-gray">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
		
		<div id="content" class="layout-content clearfix">
			
			<div id="crumbs">
				<a href="">Главная</a> > <span>Найти друзей</span>
			</div>
			
			<div class="find-friend-page">
				<div class="find-friend-title clearfix">
					<div class="search-box">
						<div class="search-box_input">
							<input type="text" class="text" placeholder="Введите имя">
							<button class="icon-search"></button>
						</div>
					</div>
					<h1><i class="icon-find-friend"></i> Найти друзей</h1>
					<ul class="find-friend-menu">
						<li class="green"><a href="">Сейчас на сайте</a></li>
						<li><a href="">Из моего региона</a></li>
						<li class="active"><a href="">С похожими интересами</a></li>
						<li><a href="">С похожим статусом</a></li>
					</ul>
				</div>
				
					<div class="masonry-news-list">
						<script>
  $(function(){

        $(".masonry-news-list").masonry({
          itemSelector : '.masonry-news-list_item',
          columnWidth: 240,
          isAnimated: false,
          animationOptions: { queue: false, duration: 500 }
        });

  })
						</script>
							<ul>
								<li class="masonry-news-list_item">
									<div class="online-status">На сайте</div>
									<div class="user-info-big clearfix">
										<div class="user-info clearfix">
											<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
											<div class="details">
												<a class="username" href="">Викториал Богоявленский</a>
												<div class="date">35 лет (22 января)</div>
								                <div class="location"><div title="Украина" class="flag flag-ua"></div>Луцк</div>
											</div>
										</div>
									</div>
									<div class="user-fast-buttons">
										<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
										<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
										<a href="">Анкета</a>
										<a href="">Блог</a><sup class="count">9999</sup>
										<a href="">Фото</a><sup class="count">9999</sup>
									</div>
									<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img alt="" src="/images/user-family.png">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img src="/images/example/w52-h34-1.jpg" alt="" /></div>
												<span class="yellow">Жена</span> <br />
												<span>Светлана</span>
											</li>
											<li>
												<div class="img">
												<img alt="Настюня" src="http://img.happy-giraffe.ru/thumbs/66x66/83/2d77cb16aa563469aeb8af25ad69e436.JPG"></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">3 мес.</span>
											</li>
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">3 мес.</span>
											</li>
										</ul>
									</div>
								
								</li>
								
								<li class="masonry-news-list_item">
									<div class="user-info-big clearfix">
										<div class="user-info clearfix">
											<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/56/ava/e270c4d21ee53c19d09a1ff3ff6ee473.jpg"></a>
											<div class="details">
												<a class="username" href="">Саша</a>
												<div class="date">35 лет (22 января)</div>
								                <div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
											</div>
										</div>
									</div>
									<div class="user-fast-buttons">
										<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
										<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
										<a href="">Анкета</a>
										<a href="">Блог</a><sup class="count">9999</sup>
										<a href="">Фото</a><sup class="count">999</sup>
									</div>
									<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img alt="" src="/images/user-family.png">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG" alt="" /></div>
												<span class="yellow">Жена</span> <br />
												<span>Елизаветушка</span>
											</li>
											<li>
												<div class="img"><img src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">3 мес.</span>
											</li>
											<li>
												<div class="img"><img src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">3 мес.</span>
											</li>
										</ul>
									</div>
									
									<div class="interests">
										<ul class="interests-list">
											<li><span class="interest">Бильярд</span></li>
											<li><span class="interest">Футбол</span></li>
											<li><span class="interest">Хоккей</span></li>
											<li><span class="interest">Художественная гимнастика</span></li>
											<li><a class="interest">Бокс</a></li>
											<li><span class="interest">Бильярд</span></li>
										</ul>									
									</div>
								
								</li>
								
								<li class="masonry-news-list_item">
									<div class="online-status">На сайте</div>
									<div class="user-info-big clearfix">
										<div class="user-info clearfix">
											<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
											<div class="details">
												<a class="username" href="">Викториал Богоявленский</a>
												<div class="date">35 лет (22 января)</div>
								                <div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
											</div>
										</div>
									</div>
									<div class="user-fast-buttons">
										<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
										<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
										<a href="">Анкета</a>
										<a href="">Блог</a><sup class="count">9</sup>
										<a href="">Фото</a><sup class="count">99</sup>
									</div>
									<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img alt="" src="/images/user-family.png">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Жена</span> <br />
												<span>Елизаветушка</span>
											</li>
											<li>
												<div class="img"><img src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">3 мес.</span>
											</li>
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">3 мес.</span>
											</li>
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">2 года 12 мес.</span>
											</li>
										</ul>
									</div>
								
								</li>

								<li class="masonry-news-list_item">
									<div class="online-status">На сайте</div>
									<div class="user-info-big clearfix">
										<div class="user-info clearfix">
											<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
											<div class="details">
												<a class="username" href="">Викториал Богоявленский</a>
												<div class="date">35 лет (22 января)</div>
								                <div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
											</div>
										</div>
									</div>
									<div class="user-fast-buttons">
										<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
										<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
										<a href="">Анкета</a>
										<a href="">Блог</a>
										<a href="">Фото</a>
									</div>
									<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img alt="" src="/images/user-family.png">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Жена</span> <br />
												<span>Елизаветушка</span>
											</li>
											<li>
												<div class="img"><img src="/images/example/w52-h34-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">4 года</span>
											</li>
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">3 года</span>
											</li>
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">2 года 12 мес.</span>
											</li>
											
											<li>
												<div class="img"><img src="/images/example/w52-h34-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow"> 2 мес.</span>
											</li>
										</ul>
									</div>
								
								</li>
								<li class="masonry-news-list_item">
									<div class="user-info-big clearfix">
										<div class="user-info clearfix">
											<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/56/ava/e270c4d21ee53c19d09a1ff3ff6ee473.jpg"></a>
											<div class="details">
												<a class="username" href="">Викториал Богоявленский</a>
												<div class="date">35 лет (22 января)</div>
								                <div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
											</div>
										</div>
									</div>
									<div class="user-fast-buttons">
										<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
										<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
										<a href="">Анкета</a>
										<a href="">Блог</a><sup class="count">9</sup>
										<a href="">Фото</a><sup class="count">99</sup>
									</div>
									<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img alt="" src="/images/user-family.png">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Жена</span> <br />
												<span>Елизаветушка</span>
											</li>
											<li>
												<div class="img"><img src="/images/example/w52-h34-1.jpg" alt="" /></div>
												<span class="yellow">Сын</span> <br />
												<span>Евгений</span> <br />
												<span class="yellow">6 лет</span>
											<li>
												<div class="img"><img src="/images/example/w52-h34-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">4 года</span>
											</li>
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">3 года</span>
											</li>
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">2 года 12 мес.</span>
											</li>
											
											<li>
												<div class="img"><img src="/images/example/w52-h34-1.jpg" alt="" /></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">2 мес.</span>
											</li>
										</ul>
									</div>
								
								</li>
								<li class="masonry-news-list_item">
									<div class="online-status">На сайте</div>
									<div class="user-info-big clearfix">
										<div class="user-info clearfix">
											<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/15814/ava/b7454669882e548326361dd8936fa223.JPG"></a>
											<div class="details">
												<a class="username" href="">Викториал Богоявленский</a>
												<div class="date">35 лет (22 января)</div>
								                <div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
											</div>
										</div>
									</div>
									<div class="user-fast-buttons">
										<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
										<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
										<a href="">Анкета</a>
									</div>
									<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img alt="" src="/images/user-family.png">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"></div>
												<span>Есть</span> <br />
												<span class="yellow">подруга</span> 
											</li>
										</ul>
									</div>
									
									<div class="interests">
										<ul class="interests-list">
											<li><span class="interest">Художественная гимнастика</span></li>
											<li><span class="interest">Хоккей</span></li>
											<li><span class="interest">Бильярд</span></li>
											<li><span class="interest">Футбол</span></li>
											<li><a class="interest">Бокс</a></li>
											<li><span class="interest">Бильярд</span></li>
	                                        <li><span class="interest">Фототуризм</span></li>
	                                        <li><span class="interest">Горный туризм</span></li>
	                                        <li><span class="interest">Водный туризм</span></li>
										</ul>									
									</div>
								</li>
								
								<li class="masonry-news-list_item">
									<div class="online-status">На сайте</div>
									<div class="user-info-big clearfix">
										<div class="user-info clearfix">
											<a class="ava male"></a>
											<div class="details">
												<a class="username" href="">Викториал Богоявленский</a>
												<div class="date">35 лет (22 января)</div>
								                <div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
											</div>
										</div>
									</div>
									<div class="user-fast-buttons">
										<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
										<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
										<a href="">Анкета</a>
										<a href="">Блог</a><sup class="count">9</sup>
										<a href="">Фото</a><sup class="count">99</sup>
									</div>
									<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img alt="" src="/images/user-family.png">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Жена</span> <br />
												<span>Елизаветушка</span>
											</li>
											
											<li>
												<div class="img boy-19"></div>
												<span class="yellow">Сын</span> <br />
												<span>Евгений</span> <br />
												<span class="yellow">20 лет</span>
											<li>
												<div class="img girl-19"></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">19 лет</span>
											</li>
											<li>
												<div class="img boy-14"></div>
												<span class="yellow">Сын</span> <br />
												<span>Евгений</span> <br />
												<span class="yellow">18 лет</span>
											<li>
												<div class="img girl-14"></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">13 лет</span>
											</li>
											<li>
												<div class="img boy-8"></div>
												<span class="yellow">Сын</span> <br />
												<span>Евгений</span> <br />
												<span class="yellow">12 лет</span>
											<li>
												<div class="img girl-8"></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">7 лет</span>
											</li>
											<li>
												<div class="img boy-5"></div>
												<span class="yellow">Сын</span> <br />
												<span>Саша</span> <br />
												<span class="yellow">5 лет</span>
											<li>
												<div class="img girl-5"></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">4 года</span>
											</li>
											<li>
												<div class="img boy-3"></div>
												<span class="yellow">Сын</span> <br />
												<span>Саша</span> <br />
												<span class="yellow">3 лет</span>
											<li>
												<div class="img girl-3"></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">2 года</span>
											</li>
											<li>
												<div class="img boy-small"></div>
												<span class="yellow">Сын</span> <br />
												<span>Кирилл</span> <br />
												<span class="yellow"> 12 мес.</span>
											</li>
											<li>
												<div class="img girl-small"></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">2 мес.</span>
											</li>
										</ul>
									</div>
								
								</li>
								
								<li class="masonry-news-list_item">
									<div class="online-status">На сайте</div>
									<div class="user-info-big clearfix">
										<div class="user-info clearfix">
											<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
											<div class="details">
												<a class="username" href="">Викториал Богоявленский</a>
												<div class="date">35 лет (22 января)</div>
								                <div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
											</div>
										</div>
									</div>
									<div class="user-fast-buttons">
										<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
										<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
										<a href="">Анкета</a>
										<a href="">Блог</a><sup class="count">9</sup>
										<a href="">Фото</a><sup class="count">99</sup>
									</div>
									<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img alt="" src="/images/user-family.png">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
												<span class="yellow">Жена</span> <br />
												<span>Елизавета</span>
											</li>
											<li>
												<div class="img boy-5"></div>
												<span class="yellow">Сын</span> <br />
												<span>Саша</span> <br />
												<span class="yellow">5 лет</span>
											<li>
												<div class="img girl-5"></div>
												<span class="yellow">Дочь</span> <br />
												<span>Евгения</span> <br />
												<span class="yellow">4 года</span>
											</li>
											<li>
												<div class="img boy-wait"></div>
												<span>Ждем</span> <br />
												<span class="yellow">мальчика</span> <br />
												<span class="blue-text">26 неделя</span>
											</li>
											<li>
												<div class="img girl-wait"></div>
												<span>Ждем</span> <br />
												<span class="yellow">Девочку</span> <br />
												<span class="pink-text">26 неделя</span>
											</li>
										</ul>
									</div>
								
								</li>
								
								<li class="masonry-news-list_item">
									<div class="user-info-big clearfix">
										<div class="user-info clearfix">
											<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/15814/ava/b7454669882e548326361dd8936fa223.JPG"></a>
											<div class="details">
												<a class="username" href="">Викториал Богоявленский Житомирский</a>
												<div class="date">35 лет (22 января)</div>
								                <div class="location"><div title="Белорусия" class="flag flag-by"></div>Келиногорск Брестская обл.</div>
											</div>
										</div>
									</div>
									<div class="user-fast-buttons">
										<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
										<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
										<a href="">Анкета</a>
										<a href="">Блог</a><sup class="count">999</sup>
										<a href="">Фото</a><sup class="count">99</sup>
									</div>
									<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img alt="" src="/images/user-family.png">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"></div>
												<span class="yellow">Жена</span> <br />
												<span>Катя</span>
											</li>
											<li>
												<div class="img baby"></div>
												<span class="yellow">Ждем</span> <br />
												<span>ребенка</span> <br />
												<span class="pink-text">3 неделя</span>
											</li>
										</ul>
									</div>
								
								</li>
								<li class="masonry-news-list_item">
									<div class="user-info-big clearfix">
										<div class="user-info clearfix">
											<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/15814/ava/b7454669882e548326361dd8936fa223.JPG"></a>
											<div class="details">
												<a class="username" href="">Викториал Богоявленский Житомирский</a>
												<div class="date">35 лет (22 января)</div>
								                <div class="location"><div title="Белорусия" class="flag flag-by"></div>Келиногорск Брестская обл.</div>
											</div>
										</div>
									</div>
									<div class="user-fast-buttons">
										<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
										<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
										<a href="">Анкета</a>
										<a href="">Блог</a><sup class="count">999</sup>
										<a href="">Фото</a><sup class="count">99</sup>
									</div>
									<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img alt="" src="/images/user-family.png">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"></div>
												<span class="yellow">Жена</span> <br />
												<span>Катя</span>
											</li>
											<li>
												<div class="img baby-plan"></div>
												<span class="yellow">Планируем</span> <br />
												<span>ребенка</span>
											</li>
										</ul>
									</div>
								
								</li>
							</ul>
						</div>
				
			</div>
			
			
			<!-- Старая версия  -->
	<script>
		$(function(){
			
			ffpactive = 0;
			ffpcount = $('#find-friend-wrapper').find('ul').size();
			
		})
		
		var ffpcount;
		var ffpactive;
		
		
		function nextFriendsPage(){
			
			if (!$('#find-friend-wrapper').find('ul').is(':animated')){
			
				ffpcount == ffpactive+1 ? ffpactive = 0 : ffpactive++;
				
				$('#find-friend-wrapper').find('ul').eq(ffpactive).fadeIn();
				$('#find-friend-wrapper').find('ul').not(':eq('+ffpactive+')').hide();
				
			}
			
		}
	</script>
			<div id="find-friend" class="activity-find-friend">
				
				<div class="title">Найти <span>друзей</span> <a href="javascript:void(0);" onclick="nextFriendsPage();"><span>Найти<br/>еще</span></a></div>
				
				<div id="find-friend-wrapper">
					<ul class="clearfix" style="display:block;">
						
						<li>
							
							<div class="clearfix user-info-big">
								<div class="user-info clearfix">
									<a class="ava female"></a>
									<div class="details">
										<span class="icon-status status-online"></span>
										<a href="" class="username">Богоявленский</a>
										<div class="user-fast-buttons">
											<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
											<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
										</div>
									</div>
								</div>
								<div class="text-status pattern pattern-10">
									<span class="tale"></span>
									Родители всегда говорили мне, что я могу добиться чего угодно, но никогда не говорили, сколько времени это займет
								</div>
							</div>
							
							<div class="info">
								
								<p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия Ярославская область, г. Гаврилов-Ям</span></p>
								
								<p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>
								
								<div class="interests">
									<div class="interest-cat">
                      <img src="/images/interest_icon_1.png" />
                  </div>
                  <ul class="interests-list">
                    <li><a class="interest">Бильярд</a></li>
                  </ul>		
									<div class="interest-cat">
										<img src="/images/interest_icon_2.png" />
									</div>
                  <ul class="interests-list">
                    <li><a class="interest">Футбол</a></li>
                    <li><a class="interest">Хоккей</a></li>
                    <li><a class="interest">Художественная гимнастика</a></li>
                    <li><a class="interest">Бокс</a></li>
                    <li><a class="interest">Бильярд</a></li>
                  </ul>									
								</div>
								
							</div>
							
						</li>
					
						<li>
							
							<div class="clearfix user-info-big">
								<div class="user-info clearfix">
									<a class="ava female"></a>
									<div class="details">
										<span class="icon-status status-online"></span>
										<a href="" class="username">Богоявленский</a>
										<div class="user-fast-buttons">
											<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
											<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
										</div>
									</div>
								</div>
								<div class="text-status pattern pattern-11">
									<span class="tale"></span>
									Родители всегда говорили мне, что я могу добиться чего угодно, но никогда не говорили, сколько времени это займет
								</div>
							</div>
							
							<div class="info">
								
								<p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия</span></p>
								
								<p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>
								
								<div class="interests">
									<div class="interest-cat">
                      <img src="/images/interest_icon_1.png" />
                  </div>
                  <ul class="interests-list">
                    <li><a class="interest">Бильярд</a></li>
                  </ul>		
									<div class="interest-cat">
										<img src="/images/interest_icon_2.png" />
									</div>
                  <ul class="interests-list">
                    <li><a class="interest">Футбол</a></li>
                    <li><a class="interest">Хоккей</a></li>
                    <li><a class="interest">Художественная гимнастика</a></li>
                    <li><a class="interest">Бокс</a></li>
                    <li><a class="interest">Бильярд</a></li>
                  </ul>									
								</div>
								
							</div>
							
						</li>
					
						<li>
							
							<div class="clearfix user-info-big">
								<div class="user-info clearfix">
									<a class="ava female"></a>
									<div class="details">
										<span class="icon-status status-online"></span>
										<a href="" class="username">Богоявленский</a>
										<div class="user-fast-buttons">
											<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
											<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
										</div>
									</div>
								</div>
								<div class="text-status pattern pattern-12">
									<span class="tale"></span>
									Родители всегда говорили мне, что я могу добиться чего угодно, но никогда не говорили, сколько времени это займет
								</div>
							</div>
							
							<div class="info">
								
								<p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия Ярославская область, г. Гаврилов-Ям</span></p>
								
								<p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>
								
								<div class="interests">
									<div class="interest-cat">
                      <img src="/images/interest_icon_1.png" />
                  </div>
                  <ul class="interests-list">
                    <li><a class="interest">Бильярд</a></li>
                  </ul>		
									<div class="interest-cat">
										<img src="/images/interest_icon_2.png" />
									</div>
                  <ul class="interests-list">
                    <li><a class="interest">Футбол</a></li>
                    <li><a class="interest">Хоккей</a></li>
                    <li><a class="interest">Художественная гимнастика</a></li>
                    <li><a class="interest">Бокс</a></li>
                    <li><a class="interest">Бильярд</a></li>
                  </ul>									
								</div>
								
							</div>
							
						</li>
					
						<li>
							
							<div class="clearfix user-info-big">
								<div class="user-info clearfix">
									<a class="ava female"></a>
									<div class="details">
										<span class="icon-status status-online"></span>
										<a href="" class="username">Богоявленский</a>
										<div class="user-fast-buttons">
											<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
											<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
										</div>
									</div>
								</div>
								<div class="text-status pattern pattern-14">
									<span class="tale"></span>
									Родители всегда говорили мне, что я могу добиться чего угодно, но никогда не говорили, сколько времени это займет
								</div>
							</div>
							
							<div class="info">
								
								<p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия Ярославская область, г. Гаврилов-Ям</span></p>
								
								<p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>
								
								<div class="interests">
									<div class="interest-cat">
                      <img src="/images/interest_icon_1.png" />
                  </div>
                  <ul class="interests-list">
                    <li><a class="interest">Бильярд</a></li>
                  </ul>		
									<div class="interest-cat">
										<img src="/images/interest_icon_2.png" />
									</div>
                  <ul class="interests-list">
                    <li><a class="interest">Футбол</a></li>
                    <li><a class="interest">Хоккей</a></li>
                    <li><a class="interest">Художественная гимнастика</a></li>
                    <li><a class="interest">Бокс</a></li>
                    <li><a class="interest">Бильярд</a></li>
                  </ul>									
								</div>
								
							</div>
							
						</li>
					
						
						<li>
							
							<div class="clearfix user-info-big">
								<div class="user-info clearfix">
									<a class="ava female"></a>
									<div class="details">
										<span class="icon-status status-online"></span>
										<a href="" class="username">Богоявленский</a>
										<div class="user-fast-buttons">
											<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
											<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
										</div>
									</div>
								</div>
								<div class="text-status pattern pattern-15">
									<span class="tale"></span>
									Родители всегда говорили мне, что я могу добиться чего угодно, но никогда не говорили, сколько времени это займет
								</div>
							</div>
							
							<div class="info">
								
								<p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия Ярославская область, г. Гаврилов-Ям</span></p>
								
								<p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>
								
								<div class="interests">
									<div class="interest-cat">
                      <img src="/images/interest_icon_1.png" />
                  </div>
                  <ul class="interests-list">
                    <li><a class="interest">Бильярд</a></li>
                  </ul>		
									<div class="interest-cat">
										<img src="/images/interest_icon_2.png" />
									</div>
                  <ul class="interests-list">
                    <li><a class="interest">Футбол</a></li>
                    <li><a class="interest">Хоккей</a></li>
                    <li><a class="interest">Художественная гимнастика</a></li>
                    <li><a class="interest">Бокс</a></li>
                    <li><a class="interest">Бильярд</a></li>
                  </ul>									
								</div>
								
							</div>
							
						</li>
					
						<li>
							
							<div class="clearfix user-info-big">
								<div class="user-info clearfix">
									<a class="ava female"></a>
									<div class="details">
										<span class="icon-status status-online"></span>
										<a href="" class="username">Богоявленский</a>
										<div class="user-fast-buttons">
											<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
											<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
										</div>
									</div>
								</div>
								<div class="text-status pattern pattern-16">
									<span class="tale"></span>
									Родители всегда говорили мне, что я могу добиться чего угодно, но никогда не говорили, сколько времени это займет
								</div>
							</div>
							
							<div class="info">
								
								<p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия</span></p>
								
								<p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>
								
								<div class="interests">
									<div class="interest-cat">
                      <img src="/images/interest_icon_1.png" />
                  </div>
                  <ul class="interests-list">
                    <li><a class="interest">Бильярд</a></li>
                  </ul>		
									<div class="interest-cat">
										<img src="/images/interest_icon_2.png" />
									</div>
                  <ul class="interests-list">
                    <li><a class="interest">Футбол</a></li>
                    <li><a class="interest">Хоккей</a></li>
                    <li><a class="interest">Художественная гимнастика</a></li>
                    <li><a class="interest">Бокс</a></li>
                    <li><a class="interest">Бильярд</a></li>
                  </ul>									
								</div>
								
							</div>
							
						</li>
					
						<li>
							
							<div class="clearfix user-info-big">
								<div class="user-info clearfix">
									<a class="ava female"></a>
									<div class="details">
										<span class="icon-status status-online"></span>
										<a href="" class="username">Богоявленский</a>
										<div class="user-fast-buttons">
											<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
											<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
										</div>
									</div>
								</div>
								<div class="text-status pattern pattern-17">
									<span class="tale"></span>
									Родители всегда говорили мне, что я могу добиться чего угодно, но никогда не говорили, сколько времени это займет
								</div>
							</div>
							
							<div class="info">
								
								<p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия Ярославская область, г. Гаврилов-Ям</span></p>
								
								<p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>
								
								<div class="interests">
									<div class="interest-cat">
                      <img src="/images/interest_icon_1.png" />
                  </div>
                  <ul class="interests-list">
                    <li><a class="interest">Бильярд</a></li>
                  </ul>		
									<div class="interest-cat">
										<img src="/images/interest_icon_2.png" />
									</div>
                  <ul class="interests-list">
                    <li><a class="interest">Футбол</a></li>
                    <li><a class="interest">Хоккей</a></li>
                    <li><a class="interest">Художественная гимнастика</a></li>
                    <li><a class="interest">Бокс</a></li>
                    <li><a class="interest">Бильярд</a></li>
                  </ul>									
								</div>
								
							</div>
							
						</li>
					
						<li>
							
							<div class="clearfix user-info-big">
								<div class="user-info clearfix">
									<a class="ava female"></a>
									<div class="details">
										<span class="icon-status status-online"></span>
										<a href="" class="username">Богоявленский</a>
										<div class="user-fast-buttons">
											<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
											<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
										</div>
									</div>
								</div>
								<div class="text-status pattern pattern-18">
									<span class="tale"></span>
									Родители всегда говорили мне, что я могу добиться чего угодно, но никогда не говорили, сколько времени это займет
								</div>
							</div>
							
							<div class="info">
								
								<p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия Ярославская область, г. Гаврилов-Ям</span></p>
								
								<p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>
								
								<div class="interests">
									<div class="interest-cat">
                      <img src="/images/interest_icon_1.png" />
                  </div>
                  <ul class="interests-list">
                    <li><a class="interest">Бильярд</a></li>
                  </ul>		
									<div class="interest-cat">
										<img src="/images/interest_icon_2.png" />
									</div>
                  <ul class="interests-list">
                    <li><a class="interest">Футбол</a></li>
                    <li><a class="interest">Хоккей</a></li>
                    <li><a class="interest">Художественная гимнастика</a></li>
                    <li><a class="interest">Бокс</a></li>
                    <li><a class="interest">Бильярд</a></li>
                  </ul>									
								</div>
								
							</div>
							
						</li>
					
					</ul>
					
				</div>
			</div>
			<!-- /Старая версия  -->
		</div>  	
		
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
</body>
</html>
