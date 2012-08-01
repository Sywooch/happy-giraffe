<?php
    $model = CActiveRecord::model($action->data['entity'])->findByPk($action->data['entity_id']);
?>

<?php if ($model !== null): ?>
    <div class="user-family list-item">
        <?=$this->renderPartial('activity/_activity_friend', array('user_id' => $action['user_id'], 'type' => $type))?>

        <div class="box-title">Добавил в семью</div>
        <div class="t"></div>
        <div class="c">
            <ul>
                <?php if (get_class($model) == 'UserPartner'): ?>
                    <li>
                        <big><?=$model->name?> &nbsp; <small><?=$users[$action->user_id]->getPartnerTitle($users[$action->user_id]->relationship_status)?></small></big>
                        <?php if (! empty($model->notice)): ?>
                            <div class="comment purple">
                                <?= $model->notice ?>
                                <span class="tale"></span>
                            </div>
                        <?php endif; ?>
                        <?php if (count($model->photos) != 0): ?>
                            <div class="img">
                                <img src="<?php echo $model->getRandomPhotoUrl() ?>">
                            </div>
                        <?php endif; ?>
                    </li>
                <?php elseif (get_class($model) == 'Baby'): ?>
                    <li>
                        <big><?=$model->name?><span><?php if (!empty($model->birthday)) echo ', '.$model->getTextAge(false) ?></span></big>
                        <?php if (! empty($model->notice)): ?>
                        <div class="comment <?= ($model->sex == 1)?'blue':'pink' ?>">
                            <?=$model->notice?>
                            <span class="tale"></span>
                        </div>
                        <?php endif; ?>
                        <?php if (count($model->photos) != 0): ?>
                        <div class="img">
                            <img src="<?php echo $model->getRandomPhotoUrl() ?>">
                        </div>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="b"></div>
        <!--<a href="" class="read-more">Смотреть семейный альбом<i class="icon"></i></a>-->
    </div>
<?php endif; ?>