<?php
/* @var $this CommentatorController
 * @var $period
 */

$months = $this->commentator->getWorkingMonths();
$current_month = CommentatorsMonth::get($period);
?><div class="seo-table">

    <div class="fast-filter fast-filter-community">
        <?php foreach ($months as $key => $month): ?>
            <?php if ($period == $month):?>
                <span class="active"><?=HDate::formatMonthYear($month) ?></span>
            <?php else: ?>
                <a href="<?=$this->createUrl('/signal/commentator/statistic', array('period'=>$month)) ?>"><?=HDate::formatMonthYear($month) ?></a>
            <?php endif ?>
        <?php if ($key + 1 < count($months)):?>
            &nbsp;|&nbsp;
        <?php endif ?>
        <?php endforeach; ?>
    </div>

    <ul class="task-list">

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">1.  Друзей за месяц</td>

                    <td class="col-2"><?=$this->commentator->newFriends($period) ?></td>
                    <td class="col-3"><?=$this->commentator->getPlace($period, CommentatorsMonth::NEW_FRIENDS) ?></td>
                    <td class="col-4"><a href="<?=$this->createUrl('/signal/commentator/help/') ?>#friends">Как завести наибольшее количество дружеских связей (больше всего друзей на сайте)</a></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">2.  Баллов от личных сообщений</td>

                    <td class="col-2"><?=$this->commentator->imMessages($period) ?></td>
                    <td class="col-3"><?=$this->commentator->getPlace($period, CommentatorsMonth::IM_MESSAGES) ?></td>
                    <td class="col-4"><a href="<?=$this->createUrl('/signal/commentator/help/') ?>#im">Самый коммуникабельный сотрудник (тот, кто больше всего отправил сообщений по внутренней почте) – входящие и исходящие сообщения</a></td>
                </tr>
            </table>


        <li>

            <?php $this->renderPartial('_plan_executing', compact('period')); ?>

        </li>

    </ul>

</div>