<?php
/**
 * @var HController $this
 */

Yii::app()->clientScript->registerPackage('ko_antispam');
?>

<?php $this->beginContent('//layouts/new/common'); ?>
    <!-- header-->
    <div class="header header__small">
        <div class="header_hold clearfix">
            <!-- logo__small-->
            <div class="logo logo__small"><a title="Веселый жираф - сайт для всей семьи" href="" class="logo_i">Веселый жираф - сайт для всей семьи</a></div>
            <div class="header_t-big">Модератор</div>
            <div class="header_user">
                <?php $this->widget('site.frontend.widgets.userAvatarWidget.Avatar', array('user' => Yii::app()->user->model, 'size' => 40)); ?>
                <a class="header_user-name" href="<?=Yii::app()->user->model->getUrl()?>"><?=Yii::app()->user->model->getFullName()?></a>
            </div>
        </div>
    </div>
    <!-- /header-->
    <div class="layout-wrapper">
        <div class="layout-wrapper_frame clearfix">
            <!-- side-menu-->
            <div class="side-menu side-menu__antispam">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array(
                        'class' => 'side-menu_ul',
                    ),
                    'encodeLabel' => false,
                    'items' => array(
                        array(
                            'url' => array('/antispam/default/live'),
                            'itemOptions' => array('class' => 'side-menu_li' . ($this->counts[DefaultController::TAB_CHECKS_LIVE] > 0 ? '' : ' disabled')),
                            'linkOptions' => array('class' => 'side-menu_i'),
                            'label' => $this->renderPartial('_menu_item', array(
                                'label' => 'Прямой эфир',
                                'ico' => 'broadcast',
                                'count' => $this->counts[DefaultController::TAB_CHECKS_LIVE],
                            ), true),
                        ),
                        array(
                            'url' => array('/antispam/default/expert'),
                            'itemOptions' => array('class' => 'side-menu_li' . ($this->counts[DefaultController::TAB_EXPERT] > 0 ? '' : ' disabled')),
                            'linkOptions' => array('class' => 'side-menu_i'),
                            'label' => $this->renderPartial('_menu_item', array(
                                'label' => 'Эксперт',
                                'ico' => 'expert',
                                'count' => $this->counts[DefaultController::TAB_EXPERT],
                                'sub' => false,
                            ), true),
                        ),
                        array(
                            'url' => array('/antispam/default/deleted'),
                            'itemOptions' => array('class' => 'side-menu_li' . ($this->counts[DefaultController::TAB_CHECKS_BAD] > 0 ? '' : ' disabled')),
                            'linkOptions' => array('class' => 'side-menu_i'),
                            'label' => $this->renderPartial('_menu_item', array(
                                'label' => 'Удалено',
                                'ico' => 'deleted',
                                'count' => $this->counts[DefaultController::TAB_CHECKS_BAD],
                            ), true),
                        ),
                        array(
                            'url' => array('/antispam/default/questionable'),
                            'itemOptions' => array('class' => 'side-menu_li' . ($this->counts[DefaultController::TAB_CHECKS_QUESTIONABLE] > 0 ? '' : ' disabled')),
                            'linkOptions' => array('class' => 'side-menu_i'),
                            'label' => $this->renderPartial('_menu_item', array(
                                'label' => 'Под вопросом',
                                'ico' => 'question',
                                'count' => $this->counts[DefaultController::TAB_CHECKS_QUESTIONABLE],
                            ), true),
                        ),
                        array(
                            'url' => array('/antispam/default/usersList', 'status' => AntispamStatusManager::STATUS_WHITE),
                            'itemOptions' => array('class' => 'side-menu_li' . ($this->counts[DefaultController::TAB_USERS_WHITE] > 0 ? '' : ' disabled')),
                            'linkOptions' => array('class' => 'side-menu_i'),
                            'label' => $this->renderPartial('_menu_item', array(
                                'label' => 'Белый список',
                                'ico' => 'ul-white',
                                'count' => $this->counts[DefaultController::TAB_USERS_WHITE],
                            ), true),
                        ),
                        array(
                            'url' => array('/antispam/default/usersList', 'status' => AntispamStatusManager::STATUS_BLACK),
                            'itemOptions' => array('class' => 'side-menu_li' . ($this->counts[DefaultController::TAB_USERS_BLACK] > 0 ? '' : ' disabled')),
                            'linkOptions' => array('class' => 'side-menu_i'),
                            'label' => $this->renderPartial('_menu_item', array(
                                'label' => 'Черный список',
                                'ico' => 'ul-black',
                                'count' => $this->counts[DefaultController::TAB_USERS_BLACK],
                            ), true),
                        ),
                        array(
                            'url' => array('/antispam/default/usersList', 'status' => AntispamStatusManager::STATUS_BLOCKED),
                            'itemOptions' => array('class' => 'side-menu_li' . ($this->counts[DefaultController::TAB_USERS_BLOCKED] > 0 ? '' : ' disabled')),
                            'linkOptions' => array('class' => 'side-menu_i'),
                            'label' => $this->renderPartial('_menu_item', array(
                                'label' => 'Блок',
                                'ico' => 'block',
                                'count' => $this->counts[DefaultController::TAB_USERS_BLOCKED],
                            ), true),
                        ),
                    ),
                ));
                ?>
            </div>
            <!-- /side-menu-->
            <?=$content?>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('a:not([href*="/antispam"])').attr('target', '_blank');
        });
    </script>
<?php $this->endContent(); ?>