<?php if ($this->mode == 'vote'): ?>

<div class="services">
    <ul class="auth-services">
        <?php


        foreach ($services as $name => $service) {
            echo '<li class="auth-service ' . $service->id . '">';
            $html = HHtml::link($service->id . '[' . Rating::model()->countByEntity($this->params['model'], Rating::getShort($service->id)) . ']', Yii::app()->createUrl('/'.$action, array('service' => $name, 'entity_id' => $this->params['entity_id'], 'entity' => $this->params['entity'])), array(
                'class' => 'auth-link ' . $service->id,
            ), true);

            echo $html;

            echo '</li>';
        }
        ?>
    </ul>
</div>

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
                <div class="col col-3">Удалить профиль </div>

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