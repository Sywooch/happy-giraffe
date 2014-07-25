<?php
/**
 * @var CActiveDataProvider $dataProvider
 * @var $this NewCommentWidget
 */
//if (!Yii::app()->user->isGuest || $this->beginCache('comments'. $this->entity . $this->entity_id, array(
//    'duration' => 36000,
//    'dependency' => $this->getCacheDependency(),
//))){

    $comments = $this->getComments();
NotificationRead::getInstance()->SetVisited();
$allCount = ($this->full) ? count($comments) : $this->model->getCommentsCount();
$data = array(
    'entity' => $this->entity,
    'entity_id' => (int)$this->entity_id,
    'objectName' => $this->objectName,
    'comments' => Comment::getViewData($comments, $this->isSummaryPhotoComments()),
    'full' => (bool)$this->full,
    'gallery' => (bool)$this->gallery,
    'allCount' => (int)$allCount,
    'messaging__enter' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__enter', false),
);

//помечаем комментарии как прочитанные
foreach($comments as $comment)
    NotificationRead::getInstance()->addShownComment($comment);
NotificationRead::getInstance()->SetVisited();

?>
<!-- ko stopBinding: true -->
<div class="comments-gray <?=$this->objectName ?><?php if ($this->full): ?> comments-gray__wide<?php endif; ?>" id="<?=$this->objectName ?>" style="display: none" data-bind="visible: true, baron: extended">
    <?php if ($this->entity == 'Service' && $this->entity_id == 9): ?>
        <?php Yii::app()->controller->renderPartial('//banners/_route'); ?>
    <?php endif; ?>
    <div id="comment_list"></div>

    <!-- ko if: full() && (comments().length == 0 || comments().length > 10) -->
    <?php if (!Yii::app()->user->isGuest && !$this->gallery):?>
        <div class="comments-gray_add comments-gray_add__top clearfix" data-bind="css: {active: opened() === $root.OPENED_TOP}">
            <div class="comments-gray_ava">
                <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 40)) ?>
            </div>
            <div class="comments-gray_frame">
                <input type="text" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий" data-bind="click: function() {openComment($root.OPENED_TOP)}, visible: opened() !== $root.OPENED_TOP">
                <!-- ko if: opened() === $root.OPENED_TOP -->
                <div class="wysiwyg-h">
                    <div class="wysiwyg-toolbar"><div class="wysiwyg-toolbar-btn"></div></div>
                    <div id="add_top_<?=$this->objectName ?>" data-bind="enterKey: Enter"></div>
                </div>
                <div class="redactor-control clearfix">

                    <div class="float-r">
                        <div class="redactor-control_key">
                            <input type="checkbox" class="redactor-control_key-checkbox" id="redactor-control_key-checkbox"  data-bind="checked: enterSetting, click: focusEditor"> <label class="redactor-control_key-label" for="redactor-control_key-checkbox">Enter - отправить</label>
                        </div>

                        <button class="btn-green" data-bind="click: addComment">Отправить</button>
                    </div>

                </div>
                <!-- /ko -->
            </div>
        </div>
    <?php else: ?>
        <div class="comments-gray_add comments-gray_add__top clearfix">
            <div class="comments-gray_ava">
                <span class="ava middle">
                    <span class="icon-status status-online"></span>
                </span>
            </div>
            <div class="comments-gray_frame">
                <input type="text" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий" onfocus="$('[href=#loginWidget]').trigger('click')">
            </div>
        </div>
    <?php endif ?>
    <!-- /ko -->

    <!-- ko if: comments().length > 0 -->

    <div class="comments-gray_t">

        <span class="comments-gray_t-tx">Комментарии <span class="color-gray" data-bind="text: '(' + allCount() + ')'"></span></span>
        <!-- ko if: ! full() && comments().length > 3 -->
            <a class="a-pseudo font-small" data-bind="click: toggleExtended, text: extended() ? 'Скрыть все' : 'Показать все'"></a>
        <!-- /ko -->

    </div>

    <div class="scroll" data-bind="css: { 'scroll__on' : extended }">
        <div class="comments-gray_hold scroll_scroller" data-bind="visible: comments().length > 0, css: { 'comments-gray_hold__scroll' : extended }">

            <div data-bind="visible: false">
            <?php foreach ($comments as $comment): ?>
                <div class="comments-gray_i">
                    <div class="comments-gray_frame">
                        <div class="comments-gray_header clearfix"><?=$comment->author->getFullName() ?></div>
                        <div class="comments-gray_cont wysiwyg-content">
                            <div><?=$comment->purified->text ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>

            <!-- ko foreach: commentsToShow -->
            <div class="comments-gray_i" data-bind="css: {'comments-gray_i__self': ownComment(), 'comments-gray_i__recovery': removed(), 'comments-gray_i__pink' : specialistLabel() !== null}, attr: {id: 'comment_'+id()}">

                <div class="comments-gray_ava">
                    <!-- ko if: author.deleted() == 0 -->
                    <a class="ava middle" href="" data-bind="css: author.avatarClass(), attr:{href: author.url()}">
                        <img data-bind="attr : { src : author.avatar() }">
                    </a>
                    <!-- /ko -->
                    <!-- ko if: author.deleted() != 0 -->
                    <span class="ava middle" data-bind="css: author.avatarClass()">
                        <img data-bind="attr : { src : author.avatar() }">
                    </span>
                    <!-- /ko -->
                </div>

                <div class="comments-gray_r">
                    <div class="comments-gray_date" data-bind="moment: created"></div>

                    <div class="comments-gray_control" data-bind="css: {'comments-gray_control__self': ownComment()}, visible: (!editMode() && !removed())">
                        <div class="comments-gray_control-hold">
                            <a class="comments-gray_quote-ico powertip" data-bind="visible: (!ownComment() && !$parent.gallery() && !photoUrl()), click: Reply, tooltip: 'Ответить'"></a>
                            <a class="message-ico message-ico__edit powertip" data-bind="visible: canEdit() && !$parent.gallery() && !photoUrl(), click: GoEdit, tooltip: 'Редактировать'"></a>
                            <a class="message-ico message-ico__del powertip" data-bind="visible: canRemove(), click: Remove, tooltip: 'Удалить'"></a>
                        </div>
                    </div>

                </div>

                <div class="comments-gray_frame">
                    <div class="comments-gray_header clearfix">
                        <!-- ko if: author.deleted() == 0 -->
                        <a href="" class="comments-gray_author" data-bind="text: author.fullName(), attr:{href: author.url()}"></a>
                        <!-- /ko -->
                        <!-- ko if: author.deleted() != 0 -->
                        <span class="comments-gray_author" data-bind="text: author.fullName()"></span>
                        <!-- /ko -->
                        <!-- ko if: specialistLabel() !== null -->
                        <span class="comments-gray_spec" data-bind="text: specialistLabel"></span>
                        <!-- /ko -->
                        <a class="comments-gray_like like-hg-small powertip" href="" data-bind="text:likesCount, css:{active: userLikes, hide: (likesCount() == 0)}, click:Like, tooltip: 'Нравится'"></a>
                    </div>

                    <div class="comments-gray_cont wysiwyg-content" data-bind="visible: !removed() && !editMode()">
                        <div class="clearfix" data-bind="visible: albumPhoto()">
                            <div class="comments-gray_photo">
                                <img src="" class="comments-gray_photo-img" data-bind="attr: {src: photoUrl}">
                                <div class="comments-gray_photo-overlay">
                                    <span class="comments-gray_photo-zoom" data-bind="click: openGallery"></span>
                                </div>
                            </div>
                        </div>
                        <div data-bind="html: html"></div>
                    </div>

                    <div class="comments-gray_cont wysiwyg-content" data-bind="visible: removed()">
                        <p>Комментарий успешно удален. <a href="" class="comments-gray_a-recovery" data-bind="click: Restore">Восстановить?</a> </p>
                    </div>

                    <!-- ko if: editMode() -->
                    <?php if (!$this->gallery):?>

                        <div class="wysiwyg-h">
                            <div class="wysiwyg-toolbar"><div class="wysiwyg-toolbar-btn"></div></div>
                            <div class="js-edit-field" data-bind="attr: {id: 'text' + id()}, html: editHtml, enterKey: Enter"></div>
                        </div>

                        <div class="redactor-control clearfix">
                            <div class="redactor-control_key">
                                <input type="checkbox" class="redactor-control_key-checkbox" id="redactor-control_key-checkbox"  data-bind="checked: $parent.enterSetting, click: $parent.focusEditor"> <label class="redactor-control_key-label" for="redactor-control_key-checkbox">Enter - отправить</label>
                            </div>
                            <button class="btn-green" data-bind="click: Edit">Отправить</button>
                        </div>
                    <?php else: ?>
                        <input type="text" class="comments-gray_add-itx itx-gray" data-bind="attr: {id: 'text' + id()}, html: html, enterKey: Enter">
                    <?php endif ?>
                    <!-- /ko -->

                </div>
            </div>

            <?php if (!Yii::app()->user->isGuest && !$this->gallery):?>
                <!-- ko if: $data == $root.response() -->
                <div class="comments-gray_add clearfix">
                    <div class="comments-gray_ava">
                        <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 40)) ?>
                    </div>
                    <div class="comments-gray_frame">
                        <div class="wysiwyg-h">
                            <a class="wysiwyg-toolbar_close ico-close3" data-bind="click: $root.cancelReply, tooltip: 'Отменить ответ'"></a>
                            <div class="wysiwyg-toolbar"><div class="wysiwyg-toolbar-btn"></div></div>
                            <div data-bind="enterKey: $root.Enter, attr: { id : 'reply_' + id() }"></div>
                        </div>
                        <div class="redactor-control clearfix">

                            <div class="float-r">
                                <div class="redactor-control_key">
                                    <input type="checkbox" class="redactor-control_key-checkbox" id="redactor-control_key-checkbox"  data-bind="checked: $root.enterSetting, click: $root.focusEditor"> <label class="redactor-control_key-label" for="redactor-control_key-checkbox">Enter - отправить</label>
                                </div>

                                <button class="btn-green" data-bind="click: $root.addComment">Отправить</button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /ko -->
            <?php endif; ?>
            <!-- /ko -->
        </div>
        <div class="scroll_bar-hold">
            <div class="scroll_bar">
                <div class="scroll_bar-in"></div>
            </div>
        </div>
    </div>

    <!-- /ko -->

    <!-- ko if: ! full() || comments().length > 0 -->
    <?php if (!Yii::app()->user->isGuest && !$this->gallery):?>
        <div class="comments-gray_add clearfix" data-bind="css: {active: opened === $root.OPENED_BOT}">
            <div class="comments-gray_ava">
                <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 40)) ?>
            </div>
            <div class="comments-gray_frame">
                <input type="text" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий" data-bind="click: function() {openComment($root.OPENED_BOT)}, visible: opened() !== $root.OPENED_BOT">
                <!-- ko if: opened() === $root.OPENED_BOT -->
                <div class="wysiwyg-h">
                    <div class="wysiwyg-toolbar"><div class="wysiwyg-toolbar-btn"></div></div>
                    <div id="add_<?=$this->objectName ?>" data-bind="enterKey: Enter"></div>
                </div>
                <div class="redactor-control clearfix">

                    <div class="float-r">
                        <div class="redactor-control_key">
                            <input type="checkbox" class="redactor-control_key-checkbox" id="redactor-control_key-checkbox"  data-bind="checked: enterSetting, click: focusEditor"> <label class="redactor-control_key-label" for="redactor-control_key-checkbox">Enter - отправить</label>
                        </div>

                        <button class="btn-green" data-bind="click: addComment">Отправить</button>
                    </div>

                </div>
                <!-- /ko -->
            </div>
        </div>
    <?php endif ?>
    <!-- /ko -->

    <!-- ko if: ! full() && comments().length > 3 && extended() -->
    <div class="textalign-c margin-t10">
        <a class="a-pseudo font-small" data-bind="click: toggleExtended">Скрыть все</a>
    </div>
    <!-- /ko -->
</div>
<!-- /ko -->

    <script type="text/javascript">
        $(function() {
            var viewModel = new CommentViewModel(<?=CJSON::encode($data)?>);
            $('.'+'<?=$this->objectName ?>').each(function(index, el) {
                ko.applyBindings(viewModel, el);
            });
        });
    </script>

<?php //if (Yii::app()->user->isGuest) $this->endCache();} ?>