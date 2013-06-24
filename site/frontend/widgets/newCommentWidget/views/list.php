<?php
/**
 * @var CActiveDataProvider $dataProvider
 * @var $this NewCommentWidget
 */
NotificationRead::getInstance()->SetVisited();
$data = array(
    'entity'=>$this->entity,
    'entity_id'=>$this->entity_id,
    'comments' => Comment::getViewData($dataProvider)
);
?>
<div class="comments-gray" id="<?=$this->objectName ?>">
    <!-- ko if: getCount() > 0 -->
    <div class="comments-gray_t">

        <?php if ($this->full):?>
            <span class="comments-gray_t-a-tx">Все комментарии (<span data-bind="text:getCount"></span>)</span>
        <?php else: ?>
            <a href="<?= $this->model->getUrl() ?>" class="comments-gray_t-a">
                <span class="comments-gray_t-a-tx">Все комментарии (<span data-bind="text:getCount"></span>)</span>
            </a>
        <?php endif ?>

    </div>
    <!-- /ko -->

    <!-- ko foreach: comments -->
    <div class="comments-gray_hold">
        <div class="comments-gray_i" data-bind="css: { comments-gray_i__self: own}">

            <a href="" data-bind="text:likesCount, css:{active: userLikes}"></a>

            <div class="comments-gray_ava">
                <?php //$this->widget('UserAvatarWidget', array('user' => $data->author, 'size' => 'micro')) ?>
            </div>

            <div class="comments-gray_frame">
                <div class="comments-gray_header clearfix">
                    <a href="" class="comments-gray_author" data-bind="text: author_name, href: author_url"></a>
                    <span class="font-smallest color-gray" data-bind="text: created"></span>
                </div>
                <div class="comments-gray_cont wysiwyg-content" data-bind="html:html"></div>
            </div>

        </div>
    </div>
    <!-- /ko -->

    <?php //$this->render('form'); ?>

</div>
<script type="text/javascript">
    $(function() {
        var viewModel = new CommentViewModel(<?=$data?>);
        ko.applyBindings(viewModel, document.getElementById('<?=$this->objectName ?>'));
    });
</script>