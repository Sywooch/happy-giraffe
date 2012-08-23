<?php

//if ($this->beginCache('find-friend-' . $f->id, array(
//    'dependency' => array(
//        'class' => 'system.caching.dependencies.CDbCacheDependency',
//        'sql' => 'SELECT updated FROM users WHERE id='.$f->id),
//    'duration' => 3600
//))
//) {
    $_interests = array();
    foreach ($f->interests as $i)
        $_interests[$i->category_id][] = $i;
    ?>

<li>

    <div class="clearfix user-info-big">
        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
        'user' => $f, 'location' => false, 'friendButton' => true
    )); ?>
        <?php if ($f->status): ?>
        <div class="text-status">
            <span class="tale"></span>
            <?=$f->status->text?>
        </div>
        <?php endif; ?>
    </div>

    <div class="info">

        <?php if ($f->userAddress->country_id): ?>
        <p class="location"><?=$f->userAddress->getFlag(true, 'span')?>
            <span><?=$f->userAddress->locationString?></span></p>
        <?php endif; ?>

        <p>
            <?=$f->normalizedAge?>, <?=$f->RelationshipStatusString?> &nbsp;
            <?php if ($f->babies): ?>
            <?php foreach ($f->babies as $b): ?>
                <?php if ($b->type == 1): ?>
                    <i class="icon-kid-wait"></i>
                    <?php elseif ($b->sex != 0): ?>
                    <i class="icon-kid-<?=$b->sex == 1 ? 'boy' : 'girl'?>"></i>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </p>

        <div class="interests">
            <?php foreach ($_interests as $category_id => $interests): ?>
            <div class="interest-cat">
                <img src="/images/interest_icon_<?=$category_id?>.png"/>
            </div>
            <ul class="interests-list">
                <?php foreach ($interests as $i): ?>
                <li><a class="interest"><?=$i->title?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php endforeach; ?>
        </div>

    </div>

</li>

<?php if (false): ?>
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
                <?php if (false): ?><img
                src="http://maps.googleapis.com/maps/api/staticmap?center=<?=$f->userAddress->locationString?>&zoom=7&size=200x65&maptype=hybrid&sensor=false&lang=ru"/><?php endif; ?>
            </p>

            <div class="interests">
                <span>Интересы:</span><br/>
                <?php foreach ($f->interests as $interest): ?>
                <a class="interest <?=$interest->category->css_class?> selected"><?=$interest->title?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </li>
    <?php endif; ?>
<?php //$this->endCache(); } ?>