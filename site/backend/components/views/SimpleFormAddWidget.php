<?php
/* @var $model CActiveRecord
 * @var $attribute string
 */
$js = "
    $('body').delegate('span.add_enum_value', 'click', function(){
        $(this).parent().append('<form class=\"input-text-add-form\" action=\"#\">' +
            '<p><input type=\"text\" value=\"\"/></p>' +
                '<p><input type=\"submit\" value=\"Ok\"/></p>' +
                '</form>');
        $(this).hide();
        return false;
    });

    $('body').delegate('form.input-text-add-form input[type=submit]', 'click', function(){
        var bl = $(this).parent('p').parent('form').parent();
        var text = bl.find('input[type=text]').val();
        var url = bl.find('input.url').val();
        var model_id = bl.find('input.model_id').val();

        $.ajax({
                url: url,
                data: {
                    text: text,
                    model_id: model_id
                },
                type: 'POST',
                success: function(data) {
                    bl.find('form').remove();
                    bl.find('span.add_enum_value').show();
                    if (data != ''){
                        bl.before('<li>'+data+'</li>');
                    }
                },
        });

        return false;
    });
";
Yii::app()->clientScript->registerScript('input-text-add', $js);

if (!$init){
?>
<input type="hidden" class="url" value="<?php echo $url ?>">
<input type="hidden" class="model_id" value="<?php echo $model_id ?>">
<span class="add_paket add_enum_value" title="добавить элемент в список">+</span><?php }