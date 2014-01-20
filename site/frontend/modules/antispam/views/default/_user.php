<?php
/**
 * @var HController $this
 * @var AntispamStatus $data
 */
?>

<li class="antispam-user_li">
    <div class="antispam-user_hold">
        <?php $this->widget('UserInfoWidget', array('user' => $data->user)); ?>
        <!-- antispam-user-act-->
        <?php $this->widget('UserMarkWidget', array('status' => $data)); ?>
        <a class="btn-red btn-m" href="<?=$this->createUrl('/antispam/default/analysis', array('userId' => $data->user_id))?>">Анализ</a>
    </div>
</li>