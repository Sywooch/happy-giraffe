<div class="hint">
    <?=$data->content; ?>
    <div><a href="<?=CHtml::normalizeUrl(array('club/cookSpices/deleteHint','id' => $data->id));?>" onclick="Spice.deleteHint(event);">удалить</a></div>
</div>

