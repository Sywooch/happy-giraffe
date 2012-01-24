<?php
/* @var $this Controller
 * @var $model Attribute
 * @var $product Product
 */

$values = $product->GetCardAttributeValues($model->attribute_id);
?>
<script type="text/javascript">
    $(function() {
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
                url: <?php echo $this->createUrl('product/AddAttrListElem', array()) ?>,
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
                }
            });

            return false;
        });
    });
</script>
<?php if (!isset($no_list)):?>
    <li>
<?php endif ?>
    <div class="name attr-name">
        <p><?php echo $model->attribute_title ?></p>
    </div>
    <ul class="list-elems">
        <?php foreach ($values as $attr_val): ?>
        <li>
            <?php $this->renderPartial('_attribute_value_view',array('attr_val'=>$attr_val)); ?>
        </li>
        <?php endforeach; ?>
        <li>
            <input type="hidden" name="attribute_id" value="<?php echo $model->attribute_id ?>">
            <span class="add_paket add_enum_value" title="добавить элемент в список">+</span>
        </li>
    </ul>
<?php if (!isset($no_list)):?>
    </li>
<?php endif ?>