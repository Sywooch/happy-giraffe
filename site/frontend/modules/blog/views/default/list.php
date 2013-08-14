<?php
/**
 * @var $contents CActiveDataProvider
 */
Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

if ($contents->totalItemCount > 0 || empty($this->rubric_id))
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
else {
    ?>
    <div class="cap-empty cap-empty__rel">
        <div class="cap-empty_hold">
            <div class="cap-empty_tx">В данной рубрике нет ни одной записи.</div>
            <?php if ($this->user->id == Yii::app()->user->id): ?>
                <a class="cap-empty_a padding-r20" href="javascript:;" onclick="$('.user-add-record_ico__article').click();">Добавить запись</a>
                <a class="cap-empty_a color-gray" href="javascript:;" onclick="removeBlogRubric(<?=$this->rubric_id ?>)">Удалить рубрику</a>
            <?php endif ?>
        </div>
    </div>
    <script type="text/javascript">
        function removeBlogRubric(id) {
            $.post('/newblog/removeRubric/', {id:id}, function (response) {
                if (response.status) {
                    window.location.href = '<?=$this->user->url ?>';
                }
            }, 'json');
        }
    </script>
<?php }