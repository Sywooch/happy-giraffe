<?php
/**
 * @var $contents CActiveDataProvider
 */
Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
?>

<?php if ($contents->totalItemCount > 0): ?>
    <?php
        $this->widget('zii.widgets.CListView', array(
            'cssFile' => false,
            'ajaxUpdate' => false,
            'dataProvider' => $contents,
            'itemView' => 'view',
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
        ));
    ?>
<?php else: ?>
    <?php if ($this->rubric_id !== null): ?>
        <div class="cap-empty cap-empty__rel">
            <div class="cap-empty_hold">
                <div class="cap-empty_tx">В данной рубрике нет ни одной записи.</div>
                <?php if ($this->user->id == Yii::app()->user->id): ?>
                    <a class="cap-empty_a padding-r20 fancy-top" href="<?=$this->createUrl('/blog/default/form', array('type' => 1))?>">Добавить запись</a>
                    <a class="cap-empty_a color-gray" href="javascript:void(0)" onclick="removeBlogRubric(<?=$this->rubric_id ?>)">Удалить рубрику</a>
                <?php endif; ?>
            </div>
        </div>
        <script type="text/javascript">
            function removeBlogRubric(id) {
                $.post('/newblog/removeRubric/', {id:id}, function (response) {
                    if (response.status) {
                        window.location.href = '<?=$this->user->getBlogUrl() ?>';
                    }
                }, 'json');
            }
        </script>
    <?php elseif($this->user->id == Yii::app()->user->id): ?>
        <div class="cap-empty cap-empty__blog">
            <div class="cap-empty_hold">
                <div class="cap-empty_tx margin-b10">В вашем блоге пока нет записей.</div>
                <div class="cap-empty_gray">Будьте активны! Добавляйте записи, фото, видео.</div>
                <a href="<?=$this->createUrl('/blog/default/form', array('type' => 1))?>" class="btn-blue btn-h46 margin-t15 fancy-top">Добавить запись</a>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>