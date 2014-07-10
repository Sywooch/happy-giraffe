<?php if (Yii::app()->user->model->userSocialServices): ?>

    <table class="form-settings_table">
        <thead>
        <tr>
            <th class="form-settings_th textalign-l">Социальная сеть</th>
            <th class="form-settings_th"> Имя</th>
            <th class="form-settings_th">Удалить профиль</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($services as $name => $service): ?>
            <?php if(($us = UserSocialService::model()->findByUser($name, Yii::app()->user->id)) != null): ?>
                <tr>
                    <td class="form-settings_td textalign-l">
                                        <span class="custom-like">
                                            <span class="custom-like_icon <?=$service->id?>"></span>
                                        </span>
                        <span><?= $service->title?></span>
                    </td>
                    <td class="form-settings_td">
                        <?php if ($us->urlString != ''): ?>
                            <?=CHtml::link($us->nameString, $us->urlString, array('target' => '_blank'))?>
                        <?php else: ?>
                            <?=$us->nameString?>
                        <?php endif; ?>
                    </td>
                    <td class="form-settings_td">
                        <a href="javascript:void(0)" class="a-pseudo-icon" onclick="removeSocialService(this, '<?=$us->id?>', '<?=$service->id?>')">
                            <span class="ico-close2"></span>
                            <span class="a-pseudo-icon_tx">
                        </a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div class="form-settings_t">Добавить профиль</div>

<ul class="margin-b30 clearfix">
    <?php foreach ($services as $name => $service): ?>
        <li class="b-social-big auth-service <?=$service->id?>">
            <a href="<?=Yii::app()->createUrl('/' . $action, array('service' => $name))  ?>" class="b-social-big" <?php if(UserSocialService::model()->findByUser($name, Yii::app()->user->id) !== null): ?> style="display: none;"<?php endif; ?>>
                <span class="b-social-big_ico <?=$service->id?>"></span>
            </a>
        </li>
    <?php endforeach; ?>
</ul>