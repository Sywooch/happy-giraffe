<?php
/**
 * @var $list ScoreInput[]
 */
?><?php foreach ($list as $model): ?>
    <div class="career-achievement-hold">
        <div class="career-achievement">
            <div class="career-achievement_left">
                <div class="career-achievement_time font-smallest color-gray"><?= HDate::GetFormattedTime($model->updated) ?></div>
                <div class="career-achievement_tx"><?=$model->getTitle() ?></div>
            </div>
            <div class="career-achievement_center">
                <?php if (method_exists($model, 'getImage')):?>
                    <?=$model->getImage() ?>
                <?php else: ?>
                    <div class="career-achievement-ico <?=$model->getIcon() ?>"></div>
                <?php endif ?>
            </div>
            <div class="career-achievement_right">
                <div class="career-achievement_ball">
                    <div class="career-achievement_ball-num"><?=$model->scores ?></div>
                    <div class="career-achievement_ball-tx"><?=Str::GenerateNoun(array('балл','балла','баллов'), $model->scores) ?></div>
                </div>
            </div>
            <a href="javascript:;" class="career-achievement_info powertip ico-info" title="Подробней" onclick="ScorePage.showDescription(this)"></a>
        </div>

        <div class="career-achievement <?=$model->descriptionClass() ?>" style="display:none;">
            <?php $this->renderPartial('types/type_' . $model->type, compact('model')); ?>
            <div class="career-achievement_right">
                <div class="career-achievement_ball">
                    <div class="career-achievement_ball-add">+<?=$model->scores ?></div>
                </div>
            </div>
            <a href="javascript:;" class="career-achievement_info powertip ico-back" title="Назад" onclick="ScorePage.hideDescription(this)"></a>
        </div>
    </div>
<?php endforeach; ?>