<?php if ($this->mode !== 'profile'): ?>

    <div class="services">
        <ul class="auth-services">
            <?php
            foreach ($services as $name => $service) {
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

    <div class="profiles-list">

        <div class="list-title clearfix">

            <div class="col col-1">Социальная сеть</div>
            <div class="col col-2">Имя</div>
            <div class="col col-3">Удалить профиль </div>

        </div>

        <ul>
            <?php foreach ($services as $name => $service): ?>
                <?php if(UserSocialService::model()->findByUser($name, Yii::app()->user->id) != null): ?>
                    <li class="clearfix">
                        <div class="col col-1"><span class="social-logo <?=$service->id?>"></span></div>
                        <div class="col col-2"><a href="">Александр Кувыркин</a></div>
                        <div class="col col-3"><a href="" class="btn-remove"><i class="icon"></i>Удалить профиль</a></div>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

    </div>

    <div class="add-profile">

        <div class="block-title">Добавить профиль</div>

        <ul class="auth-services">
            <?php foreach ($services as $name => $service): ?>
                <?php if(UserSocialService::model()->findByUser($name, Yii::app()->user->id) === null): ?>
                    <li class="auth-service <?=$service->id?>">
                        <?=HHtml::link('', array('/' . $action, 'service' => $name), array(
                            'class' => 'auth-link ' . $service->id,
                        ), true)?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

    </div>

<?php endif; ?>