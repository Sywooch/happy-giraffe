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

<script type="text/javascript">
    //remove dialog
    $('body').delegate('#dialog .dialog-inn a.remove-dialog', 'click', function () {
        if (confirm("Удалить диалог?")) {
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/im/default/removeDialog") ?>',
                data:{id:dialog},
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.status) {
                        $('li#dialog-' + dialog).remove();
                        $('.dialog-inn').html('');

                        var ul = $('.opened-dialogs-list ul');
                        if (ul.find('li input.dialog-id').length == 0) {
                            ChangeDialog(null);
                        }
                        else {
                            ChangeDialog(ul.find('li input.dialog-id').val());
                        }

                        if (response.active_dialog_url == '')
                            $('.nav .opened').hide();
                        else
                            $('.nav .opened a').attr("href", response.active_dialog_url);
                    }
                },
                context:$(this)
            });
        }
        return false;
    });

</script>