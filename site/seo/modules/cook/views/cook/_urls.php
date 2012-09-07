<?php foreach ($urls as $url): ?>
<input name="urls[]" type="text" class="example" value="<?=$url->url?>" data-id="<?=$url->id?>"/><br/>
<?php endforeach; ?>
<input name="urls[]" type="text" class="example"/><br/>