<?php if ($this->mode == 'vote'): ?>

    <?php $this->controller->beginWidget('SeoContentWidget'); ?>

        <?php if (false): ?>
            <div class="share_button auth-service facebook">
                <div class="custom-like-fb">
                    <a href="<?=Yii::app()->createUrl('/'.$action, array('service' => 'facebook', 'entity_id' => $this->params['entity_id'], 'entity' => $this->params['entity']))?>" class="custom-like-fb-text">
                        <i class="icon-fb"></i>Мне нравится
                    </a>
                    <div class="custom-like-fb-share-count"><?=Rating::model()->countByEntity($this->params['model'], 'fb')?></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="share_button auth-service vkontakte" style="margin-left: 140px;">
            <a href="<?=Yii::app()->createUrl('/'.$action, array('service' => 'vkontakte', 'entity_id' => $this->params['entity_id'], 'entity' => $this->params['entity']))?>" class="custom-like-vk">
                <span class="custom-like-vk_text">Мне нравится</span>
                <span class="custom-like-vk_logo"></span>
                <span class="custom-like-vk_value"><?=Rating::model()->countByEntity($this->params['model'], 'vk')?></span>
            </a>

        </div>

        <div class="share_button auth-service odnoklassniki">
            <a class="custom-like-odkl" href="<?=Yii::app()->createUrl('/'.$action, array('service' => 'odnoklassniki', 'entity_id' => $this->params['entity_id'], 'entity' => $this->params['entity']))?>">
                <span class="custom-like-odkl_value"><?=Rating::model()->countByEntity($this->params['model'], 'ok')?></span>
            </a>
        </div>

        <div class="share_button auth-service twitter">
            <div class="custom-like-tw">
                <a href="<?=Yii::app()->createUrl('/'.$action, array('service' => 'twitter', 'entity_id' => $this->params['entity_id'], 'entity' => $this->params['entity']))?>" class="custom-like-tw_text">
                    <i class="icon-tw"></i>Твитнуть
                </a>
                <span class="custom-like-tw_value"><?=Rating::model()->countByEntity($this->params['model'], 'tw')?></span>
            </div>
        </div>

    <?php $this->controller->endWidget(); ?>
<?php elseif ($this->mode == 'small'): ?>
    <?php
    foreach ($services as $name => $service)
        if ($service->id != 'twitter') {
            echo '<li class="auth-service ' . $service->id . '">';
            $params['service'] = $name;
            if (isset($this->params['redirectUrl']))
                $params['redirectUrl'] = $this->params['redirectUrl'];
            echo HHtml::link('', Yii::app()->createUrl('/'.$action, $params), array('class' => 'auth-link ' . $service->id), true);
            echo '</li>';
        }
    ?>
<?php elseif ($this->mode == 'signup'): ?>

<ul class="clearfix">
    <?php foreach ($services as $name => $service): ?>
        <li class="b-social-big auth-service <?=$service->id?>">
            <a href="<?=Yii::app()->createUrl('/' . $action, array('service' => $name))?>" class="b-social-big_ico auth-link <?=$service->id?>"></a>
        </li>
    <?php endforeach; ?>
</ul>

<?php elseif ($this->mode == 'home'): ?>

<ul class="display-ib verticalalign-m">
    <?php foreach ($services as $name => $service): ?>
        <li class="display-ib auth-service <?=$service->id?>">
            <a class="custom-like" href="<?=Yii::app()->createUrl('/' . $action, array('service' => $name))?>">
                <span class="custom-like_icon <?=$service->id?>"></span>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php elseif ($this->mode !== 'profile'): ?>

    <div class="services">
        <ul class="auth-services">
            <?php
            foreach ($services as $name => $service)
                if ($service->id != 'twitter') {
                    echo '<li class="auth-service ' . $service->id . '">';
                    $html = HHtml::link('', array('/'.$action, 'service' => $name), array(
                        'class' => 'auth-link ' . $service->id,
                    ), true);

                    echo $html;

                    echo '</li>';
                }
            ?>
        </ul>
    </div>

<?php else: ?>

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
                    <td class="form-settings_td"
                        <?php if ($us->urlString != ''): ?>
                            <?=CHtml::link($us->nameString, $us->urlString, array('target' => '_blank'))?>
                        <?php else: ?>
                            <?=$us->nameString?>
                        <?php endif; ?>
                    </td>
                    <td class="form-settings_td">
                        <a href="" class="a-pseudo-icon">
                            <span class="ico-close2"></span>
                            <span onclick="Settings.removeService(this, <?=$us->id?>, '<?=$service->id?>')" class="a-pseudo-icon_tx">
                        </a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table>
    <?php endif; ?>

    <div class="form-settings_t">Добавить профиль</div>

    <div class="margin-b30 clearfix">
    <?php foreach ($services as $name => $service): ?>
        <a href="<?=Yii::app()->createUrl('/' . $action, array('service' => $name, 'settings' => true))  ?>" class="b-social-big" <?php if(UserSocialService::model()->findByUser($name, Yii::app()->user->id) !== null): ?> style="display: none;"<?php endif; ?>>
            <span class="b-social-big_ico <?=$service->id?>"></span>
        </a>
    <?php endforeach; ?>
    </div>

<?php endif; ?>