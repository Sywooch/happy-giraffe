<?php
/**
 * @var $openLogin
 */

Yii::app()->ads->addVerificationTags();
Yii::app()->clientScript
    ->registerScriptFile('/javascripts/jquery.fitvids.js')
;
?>

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