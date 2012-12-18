<?php if (Yii::app()->user->isGuest): ?>

<div class="comment-add clearfix">
    <div class="comment-add_user">
        <a href="#login" class="fancy">Авторизируйтесь</a>
        <div class="social-small-row clearfix">
            <em>или войти с помощью</em> <br>
            <ul class="social-list-small">
                <li><a href="#" class="odnoklasniki"></a></li>
                <li><a href="#" class="mailru"></a></li>
                <li><a href="#" class="vk"></a></li>
                <li><a href="#" class="fb"></a></li>
            </ul>
        </div>
    </div>
    <div class="comment-add_form-holder">
        <input type="text" name="" class="input-text" placeholder="Введите ваш комментарий">
    </div>
</div>

    <?php else: ?>
<div class="comment-add active clearfix">
    <div class="comment-add_user">
        <div class="comment-add_user-ava">
            <a href="" class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/13623/ava/7acd577045e2014b4d26ecd33f6ce6d2.jpeg"></a>
            <span class="comment-add_username">Татьяна Пахоменко </span>
        </div>
    </div>
    <div class="comment-add_form-holder">
        <textarea cols="40" id="editor2" name="editor2" rows="5" style="visibility: hidden; display: none;"></textarea><span id="cke_editor2" class="cke_skin_hgrucomment cke_2 cke_editor_editor2" dir="ltr" title="" lang="ru-hg" tabindex="0" role="application" aria-labelledby="cke_editor2_arialbl"><span id="cke_editor2_arialbl" class="cke_voice_label">Визуальный редактор текста</span><span class="cke_browser_webkit cke_browser_quirks" role="presentation"><span class="cke_wrapper cke_ltr" role="presentation"><table class="cke_editor" border="0" cellspacing="0" cellpadding="0" role="presentation"><tbody><tr role="presentation"><td id="cke_top_editor2" class="cke_top" role="presentation"><div class="cke_toolbox" role="group" aria-labelledby="cke_18" onmousedown="return false;"><span id="cke_18" class="cke_voice_label">Панели инструментов редактора</span><span id="cke_19" class="cke_toolbar" role="toolbar"><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><span class="cke_button"><a id="cke_20" class="cke_off cke_button_bold" "="" href="javascript:void('Полужирный')" title="Полужирный" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_20_label" onkeydown="return CKEDITOR.tools.callFunction(20, event);" onfocus="return CKEDITOR.tools.callFunction(21, event);" onclick="CKEDITOR.tools.callFunction(22, this); return false;"><span class="cke_icon">&nbsp;</span><span id="cke_20_label" class="cke_label">Полужирный</span></a></span><span class="cke_button"><a id="cke_21" class="cke_off cke_button_italic" "="" href="javascript:void('Курсив')" title="Курсив" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_21_label" onkeydown="return CKEDITOR.tools.callFunction(23, event);" onfocus="return CKEDITOR.tools.callFunction(24, event);" onclick="CKEDITOR.tools.callFunction(25, this); return false;"><span class="cke_icon">&nbsp;</span><span id="cke_21_label" class="cke_label">Курсив</span></a></span><span class="cke_button"><a id="cke_22" class="cke_off cke_button_underline" "="" href="javascript:void('Подчеркнутый')" title="Подчеркнутый" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_22_label" onkeydown="return CKEDITOR.tools.callFunction(26, event);" onfocus="return CKEDITOR.tools.callFunction(27, event);" onclick="CKEDITOR.tools.callFunction(28, this); return false;"><span class="cke_icon">&nbsp;</span><span id="cke_22_label" class="cke_label">Подчеркнутый</span></a></span></span><span class="cke_separator" role="separator"></span><span class="cke_toolgroup" role="presentation"><span class="cke_button"><a id="cke_23" class="cke_off cke_button_image" "="" href="javascript:void('Изображение')" title="Изображение" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_23_label" onkeydown="return CKEDITOR.tools.callFunction(29, event);" onfocus="return CKEDITOR.tools.callFunction(30, event);" onclick="CKEDITOR.tools.callFunction(31, this); return false;"><span class="cke_icon">&nbsp;</span><span id="cke_23_label" class="cke_label">Изображение</span></a></span><span class="cke_button"><a id="cke_24" class="cke_off cke_button_smiles" "="" href="javascript:void('Вставить смайлик')" title="Вставить смайлик" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_24_label" onkeydown="return CKEDITOR.tools.callFunction(32, event);" onfocus="return CKEDITOR.tools.callFunction(33, event);" onclick="CKEDITOR.tools.callFunction(34, this); return false;"><span class="cke_icon">&nbsp;</span><span id="cke_24_label" class="cke_label">Вставить смайлик</span></a></span></span><span class="cke_toolbar_end"></span></span></div></td></tr><tr role="presentation"><td id="cke_contents_editor2" class="cke_contents" style="height:80px" role="presentation"><iframe style="width:100%;height:100%" frameborder="0" title="Визуальный редактор текста, editor2, нажмите ALT-0 для открытия справки." src="javascript:void(function(){}())" tabindex="-1" allowtransparency="true"></iframe></td></tr><tr role="presentation"><td id="cke_bottom_editor2" class="cke_bottom" role="presentation"><div class="cke_resizer cke_resizer_ltr" title="Перетащите для изменения размера" onmousedown="CKEDITOR.tools.callFunction(19, event)"></div></td></tr></tbody></table></span></span></span>
        <div class="a-right">
            <button class="btn-gray medium cancel">Отмена</button>
            <button class="btn-green medium">Добавить</button>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="new_comment new-comment" id="new_comment_wrapper">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'add_comment',
    'htmlOptions' => array(
        'onsubmit' => "return ".$this->objectName.".send(this, event);",
        'style' => 'display:none;',
    ),
)); ?>

    <div class="response">
        <input type="hidden" id="Comment_response_id" name="Comment[response_id]" value="" />
    </div>
    <div class="quote">
        <input type="hidden" id="Comment_quote_id" name="Comment[quote_id]" value="" />
        <input type="hidden" id="Comment_selectable_quote" name="Comment[selectable_quote]" value="" />
    </div>
    <?php echo $form->hiddenField($comment_model, 'entity', array('value' => $this->entity)); ?>
    <?php echo $form->hiddenField($comment_model, 'entity_id', array('value' => $this->entity_id)); ?>
    <?php echo CHtml::hiddenField('edit-id', ''); ?>
    <?php echo $form->textArea($comment_model, 'text'); ?>
    <div class="button_panel">
        <button class="btn btn-gray-medium cancel" onclick="return <?php echo $this->objectName; ?>.cancel(event);"><span><span>Отмена</span></span></button>
        <button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
    </div>
    <?php $this->endWidget(); ?>
</div>

    <div style="display: none;">
        <div class="upload-btn" id="refresh_upload">
            <?php
            $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                'model' => new Comment(),
            ));
            $fileAttach->button();
            $this->endWidget();
            ?>
        </div>
    </div>


<?php $this->render('list', array('dataProvider' => $dataProvider,'type'=>$type)); ?>
<script type="text/javascript">
    var cke_instance = '<?php echo $this->commentModel; ?>_text';
</script>
