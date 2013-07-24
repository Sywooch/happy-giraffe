<?php
/**
 * @var $this DefaultController
 * @var $month string
 * @var $commentators CommentatorWork[]
 * @author Alex Kireev <alexk984@gmail.com>
 */
$commentatorMonth = CommentatorsMonth::get($month);
$teams = $commentatorMonth->getTeams();
$commentators = CommentatorWork::model()->findAll();

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
                    Количество <br> записей
                </th>
                <th>
                    <div class="report-plan_sort-hold">
                        <a href="javascript:;" class="report-plan_sort"></a>
                    </div>
                    Наибольшее <br> кол-во <br> комментариев
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
            <?php foreach ($teams as $team): ?>
                <?php $i++; ?>
                <tr>
                    <td class="report-plan_td-user" data-val="<?=$i ?>" style="width: 280px !important;">
                        <?php $this->renderPartial('_team_users', compact('commentators', 'team')) ?>
                    </td>
                    <td class="report-plan_td-friend" data-val="<?=$commentatorMonth->getTeamPlace($team, CommentatorsMonth::NEW_FRIENDS) ?>">
                        <?=$commentatorMonth->getTeamStatValue($team, CommentatorsMonth::NEW_FRIENDS) ?>
                        <?=$commentatorMonth->getPlaceViewAdmin($team, CommentatorsMonth::NEW_FRIENDS, true) ?>
                    </td>
                    <td class="report-plan_td-message" data-val="<?=$commentatorMonth->getTeamPlace($team, CommentatorsMonth::IM_MESSAGES) ?>">
                        <?=$commentatorMonth->getTeamStatValue($team, CommentatorsMonth::IM_MESSAGES) ?>
                        <?=$commentatorMonth->getPlaceViewAdmin($team, CommentatorsMonth::IM_MESSAGES, true) ?>
                    </td>
                    <td class="report-plan_td-message" data-val="<?=$commentatorMonth->getTeamPlace($team, CommentatorsMonth::RECORDS_COUNT) ?>">
                        <?=$commentatorMonth->getTeamStatValue($team, CommentatorsMonth::RECORDS_COUNT) ?>
                        <?=$commentatorMonth->getPlaceViewAdmin($team, CommentatorsMonth::RECORDS_COUNT, true) ?>
                    </td>
                    <td class="report-plan_td-message" data-val="<?=$commentatorMonth->getTeamPlace($team, CommentatorsMonth::MOST_COMMENTED_POST) ?>">
                        <?=$commentatorMonth->getTeamStatValue($team, CommentatorsMonth::MOST_COMMENTED_POST) ?>
                        <?=$commentatorMonth->getPlaceViewAdmin($team, CommentatorsMonth::MOST_COMMENTED_POST, true) ?>
                    </td>
                    <td class="report-plan_td-message" data-val="<?=$commentatorMonth->getTeamPlace($team, CommentatorsMonth::GOOD_COMMENTS_COUNT) ?>">
                        <?=$commentatorMonth->getTeamStatValue($team, CommentatorsMonth::GOOD_COMMENTS_COUNT) ?>
                        <?=$commentatorMonth->getPlaceViewAdmin($team, CommentatorsMonth::GOOD_COMMENTS_COUNT, true) ?>
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