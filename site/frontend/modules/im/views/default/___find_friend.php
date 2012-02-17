<li style="display: none;">
    <form action="<?php echo $this->createUrl('/im/default/getDialog') ?>">
        <input type="text" value="введите имя" class="placeholder"
               placeholder="введите имя" onblur="setPlaceholder(this)"
               onfocus="unsetPlaceholder(this)" id="find-user" name="dialog_name"/>
        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
        'name' => 'search_user_autocomplete',
        'sourceUrl' => $this->createUrl('/im/default/ajaxSearchByName'),
        'value' => '',
        'htmlOptions' => array(
            'id'=>'find-user'
        ),
        'options' => array(
            'select' => "js: function(event, ui) {
                                                this.value = ui.item.label;
                                                $(\"#find-user\").val(ui.item.label);
                                                return false;
                                            }",
        ),
    ), true); ?>
        <button class="btn btn-green-small" type="submit"><span><span>Ok</span></span></button>
    </form>
</li>