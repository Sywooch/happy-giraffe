<?php
/* @var $this CommentatorController
 * @var $month string месяц отчетности
 * @var $section string раздел отчетности
 */

$stats = $this->commentator->visitors($month);
?>
<div class="report-icons">
    <div class="report-icons_i">
        <img src="/images/seo2/ico/visitor.png" alt="" class="report-icons_img">
        <div class="report-icons_hold">
            <div class="report-icons_tx">Посетители</div>
            <div class="report-icons_count"><?=$stats['visitors'] ?></div>
        </div>
    </div>
    <div class="report-icons_i">
        <img src="/images/seo2/ico/view.png" alt="" class="report-icons_img">
        <div class="report-icons_hold">
            <div class="report-icons_tx">Просмотры</div>
            <div class="report-icons_count"><?=$stats['views'] ?></div>
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
                    <img src="/images/seo2/ico/profile-view-small.png" alt="" class="report_count-ico">
                    <div class="report_count"><?=$day->visits['main'] ?></div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/photo-small.png" alt="" class="report_count-ico">
                    <div class="report_count"><?=$day->visits['photo'] ?></div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/blog-purple-small.png" alt="" class="report_count-ico">
                    <div class="report_count"><?=$day->visits['blog'] ?></div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/visitor-small.png" alt="" class="report_count-ico">
                    <div class="report_count"><?=$day->visits['visitors'] ?></div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/view-small.png" alt="" class="report_count-ico">
                    <div class="report_count"><?=$day->visits['visits'] ?></div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="report-legend">
        <div class="report-legend_i">
            <img src="/images/seo2/ico/profile-view-small.png" alt="" class="report-legend_img"> -  посещений анкеты
        </div>
        <div class="report-legend_i">
            <img src="/images/seo2/ico/photo-small.png" alt="" class="report-legend_img"> -  посещений фотоальбомов
        </div>
        <div class="report-legend_i">
            <img src="/images/seo2/ico/blog-purple-small.png" alt="" class="report-legend_img"> -  посещений блога
        </div>
    </div>
</div>
