<?php $this->beginContent('//layouts/new'); ?>

    </div>
    <div class="nav-hor clearfix">
        <?php $this->widget('zii.widgets.CMenu', array(
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'nav-hor_ul'),
            'itemCssClass' => 'nav-hor_li',
            'items' => array(
                array(
                    'label' => '<span class="nav-hor_tx"><span class="ico-best ico-best__interest"></span>Самое интересное</span>',
                    'url' => array('/best/default/index'),
                    'linkOptions' => array('class' => 'nav-hor_i'),
                    'active' => (Yii::app()->controller->action->id == 'index')
                ),
                array(
                    'label' => '<span class="nav-hor_tx"><span class="ico-best ico-best__blog"></span>Блоги на главную</span>',
                    'url' => array('/best/default/blogs'),
                    'linkOptions' => array('class' => 'nav-hor_i'),
                    'active' => (Yii::app()->controller->action->id == 'blogs')
                ),
                array(
                    'label' => '<span class="nav-hor_tx"><span class="ico-best ico-best__social"></span>Посты в соцсети</span>',
                    'url' => array('/best/default/social'),
                    'linkOptions' => array('class' => 'nav-hor_i'),
                    'active' => (Yii::app()->controller->action->id == 'social')
                ),
                array(
                    'label' => '<span class="nav-hor_tx"><span class="ico-best ico-best__mail"></span>Посты в рассылку</span>',
                    'url' => array('/best/default/email'),
                    'linkOptions' => array('class' => 'nav-hor_i'),
                    'active' => (Yii::app()->controller->action->id == 'email')
                ),
            ),
        ));?>
    </div>

<?= $content; ?>

<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
    <script type="text/javascript">
        var EditFavourites = {
            remove: function (id, el) {
                $.post('/best/remove/', {id: id}, function (response) {
                    if (response.status) {
                        $(el).parents('li').remove();
                    }
                }, 'json');
            }
        }
    </script>

<?php $this->endContent(); ?>