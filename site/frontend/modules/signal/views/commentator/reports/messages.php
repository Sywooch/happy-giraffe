<?php
/* @var $this CommentatorController
 * @var $month string месяц отчетности
 * @var $section string раздел отчетности
 */

$stats = $this->commentator->imMessagesMonthStats($month);
?>
<div class="report-icons">
    <div class="report-icons_i">
        <img src="/images/seo2/ico/message-out.png" alt="" class="report-icons_img">
        <div class="report-icons_hold">
            <div class="report-icons_tx">Исх. сообщения</div>
            <div class="report-icons_count"><?=$stats['out'] ?></div>
        </div>
    </div>
    <div class="report-icons_i">
        <img src="/images/seo2/ico/respondent-out.png" alt="" class="report-icons_img">
        <div class="report-icons_hold">
            <div class="report-icons_tx">Исх. респонденты</div>
            <div class="report-icons_count"><?=$stats['interlocutors_out'] ?></div>
        </div>
    </div>

    <div class="report-icons_i">
        <img src="/images/seo2/ico/message-in.png" alt="" class="report-icons_img">
        <div class="report-icons_hold">
            <div class="report-icons_tx">Вх. сообщения</div>
            <div class="report-icons_count"><?=$stats['in'] ?></div>
        </div>
    </div>

    <div class="report-icons_i">
        <img src="/images/seo2/ico/respondent-in.png" alt="" class="report-icons_img">
        <div class="report-icons_hold">
            <div class="report-icons_tx">Вх. респонденты</div>
            <div class="report-icons_count"><?=$stats['interlocutors_in'] ?></div>
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
                <img src="/images/seo2/ico/message-out-small.png" alt="" class="report_count-ico">
                <div class="report_count"><?=$day->im['out'] ?></div>
            </td>
            <td class="report_td-count">
                <img src="/images/seo2/ico/respondent-out-small.png" alt="" class="report_count-ico">
                <div class="report_count"><?=$day->im['interlocutors_out'] ?></div>
            </td>
            <td class="report_td-empty w-50"></td>
            <td class="report_td-count">
                <img src="/images/seo2/ico/message-in-small.png" alt="" class="report_count-ico">
                <div class="report_count"><?=$day->im['in'] ?></div>
            </td>
            <td class="report_td-count">
                <img src="/images/seo2/ico/respondent-in-small.png" alt="" class="report_count-ico">
                <div class="report_count"><?=$day->im['interlocutors_in'] ?></div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody></table>
</div>
