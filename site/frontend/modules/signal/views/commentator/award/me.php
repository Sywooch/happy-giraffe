<?php
/**
 * @var $this CommentatorController
 * @var $month string
 * @author Alex Kireev <alexk984@gmail.com>
 */

$commentatorMonth = CommentatorsMonth::get($month);
?><div class="nav-hor nav-hor__2 clearfix">
    <ul class="nav-hor_ul">
        <li class="nav-hor_li active">
            <a href="javascript:;" class="nav-hor_i">
                <span class="nav-hor_tx">Моя премия</span>
            </a>
        </li>
        <li class="nav-hor_li">
            <a href="<?=$this->createUrl('', array('type'=>'all')) ?>" class="nav-hor_i">
                <span class="nav-hor_tx">Рейтинги</span>
            </a>
        </li>
    </ul>
</div>

<div class="block">

    <?php $this->renderPartial('_month_list', array('month' => $month, 'params'=>array('type'=>'me'))); ?>

    <div class="award-me clearfix">
        <?php $place = $commentatorMonth->getPlace(Yii::app()->user->id, CommentatorsMonth::NEW_FRIENDS) ?>
        <div class="award-me_i award-me_i__1"<?php if ($place < 4) echo ' win' ?>>
            <div class="award-me_t">Новые <br>друзья</div>
            <div class="award-me_value"><?=$commentatorMonth->getStatValue(Yii::app()->user->id, CommentatorsMonth::NEW_FRIENDS) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView(Yii::app()->user->id, CommentatorsMonth::NEW_FRIENDS) ?>
            </div>
            <div class="award-me_desc">
                <div class="ico-info"></div> <br>
                <a href="/commentator/secrets/#friends">Как завести наибольшее количество дружеских связей (болше всего друзей на сайте)</a>
            </div>
        </div>
        <?php $place = $commentatorMonth->getPlace(Yii::app()->user->id, CommentatorsMonth::PROFILE_VIEWS) ?>
        <div class="award-me_i award-me_i__2<?php if ($place < 4) echo ' win' ?>">
            <div class="award-me_t">Просмотры <br> анкеты</div>
            <div class="award-me_value"><?=$commentatorMonth->getStatValue(Yii::app()->user->id, CommentatorsMonth::PROFILE_VIEWS) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView(Yii::app()->user->id, CommentatorsMonth::PROFILE_VIEWS) ?>
            </div>
            <div class="award-me_desc">
                <div class="ico-info"></div> <br>
                <a href="/commentator/secrets/#visitors">Как сделать личную страницу (включая блог и фотогалерею) наиболее посещаемой по количеству просмотров</a>
            </div>
        </div>
        <?php $place = $commentatorMonth->getPlace(Yii::app()->user->id, CommentatorsMonth::IM_MESSAGES) ?>
        <div class="award-me_i award-me_i__3<?php if ($place < 4) echo ' win' ?>">
            <div class="award-me_t">Личная <br> переписка</div>
            <div class="award-me_value"><?=$commentatorMonth->getStatValue(Yii::app()->user->id, CommentatorsMonth::IM_MESSAGES) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView(Yii::app()->user->id, CommentatorsMonth::IM_MESSAGES) ?>
            </div>
            <div class="award-me_desc">
                <div class="ico-info"></div> <br>
                <a href="/commentator/secrets/#messages">Самый коммуникабельный сотрудник (тот, кто больше всего отправил сообщений по внутренней почте) – входящие и исходящие сообщения</a>
            </div>
        </div>
        <?php $place = $commentatorMonth->getPlace(Yii::app()->user->id, CommentatorsMonth::SE_VISITS) ?>
        <div class="award-me_i award-me_i__4<?php if ($place < 4) echo ' win' ?>">
            <div class="award-me_t">Поисковые <br>системы</div>
            <div class="award-me_value"><?=$commentatorMonth->getStatValue(Yii::app()->user->id, CommentatorsMonth::SE_VISITS) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView(Yii::app()->user->id, CommentatorsMonth::SE_VISITS) ?>
            </div>
            <div class="award-me_desc">
                <div class="ico-info"></div> <br>
                <a href="/commentator/secrets/#se">Как писать посты, которые приведут на сайт наибольшее количество людей из поисковиков (блог и записи в клубах)</a>
            </div>
        </div>
    </div>

</div>