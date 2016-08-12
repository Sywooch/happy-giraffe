<?php
$objNext = $next['qa'];
$objPrevious = $previous['qa'];
?>
<table class="article-nearby clearfix">
    <tr>
        <td><?= $objPrevious ? '<a href="' . $objPrevious->formatedUrl($previous['tab'], $previous['categoryId']) . '" class="article-nearby_a article-nearby_a__l" rel="prev"><span class="article-nearby_tx">' . strip_tags($objPrevious->title) . '</span></a>' : '&nbsp;' ?></td>
        <td><?= $objNext ? '<a href="' . $objNext->formatedUrl($next['tab'], $next['categoryId']) . '" class="article-nearby_a article-nearby_a__r" rel="next"><span class="article-nearby_tx">' . strip_tags($objNext->title) . '</span></a>' : '&nbsp;' ?></td>
    </tr>
</table>