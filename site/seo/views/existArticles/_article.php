<tr>
    <td class="col-1"><?=$model->id ?></td>
    <td><b><?=$model->article->title ?></b><br/><a target="_blank" href="<?=$model->url ?>"><?=$model->url ?></a></td>
    <td><?=$model->getKeywords() ?></td>
</tr>