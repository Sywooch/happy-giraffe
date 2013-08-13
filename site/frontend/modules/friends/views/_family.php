<?php $count = 0;$partner = 0; ?><ul class="b-family_ul">
    <?php if ($data->hasPartner() && ! empty($data->partner->name)): ?>
        <?php $count++;$partner = 1; Yii::app()->controller->renderPartial('application.modules.friends.views._partner', array('user' => $data)); ?>
    <?php endif; ?>
    <?php foreach ($data->babies as $b): ?>
        <?php if ($count == 5) : ?>
            <li class="b-family_li">
                <div class="b-family_img-hold">
                    <a class="b-family_more" href="">еще <?php echo (count($data->babies) - 4 - $partner) ?></a>
                </div>
                <div class="b-family_tx">
                </div>
            </li>
        <?php break; ?>
        <?php endif; ?>
        <?php $count++; Yii::app()->controller->renderPartial('application.modules.friends.views._baby', array('baby' => $b)); ?>
    <?php endforeach; ?>
</ul>
