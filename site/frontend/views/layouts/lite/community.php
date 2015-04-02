<?php $this->beginContent('//layouts/lite/main'); ?>
<?php /* <div class="b-main_cont"> */ ?>
<?php /* Тут происходит неведомая хрень. Я просто скопировал это из application.modules.community.views.default._links */ ?>
<section class="b-section b-section__collection-<?= $this->club->section->id ?>">
    <div class="b-section_hold b-main_cont">
        <div class="b-main_col-hold clearfix">
            <div class="b-section_sidebar">
                <a href="#" class="i-club i-club__section"> 
                    <div class="ico-club ico-club__<?= $this->club->id ?>"></div>
                </a>
            </div>
            <div class="b-section_article">
                <?php if (isset($this->post)) {
                    ?><div class="b-section_t"><a href="<?= $this->club->getUrl() ?>"><?= $this->club->title ?></a></div><?php
                } else {
                    ?><h1 class="b-section_t"><a href="<?= $this->club->getUrl() ?>"><?= $this->club->title ?></a></h1><?php
                }
                ?>
                <div class="clearfix">
                    <ul class="b-section_ul clearfix">
                        <?php if (!in_array($this->club->id, array(7))): ?>
                            <?php if (count($this->club->communities) > 1): ?>
                                <?php foreach ($this->club->communities as $community): ?>
                                    <li class="b-section_li">
                                        <a href="<?= $this->createUrl('/community/default/forum', array('forum_id' => $community->id)) ?>"
                                           class="b-section_li-a<?php
                                           if (isset($this->forum) && $this->forum !== null && $this->forum->id == $community->id)
                                               echo ' active'
                                               ?>"><?= $community->title ?></a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif ?>
                            <?php if (count($this->club->communities) == 1 /*&& (count($this->club->services) > 0)*/): ?>
                                <!--<li class="b-section_li">
                                    <a href="<?=
                                    $this->createUrl('/community/default/forum', array(
                                        'forum_id' => $this->club->communities[0]->id))
                                    ?>"
                                       class="b-section_li-a<?php
                                       if (isset($this->forum) && $this->forum !== null && $this->forum->id == $this->club->communities[0]->id)
                                           echo ' active'
                                           ?>">Форум</a>
                                </li>-->
                            <?php endif ?>

                            <?php /*if (count($this->club->services) < 2): ?>
                                <?php foreach ($this->club->services as $service): ?>
                                    <li class="b-section_li">
                                        <a href="<?= $service->getUrl() ?>" class="b-section_li-a<?php if (isset($this->service) && $this->service->id = $service->id) echo ' active' ?>"><?= $service->title ?></a>
                                    </li>
                                <?php endforeach ?>
                            <?php else: ?>
                                <li class="b-section_li">
                                    <a href="<?= $this->createUrl('/community/default/services', array('club' => $this->club->slug)) ?>" class="b-section_li-a<?php if (Yii::app()->controller->action->id == 'services') echo ' active' ?>">Сервисы</a>
                                </li>
                            <?php endif*/ ?>

                            <?php if (!Yii::app()->user->isGuest && Yii::app()->user->model->group != UserGroup::USER && Yii::app()->user->model->checkAuthItem('clubFavourites')): ?>
                                <li class="b-section_li">
                                    <a href="<?= $this->createUrl('/community/default/clubFavourites', array('clubId' => $this->club->id)) ?>" class="b-section_li-a<?php if (Yii::app()->controller->action->id == 'clubFavourites') echo ' active' ?>">Избранное</a>
                                </li>
                                <li class="b-section_li">
                                    <a href="<?= $this->createUrl('/community/default/clubPhotoPosts', array('clubId' => $this->club->id)) ?>" class="b-section_li-a<?php if (Yii::app()->controller->action->id == 'clubPhotoPosts') echo ' active' ?>">Фото-посты</a>
                                </li>
                            <?php endif; ?>
                            <?php /*if ($this->club->contest !== null): ?>
                                <li class="b-section_li"><a href="<?= $this->club->contest->url ?>" class="b-section_li-a"><img src="/images/contest/club/<?= $this->club->contest->cssClass ?>/club-menu-btn.png" alt=""></a></li>
                                    <?php endif;*/ ?>
                                <?php else: ?>
                                    <?php $this->renderPartial('application.modules.community.views.default.club_specific._links_' . $this->club->id); ?>
                                <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /* <div class="b-main_cont"> </div> */ ?>
<?= $content ?>
<?php $this->endContent(); ?>