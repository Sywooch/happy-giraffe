<tr>
    <td class="col-1"><?=$input_link->phrase->keyword->name ?></td>
    <td class="col-1"><?=$input_link->page->getArticleLink() ?></td>
    <td><?= Yii::app()->dateFormatter->format("d MMMM y", $input_link->date); ?></td>
    <td><?=$input_link->keyword->name ?></td>
    <td><a href="javascript:;" class="icon-remove" onclick="SeoLinking.removeLink(this, <?=$input_link->page_id ?>, <?=$input_link->page_to_id ?>)"></a></td>
</tr>