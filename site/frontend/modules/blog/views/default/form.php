<div class="popup-user-add-record">
    <a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-720 float-r">

            <?php $this->renderPartial('/default/form/_menu', array('type' => $model->type_id, 'model' => $model, 'club_id' => $club_id)); ?>

            <div id="add_form_container">
                <?php $this->renderPartial('/default/form/' . $model->type_id, compact('model', 'slaveModel', 'json', 'club_id')); ?>
            </div>

        </div>
    </div>
</div>