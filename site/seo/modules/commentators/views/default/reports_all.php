<?php
/**
 * @var $this DefaultController
 * @var $month string
 * @var $commentators CommentatorWork[]
 * @author Alex Kireev <alexk984@gmail.com>
 */

$criteria = new EMongoCriteria();
$criteria->setSort(array('user_id'=>EMongoCriteria::SORT_ASC));
$commentators = CommentatorWork::model()->findAll($criteria);

?>
<?php $this->renderPartial('menu', array('month' => $month, 'active'=>null, 'url'=>'reports')); ?>
<div class="block">

    <?php $this->renderPartial('_month_list', array('month' => $month)); ?>

    <div class="report report__center">
        <table class="report_table">
            <thead>
            <tr>
                <th>Комментаторы</th>
                <th>Записей в блог</th>
                <th>Записей в клуб</th>
                <th>Комментариев</th>
                <th>План</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($commentators as $commentator): ?>
                <?php $user = $commentator->getUserModel() ?>
                <tr class="report_odd">
                    <td class="report_td-user">
                        <div class="user-info clearfix">
                            <?php $url = $this->createUrl('/commentators/default/reports', array('month'=>$month, 'user_id'=>$user->id))?>
                            <a href="<?=$url ?>" class="ava small"><?=CHtml::image($user->getAva('small')) ?></a>
                            <div class="user-info_details">
                                <a href="<?=$url ?>" class="user-info_username"><?=$user->fullName ?></a>
                            </div>
                        </div>
                    </td>
                    <?php
                    $blog_stats = $commentator->getEntitiesCount('blog_posts', $month, $commentator->getBlogPostsLimit());
                    $club_stats = $commentator->getEntitiesCount('club_posts', $month, $commentator->getClubPostsLimit());
                    $comments_stats = $commentator->getEntitiesCount('comments', $month, $commentator->getCommentsLimit());
                    ?>
                    <td class="report_td-count">
                        <div class="report_count"><?=$blog_stats[0] ?></div>
                        <div class="report_percent color-<?=($blog_stats[1]>=100)?'green':'red' ?>">
                            <img src="http://www.happy-giraffe.ru/images/seo2/ico/blog-<?=($blog_stats[1]>=100)?'green':'red' ?>-small.png" alt="" class="report_count-ico">
                            <?=$blog_stats[1] ?>%
                        </div>
                    </td>
                    <td class="report_td-count">
                        <div class="report_count"><?=$club_stats[0] ?></div>
                        <div class="report_percent color-<?=($club_stats[1]>=100)?'green':'red' ?>">
                            <img src="http://www.happy-giraffe.ru/images/seo2/ico/club-<?=($club_stats[1]>=100)?'green':'red' ?>-small.png" alt="" class="report_count-ico">
                            <?=$club_stats[1] ?>%
                        </div>
                    </td>
                    <td class="report_td-count">
                        <div class="report_count"><?=$comments_stats[0] ?></div>
                        <div class="report_percent color-<?=($comments_stats[1]>=100)?'green':'red' ?>">
                            <img src="http://www.happy-giraffe.ru/images/seo2/ico/comment-<?=($comments_stats[1]>=100)?'green':'red' ?>-small.png" alt="" class="report_count-ico">
                            <?=$comments_stats[1] ?>%
                        </div>
                    </td>
                    <td class="report_td-status">
                        <?php if ($blog_stats[1] >= 100 && $club_stats[1] >= 100 && $comments_stats[1] >= 100):?>
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
    refreshOdd('table.report_table tr', 'report_odd');
</script>