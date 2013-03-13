<?php
/* @var $this Controller
 * @var $commentator CommentatorWork
 * @var $period
 */
$months = $commentator->getWorkingMonths();
if (!empty($months))
{
$user_id = $commentator->user_id;
if (empty($period))
    $period = $months[0];
$month = CommentatorsMonthStats::getWorkingMonth($period);
$this->renderPartial('_avatar', compact('commentator'));
?>
<div class="seo-table">

    <div class="fast-filter fast-filter-community">
        <?php foreach ($months as $key => $_month): ?>
        <?php if ($period == $_month): ?>
            <span class="active"><?=HDate::formatMonthYear($_month) ?></span>
            <?php else: ?>
            <a href="<?=$this->createUrl('/commentators/default/commentator', array('user_id' => $commentator->user_id, 'period' => $_month)) ?>"><?=HDate::formatMonthYear($_month) ?></a>
            <?php endif ?>
        <?php if ($key + 1 < count($months)): ?>
            &nbsp;|&nbsp;
            <?php endif ?>
        <?php endforeach; ?>
    </div>

    <ul class="task-list">

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">1. Друзей за месяц</td>

                    <td class="col-2"><?=$month->getStatValue($user_id, CommentatorsMonthStats::NEW_FRIENDS) ?></td>
                    <td class="col-3"><?=$month->getPlaceView($user_id, CommentatorsMonthStats::NEW_FRIENDS) ?></td>
                    <td class="col-4"></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">2. Уникальных посетителей блога</td>

                    <td class="col-2"><?=$month->getStatValue($user_id, CommentatorsMonthStats::BLOG_VISITS) ?></td>
                    <td class="col-3"><?=$month->getPlaceView($user_id, CommentatorsMonthStats::BLOG_VISITS) ?></td>
                    <td class="col-4"></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">3. Количество просмотров анкеты</td>

                    <td class="col-2"><?=$month->getStatValue($user_id, CommentatorsMonthStats::PROFILE_UNIQUE_VIEWS) ?></td>
                    <td class="col-3"><?=$month->getPlaceView($user_id, CommentatorsMonthStats::PROFILE_UNIQUE_VIEWS) ?></td>
                    <td class="col-4"></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">4. Количество личных сообщений</td>

                    <td class="col-2"><?=$month->getStatValue($user_id, CommentatorsMonthStats::IM_MESSAGES) ?></td>
                    <td class="col-3"><?=$month->getPlaceView($user_id, CommentatorsMonthStats::IM_MESSAGES) ?></td>
                    <td class="col-4"></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">5. Заходов из поисковых систем
                        <a href="javascript:;" class="pseudo" onclick="ShowHide(this, 'traffic-stat');">Показать</a>
                    </td>

                    <td class="col-2"><?=$month->getStatValue($user_id, CommentatorsMonthStats::SE_VISITS) ?></td>
                    <td class="col-3"><?=$month->getPlaceView($user_id, CommentatorsMonthStats::SE_VISITS) ?></td>
                    <td class="col-4"></td>
                </tr>
            </table>

            <div class="table-box table-statistic" id="traffic-stat" style="display: none;">
                <table>
                    <thead>
                    <tr>
                        <th class="al"><span class="big">Запись</span></th>
                        <th><span class="big">Заходов</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($commentator->getPosts($month) as $post): ?>
                        <tr>
                            <td class="al"><span class="big"><a target="_blank" href="http://www.happy-giraffe.ru<?=$post->url ?>"><?=$post->title ?></a></span></td>
                            <td><?=$month->getPageVisitsCount($post->url) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


        </li>

        <li>

            <?php $this->renderPartial('_plan_executing', compact('period', 'commentator')); ?>

        </li>

    </ul>

</div>
<?php } ?>