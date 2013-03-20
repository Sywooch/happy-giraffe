<?php
/* @var $this Controller
 * @var $period string
 * @var $month CommentatorsMonthStats
 * @var $day int
 * @var $commentators CommentatorWork[]
 */

$date = $period.'-'.str_pad($day, 2, "0", STR_PAD_LEFT);
$daysInMonth = date('t', strtotime($date));
$months = CommentatorsMonthStats::getMonths();

?><div class="seo-table">

    <div class="fast-filter fast-filter-community">
        <?php foreach ($months as $key => $_month): ?>
        <?php if ($period == $_month):?>
            <span class="active" style="text-transform: capitalize;"><?=Yii::app()->dateFormatter->format('MMM yyyy',strtotime($_month)) ?></span>
            <?php else: ?>
            <a style="text-transform: capitalize;" href="<?=$this->createUrl('/commentators/default/index', array('period'=>$_month)) ?>"><?=Yii::app()->dateFormatter->format('MMM yyyy',strtotime($_month)) ?></a>
            <?php endif ?>
        <?php if ($key + 1 < count($months)):?>
            &nbsp;|&nbsp;
            <?php endif ?>
        <?php endforeach; ?>
    </div>

    <div class="fast-filter fast-filter-community">
        <?php for ($i = 1; $i <= $daysInMonth; $i++): ?>
            <?php if (in_array($period.'-'.str_pad($i, 2, "0", STR_PAD_LEFT), $month->workingDays)):?>
                <a<?php if ($i == $day) echo ' class="active"' ?> href="<?=$this->createUrl('/commentators/default/index', array('period'=>$period, 'day'=>$i)) ?>"><?=$i ?></a>
            <?php else: ?>
                <span><?=$i ?></span>
            <?php endif ?>
        <?php endfor; ?>
        <a<?php if (empty($day)) echo ' class="active"' ?> href="<?=$this->createUrl('/commentators/default/index', array('period'=>$period)) ?>">Месяц</a>
    </div>

    <div class="table-box table-statistic">
        <table>
            <thead>
            <tr>
                <th rowspan=2 class="al"><span class="big">Комментатор</span></th>
                <th rowspan=2><span class="big">Записей<br/>в блог</span></th>
                <th rowspan=2><span class="big">Записей<br/>в клуб</span></th>
                <th rowspan=2><span class="big">Комментариев</span></th>
                <?php if (empty($day)):?>
                    <th colspan=5><span class="big">Места</span></th>
                <?php endif ?>
                <th rowspan=2><span class="big">План</span></th>
            </tr>
            <tr>
                <?php if (empty($day)):?>
                    <th title="Новых Друзей">Д</th>
                    <th title="Посетителей Блога">Б</th>
                    <th title="Уникальных просмотров Анкеты">А</th>
                    <th title="Сообщений">С</th>
                    <th title="Заходов из поисковых систем">П</th>
                <?php endif ?>
            </tr>
            </thead>
            <tbody>
            <?php $summary = array(0, 0, 0); ?>
            <?php $working_commentators = array();$i = 0; ?>
            <?php foreach ($commentators as $commentator)
                if (isset($month->commentators[$commentator->user_id]))
                { ?>
                <?php if ($month->period == '2012-09') $group_size = 11;
                else $group_size = 9;?>
                <?php $i++; if ($i > $group_size):?>
                    <tr><td colspan="10">-----------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>
                    <?php $i = 2; ?>
                <?php endif ?>

                <?php if (!empty($day)):?>
                    <?php $commentator_day = $commentator->getDay($date) ?>
                    <?php if ($commentator_day !== null):?>
                        <?php
                        $summary[0] += $commentator_day->blog_posts;
                        $summary[1] += $commentator_day->club_posts;
                        $summary[2] += $commentator_day->comments;
                        $working_commentators [] = $commentator;
                        ?>
                        <tr>
                            <td class="al"><span class="big"><?php $this->renderPartial('_user_link',array('user'=>User::getUserById($commentator->user_id))); ?></span></td>
                            <td><?=$commentator_day->blog_posts ?></td>
                            <td><?=$commentator_day->club_posts ?></td>
                            <td><?=$commentator_day->comments ?></td>
                            <?=$commentator_day->getStatusView() ?>
                        </tr>
                    <?php else: ?>
                        <tr class="task-red">
                            <td class="al"><span class="big"><?php $this->renderPartial('_user_link',array('user'=>User::getUserById($commentator->user_id))); ?></span></td><td></td><td></td><td></td><td></td>
                        </tr>
                    <?php endif ?>
                <?php else: ?>
                    <?php
                    $blog_posts = $commentator->getEntitiesCount('blog_posts', $period);
                    $club_posts = $commentator->getEntitiesCount('club_posts', $period);
                    $comments = $commentator->getEntitiesCount('comments', $period);
                    $working_commentators [] = $commentator;
                        $summary[0] += $blog_posts;
                        $summary[1] += $club_posts;
                        $summary[2] += $comments;
                    ?>
                    <tr>
                        <td class="al"><span class="big"><?php $this->renderPartial('_user_link',array('user'=>User::getUserById($commentator->user_id))); ?></span></td>
                        <td><?=$blog_posts?></td>
                        <td><?=$club_posts?></td>
                        <td><?=$comments?></td>
                        <td><?=$month->getPlace($commentator->user_id, CommentatorsMonthStats::NEW_FRIENDS) ?></td>
                        <td><?=$month->getPlace($commentator->user_id, CommentatorsMonthStats::BLOG_VISITS) ?></td>
                        <td><?=$month->getPlace($commentator->user_id, CommentatorsMonthStats::PROFILE_VIEWS) ?></td>
                        <td><?=$month->getPlace($commentator->user_id, CommentatorsMonthStats::IM_MESSAGES) ?></td>
                        <td><?=$month->getPlace($commentator->user_id, CommentatorsMonthStats::SE_VISITS) ?></td>
                        <?php if ($blog_posts/$month->working_days_count >= $commentator->getBlogPostsLimit()
                        && $club_posts/$month->working_days_count >= $commentator->getClubPostsLimit()
                        && $comments/$month->working_days_count >= $commentator->getCommentsLimit()
                    ):?>
                            <td class="task-done">Выполнен</td>
                        <?php else: ?>
                            <td class="task-not-done">Не выполнен</td>
                        <?php endif ?>
                    </tr>
                <?php endif ?>
            <?php } ?>
            <?php if (count($working_commentators) > 0):?>
                <tr class="total">
                    <td class="al"><span class="big">Всего</span></td>
                    <td><?=$summary[0] ?></td>
                    <td><?=$summary[1] ?></td>
                    <td><?=$summary[2] ?></td><?php $days_count = 1; ?>
                    <?php if (empty($day)):?><?php $days_count = $month->working_days_count; ?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    <?php endif ?>
                    <?php if (CommentatorWork::getExecutedStatus($working_commentators, $summary, $days_count)):?>
                        <td><span class="task-done">Выполнен</span></td>
                    <?php else: ?>
                        <td><span class="task-not-done">Не выполнен</span></td>
                    <?php endif ?>
                </tr>
            <?php endif ?>
            </tbody>
        </table>
    </div>
</div>
