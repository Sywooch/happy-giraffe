<?php
/**
 * @var $openLogin
 */
$this->layout = false;
Yii::app()->ads->addVerificationTags();
// Yii::app()->clientScript
//     ->registerScriptFile('/javascripts/jquery.fitvids.js')
// ;

  $cs = Yii::app()->clientScript;
  $cs
      ->registerCssFile('/lite/css/min/homepage.css')
      ->registerCssFile('http://fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=cyrillic,latin');
?>
<!DOCTYPE html>
<html class="no-js ">
<head>
    <meta charset="utf-8">
    <title>Веселый Жираф - сайт для всей семьи</title>
</head>
<body>
  <div class="layout-container homepage">
    <div class="layout-loose layout-loose__white">
      <div class="layout-header">

        <!-- header-->
        <header class="header header__homepage">
          <div class="header_hold">
            <div class="clearfix">
              <div class="header-login"><a href="#loginWidget" class="header-login_a popup-a">Вход</a><a href="#registerWidget" class="header-login_a popup-a">Регистрация</a></div>
              
              <?php if ($this->module === null || $this->module->id != 'search'): ?>
                  <div class="sidebar-search clearfix sidebar-search__big">
                      <!-- <input type="text" name="" placeholder="Поиск" class="sidebar-search_itx"> -->
                      <!-- При начале ввода добавить класс .active на кнопку-->
                      <!-- <button class="sidebar-search_btn"></button> -->
                      <?php $this->widget('site.frontend.modules.search.widgets.YaSearchWidget'); ?>
                  </div>
              <?php endif; ?>

            </div>

            <div class="header_row-home">
              <!-- logo-->
              <div class="logo logo__l"><a title="Веселый жираф - сайт для всей семьи" href="<?=$this->createUrl('/site/index')?>" class="logo_i">Веселый жираф - сайт для всей семьи</a><span class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span></div>
              <!-- /logo-->
            </div>
          </div>
        </header>
        <!-- header-->
      </div>
      <div class="layout-loose_hold clearfix">
        <div class="homepage-desc">
          <div class="homepage-desc_hold">
            <div class="homepage-desc_b clearfix">
              <div class="homepage-desc_l">Веселый Жираф - это социальная сеть<br><span class="homepage-desc_mark">для всей семьи</span>, которая собрала <br>миллионы мам и пап со всей  России</div>
              <div class="homepage-desc_r"><a href="#registerWidget" class="homepage_btn-sign btn btn-success btn-xxl popup-a">Присоединяйся!</a>
                <div class="homepage-desc_soc">
                  <span class="i-or-tx">или войти с помощью</span>
                  <!-- <span class="ico-social-hold"><a href="#" class="ico-social ico-social__m ico-social__odnoklassniki"></a><a href="#" class="ico-social ico-social__m ico-social__vkontakte"></a></span> -->
                  <?php $this->widget('AuthWidget', array('action' => '/signup/login/social')); ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Клубы-->
        <div class="homepage_row">
          <div class="homepage-clubs">
            <div class="homepage_title"> Мы здесь общаемся<br>на различные семейные темы </div>
            <div class="homepage-clubs_hold">
              <!-- collection-->
              <div class="homepage-clubs_collection homepage-clubs_collection__1">
                <div class="homepage-clubs_title-hold">
                  <div class="homepage-clubs_title">Муж и жена</div>
                </div>
                <ul class="homepage-clubs_ul">
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__14"></div>
                      </div>
                      <div class="homepage-clubs_tx">Свадьба</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__15"></div>
                      </div>
                      <div class="homepage-clubs_tx">Отношение в семье </div></a></li>
                </ul>
              </div>
              <!-- collection-->
              <div class="homepage-clubs_collection homepage-clubs_collection__2">
                <div class="homepage-clubs_title-hold">
                  <div class="homepage-clubs_title">Беременность и дети</div>
                </div>
                <ul class="homepage-clubs_ul">
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__1"></div>
                      </div>
                      <div class="homepage-clubs_tx">Планирование</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__2"></div>
                      </div>
                      <div class="homepage-clubs_tx">Беременность и роды</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__3"></div>
                      </div>
                      <div class="homepage-clubs_tx">Дети до года</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__4"></div>
                      </div>
                      <div class="homepage-clubs_tx">Дети старше года</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__5"></div>
                      </div>
                      <div class="homepage-clubs_tx">Дошкольники</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__6"></div>
                      </div>
                      <div class="homepage-clubs_tx">Школьники</div></a></li>
                </ul>
              </div>
              <!-- collection-->
              <div class="homepage-clubs_collection homepage-clubs_collection__3">
                <div class="homepage-clubs_title-hold">
                  <div class="homepage-clubs_title">Наш дом</div>
                </div>
                <ul class="homepage-clubs_ul">
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__7"></div>
                      </div>
                      <div class="homepage-clubs_tx">Готовим на кухне</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__9"></div>
                      </div>
                      <div class="homepage-clubs_tx">Домашние хлопоты</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__11"></div>
                      </div>
                      <div class="homepage-clubs_tx">Наши питомцы</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__10"></div>
                      </div>
                      <div class="homepage-clubs_tx">Сад и огород </div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__8"></div>
                      </div>
                      <div class="homepage-clubs_tx">Ремонт в доме</div></a></li>
                </ul>
              </div>
              <!-- collection-->
              <div class="homepage-clubs_collection homepage-clubs_collection__4">
                <div class="homepage-clubs_title-hold">
                  <div class="homepage-clubs_title">Красота и здоровье</div>
                </div>
                <ul class="homepage-clubs_ul">
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__12"></div>
                      </div>
                      <div class="homepage-clubs_tx">Красота и мода</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__13"></div>
                      </div>
                      <div class="homepage-clubs_tx">Наше здоровье</div></a></li>
                </ul>
              </div>
              <!-- collection-->
              <div class="homepage-clubs_collection homepage-clubs_collection__5">
                <div class="homepage-clubs_title-hold">
                  <div class="homepage-clubs_title">Интересы и увлечения</div>
                </div>
                <ul class="homepage-clubs_ul">
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__18"></div>
                      </div>
                      <div class="homepage-clubs_tx">Наш автомобиль</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__16"></div>
                      </div>
                      <div class="homepage-clubs_tx">Рукоделие</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__17"></div>
                      </div>
                      <div class="homepage-clubs_tx">Цветы в доме</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__21"></div>
                      </div>
                      <div class="homepage-clubs_tx">Рыбалка</div></a></li>
                </ul>
              </div>
              <!-- collection-->
              <div class="homepage-clubs_collection homepage-clubs_collection__6">
                <div class="homepage-clubs_title-hold">
                  <div class="homepage-clubs_title">Семейный отдых</div>
                </div>
                <ul class="homepage-clubs_ul">
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__20"></div>
                      </div>
                      <div class="homepage-clubs_tx">Выходные с семьей</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__19"></div>
                      </div>
                      <div class="homepage-clubs_tx">Мы путешествуем</div></a></li>
                  <li class="homepage-clubs_li"><a href="#" class="homepage-clubs_a"> 
                      <div class="homepage-clubs_ico-hold">
                        <div class="ico-club ico-club__22"></div>
                      </div>
                      <div class="homepage-clubs_tx">Семейные праздники</div></a></li>
                </ul>
              </div>
            </div>
            <div class="homepage-clubs_b">
              <div class="homepage-clubs_btn-hold"><a href="#" class="homepage_btn-sign btn btn-xxl">Начни общаться!</a></div>
              <div class="homepage_desc-tx">узнавай новое, делись самым интересным </div>
            </div>
          </div>
        </div>
        <!-- /Клубы-->


        <!-- Посты-->
        <div class="homepage_row">
          <div class="homepage-posts">
            <div class="homepage_title"> Лучшие записи </div>
            <div class="homepage-posts_col-hold">
              <div class="homepage-posts_col">
                <!-- Варианты цветов блока
                article-similar__green
                article-similar__blue
                article-similar__lilac
                article-similar__red
                article-similar__yellow
                -->
                <div class="article-similar article-similar__lilac">
                  <div class="article-similar_row">
                    <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="article-similar_author"> Антон Привольный</a>
                  </div>
                  <div class="article-similar_row"><a href="#" class="article-similar_t"> Первый российский Comic Con </a></div>
                  <div class="article-similar_img-hold"><a href="#"><img src="/lite/images/example/w240-h154-1.jpg" alt="" class="article-similar_img"></a></div>
                </div>
                <!-- Варианты цветов блока
                article-similar__green
                article-similar__blue
                article-similar__lilac
                article-similar__red
                article-similar__yellow
                -->
                <div class="article-similar article-similar__yellow">
                  <div class="article-similar_row">
                    <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="article-similar_author"> Марина Правдинина</a>
                  </div>
                  <div class="article-similar_row"><a href="#" class="article-similar_t"> Наши первые движения </a></div>
                  <div class="article-similar_img-hold"><a href="#"><img src="/lite/images/example/w240-h165.jpg" alt="" class="article-similar_img"></a></div>
                </div>
              </div>
              <div class="homepage-posts_col">
                <!-- Варианты цветов блока
                article-similar__green
                article-similar__blue
                article-similar__lilac
                article-similar__red
                article-similar__yellow
                -->
                <div class="article-similar article-similar__blue">
                  <div class="article-similar_row">
                    <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="article-similar_author"> Марина Правдинина</a>
                  </div>
                  <div class="article-similar_row"><a href="#" class="article-similar_t"> Наши первые движения </a></div>
                  <div class="article-similar_img-hold"><a href="#"><img src="/lite/images/example/w240-h165.jpg" alt="" class="article-similar_img"></a></div>
                </div>
                <div class="bnr-base"><a href="#"> <img src="/lite/images/example/w240-h400-2.jpg" alt=""></a></div>
              </div>
              <div class="homepage-posts_col"> 
                <!-- Варианты цветов блока
                article-similar__green
                article-similar__blue
                article-similar__lilac
                article-similar__red
                article-similar__yellow
                -->
                <div class="article-similar article-similar__red">
                  <div class="article-similar_row">
                    <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="article-similar_author"> Марина Правдининаertertertert</a>
                  </div>
                  <div class="article-similar_row"><a href="#" class="article-similar_t"> Яркие идеи для оформления детской комнаты </a></div>
                  <div class="article-similar_img-hold"><a href="#"><img src="/lite/images/example/w240-h183.jpg" alt="" class="article-similar_img"></a></div>
                </div>
                <!-- Варианты цветов блока
                article-similar__green
                article-similar__blue
                article-similar__lilac
                article-similar__red
                article-similar__yellow
                -->
                <div class="article-similar article-similar__green">
                  <div class="article-similar_row">
                    <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="article-similar_author"> Антон Кузнецов-Привольный</a>
                  </div>
                  <div class="article-similar_row"><a href="#" class="article-similar_t"> Одиночное путешествие: куда поехать и как организовать </a></div>
                  <div class="article-similar_img-hold"><a href="#"><img src="/lite/images/example/w240-h176.jpg" alt="" class="article-similar_img"></a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /Посты-->
        
        <!-- Посетители-->
        <div class="homepage_row">
          <div class="homepage-counter">
            <div class="homepage_title"> Нас посетило уже! </div>
            <!--Countdown dashboard start 
            -->
            <div id="counter-users" class="counter-users">
              <div class="counter-users_dash counter-users_dash__millions">
                <div class="counter-users_digit">6</div>
                <div class="counter-users_digit">2</div>
              </div>
              <div class="counter-users_dash counter-users_dash__thousands">
                <div class="counter-users_digit">0</div>
                <div class="counter-users_digit">7</div>
                <div class="counter-users_digit">2</div>
              </div>
              <div class="counter-users_dash counter-users_dash__hundreds">
                <div class="counter-users_digit">1</div>
                <div class="counter-users_digit">9</div>
                <div class="counter-users_digit">0</div>
              </div>
            </div>
            <!--
            Countdown dashboard end 
            
            -->
            <div class="homepage_desc-tx">будущих и настоящих мам и пап</div><a href="#" class="homepage_btn-sign btn btn-success btn-xxl">Присоединяйся!</a>

            <?php $this->widget('application.widgets.home.CounterWidget')?>
          </div>
        </div>
        <!-- /Посетители-->

      <?php $this->renderPartial('//_footer'); ?>






