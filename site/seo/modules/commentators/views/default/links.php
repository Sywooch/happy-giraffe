<?php
/**
 * @var $this DefaultController
 * @var $month string
 * @var $commentator CommentatorWork
 * @author Alex Kireev <alexk984@gmail.com>
 */

$links = $commentator->GetLinks($month);
?>
<?php $this->renderPartial('menu', array('month' => $month, 'active'=>$commentator->user_id, 'url'=>'links')); ?>
<div class="block">

    <?php $this->renderPartial('_month_list', array('month' => $month)); ?>

    <table class="external-link">
        <tbody>
        <?php foreach ($links as $link): ?>
            <tr class="external-link_odd">
                <td class="external-link_td-date">
                    <div class="b-date"><?=Yii::app()->dateFormatter->format('d MMM yyyy',strtotime($link->created))?></div>
                </td>
                <td class="external-link_td-outer">
                    <a href="<?=$link->url ?>" class="external-link_outer" target="_blank"><?=$link->url ?></a>
                </td>
                <td class="external-link_td-inner">
                    <?php $article = $link->article() ?>
                    <a href="http://www.happy-giraffe.ru<?=$article->url ?>" class="external-link_inner" target="_blank"><?=$article->title ?></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<script type="text/javascript">
    refreshOddClass();
    function refreshOddClass(){
        $ ('table.external-link__thin tr').removeClass('external-link_odd');
        $ ('table.external-link__thin tr:even').addClass('external-link_odd');
    }
</script>