<?php
/**
 * @var $this CommentatorController
 * @var $month string
 * @author Alex Kireev <alexk984@gmail.com>
 */
$commentatorMonth = CommentatorsMonth::get($month);
?><div class="block">
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


        <?php $place = $commentatorMonth->getPlace(Yii::app()->user->id, CommentatorsMonth::RECORDS_COUNT) ?>
        <div class="award-me_i award-me_i__2<?php if ($place < 4) echo ' win' ?>">
            <div class="award-me_t">Количество <br> постов</div>
            <div class="award-me_value"><?=$commentatorMonth->getStatValue(Yii::app()->user->id, CommentatorsMonth::RECORDS_COUNT) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView(Yii::app()->user->id, CommentatorsMonth::RECORDS_COUNT) ?>
            </div>
        </div>


        <?php $place = $commentatorMonth->getPlace(Yii::app()->user->id, CommentatorsMonth::MOST_COMMENTED_POST) ?>
        <div class="award-me_i award-me_i__2<?php if ($place < 4) echo ' win' ?>">
            <div class="award-me_t">Количество <br> пользовательских <br> комментариев к посту</div>
            <div class="award-me_value"><?=$commentatorMonth->getStatValue(Yii::app()->user->id, CommentatorsMonth::MOST_COMMENTED_POST) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView(Yii::app()->user->id, CommentatorsMonth::MOST_COMMENTED_POST) ?>
            </div>
        </div>


        <?php $place = $commentatorMonth->getPlace(Yii::app()->user->id, CommentatorsMonth::GOOD_COMMENTS_COUNT) ?>
        <div class="award-me_i award-me_i__2<?php if ($place < 4) echo ' win' ?>">
            <div class="award-me_t">Количество развернутых<br> комментариев (от 200 знаков)</div>
            <div class="award-me_value"><?=$commentatorMonth->getStatValue(Yii::app()->user->id, CommentatorsMonth::GOOD_COMMENTS_COUNT) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView(Yii::app()->user->id, CommentatorsMonth::GOOD_COMMENTS_COUNT) ?>
            </div>
        </div>
    </div>

</div>