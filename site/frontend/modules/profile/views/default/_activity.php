<?php
/**
 * @var $dataProvider CActiveDataProvider
 */
if ($dataProvider->totalItemCount > 0):
    $this->widget('zii.widgets.CListView', array(
        'cssFile' => false,
        'ajaxUpdate' => false,
        'dataProvider' => $dataProvider,
        'itemView' => 'blog.views.default.view',
        'pager' => array(
            'class' => 'HLinkPager',
        ),
        'template' => '{items}
        <div class="yiipagination">
            {pager}
        </div>
    ',
        'emptyText' => '',
        'viewData' => array('full' => false),
    )); else: ?>
    <div class="cap-empty cap-empty__blog">
        <div class="cap-empty_hold">
            <div class="cap-empty_tx margin-b10">У вас пока нет записей.</div>
            <div class="cap-empty_gray">Будьте активны! Добавляйте записи, фото, видео.</div>
            <a href="<?= $this->createUrl('/blog/default/form', array('type' => 1)) ?>" class="btn-blue btn-h46 margin-t15 fancy-top">Добавить запись</a>
        </div>
    </div>
<?php endif; ?>