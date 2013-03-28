<?php
/* @var $this CommentatorController
 * @var $month string месяц отчетности
 * @var $section string раздел отчетности
 */

$stats = $this->commentator->seVisits($month);
$sort_order = UserAttributes::get(Yii::app()->user->id, 'commentators_se_visits_sort', 1);
$monthModel = CommentatorsMonth::get($month);
$posts = $this->commentator->getPostsTraffic($monthModel)
?>
<div class="visits-row">
    <div class="visits-filter">
        <a id="sort_visits_by_date" href="javascript:;" class="visits-filter_i<?php if ($sort_order == 1) echo ' active' ?>">По дате</a>
        <a id="sort_visits_by_traf" href="javascript:;" class="visits-filter_i<?php if ($sort_order == 0) echo ' active' ?>">По трафику</a>
    </div>
    <div class="visits-row_t">
        Общее количество заходов
        <div class="visits-row_count"><?=$stats ?></div>
    </div>
</div>

<?php if ($sort_order == 1):?>
    <div class="report">
        <table class="visits-table">
            <tbody>
            <?php $date = ''; ?>
            <?php foreach ($posts as $post): ?>
                <?php if (date("Y-m-d", strtotime($post->created)) != $date):?>
                    <?php $date = date("Y-m-d", strtotime($post->created)) ?>
                    <tr class="visits-table_odd">
                        <td class="visits-table_td-date">
                            <div class="b-date"><?=Yii::app()->dateFormatter->format('d MMMM yyyy',strtotime($post->created))?></div>
                        </td>
                        <td class="visits-table_td-empty">&nbsp;</td>
                        <td class="visits-table_td-count">
                            <div class="visits-table_count visits-table_count__blue"><?php  ?></div>
                        </td>
                    </tr>
                <?php endif ?>
                <tr>
                    <td class="visits-table_td-link" colspan="2">
                        <a href="<?=$post->url ?>"><?=$post->title ?></a>
                    </td>
                    <td class="visits-table_td-count">
                        <div class="visits-table_count visits-table_count__blue"><?=$monthModel->getPageVisitsCount($post->url) ?></div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="report">
        <table class="visits-table">
            <tbody>
            <?php foreach ($posts as $post): ?>
                <?php if (!isset($count)) $count=0;$count++; ?>
                <tr<?php if ($count % 2 == 1) echo ' class="visits-table_odd"' ?>>
                    <td class="visits-table_td-link" colspan="2">
                        <a href="<?=$post->url ?>"><?=$post->title ?></a>
                    </td>
                    <td class="visits-table_td-count">
                        <div class="visits-table_count visits-table_count__blue"><?=$monthModel->getPageVisitsCount($post->url) ?></div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif ?>

<script type="text/javascript">
    $('#sort_visits_by_date').click(function () {
        $.post('/commentator/setSort/', {sort: 1}, function (response) {
            document.location.reload();
        }, 'json');
    });

    $('#sort_visits_by_traf').click(function () {
        $.post('/commentator/setSort/', {sort: 0}, function (response) {
            document.location.reload();
        }, 'json');
    });
</script>