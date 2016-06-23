<?php 

$this->pageTitle = 'Блоги';

$breadcrumbs = [
    'Главная' => ['/site/index'],
    $this->pageTitle
];

?>

<div class="b-main blog-homepage">
	
	<div class="b-breadcrumbs">
  		
  	<?php 
  	
      	$this->widget('zii.widgets.CBreadcrumbs', [
            'links'                => $breadcrumbs,
            'tagName'              => 'ul',
            'homeLink'             => FALSE,
            'separator'            => '',
            'activeLinkTemplate'   => '<li><a href="{url}">{label}</a></li>',
            'inactiveLinkTemplate' => '<li>{label}</li>',
        ]); 
  	
  	?>
  	
  	</div>
  	
  	<?php $feedWidget->getMenuWidget()->run(); ?> 
  	
  	<div class="mobile-ctrl">
    	<div class="mobile-ctrl_heading"><img src="/lite/images/new-design/images/blog-logo.png"><span>Блоги</span></div>
    	<div class="mobile-ctrl_btn"></div>
  	</div>
  
  <div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
      <div class="b-main_col-article">
      	
        <?php $feedWidget->run(); ?>
        
        <?php if (FALSE): ?>
        
        <article class="b-article clearfix b-article__list">
          <div class="b-article_cont clearfix">
            <div class="b-article_cont-tale"></div>
            <div class="b-article_header clearfix">
              <div class="icons-meta"><a href="#" class="icons-meta_comment"><span class="icons-meta_tx">3685</span></a>
                <div class="icons-meta_view"><span class="icons-meta_tx">228</span></div>
              </div>
              <div class="float-l"><a href="#" class="ava ava__female ava__middle-xs ava__middle-sm-mid"><span class="ico-status ico-status__online"></span><img src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="b-article_author">Цветы в доме</a>
                <time pubdate="1957-10-04" class="tx-date">минуту назад</time>
                <div class="b-subscribe">
                  <div class="btn btn-tiny green">Подписаться</div>
                  <div class="b-subscribe_tx">23</div>
                </div>
              </div>
            </div>
            <div class="b-article_t-list article_t-feed"><a class="b-article_t-a article_t-feed">Прикольная тема</a></div>
            <div class="b-album-cap">
              <div class="b-album-cap_hold"><img src="../../../images/sovhoz.jpg"></div>
            </div>
            <div class="b-article_content wysiwyg-content clearfix">
              <p>
                В половине чашке горячей воды разведем желатин. Дадим ему остыть. Желе для торта разводим согласно инструкции.
                Поломаем не небольшие кусочки крекер. Апельсин почистим и разберем на а не только лишь на экране, все<a class="ico-more"></a>
              </p>
            </div>
          </div>
        </article>
        
        <article class="b-article clearfix b-article__list">
          <div class="b-article_cont clearfix">
            <div class="b-article_cont-tale"></div>
            <div class="b-article_header clearfix">
              <div class="icons-meta"><a href="#" class="icons-meta_comment"><span class="icons-meta_tx">3685</span></a>
                <div class="icons-meta_view"><span class="icons-meta_tx">228</span></div>
              </div>
              <div class="float-l"><a href="#" class="ava ava__female ava__middle-xs ava__middle-sm-mid"><span class="ico-status ico-status__online"></span><img src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="b-article_author">Цветы в доме</a>
                <time pubdate="1957-10-04" class="tx-date">минуту назад</time>
                <div class="b-subscribe">
                  <div class="btn btn-tiny green">Подписаться</div>
                  <div class="b-subscribe_tx">23</div>
                </div>
              </div>
            </div>
            <div class="b-article_t-list article_t-feed"><a class="b-article_t-a article_t-feed">Прикольная тема</a></div>
            <ul class="b-album-cap multiply">
              <li class="b-album-cap_hold"><a href="#" class="b-album-cap__link"><img src="../../../images/sovhoz.jpg"></a></li>
              <li class="b-album-cap_hold"><a href="#" class="b-album-cap__link"> <img src="../../../images/sovhoz.jpg"></a></li>
              <li class="b-album-cap_hold"><a href="#" class="b-album-cap__link"><img src="../../../images/sovhoz.jpg"></a></li>
              <li class="b-album-cap_hold"><a href="#" class="b-album-cap__link"><img src="../../../images/sovhoz.jpg"></a></li>
            </ul>
            <div class="b-article_content wysiwyg-content clearfix">
              <p>
                В половине чашке горячей воды разведем желатин. Дадим ему остыть. Желе для торта разводим согласно инструкции.
                Поломаем не небольшие кусочки крекер. Апельсин почистим и разберем на а не только лишь на экране, все<a class="ico-more"></a>
              </p>
            </div>
          </div>
        </article>
        
        <article class="b-article clearfix b-article__list quote">
          <div class="b-article_cont clearfix">
            <div class="b-article_cont-tale"></div>
            <div class="b-article_header clearfix">
              <div class="icons-meta"><a href="#" class="icons-meta_comment"><span class="icons-meta_tx">3685</span></a>
                <div class="icons-meta_view"><span class="icons-meta_tx">228</span></div>
              </div>
              <div class="float-l"><a href="#" class="ava ava__female ava__middle-xs ava__middle-sm-mid"><span class="ico-status ico-status__online"></span><img src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="b-article_author">Цветы в доме</a>
                <time pubdate="1957-10-04" class="tx-date">минуту назад</time>
              </div>
            </div>
            <div class="b-article_content wysiwyg-content clearfix">
              <p>Говори себе с утра: Счастье, нам вставать пора!!! Так со Счастьем и вставай, от с<a class="ico-more-white"></a></p>
              <div class="mood">
                <div class="mood_text">Все супер!</div>
                <div class="mood_img"><img src="/images/widget/mood/7.png"></div>
              </div>
            </div>
          </div>
        </article>
        
        <!-- paginator-->
        <div class="yiipagination yiipagination__center">
      	<div class="pager">
            <ul class="yiiPager">
              <li class="previous"><a href=""></a></li>
              <li class="page"><a href="">1</a></li>
              <!-- class .page-points нужно заменить на стандартный класс yii для этого элемента-->
              <li class="page-points">...</li>
              <li class="page"><a href="">6</a></li>
              <li class="page selected"><a href="">7</a></li>
              <li class="page"><a href="">8</a></li>
              <li class="page hidden"><a href="">8</a></li>
              <!-- class .page-points нужно заменить на стандартный класс yii для этого элемента-->
              <li class="page-points">...</li>
              <li class="page"><a href="">15</a></li>
              <li class="next"><a href=""></a></li>
        	</ul>
          </div>
        </div>
        <!-- /paginator-->
        
        <?php endif; ?>
        
      </div>
      <aside class="b-main_col-sidebar visible-md">
        <ul class="sidebar-widget">
          <li class="sidebar-widget_item center-align">
            <div class="btn bnt-massive green">Добавить в блог</div>
          </li>
          <li class="sidebar-widget_item">
            <div class="b-widget-wrapper b-widget-wrapper_people b-widget-wrapper_border b-widget-wrapper_expert">
              <div class="b-widget-header">
                <div class="b-widget-header__title">Форумчанин июля</div>
              </div>
              <div class="b-widget-content">
                <ul class="b-widget-content__list">
                  <li class="b-widget-content__item">
                    <div class="b-widget-content__number">0</div>
                    <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div>
                    <div class="b-widget-content__name"><a href="#" class="b-widget-content__link">Ольга Емельянова</a></div>
                    <div class="b-widget-content__rating">698<span>баллов</span></div>
                  </li>
                  <li class="b-widget-content__item">
                    <div class="b-widget-content__number">1</div>
                    <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div>
                    <div class="b-widget-content__name"><a href="#" class="b-widget-content__link">Ольга Емельянова</a></div>
                    <div class="b-widget-content__rating">698<span>баллов</span></div>
                  </li>
                  <li class="b-widget-content__item">
                    <div class="b-widget-content__number">2</div>
                    <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div>
                    <div class="b-widget-content__name"><a href="#" class="b-widget-content__link">Ольга Емельянова</a></div>
                    <div class="b-widget-content__rating">698<span>баллов</span></div>
                  </li>
                  <li class="b-widget-content__item">
                    <div class="b-widget-content__number">3</div>
                    <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div>
                    <div class="b-widget-content__name"><a href="#" class="b-widget-content__link">Ольга Емельянова</a></div>
                    <div class="b-widget-content__rating">698<span>баллов</span></div>
                  </li>
                  <li class="b-widget-content__item">
                    <div class="b-widget-content__number">4</div>
                    <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div>
                    <div class="b-widget-content__name"><a href="#" class="b-widget-content__link">Ольга Емельянова</a></div>
                    <div class="b-widget-content__rating">698<span>баллов</span></div>
                  </li>
                </ul>
              </div>
            </div>
          </li>
          <li class="sidebar-widget_item">
            <div class="b-widget-wrapper b-widget-wrapper_theme b-widget-wrapper_border">
              <div class="b-widget-header">
                <div class="b-widget-header__title b-widget-header__title_live">Блогоэфир</div>
              </div>
              <div class="b-widget-content">
                <ul class="b-widget-content__list">
                  <li class="b-widget-content__item">
                    <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div><a href="#" class="b-widget-content__username">Ольга Емельянова</a>
                    <div class="b-widget-content__date">30 минут назад</div>
                    <div class="b-widget-content__title"><a href="#" class="b-widget-content__link">Что вы ели при токсиккозе? Не могу больше пить чай с бубликами</a></div>
                  </li>
                  <li class="b-widget-content__item">
                    <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div><a href="#" class="b-widget-content__username">Ольга Емельянова</a>
                    <div class="b-widget-content__date">30 минут назад</div>
                    <div class="b-widget-content__title"><a href="#" class="b-widget-content__link">Что вы ели при токсиккозе? Не могу больше пить чай с бубликами</a></div>
                  </li>
                  <li class="b-widget-content__item">
                    <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div><a href="#" class="b-widget-content__username">Ольга Емельянова</a>
                    <div class="b-widget-content__date">30 минут назад</div>
                    <div class="b-widget-content__title"><a href="#" class="b-widget-content__link">Что вы ели при токсиккозе? Не могу больше пить чай с бубликами</a></div>
                  </li>
                  <li class="b-widget-content__item">
                    <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div><a href="#" class="b-widget-content__username">Ольга Емельянова</a>
                    <div class="b-widget-content__date">30 минут назад</div>
                    <div class="b-widget-content__title"><a href="#" class="b-widget-content__link">Что вы ели при токсиккозе? Не могу больше пить чай с бубликами</a></div>
                  </li>
                </ul>
                <div class="b-widget-controls">
                  <div class="b-widget-controls__left"></div>
                  <div class="b-widget-controls__right"></div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </aside>
    </div>
  </div>
</div>