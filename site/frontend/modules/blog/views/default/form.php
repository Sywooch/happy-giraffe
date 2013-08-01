<div class="popup-user-add-record">
    <a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-720 float-r">

            <?php $this->renderPartial('form/_menu', array('type' => $model->type_id, 'model' => $model)); ?>

            <div id="add_form_container">
                <?php $this->renderPartial('form/' . $model->type_id, compact('model', 'slaveModel', 'json')); ?>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $.fancybox.center();
    });
</script>