////////////////////////////////////////////////////////////





<div class="start-page">

	<div class="start-page_row start-page_row__head">
		<div class="start-page_hold">
			<div class="start-page_head clearfix">
				<h1 class="logo logo__big">
					<span class="logo_i" title="Веселый жираф - сайт для все семьи">Веселый жираф - сайт для все семьи</span>
					<strong class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</strong>
				</h1>
				<div class="start-page_head-desc">
                    <a class="btn-green btn-big popup-a" href="#registerWidget">Присоединяйтесь!</a>
                    <div class="clearfix">
                        <a class="display-ib verticalalign-m popup-a" href="#loginWidget">Войти</a>
                        <span class="i-or">или</span>
                        <?php $this->widget('AuthWidget', array('action' => '/signup/login/social')); ?>
                    </div>
                </div>

			</div>
		</div>
	</div>

	<?php $this->widget('application.widgets.home.CounterWidget')?>

	<div class="start-page_row start-page_row__articles">
		<div class="start-page_hold">
			<div class="start-page_articles">

                <?php
                if ($this->beginCache(300)):
                $models = Favourites::getArticlesByDate(Favourites::BLOCK_INTERESTING, date("Y-m-d"), 6);

                foreach ($models as $model): ?>
                    <?php $this->renderPartial('application.modules.blog.views.default._b_article', array('model' => $model, 'showLikes' => true)); ?>
                <?php endforeach; ?>
                <?php $this->endCache();endif; ?>
			</div>
		</div>
	</div>

	<div class="start-page_row start-page_row__club">
		<div class="start-page_hold">
			<div class="start-page_club">
				<h2 class="start-page_club-t">Выбирайте клубы по интересам</h2>
				<ul class="start-page_club-ul clearfix">
					<li class="start-page_club-li">
						<a href="<?=$this->createUrl('/community/default/section', array('section_id'=>1)) ?>" class="start-page_club-i">
							<img src="/images/club/collection/1.png" alt="" class="start-page_club-img">
							<span class="start-page_club-tx">Беременность <br>и дети</span>
						</a>
					</li>
					<li class="start-page_club-li">
						<a href="<?=$this->createUrl('/community/default/section', array('section_id'=>2)) ?>" class="start-page_club-i">
							<img src="/images/club/collection/2.png" alt="" class="start-page_club-img">
							<span class="start-page_club-tx">Наш дом</span>
						</a>
					</li>
					<li class="start-page_club-li">
						<a href="<?=$this->createUrl('/community/default/section', array('section_id'=>4)) ?>" class="start-page_club-i">
							<img src="/images/club/collection/4.png" alt="" class="start-page_club-img">
							<span class="start-page_club-tx">Муж и жена</span>
						</a>
					</li>
					<li class="start-page_club-li">
						<a href="<?=$this->createUrl('/community/default/section', array('section_id'=>3)) ?>" class="start-page_club-i">
							<img src="/images/club/collection/3.png" alt="" class="start-page_club-img">
							<span class="start-page_club-tx">Красота <br> и здоровье</span>
						</a>
					</li>
					<li class="start-page_club-li">
						<a href="<?=$this->createUrl('/community/default/section', array('section_id'=>5)) ?>" class="start-page_club-i">
							<img src="/images/club/collection/5.png" alt="" class="start-page_club-img">
							<span class="start-page_club-tx">Интересы <br> и увлечения</span>
						</a>
					</li>
					<li class="start-page_club-li">
						<a href="<?=$this->createUrl('/community/default/section', array('section_id'=>6)) ?>" class="start-page_club-i">
							<img src="/images/club/collection/6.png" alt="" class="start-page_club-img">
							<span class="start-page_club-tx">Семейный <br> отдых</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="start-page_row start-page_row__join">
		<div class="start-page_hold">
			<div class="start-page_join">
				<a class="btn-green start-page_join-btn popup-a" href="#registerWidget">Присоединяйтесь!</a>
                <div class="clearfix">
                    <span class="i-or">войти через</span>
                    <?php $this->widget('AuthWidget', array('action' => '/signup/login/social')); ?>
                </div>
			</div>
		</div>
	</div>

	<div class="footer-push"></div>
    <?php $this->renderPartial('//_footer'); ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(".b-article_in-img").fitVids({ customSelector : "iframe[src*='rutube.ru']" });
        <?php if ($openLogin !== false): ?>
            loginVm.open();
        <?php endif; ?>
    });
</script>
      </body>
      </html>