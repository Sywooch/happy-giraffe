<div class="date"><?php if ($canUpdate): ?><a href="" class="a-right pseudo">Новый статус</a><?php endif; ?><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $status->created); ?></div>
<p><?php echo $status->text; ?></p>
<?php if ($this->isMyProfile && $user->hasFeature(2)): ?>
    <div class="clearfix">
        <div class="tooltip-new">10 новых</div>
        <a href="javascript:void(0)" class="a-right pseudo">Стиль статуса</a>
    </div>
<?php endif; ?>