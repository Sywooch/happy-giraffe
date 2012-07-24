<li>
    <div class="clearfix">
        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $f, 'location' => false, 'friendButton' => true)); ?>
    </div>
    <div class="info">
        <p>
            <span>Семья:</span> <?=$f->RelationshipStatusString?><?php if ($f->babies): ?>,
            <?php foreach ($f->babies as $b): ?>
                <?php if ($b->type == 1): ?>
                    <i class="icon-kid-wait"></i>
                    <?php elseif ($b->sex != 0): ?>
                    <i class="icon-kid-<?=$b->sex == 1 ? 'boy' : 'girl'?>"></i>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </p>
        <p><span>Я живу здесь:</span> <?=$f->userAddress->locationString?></p>
        <p>
            <?php $this->widget('application.widgets.mapWidget.MapWidget', array('user' => $f, 'width' => 200, 'height' => 65)); ?>
            <?php if (false): ?><img src="http://maps.googleapis.com/maps/api/staticmap?center=<?=$f->userAddress->locationString?>&zoom=7&size=200x65&maptype=hybrid&sensor=false&lang=ru" /><?php endif; ?>
        </p>
        <div class="interests">
            <span>Интересы:</span><br/>
            <?php foreach ($f->interests as $interest): ?>
            <a class="interest <?=$interest->category->css_class?> selected"><?=$interest->title?></a>
            <?php endforeach; ?>
        </div>
    </div>
</li>