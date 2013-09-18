<?php
/**
 * @var CActiveDataProvider $dataProvider
 * @var $this NewCommentWidget
 */
if (!Yii::app()->user->isGuest || $this->beginCache('comments'. $this->entity . $this->entity_id, array(
    'duration' => 36000,
    'dependency' => $this->getCacheDependency(),
))){

    $comments = $this->getComments();
NotificationRead::getInstance()->SetVisited();
$allCount = ($this->full) ? count($comments) : $this->model->commentsCount;
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
<div class="comments-gray <?=$this->objectName ?>" id="<?=$this->objectName ?>">
    <div id="comment_list"></div>
    <div class="comments-gray_t">

        <?php if ($this->full || $allCount <= 3): ?>
            <span class="comments-gray_t-a-tx" data-bind="visible: allCount() > 0">Все комментарии (<span data-bind="text:allCount"></span>)</span>
            <?php if ($this->full):?>
                <a href="" class="btn-green" data-bind="click: goBottom, visible: allCount() > 10">Добавить</a>
            <?php endif ?>
        <?php else: ?>
            <a href="<?= $this->model->getUrl(true) ?>" class="comments-gray_t-a">
                <span class="comments-gray_t-a-tx">Все комментарии (<span data-bind="text:allCount"></span>)</span>
                <?php if ($this->full):?>
                    <a href="" class="btn-green" data-bind="click: goBottom">Добавить</a>
                <?php endif ?>
            </a>
        <?php endif ?>

        <?php if (!empty($this->notice)):?>
            <div class="color-gray fontstyle-i margin-b5 margin-t10"><?=$this->notice ?></div>
        <?php endif ?>

    </div>


    <div class="comments-gray_hold" data-bind="visible: comments().length > 0">

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

        <!-- ko foreach: comments -->
        <div class="comments-gray_i" data-bind="css: {'comments-gray_i__self': ownComment(), 'comments-gray_i__recovery': removed()}, attr: {id: 'comment_'+id()}">

            <a class="comments-gray_like like-hg-small powertip" href="" data-bind="text:likesCount, css:{active: userLikes, hide: (likesCount() == 0)}, click:Like, tooltip: 'Нравится'"></a>

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
                        <div class="js-edit-field" data-bind="attr: {id: 'text' + id()}, html: editHtml, enterKey: Enter"></div>
                    </div>

                    <div class="redactor-control clearfix">
                        <div class="redactor-control_key">
                            <input type="checkbox" class="redactor-control_key-checkbox" id="redactor-control_key-checkbox"  data-bind="checked: $parent.enterSetting, click: $parent.focusEditor">
                            <label class="redactor-control_key-label" for="redactor-control_key-checkbox">Enter - отправить</label>
                        </div>
                        <button class="btn-green" data-bind="click: Edit">Отправить</button>
                    </div>
                <?php else: ?>
                    <input type="text" class="comments-gray_add-itx itx-gray" data-bind="attr: {id: 'text' + id()}, html: html, enterKey: Enter">
                <?php endif ?>
                <!-- /ko -->

            </div>

            <div class="comments-gray_control" data-bind="css: {'comments-gray_control__self': ownComment()}, visible: (!editMode() && !removed())">
                <div class="comments-gray_control-hold">

                    <div class="clearfix" data-bind="visible: (!ownComment() && !$parent.gallery() && !photoUrl())">
                        <a href="" class="comments-gray_quote-ico powertip" data-bind="click: Reply, tooltip: 'Ответить'"></a>
                    </div>

                    <div class="clearfix" data-bind="visible: canEdit() && !$parent.gallery() && !photoUrl()">
                        <a href="" class="message-ico message-ico__edit powertip" data-bind="click: GoEdit, tooltip: 'Редактировать'"></a>
                    </div>

                    <div class="clearfix" data-bind="visible: canRemove()">
                        <a href="" class="message-ico message-ico__del powertip" data-bind="click: Remove, tooltip: 'Удалить'"></a>
                    </div>

                </div>
            </div>

        </div>
        <!-- /ko -->
    </div>

    <?php if (!Yii::app()->user->isGuest && !$this->gallery):?>
        <div class="comments-gray_add clearfix" data-bind="css: {active: opened}">
            <div class="comments-gray_ava">
                <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 24)) ?>
            </div>
            <div class="comments-gray_frame">
                <input type="text" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий" data-bind="click:openComment, visible: !opened()">
                <!-- ko if: opened() -->
                <div class="wysiwyg-h">
                    <div id="add_<?=$this->objectName ?>" data-bind="enterKey: Enter"></div>
                </div>
                <div class="redactor-control clearfix">

                    <!-- ko if: response() -->
                    <div class="redactor-control_quote">
                        <span class="comments-gray_quote-ico active"></span>
                        <span class="redactor-control_quote-tx" data-bind="text: response().author.fullName"></span>
                        <a href="" class="ico-close3 powertip" data-bind="click: removeResponse"></a>
                    </div>
                    <!-- /ko -->

                    <div class="float-r">
                        <div class="redactor-control_key">
                            <input type="checkbox" class="redactor-control_key-checkbox" id="redactor-control_key-checkbox"  data-bind="checked: enterSetting, click: focusEditor">
                            <label class="redactor-control_key-label" for="redactor-control_key-checkbox">Enter - отправить</label>
                        </div>

                        <button class="btn-green" data-bind="click: addComment">Отправить</button>
                    </div>

                </div>
                <!-- /ko -->
            </div>
        </div>
    <?php endif ?>

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

<?php if (Yii::app()->user->isGuest) $this->endCache();} ?>
<script type="text/javascript">
    var CURRENT_USER_ID = '<?=Yii::app()->user->id ?>';
</script>