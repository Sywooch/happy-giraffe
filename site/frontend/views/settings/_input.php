<div class="row clearfix">

    <div class="row-title"><?=$model->getAttributeLabel($attribute)?>:</div>

    <div class="row-elements">
        <div class="value">
            <span class="<?=$big ? 'value-big' : 'value'?>"><?=$model->$attribute?></span>
            <a href="javascript:void(0)" onclick="Settings.showInput(this)" class="edit tooltip" title="Изменить"></a>
        </div>
        <div class="input" style="display: none;">
            <input type="text" value="<?=$model->$attribute?>" />
            <button onclick="Settings.saveInput(this, '<?=$attribute?>')" class="btn-green small">Ok</button>
        </div>
    </div>

</div>