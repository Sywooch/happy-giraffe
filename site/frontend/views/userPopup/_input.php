<div class="row clearfix">

    <div class="row-title"><?=$model->getAttributeLabel($attribute)?>:</div>

    <div class="row-elements">
        <div class="value">
            <span class="value-big"><?=$model->$attribute?></span>
            <a href="javascript:void(0)" onclick="$(this).parents('.row-elements').find('.value').hide(); $(this).parents('.row-elements').find('.input').show();" class="edit tooltip" title="Изменить"></a>
        </div>
        <div class="input" style="display: none;">
            <input type="text" value="<?=$model->$attribute?>" />
            <button onclick="$.post('/ajax/setValue/', {
                entity: '<?=get_class($model)?>',
                entity_id: '<?=$model->id?>',
                attribute: '<?=$attribute?>',
                value: $(this).prev().val(),
                context: $(this)
            }, function(response) {
                if (response) {
                    alert('123');
                    $(this).parents('.row-elements').find('.input').hide();
                    $(this).parents('.row-elements').find('.value').show();
                    $(this).parents('.row-elements').find('.value span').text($(this).prev().val());
                }
            });" class="btn-green small">Ok</button>
        </div>
    </div>

</div>