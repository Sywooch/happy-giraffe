<?php
/* @var $this CController
 * @var $userScores UserScores
 */

//$dataProvider = $userScores->getUserHistory();
?>
<div class="user-cols clearfix">

    <div class="col-1">

        <div class="user-points">

            <div class="rank">
                Новичок
            </div>

            <div class="points">
                У вас сейчас:<br>
                <div class="in">
                    <span><?php echo $userScores->scores ?></span><br><?php echo HDate::GenerateNoun(array('Балл', 'Балла', 'Баллов'),$userScores->scores ) ?>
                </div>
            </div>

        </div>

    </div>

    <div class="col-23 clearfix">

        <div class="content-title">Мои баллы</div>

        <div class="user-points-list">

            <?php

            $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider'=>$dataProvider,
                'template'=>'{items}
                        <div class="pagination pagination-center clearfix">
                            {summary}
                            {pager}
                        </div>',
                'pager' => array(
                    'class' => 'MyLinkPager',
                    'header' => 'Страницы',
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