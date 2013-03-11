<?php if ($this->mode == 'vote'): ?>

    <?php $this->controller->beginWidget('SeoContentWidget'); ?>

        <div class="share_button auth-service facebook">
            <?php if (false): ?>
                <div class="custom-like-fb">
                    <a href="<?=Yii::app()->createUrl('/'.$action, array('service' => 'facebook', 'entity_id' => $this->params['entity_id'], 'entity' => $this->params['entity']))?>" class="custom-like-fb-text">
                        <i class="icon-fb"></i>Мне нравится
                    </a>
                    <div class="custom-like-fb-share-count"><?=Rating::model()->countByEntity($this->params['model'], 'fb')?></div>
                </div>
            <?php endif; ?>
        </div>

        <div class="share_button auth-service vkontakte">
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

        <div class="profiles-list">

            <div class="list-title clearfix">

                <div class="col col-1">Социальная сеть</div>
                <div class="col col-2">Имя</div>
                <div class="col col-3">Удалить профиль</div>

            </div>

            <ul>
                <?php foreach ($services as $name => $service): ?>
                    <?php if(($us = UserSocialService::model()->findByUser($name, Yii::app()->user->id)) != null): ?>
                        <li class="clearfix">
                            <div class="col col-1"><span class="social-logo <?=$service->id?>"></span></div>
                            <div class="col col-2">
                                <?php if ($us->urlString != ''): ?>
                                    <?=CHtml::link($us->nameString, $us->urlString, array('target' => '_blank'))?>
                                <?php else: ?>
                                    <?=$us->nameString?>
                                <?php endif; ?>
                            </div>
                            <div class="col col-3"><a href="javascript:void(0)" onclick="Settings.removeService(this, <?=$us->id?>, '<?=$service->id?>')" class="btn-remove"><i class="icon"></i>Удалить</a></div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

        </div>

    <?php endif; ?>

    <div class="add-profile">

        <div class="block-title">Добавить профиль</div>

        <ul class="auth-services">
            <?php foreach ($services as $name => $service): ?>
                <li class="auth-service <?=$service->id?>"<?php if(UserSocialService::model()->findByUser($name, Yii::app()->user->id) !== null): ?> style="display: none;"<?php endif; ?>>
                    <?=HHtml::link('', array('/' . $action, 'service' => $name, 'settings' => true), array(
                        'class' => 'auth-link ' . $service->id,
                    ), true)?>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>

<?php endif; ?>