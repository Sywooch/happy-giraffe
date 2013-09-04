<?php
/**
 * @var $this UserController
 * @var $data Album
 * @var $full bool
 */
?>
<div class="photo-preview-row clearfix margin-t30">
    <?php $this->widget('UserPhotosWidget', array('userId' => $user_id));?>
</div>

<?php
$this->widget('zii.widgets.CListView', array(
    'cssFile' => false,
    'ajaxUpdate' => false,
    'dataProvider' => $dataProvider,
    'itemView' => '_album',
    'viewData' => array(
        'full' => false,
    ),
    'pager' => array(
        'class' => 'HLinkPager',
    ),
    'template' => '{items}<div class="yiipagination">{pager}</div>',
));
