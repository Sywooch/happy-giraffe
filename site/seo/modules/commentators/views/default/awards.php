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
            Просмотры <br> анкеты
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
            Поисковые <br> системы
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
                <div class="report-plan_place">
                    <?=$commentatorMonth->getPlaceViewAdmin($user->id, CommentatorsMonth::NEW_FRIENDS) ?>
                </div>
            </td>
            <td class="report-plan_td-profile" data-val="<?=$commentatorMonth->getPlace($user->id, CommentatorsMonth::PROFILE_VIEWS) ?>">
                <?=$commentatorMonth->getStatValue($user->id, CommentatorsMonth::PROFILE_VIEWS) ?>
                <div class="report-plan_place">
                    <?=$commentatorMonth->getPlaceViewAdmin($user->id, CommentatorsMonth::PROFILE_VIEWS) ?>
                </div>
            </td>
            <td class="report-plan_td-message" data-val="<?=$commentatorMonth->getPlace($user->id, CommentatorsMonth::IM_MESSAGES) ?>">
                <?=$commentatorMonth->getStatValue($user->id, CommentatorsMonth::IM_MESSAGES) ?>
                <div class="report-plan_place">
                    <?=$commentatorMonth->getPlaceViewAdmin($user->id, CommentatorsMonth::IM_MESSAGES) ?>
                </div>
            </td>
            <td class="report-plan_td-search" data-val="<?=$commentatorMonth->getPlace($user->id, CommentatorsMonth::SE_VISITS) ?>">
                <?=$commentatorMonth->getStatValue($user->id, CommentatorsMonth::SE_VISITS) ?>
                <div class="report-plan_place">
                    <?=$commentatorMonth->getPlaceViewAdmin($user->id, CommentatorsMonth::SE_VISITS) ?>
                </div>
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