<?php
/**
 * @var PageMetaTag $model
 * @var PagesSearchPhrase[] $phrases
 * @var Page $page
 */
if (!empty($dataProvider)) {

    $phrases = $dataProvider->getData();
    foreach ($phrases as $phrase): ?>
    <tr onclick="EditMetaTags.addKeyword($(this).find('td:first').text())">
        <td class="col-1" width="50%"><?=$phrase->keyword->name ?></td>
        <td><?=$phrase->keyword->wordstat ?></td>
        <td><?=$phrase->getPosition(2) ?></td>
        <td><?=$visits1 = $phrase->getVisits(2, 2) ?></td>
        <td><?=$phrase->getPosition(3) ?></td>
        <td><?=$visits2 = $phrase->getVisits(3, 2) ?></td>
        <td><?=($visits1 + $visits2) ?></td>
    </tr>
    <?php endforeach;
}
?>