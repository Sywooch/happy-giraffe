<?php
/**
 * @var $this CommentatorController
 * @var $month string
 * @author Alex Kireev <alexk984@gmail.com>
 */
$commentatorMonth = CommentatorsMonth::get($month);
$commentator = CommentatorWork::getCurrentUser();
?><div class="block">
    <?php $this->renderPartial('_month_list', array('month' => $month, 'params'=>array('type'=>'me'))); ?>

    <div class="award-me clearfix">
        <?php $place = $commentatorMonth->getTeamPlace($commentator->team, CommentatorsMonth::NEW_FRIENDS) ?>
        <div class="award-me_i award-me_i__1"<?php if ($place < 4) echo ' win' ?>>
            <div class="award-me_t">Новые <br>друзья</div>
            <div class="award-me_value"><?=$commentatorMonth->getTeamStatValue($commentator->team, CommentatorsMonth::NEW_FRIENDS) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView($commentator->user_id, CommentatorsMonth::NEW_FRIENDS, true) ?>
            </div>
            <div class="award-me_desc">
                <div class="ico-info"></div> <br>
                <a href="/commentator/secrets/#friends">Как завести наибольшее количество дружеских связей (болше всего друзей на сайте)</a>
            </div>
        </div>


        <?php $place = $commentatorMonth->getTeamPlace($commentator->team, CommentatorsMonth::IM_MESSAGES) ?>
        <div class="award-me_i award-me_i__3<?php if ($place < 4) echo ' win' ?>">
            <div class="award-me_t">Личная <br> переписка</div>
            <div class="award-me_value"><?=$commentatorMonth->getTeamStatValue($commentator->team, CommentatorsMonth::IM_MESSAGES) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView($commentator->user_id, CommentatorsMonth::IM_MESSAGES, true) ?>
            </div>
            <div class="award-me_desc">
                <div class="ico-info"></div> <br>
                <a href="/commentator/secrets/#messages">Самый коммуникабельный сотрудник (тот, кто больше всего отправил сообщений по внутренней почте) – входящие и исходящие сообщения</a>
            </div>
        </div>


        <?php $place = $commentatorMonth->getTeamPlace($commentator->team, CommentatorsMonth::RECORDS_COUNT) ?>
        <div class="award-me_i award-me_i__2<?php if ($place < 4) echo ' win' ?>">
            <div class="award-me_t">Количество <br> записей</div>
            <div class="award-me_value"><?=$commentatorMonth->getTeamStatValue($commentator->team, CommentatorsMonth::RECORDS_COUNT) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView($commentator->user_id, CommentatorsMonth::RECORDS_COUNT, true) ?>
            </div>
        </div>


        <?php $place = $commentatorMonth->getTeamPlace($commentator->team, CommentatorsMonth::MOST_COMMENTED_POST) ?>
        <div class="award-me_i award-me_i__2<?php if ($place < 4) echo ' win' ?>">
            <div class="award-me_t">Наибольшее кол-во <br> комментариев <br> к посту</div>
            <div class="award-me_value"><?=$commentatorMonth->getTeamStatValue($commentator->team, CommentatorsMonth::MOST_COMMENTED_POST) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView($commentator->user_id, CommentatorsMonth::MOST_COMMENTED_POST, true) ?>
            </div>
        </div>


        <?php $place = $commentatorMonth->getTeamPlace($commentator->team, CommentatorsMonth::GOOD_COMMENTS_COUNT) ?>
        <div class="award-me_i award-me_i__2<?php if ($place < 4) echo ' win' ?>">
            <div class="award-me_t">Кол-во <br>развернутых<br> комментариев</div>
            <div class="award-me_value"><?=$commentatorMonth->getTeamStatValue($commentator->team, CommentatorsMonth::GOOD_COMMENTS_COUNT) ?></div>
            <div class="award-me_place">
                <?=$commentatorMonth->getPlaceView($commentator->user_id, CommentatorsMonth::GOOD_COMMENTS_COUNT, true) ?>
            </div>
        </div>
    </div>

</div>