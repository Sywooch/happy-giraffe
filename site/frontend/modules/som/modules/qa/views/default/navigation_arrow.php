<?php
/**
 * @var \site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var \site\frontend\modules\som\modules\qa\models\QaQuestion $left
 * @var \site\frontend\modules\som\modules\qa\models\QaQuestion $right
 */
?>
<table class="article-nearby clearfix">
    <tr>
        <td><?= $left ? '<a href="' . $left->url . '" class="article-nearby_a article-nearby_a__l" rel="prev"><span class="article-nearby_tx">' . CHtml::encode($left->title) . '</span></a>' : '&nbsp;' ?></td>
        <td><?= $right ? '<a href="' . $right->url . '" class="article-nearby_a article-nearby_a__r" rel="next"><span class="article-nearby_tx">' . CHtml::encode($right->title) . '</span></a>' : '&nbsp;' ?></td>
    </tr>
</table>