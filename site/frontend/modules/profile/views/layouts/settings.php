<?php
/**
 * @var User $user
 */
$user = $this->user;
$this->beginContent('//layouts/main'); ?>
    <div class="content-cols">
        <div class="col-1">
            <?php $this->widget('Avatar', array('user' => $user, 'size' => 200, 'location' => true)) ?>
        </div>

        <div class="col-23-middle clearfix">

            <div class="heading-title clearfix">
                Мои настройки
            </div>

            <div class="col-gray">

                <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Личные данные',
                            'url' => array('/profile/settings/personal'),
                            'linkOptions' => array('class' => 'cont-nav_a'),
                            'itemOptions' => array('class' => 'cont-nav_i'),
                        ),
                        array(
                            'label' => 'Социальные сети',
                            'url' => array('/profile/settings/social'),
                            'linkOptions' => array('class' => 'cont-nav_a'),
                            'itemOptions' => array('class' => 'cont-nav_i'),
                        ),
                        array(
                            'label' => 'Пароль',
                            'url' => array('/profile/settings/password'),
                            'linkOptions' => array('class' => 'cont-nav_a'),
                            'itemOptions' => array('class' => 'cont-nav_i'),
                        ),
                    ),
                    'linkLabelWrapper'=>'div',
                    'htmlOptions'=>array('class'=>'cont-nav textalign-l')
                ));
                ?>
                <div class="form-settings">
                    <?= $content ?>
                </div>

            </div>
        </div>
    </div>

<?php $this->endContent(); ?>