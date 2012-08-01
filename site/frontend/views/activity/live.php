<?php
    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
?>

<div class="clearfix">
    <div class="main">
        <div class="main-in">

            <div class="onair-title"><img src="/images/onair_title_big.png" />Прямой <span>эфир</span></div>

            <div id="contents_live" class="full">
                <?php
                    $this->widget('zii.widgets.CListView', array(
                        'ajaxUpdate' => false,
                        'dataProvider' => $live,
                        'itemView' => '//community/_post',
                        'template' => '{items}',
                        'viewData' => array(
                            'full' => false,
                        ),
                    ));
                ?>
            </div>

        </div>
    </div>

    <div class="side-left">

        <div class="banner">
            <?=$this->renderPartial('//_banner')?>
        </div>

    </div>
</div>

<?php
    if (!Yii::app()->user->isGuest) {
        $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
        $remove_tmpl->registerTemplates();
        $this->endWidget();
    }