<?php
/* @var $model CActiveRecord
 * @var $attribute string
 * @var bool $editButton
 * @var bool $deleteButton
 * @var bool $init
 *
 * @var array $options
 */
$js = "
    $('body').delegate('a.edit-widget', 'click', function(){
        var bl = $(this).parent();
        bl.find('".$options['edit_selector']."').hide();
        bl.find('a.edit').hide();
        bl.find('a.delete').hide();
        bl.append('<form class=\"input-text-edit-form\" action=\"#\">' +
            '<p><input type=\"text\" value=\"' +bl.find('".$options['edit_selector']."').text()+
                '\"/></p>' +
                '<p><input type=\"submit\" value=\"Ok\"/></p>' +
                '</form>');
        return false;
    });

    $('body').delegate('form.input-text-edit-form input[type=submit]', 'click', function(){
        var bl = $(this).parent().parent().parent();
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
                        bl.find('".$options['edit_selector']."').text(text);
                        bl.find('".$options['edit_selector']."').show();
                        bl.find('a').removeAttr('style');
                        bl.find('.edw-attribute-title').val(text);
                    }
                },
                context: $(this)
        });

        return false;
    });

    $('body').delegate('a.delete-widget', 'click', function(){
        ConfirmPopup('Вы точно хотите удалить атрибут \"' + $(this).parent().find('.edw-attribute-title').val() + '\"', $(this), function (owner) {
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
                            ".$options['ondelete'].";
                        }
                    },
                    context: owner
            });
        });

        return false;
    });
";
Yii::app()->clientScript->registerScript('input-text-edit', $js);
if (!$init){
?>
    <input type="hidden" class="edw-class" value="<?php echo get_class($model) ?>">
    <input type="hidden" class="edw-attribute" value="<?php echo $attribute ?>">
    <input type="hidden" class="edw-id"
           value="<?php echo $model->getAttribute($model->getTableSchema()->primaryKey) ?>">
    <input type="hidden" class="edw-attribute-title" value="<?php echo $model->getAttribute($attribute) ?>">
    <?php if ($editButton):?>
        <a class="edit edit-widget" href="#" title="редактировать"></a>
    <?php endif ?>
    <?php if ($deleteButton):?>
        <a class="delete delete-widget" href="#" title="удалить"></a>
    <?php endif ?>
<?php }