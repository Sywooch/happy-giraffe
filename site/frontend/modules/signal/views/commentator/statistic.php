<?php
/* @var $this CommentatorController
 * @var $period
 */

$months = $this->commentator->getWorkingMonths();
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
                    <td class="col-3"><?=$this->commentator->getPlace($period, CommentatorsMonthStats::NEW_FRIENDS) ?></td>
                    <td class="col-4"><a href="">Как найти друзей</a></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">2.  Уникальных посетителей блога</td>

                    <td class="col-2"><?=$this->commentator->blogVisits($period) ?></td>
                    <td class="col-3"><?=$this->commentator->getPlace($period, CommentatorsMonthStats::BLOG_VISITS) ?></td>
                    <td class="col-4"><a href="">Как найти друзей</a></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">3.  Количество просмотров анкеты</td>

                    <td class="col-2"><?=$this->commentator->profileUniqueViews($period) ?></td>
                    <td class="col-3"><?=$this->commentator->getPlace($period, CommentatorsMonthStats::PROFILE_UNIQUE_VIEWS) ?></td>
                    <td class="col-4"><a href="">Как увеличить кол-во просмотров анкеты</a></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">4.  Количество личных сообщений</td>

                    <td class="col-2"><?=$this->commentator->imMessages($period) ?></td>
                    <td class="col-3"><?=$this->commentator->getPlace($period, CommentatorsMonthStats::IM_MESSAGES) ?></td>
                    <td class="col-4"><a href="">Как строить общение</a></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">5.  Заходов из поисковых систем <a href="javascript:;" class="pseudo" onclick="CommentatorPanel.show('traffic-stat', this);">Показать</a></td>

                    <td class="col-2"><?=$this->commentator->seVisits($period) ?></td>
                    <td class="col-3"><?=$this->commentator->getPlace($period, CommentatorsMonthStats::SE_VISITS) ?></td>
                    <td class="col-4"><a href="">Как получить много трафика из поисковых систем</a></td>
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
                    <?php foreach ($this->commentator->getPosts($period) as $post): ?>
                        <tr>
                            <td class="al"><span class="big"><a target="_blank" href="<?=$post->url ?>"><?=$post->title ?></a></span></td>
                            <td>0</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


        </li>

        <li>

            <?php $this->renderPartial('_plan_executing', compact('period')); ?>

        </li>

    </ul>

</div>