<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common_menu');
?>

    <div class="b-main clearfix">
        <div class="b-consult">
            <div class="b-main_cont">
                <?php if ($this->breadcrumbs): ?>
                    <div class="b-crumbs b-crumbs__s<?php if ($this->adaptiveBreadcrumbs): ?> visible-md visible-lg<?php endif; ?>">
                        <div class="b-crumbs_tx">Я здесь:</div>
                        <?php
                        $this->widget('\site\frontend\components\lite\UserBreadcrumbs', array(
                            'user' => $this->owner,
                            'tagName' => 'ul',
                            'separator' => ' ',
                            'htmlOptions' => array('class' => 'b-crumbs_ul'),
                            'homeLink' => false,
                            'activeLinkTemplate' => '<li class="b-crumbs_li"><a href="{url}" class="b-crumbs_a">{label}</a></li>',
                            'inactiveLinkTemplate' => '<li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last">{label}</span></li>',
                            'links' => $this->breadcrumbs,
                            'encodeLabel' => false,
                        ));
                        ?>
                    </div>
                <?php endif; ?>

                <div class="b-main_col-hold clearfix">
                    <?=$content?>
                </div>
            </div>
        </div>
    </div>

<?php $this->endContent(); ?>
