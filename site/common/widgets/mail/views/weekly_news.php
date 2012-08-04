<?php
/* @var $this Controller
 * @var $models CommunityContent[]
 */
$i = 0;
?><table style="width:100%;margin-bottom:50px;" cellpadding="0" cellspacing="0">
    <tbody><tr>
        <?php foreach ($models as $model): ?>
    <?php $this->render('_weekly_news',compact('model', 'i')); ?>
        <?php $i++; ?>
                <?php if ($i % 2 == 0):?>
                    <?php if ($i != count($models)):?>
                        </tr>
        </tbody>
    </table>
        <table style="width:100%;margin-bottom:50px;" cellpadding="0" cellspacing="0">
        <tbody><tr>
                    <?php endif ?>
                <?php endif ?>
        <?php endforeach; ?>

        </tr>
    </tbody>
</table>