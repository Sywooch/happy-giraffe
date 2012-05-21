<?php $i=0;  foreach ($models as $model): ?>
<?php $i++; ?>
    <tr id="key-<?=$model->id ?>">
        <td class="col-1"><?=$model->name ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <a href="" class="icon-add" onclick="SeoKeywords.Select(this);return false;"></a>
            <a href="" class="icon-hat" onclick="SeoKeywords.Hide(this);return false;"></a>
        </td>
    </tr>
<?php if ($i > 100) break; ?>
<?php endforeach; ?>
