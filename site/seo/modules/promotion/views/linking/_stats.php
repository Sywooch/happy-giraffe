<?php
/**
 * @var PagesSearchPhrase[] $goodPhrases
 * @var int $selected_phrase_id
 * @var int $period
 * @var Page $page
 */
?>
<tr>
    <td>Все запросы</td>
    <td></td>
    <td></td>
    <td><?=$visits1 = $page->getVisits(2, $period) ?></td>
    <td></td>
    <td><?=$visits2 = $page->getVisits(3, $period) ?></td>
    <td><?=($visits1 + $visits2) ?></td>
    <td></td>
</tr>
<?php foreach ($goodPhrases as $phrase): ?>
<tr onclick="SeoLinking.getPhraseData(this, <?= $phrase->id?>)"<?php if ($selected_phrase_id == $phrase->id) echo ' class="active"' ?>>
    <td><?=$phrase->keyword->name ?></td>
    <td><?=$phrase->keyword->wordstat ?></td>
    <td><?=$phrase->getPosition(2) ?></td>
    <td><?=$visits1 = $phrase->getVisits(2, $period) ?></td>
    <td><?=$phrase->getPosition(3) ?></td>
    <td><?=$visits2 = $phrase->getVisits(3, $period) ?></td>
    <td><?=($visits1 + $visits2) ?></td>
    <td><b><a><?=$phrase->linksCount ?></a></b></td>
</tr>
<?php endforeach; ?>