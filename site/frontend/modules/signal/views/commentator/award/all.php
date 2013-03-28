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
            <a href="<?=$this->createUrl('', array('type'=>'me')) ?>" class="nav-hor_i">
                <span class="nav-hor_tx">Моя премия</span>
            </a>
        </li>
        <li class="nav-hor_li">
            <a href="javascript:;" class="nav-hor_i">
                <span class="nav-hor_tx">Рейтинги</span>
            </a>
        </li>
    </ul>
</div>

<div class="block">

    <?php $this->renderPartial('_month_list', array('month' => $month)); ?>

    <div class="award-me-table">
        <table class="award-me-table_tb">
            <tbody><tr>
                <th>Место </th>
                <th>Новые <br> друзья </th>
                <th>Просмотры <br> анкеты  </th>
                <th>Личная <br> переписка </th>
                <th>Поисковые <br> системы</th>
            </tr>
            <?php $count = count(CommentatorHelper::getCommentatorIdList()); ?>
            <?php for($i = 1;$i <= $count;$i++): ?>
                <tr<?php if ($i % 2 == 1) echo ' class="award-me-table_odd"' ?>>
                    <td class="award-me-table_td-place">
                        <?php if ($i < 4):?>
                            <div class="win-place-2 win-place-2__<?=$i ?>"></div>
                        <?php else: ?>
                            <?=$i ?>
                        <?php endif ?>
                    </td>
                    <td class="award-me-table_td-friend">200</td>
                    <td class="award-me-table_td-profile">2690</td>
                    <td class="award-me-table_td-message">56800</td>
                    <td class="award-me-table_td-search">96300</td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
        <div class="report-legend">
            <div class="report-legend_i">
                <img class="report-legend_img" alt="" src="/images/seo2/ico/award-place-tb.png"> -  ваше место в общем рейтинге
            </div>
        </div>
    </div>

</div>