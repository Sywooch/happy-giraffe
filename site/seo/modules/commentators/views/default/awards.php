<?php
/**
 * @var $this DefaultController
 * @var $month string
 * @var $commentators CommentatorWork[]
 * @author Alex Kireev <alexk984@gmail.com>
 */
$commentatorMonth = CommentatorsMonth::get($month);
$criteria = new EMongoCriteria();
$criteria->setSort(array('user_id'=>EMongoCriteria::SORT_ASC));
$commentators = CommentatorWork::model()->findAll($criteria);

Yii::app()->clientScript->registerScriptFile('/js/jquery.sortElements.js');

?><div class="block">

    <?php $this->renderPartial('_month_list', array('month' => $month)); ?>
<div class="report-plan">
<table class="report-plan_tb">
    <thead><tr>
        <th>
            <div class="report-plan_sort-hold">
                <a href="javascript:;" class="report-plan_sort report-plan_sort__down"></a>
            </div>
            Комментаторы
        </th>
        <th>
            <div class="report-plan_sort-hold">
                <a href="" class="report-plan_sort"></a>
            </div>
            Новые <br> друзья
        </th>
        <th>
            <div class="report-plan_sort-hold">
                <a href="javascript:;" class="report-plan_sort"></a>
            </div>
            Личная <br> переписка
        </th>
        <th>
            <div class="report-plan_sort-hold">
                <a href="javascript:;" class="report-plan_sort"></a>
            </div>
            Количество <br> постов
        </th>
        <th>
            <div class="report-plan_sort-hold">
                <a href="javascript:;" class="report-plan_sort"></a>
            </div>
            Количество <br> пользовательских <br> комментариев к посту
        </th>
        <th>
            <div class="report-plan_sort-hold">
                <a href="javascript:;" class="report-plan_sort"></a>
            </div>
            Количество <br> развернутых <br> комментариев
        </th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 0 ?>
    <?php foreach ($commentators as $commentator): ?>
        <?php $i++;$user = $commentator->getUserModel() ?>
        <tr>
            <td class="report-plan_td-user" data-val="<?=$i ?>">
                <?php $this->renderPartial('_user', compact('user')) ?>
            </td>
            <td class="report-plan_td-friend" data-val="<?=$commentatorMonth->getPlace($user->id, CommentatorsMonth::NEW_FRIENDS) ?>">
                <?=$commentatorMonth->getStatValue($user->id, CommentatorsMonth::NEW_FRIENDS) ?>
                <?=$commentatorMonth->getPlaceViewAdmin($user->id, CommentatorsMonth::NEW_FRIENDS) ?>
            </td>
            <td class="report-plan_td-message" data-val="<?=$commentatorMonth->getPlace($user->id, CommentatorsMonth::IM_MESSAGES) ?>">
                <?=$commentatorMonth->getStatValue($user->id, CommentatorsMonth::IM_MESSAGES) ?>
                <?=$commentatorMonth->getPlaceViewAdmin($user->id, CommentatorsMonth::IM_MESSAGES) ?>
            </td>
            <td class="report-plan_td-message" data-val="<?=$commentatorMonth->getPlace($user->id, CommentatorsMonth::RECORDS_COUNT) ?>">
                <?=$commentatorMonth->getStatValue($user->id, CommentatorsMonth::RECORDS_COUNT) ?>
                <?=$commentatorMonth->getPlaceViewAdmin($user->id, CommentatorsMonth::RECORDS_COUNT) ?>
            </td>
            <td class="report-plan_td-message" data-val="<?=$commentatorMonth->getPlace($user->id, CommentatorsMonth::MOST_COMMENTED_POST) ?>">
                <?=$commentatorMonth->getStatValue($user->id, CommentatorsMonth::MOST_COMMENTED_POST) ?>
                <?=$commentatorMonth->getPlaceViewAdmin($user->id, CommentatorsMonth::MOST_COMMENTED_POST) ?>
            </td>
            <td class="report-plan_td-message" data-val="<?=$commentatorMonth->getPlace($user->id, CommentatorsMonth::GOOD_COMMENTS_COUNT) ?>">
                <?=$commentatorMonth->getStatValue($user->id, CommentatorsMonth::GOOD_COMMENTS_COUNT) ?>
                <?=$commentatorMonth->getPlaceViewAdmin($user->id, CommentatorsMonth::GOOD_COMMENTS_COUNT) ?>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>
</div>
</div>

<script type="text/javascript">
    var table = $('table');

    $('table th a').each(function(){
        var th = $(this).parents('th'),
            thIndex = th.index(),
            inverse = false;

        th.click(function(e){
            e.preventDefault();
            table.find('td').filter(function(){
                return $(this).index() === thIndex;
            }).sortElements(function(a, b){
                    return $(a).data('val') > $(b).data('val')  ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                }, function(){
                    return this.parentNode;
                });

            refreshOddClass();
        });
    });

    refreshOddClass();
    function refreshOddClass(){
        $ ('table.report-plan_tb tr').removeClass('report-plan_odd');
        $ ('table.report-plan_tb tr:odd').addClass('report-plan_odd');
    }
</script>