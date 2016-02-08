<?php
/**
 * @var array[] $scores
 * @var \site\frontend\components\api\models\User[] $users
 */
?>

<div class="top-forum">
    <div class="widget-top">
        <div class="heading-wd">Топ форумчан</div><span class="tx-hint">за неделю</span>
    </div>
    <ul>
        <?php foreach ($scores as $id => $score): ?>
        <li class="widget_item">
            <div class="widget-top_block_user">
                <a href="<?=$users[$id]->profileUrl?>" class="ava ava__middle ava__<?=($users[$id]->gender) ? 'male' : 'female'?>">
                    <?php if ($users[$id]->avatarUrl): ?>
                        <img alt="" src="<?=$users[$id]->avatarUrl?>" class="ava_img">
                    <?php endif; ?>
                </a>
                <a class="username" href="<?=$users[$id]->profileUrl?>"><?=$users[$id]->fullName?></a>
            </div>
            <div class="widget-top_block_rating counter-block"><span class="rating_count counter-text"><?=$score?></span>
                <div class="rating_text counter-hint"><?=Str::GenerateNoun(array('балл', 'балла', 'баллов'), $score)?></div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

    <?php if (false): ?>
<?php foreach ($scores as $id => $score): ?>


        <li>
            <p><?=CHtml::link($users[$id]->fullName, $users[$id]->profileUrl)?></p>
            <p><?=$score?></p>
        </li>

<?php endforeach; ?>
<?php endif; ?>