<?php
/* @var $this CController
 * @var $userScores UserScores
 */

Yii::app()->clientScript
    ->registerScript('remove_all-scores' ,'function removeHistory(){
        $.ajax({
            url:"'. Yii::app()->createUrl("/scores/default/removeAll"). '",
            type:"POST"
        });
    }', CClientScript::POS_HEAD)
    ->registerCssFile('/stylesheets/user.css');
?>
<div id="user">
<div class="user-cols clearfix">

    <div class="col-1">

        <div class="user-points">

            <?php if (!empty($userScores->level_id)): ?>
            <div class="user-lvl user-lvl-<?=$userScores->level_id?>"></div>
            <?php endif; ?>

            <div class="points">
                У вас сейчас:<br>
                <div class="in">
                    <span><?php echo $userScores->scores ?></span><br><?php echo Str::GenerateNoun(array('Балл', 'Балла', 'Баллов'),$userScores->scores ) ?>
                </div>
            </div>

        </div>

    </div>

    <div class="col-23 clearfix">

        <div class="content-title">Мои баллы</div>

        <?php if (Yii::app()->user->id == 10):?>
        <br><a href="#" onclick="removeHistory();">Очистить всё</a>
        <?php endif ?>


        <div class="user-points-list">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider'=>$dataProvider,
                'template'=>'{items}
                        <div class="pagination pagination-center clearfix">
                            {pager}
                        </div>',
                //'summaryText' => 'показано: {start} - {end} из {count}',
                'pager' => array(
                    'class' => 'MyLinkPager',
                    'header' => '',
                ),
                'hideHeader'=>true,
                'cssFile'=>false,
                'columns'=>array(
                    array(
                        'name'=>'action_id',
                        'value'=>'$data->getIcon()',
                        'type'=>'html',
                        'htmlOptions'=>array('class'=>'icon')
                    ),
                    array(
                        'name'=>'text',
                        'type'=>'html'
                    ),
                    array(
                        'name'=>'points',
                        'htmlOptions'=>array('class'=>'count')
                    ),
                ),
            ));
            ?>

        </div>

    </div>

</div>
</div>