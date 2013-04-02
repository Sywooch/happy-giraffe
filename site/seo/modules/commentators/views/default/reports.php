<?php
/**
 * @var $this DefaultController
 * @var $month string
 * @var $commentator CommentatorWork
 * @author Alex Kireev <alexk984@gmail.com>
 */

?>
<?php $this->renderPartial('menu', array('month' => $month, 'active'=>$commentator->user_id, 'url'=>'reports')); ?>
<div class="block">
    <?php $this->renderPartial('_month_list', array('month' => $month)); ?>

    <div class="report-icons">
        <div class="report-icons_i">
            <img src="http://www.happy-giraffe.ru/images/seo2/ico/blog-purple-circle.png" alt="" class="report-icons_img">
            <div class="report-icons_hold">
                <div class="report-icons_tx">Записей в блог</div>
                <div class="report-icons_count">
                    <?php $c = $commentator->getEntitiesCount('blog_posts', $month, $commentator->getBlogPostsLimit()) ?>
                    <?=$c[0] ?>
                    <span class="report-icons_percent">(<?=$c[1] ?>%)</span>
                </div>
            </div>
        </div>
        <div class="report-icons_i">
            <img src="http://www.happy-giraffe.ru/images/seo2/ico/club-purple-circle.png" alt="" class="report-icons_img">
            <div class="report-icons_hold">
                <div class="report-icons_tx">Записей в клуб</div>
                <div class="report-icons_count">
                    <?php $c = $commentator->getEntitiesCount('club_posts', $month, $commentator->getClubPostsLimit()) ?>
                    <?=$c[0] ?>
                    <span class="report-icons_percent">(<?=$c[1] ?>%)</span>
                </div>
            </div>
        </div>

        <div class="report-icons_i">
            <img src="http://www.happy-giraffe.ru/images/seo2/ico/comment-purple-circle.png" alt="" class="report-icons_img">
            <div class="report-icons_hold">
                <div class="report-icons_tx">Комментариев</div>
                <div class="report-icons_count">
                    <?php $c = $commentator->getEntitiesCount('comments', $month, $commentator->getCommentsLimit()) ?>
                    <?=$c[0] ?>
                    <span class="report-icons_percent">(<?=$c[1] ?>%)</span>
                </div>
            </div>
        </div>

    </div>
    <div class="report">
        <table class="report_table">
            <tbody>
            <?php foreach ($commentator->getDays($month) as $day): ?>
                <?php if (!isset($count)) $count=0;$count++; ?>
                <tr<?php if ($count % 2 == 1) echo ' class="report_odd"' ?>>
                    <td class="report_td-date">
                        <div class="b-date"><?=Yii::app()->dateFormatter->format('d MMMM yyyy',strtotime($day->date))?></div>
                    </td>
                    <td class="report_td-empty"></td>
                    <td class="report_td-count">
                        <img src="http://www.happy-giraffe.ru/images/seo2/ico/blog-<?=
                        ($day->blog_posts >= $commentator->getBlogPostsLimit())?'green':'red'
                        ?>-small.png" alt="" class="report_count-ico">
                        <div class="report_count"><?=$day->blog_posts ?></div>
                    </td>
                    <td class="report_td-count">
                        <img src="http://www.happy-giraffe.ru/images/seo2/ico/club-<?=
                        ($day->club_posts >= $commentator->getClubPostsLimit())?'green':'red'
                        ?>-small.png" alt="" class="report_count-ico">
                        <div class="report_count"><?=$day->club_posts ?></div>
                    </td>
                    <td class="report_td-count">
                        <img src="http://www.happy-giraffe.ru/images/seo2/ico/comment-<?=
                        ($day->comments >= $commentator->getCommentsLimit())?'green':'red'
                        ?>-small.png" alt="" class="report_count-ico">
                        <div class="report_count"><?=$day->comments ?></div>
                    </td>
                    <td class="report_td-empty w-50"></td>
                    <td class="report_td-status">
                        <?php if ($day->status >= CommentatorDayWork::STATUS_SUCCESS):?>
                            <div class="report_status color-green">Выполнен</div>
                        <?php else: ?>
                            <div class="report_status color-alizarin">Не выполнен</div>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script type="text/javascript">
    refreshOddClass();
    function refreshOddClass(){
        $ ('table.external-link__thin tr').removeClass('external-link_odd');
        $ ('table.external-link__thin tr:even').addClass('external-link_odd');
    }
</script>