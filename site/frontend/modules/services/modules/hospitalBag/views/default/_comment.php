<li class="clearfix<?php if ($i % 2 == 0) echo ' even' ?>">
    <div class="user">
        <?php $this->widget('Avatar', array('user' => $model->author)); ?>
    </div>
    <div class="content">
        <div class="hospital-bag-item-fast">
            <div class="item-storage">Ко мне в сумку</div>
            <?php if (!in_array($model->item->id, Yii::app()->user->getState('hospitalBag', array()))): ?>
            <?php $this->renderPartial('_item', array('item' => $model->item)); ?>
            <?php endif; ?>
        </div>
        <p><?php echo $model->item->description; ?></p>
        <?php if (! Yii::app()->user->isGuest): ?>
        <div class="item-useful">
            Предмет нужен?
            <?php $this->widget('application.widgets.voteWidget.VoteWidget', array(
            'model'=>$model,
            'template'=>'<div class="green">
                                <a vote="1" class="btn btn-gray-small{active1}" href=""><span><span>Да</span></span></a>
                                <br>
                                <b><span class="votes_pro">{vote1}</span> (<span class="pro_percent">{vote_percent1}</span>%)</b>
                            </div>
                            <div class="red">
                                <a vote="0" class="btn btn-gray-small{active0}" href=""><span><span>Нет</span></span></a>
                                <br>
                                <b><span class="votes_con">{vote0}</span> (<span class="con_percent">{vote_percent0}</span>%)</b>
                            </div>',
            'links' => array('.red','.green'),
            'result'=>array(0=>array('.votes_con','.con_percent'),1=>array('.votes_pro','.pro_percent')),
            'main_selector'=>'.item-useful'
        )); ?>
        </div>
        <?php endif; ?>
    </div>
</li>