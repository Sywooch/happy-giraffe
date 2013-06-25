<?php
/**
 * @var CActiveDataProvider $dataProvider
 * @var $this NewCommentWidget
 */
NotificationRead::getInstance()->SetVisited();
$allCount = ($this->full) ? count($comments) : $this->model->commentsCount;
$data = array(
    'entity' => $this->entity,
    'entity_id' => (int)$this->entity_id,
    'objectName' => $this->objectName,
    'comments' => Comment::getViewData($comments),
    'full' => (bool)$this->full,
    'allCount' => (int)$allCount,
);

$this->widget('site.common.extensions.imperavi-redactor-widget.ImperaviRedactorWidget', array('onlyRegisterScript' => true));
?>
<div class="comments-gray" id="<?= $this->objectName ?>">
    <div class="comments-gray_t">

        <?php if ($this->full || $allCount <= 3): ?>
            <span class="comments-gray_t-a-tx">Все комментарии (<span data-bind="text:allCount"></span>)</span>
            <!-- ko if: allCount() >= 10 -->
            <a href="" class="btn-green" data-bind="click: goBottom">Добавить</a>
            <!-- /ko -->
        <?php else: ?>
            <a href="<?= $this->model->getUrl() ?>" class="comments-gray_t-a">
                <span class="comments-gray_t-a-tx">Все комментарии (<span data-bind="text:allCount"></span>)</span>
                <a href="" class="btn-green" data-bind="click: goBottom">Добавить</a>
            </a>
        <?php endif ?>

    </div>

    <div class="comments-gray_hold">

        <!-- ko foreach: comments -->
        <div class="comments-gray_i" data-bind="css: {'comments-gray_i__self': ownComment()}">

            <!-- ko if: !removed() -->

            <a class="comments-gray_like like-hg-small" href="" data-bind="text:likesCount, css:{active: userLikes, hide: (likesCount() == 0)}, click:Like"></a>

            <div class="comments-gray_ava">
                <a class="ava small" href="" data-bind="css: author.avatarClass(), attr:{href: author.url()}">
                    <img data-bind="attr : { src : author.avatar() }">
                </a>
            </div>

            <div class="comments-gray_frame">
                <div class="comments-gray_header clearfix">
                    <a href="" class="comments-gray_author" data-bind="text: author.fullName(), attr:{href: author.url()}"></a>
                    <span class="font-smallest color-gray" data-bind="text: created"></span>
                </div>

                <div class="comments-gray_cont wysiwyg-content" data-bind="html: html, visible: !editMode()"></div>
                <!-- ko if: editMode() -->
                <input class="js-edit-field" type="text" data-bind="attr: {id:'text'+id()}">
                <a href="" data-bind="click: Edit">изменить</a>
                <!-- /ko -->

            </div>

            <div class="comments-gray_control" data-bind="css: {'comments-gray_control__self': ownComment()}">
                <div class="comments-gray_control-hold">
                    <!-- ko if: !ownComment() -->
                    <div class="clearfix">
                        <a href="" class="comments-gray_quote-ico powertip" title="Ответить" data-bind="click: Reply"></a>
                    </div>
                    <!-- /ko -->

                    <!-- ko if: canEdit() -->
                    <div class="clearfix">
                        <a href="" class="message-ico message-ico__edit powertip" title="Изменить" data-bind="click: GoEdit"></a>
                    </div>
                    <!-- /ko -->

                    <!-- ko if: canRemove() -->
                    <div class="clearfix">
                        <a href="" class="message-ico message-ico__del powertip" title="Удалить" data-bind="click: Remove"></a>
                    </div>
                    <!-- /ko -->

                </div>
            </div>

            <!-- /ko -->

            <!-- ko if: removed() -->
            <p>Комментарий успешно удален.<a href="" class="comments-gray_a-recovery" data-bind="click: Restore">Восстановить?</a> </p>
            <!-- /ko -->

        </div>
        <!-- /ko -->

    </div>

    <div class="comments-gray_add clearfix">
        <div class="comments-gray_ava">
            <?php $this->widget('UserAvatarWidget', array('user' => Yii::app()->user->getModel(), 'size' => 'micro')) ?>
        </div>
        <div class="comments-gray_frame">
            <input type="text" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий" data-bind="click:openComment, visible: !opened()">
            <input type="text" id="new<?=$this->objectName ?>" data-bind="visible: opened()">
            <a href="" data-bind="click: addComment, visible: opened()">добавить</a>
        </div>
    </div>

</div>
<script type="text/javascript">
    var CURRENT_USER_ID = <?=Yii::app()->user->id ?>;
    $(function () {
        var viewModel = new CommentViewModel(<?=CJSON::encode($data)?>);
        ko.applyBindings(viewModel, document.getElementById('<?=$this->objectName ?>'));
    });
</script>