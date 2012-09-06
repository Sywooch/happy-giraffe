<tr>
    <td class="al"><?=$tempKeyword->keyword->name ?> </td>
    <td width="300">
        <input type="text" name="urls[]" class="example" /><br/>
    </td>
    <td><input type="checkbox" name="multivarka" /></td>
    <td>
        <?php $this->renderPartial('_author'); ?>
    </td>
</tr>