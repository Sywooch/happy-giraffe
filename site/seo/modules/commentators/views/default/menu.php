<?php
/**
 * @var $month string месяц
 * @var $url string
 * @var $active int активный комментатор
 */
?><div class="nav-hor nav-hor__users clearfix">
    <ul class="nav-hor_ul">
        <li class="nav-hor_li<?php if ($active == null) echo ' active' ?>">
            <a href="<?=$this->createUrl('/commentators/default/'.$url, array('month'=>$month)) ?>" class="nav-hor_i">
                <span class="nav-hor_tx">Все комментаторы</span>
            </a>
        </li>
        <?php if (!isset($do_not_show_list) || $do_not_show_list === false):?>
            <?php $entities = Yii::app()->user->getState('commentators', array()); ?>
            <?php foreach ($entities as $entity): ?>
                <?php $user = User::model()->findByPk($entity) ?>
                <li class="nav-hor_li<?php if ($entity == $active) echo ' active' ?>">
                    <?php $_url = $this->createUrl('/commentators/default/'.$url, array('month'=>$month, 'user_id'=>$user->id))?>
                    <a class="nav-hor_i" href="<?=$_url ?>">
                        <span class="ava small"><?=CHtml::image($user->getAva('small')) ?></span>
                        <span class="nav-hor_tx"><?=$user->fullName ?></span>
                    </a>
                    <a href="javascript:;" class="nav-hor_close"onclick="SeoModule.removeUser('commentators', <?=$user->id ?>, this)"></a>
                </li>
            <?php endforeach; ?>
        <?php endif ?>
    </ul>
</div>