<?php
/* @var string $modelName
 * @var string $modelPk
 * @var $attribute string
 * @var bool $editButton
 * @var bool $deleteButton
 * @var bool $init
 *
 * @var array $options
 */

if ($editButton) {
    $edit_js = "
    $('body').delegate('a.edit-widget', 'click', function(){
        var bl = $(this).parent();
        bl.find('" . $options['edit_selector'] . "').hide();
        bl.find('a.edit').hide();
        bl.find('a.delete').hide();
        bl.append('<form class=\"editw-form\" action=\"#\">' +
            '<input type=\"text\" value=\"' +bl.find('" . $options['edit_selector'] . "').text()+'\"/>' +
                '<input type=\"submit\" class=\"greenGradient ok\" value=\"Ok\"/>' +
                '</form>');
        return false;
    });

    $('body').delegate('form.editw-form input[type=submit]', 'click', function(){
        var bl = $(this).parent().parent();
        var text = bl.find('input[type=text]').val();
        var id = bl.find('input.edw-id').val();
        var class_name = bl.find('input.edw-class').val();
        var attribute = bl.find('input.edw-attribute').val();

        $.ajax({
                url: '" . Yii::app()->createUrl("ajax/SetValue") . "',
                data: {
                    modelName: class_name,
                    modelPk: id,
                    value: text,
                    attribute: attribute
                },
                type: 'POST',
                success: function(data) {
                    if (data == '1'){
                        bl.find('form').remove();
                        bl.find('" . $options['edit_selector'] . "').text(text);
                        bl.find('" . $options['edit_selector'] . "').show();
                        bl.find('a').removeAttr('style');
                        bl.find('.edw-attribute-title').val(text);
                    }
                },
                context: $(this)
        });

        return false;
    });";
    Yii::app()->clientScript->registerScript('edw-edit', $edit_js);
}

if ($deleteButton) {
    $delete_js = "$('body').delegate('a.delete-widget', 'click', function(){
        ConfirmPopup('Вы точно хотите удалить \"' + $(this).parent().find('.edw-attribute-title').val() + '\"', $(this), function (owner) {
            var bl = owner.parent();
            var id = bl.find('input.edw-id').val();
            var class_name = bl.find('input.edw-class').val();

            $.ajax({
                    url: '" . Yii::app()->createUrl("ajax/delete") . "',
                    data: {
                        modelName: class_name,
                        modelPk: id
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data == '1'){
                            " . $options['ondelete'] . ";
                        }
                    },
                    context: owner
            });
        });

        return false;
    });";
    Yii::app()->clientScript->registerScript('edw-delete', $delete_js);
}
if (!$init) {
    ?>
<input type="hidden" class="edw-class" value="<?php echo $modelName ?>">
<input type="hidden" class="edw-attribute" value="<?php echo $attribute ?>">
<input type="hidden" class="edw-id"
       value="<?php echo $modelPk ?>">
<input type="hidden" class="edw-attribute-title" value="<?php echo $attributeValue ?>">
<?php if ($editButton): ?>
    <a class="edit edit-widget <?php if (isset($options['edit_link_class'])) echo $options['edit_link_class'] ?>" href="#"
       title="редактировать <?php echo $attributeValue ?>"><?php
        if (isset($options['edit_link_text'])) echo $options['edit_link_text'] ?></a>
    <?php endif ?>
<?php if ($deleteButton): ?>
    <a class="delete delete-widget <?php if (isset($options['delete_link_class'])) echo $options['delete_link_class'] ?>" href="#" title="удалить <?php
        echo $attributeValue ?>"></a>
    <?php endif ?>
<?php }