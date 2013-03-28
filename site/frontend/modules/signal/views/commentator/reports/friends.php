<?php
/* @var $this CommentatorController
 * @var $month string месяц отчетности
 * @var $section string раздел отчетности
 */

$stats = $this->commentator->friends($month);
?>
<div class="report-icons">
    <div class="report-icons_i">
        <img src="/images/seo2/ico/add-friend.png" alt="" class="report-icons_img">
        <div class="report-icons_hold">
            <div class="report-icons_tx">Заявок</div>
            <div class="report-icons_count"><?=$stats['requests'] ?></div>
        </div>
    </div>
    <div class="report-icons_i">
        <img src="/images/seo2/ico/friend.png" alt="" class="report-icons_img">
        <div class="report-icons_hold">
            <div class="report-icons_tx">Друзей</div>
            <div class="report-icons_count"><?=$stats['friends'] ?></div>
        </div>
    </div>
</div>

<div class="report">
    <table class="report_table">
        <tbody>
        <?php foreach ($this->commentator->getDays($month) as $day): ?>
        <?php if (!isset($count)) $count=0;$count++; ?>
        <tr<?php if ($count % 2 == 1) echo ' class="report_odd"' ?>>
            <td class="report_td-date">
                <div class="b-date"><?=Yii::app()->dateFormatter->format('d MMMM yyyy',strtotime($day->date))?></div>
            </td>
            <td class="report_td-empty"></td>
            <td class="report_td-count">
                <img src="/images/seo2/ico/add-friend-small.png" alt="" class="report_count-ico">
                <div class="report_count"><?=$day->friends['requests'] ?></div>
            </td>
            <td class="report_td-count">
                <img src="/images/seo2/ico/friend-small.png" alt="" class="report_count-ico">
                <div class="report_count"><?=$day->friends['friends'] ?></div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody></table>
</div>
