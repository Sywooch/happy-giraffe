<?php
/* @var $model CActiveRecord
 * @var $attribute string
 */
$js = "
    $('body').delegate('.attr-elem-name > a.edit', 'click', function(){
        $(this).parent('div.name').find('p').hide();
        $(this).parent('div.name').find('a.edit').hide();
        $(this).parent('div.name').find('a.delete').hide();
        $(this).parent('div.name').append('<form class=\"input-text-edit-form\" action=\"#\">' +
            '<p><input type=\"text\" value=\"' +$(this).parent('div.name').find('p').text()+
                '\"/></p>' +
                '<p><input type=\"submit\" value=\"Ok\"/></p>' +
                '</form>');
        return false;
    });

    $('body').delegate('form.input-text-edit-form input[type=submit]', 'click', function(){
        var bl = $(this).closest('div.attr-elem-name');
        var text = bl.find('input[type=text]').val();
        var id = bl.find('input.elem-id').val();
        var class_name = bl.find('input.elem-class').val();
        var attribute = bl.find('input.elem-attribute').val();

        $.ajax({
                url: '" . Yii::app()->createUrl("ajax/SetValue") . "',
                data: {
                    modelName: class_name,
                    modelPk: id,
                    value: text,
                    attribute: attribute
                },
                type: 'GET',
                success: function(data) {
                    if (data == '1'){
                        bl.find('form').remove();
                        bl.children('p').text(text);
                        bl.children('p').show();
                        bl.append('<a class=\"edit edit_attribute\" href=\"#\"></a><a class=\"delete delete_attribute\" href=\"#\"></a>');
                    }
                },
                context: $(this)
        });

        return false;
    });

    $('body').delegate('.attr-elem-name > a.delete', 'click', function(){
        ConfirmPopup('Вы точно хотите удалить атрибут \"' + $(this).prev().prev().text() + '\"', $(this), function (owner) {
            var bl = owner.closest('div.attr-elem-name');
            var id = bl.find('input.elem-id').val();
            var class_name = bl.find('input.elem-class').val();

            $.ajax({
                    url: '" . Yii::app()->createUrl("ajax/delete") . "',
                    data: {
                        modelName: class_name,
                        modelPk: id
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data == '1'){
                            bl.parent('li').remove();
                        }
                    }
            });
        });

        return false;
    });
";
Yii::app()->clientScript->registerScript('input-text-edit', $js);
if (!$init){
?>
<div class="name attr-elem-name">
    <input type="hidden" class="elem-class" value="<?php echo get_class($model) ?>">
    <input type="hidden" class="elem-attribute" value="<?php echo $attribute ?>">
    <input type="hidden" class="elem-id"
           value="<?php echo $model->getAttribute($model->getTableSchema()->primaryKey) ?>">

    <p><?php echo $model->getAttribute($attribute) ?></p>
    <a class="edit" href="#" title="редактировать"></a>
    <a class="delete" href="#" title="удалить"></a>
</div>
<?php }