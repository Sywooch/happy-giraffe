<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');

$clubs = Community::model()->findAll();
$commentator_ids = Yii::app()->db_seo->createCommand()
    ->selectDistinct('commentator_id')
    ->from('commentators')
    ->queryColumn();
$commentators = CommentatorWork::model()->findAll(new EMongoCriteria(array(
    'condition' => array('user_id', 'in', $commentator_ids)
)));

$clubs_count = array();
foreach($commentators as $commentator){
    foreach($commentator->clubs as $club){
        if (isset($clubs_count[$club]))
            $clubs_count[$club]++;
        else
            $clubs_count[$club] = 1;
    }
}

?>
<div id="club-distribution">

    <div id="clubs">
        <?php foreach ($clubs as $club): ?>
        <div class="club" data-id="<?=$club->id ?>">
            <i class="icon"></i><?=$club->title ?>
            <span><?=isset($clubs_count[$club->id])?$clubs_count[$club->id]:0 ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="clubs-column">
        <?php foreach ($commentators as $commentator): ?>
        <div class="user" data-id="<?=$commentator->user_id ?>">
            <b><?=$commentator->name ?></b>
            <div class="inner">
                <?php $this->renderPartial('_user_clubs', compact('commentator')); ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>


<script type="text/javascript">
    var ClubsDistribution = {
        remove:function (el, user_id, club) {
            $.post('/commentators/default/removeClub/', {user_id:user_id, club_id:club},
                function (response) {
                    if (response.status) {
                        $(el).parent().remove();
                        $('#clubs .club').each(function(index, elem){
                            if ($(this).data('id') == club)
                                $(this).find('span').text(parseInt($(this).find('span').text()) - 1);
                        });
                    }
                }, 'json');
        }
    };

    $(function () {
        $('#clubs .club').draggable({
            revert:true
        });
        $('#club-distribution .user').droppable({
            drop:function (event, ui) {
                $.ajax({
                    url:'/commentators/default/addClub/',
                    data:{
                        user_id:$(this).data('id'),
                        club_id:ui.draggable.data('id')
                    },
                    type:'POST',
                    success:function (response) {
                        $(this).find('div.inner').html(response);
                        ui.draggable.find('span').text(parseInt(ui.draggable.find('span').text()) + 1);
                    },
                    context:$(this)
                });
            }
        });
    });

</script>
<style type="text/css">
    .clubs-column {
        float: left;
        width: 500px;
        padding-left: 500px;
    }

    .club {
        background: #DFEEFE;
        float: left;
        height: 22px;
        line-height: 22px;
        padding: 0 10px 0 6px;
        margin: 0 10px 10px 0;
        color: #575757;
    }

    #clubs .club {
        cursor: move;
    }

    #clubs{
        position: fixed;
        width: 500px;
    }

    .club .icon {
        float: left;
        width: 4px;
        height: 10px;
        background: url(http://www.happy-giraffe.ru/images/common.png) no-repeat -383px -179px;
        margin: 6px 6px 0 0;
    }

    .user .inner{
        margin-top: 10px;
    }

    .club span {
        font-weight: bold;
        color: #b90039;
    }

    .user {
        padding: 10px;
        border: 2px dashed #C5C6C7;
        margin-bottom: 20px;
        text-align: center;
        width: 400px;
        min-height: 70px;
    }

    a.remove {
        display: inline-block;
        background: url(/images/seo_sprite.png) no-repeat -1px -81px;
        width: 10px;
        height: 11px;
        margin-left: 6px;
    }

    a.remove:hover {
        background-position: -1px -94px;
    }
</style>