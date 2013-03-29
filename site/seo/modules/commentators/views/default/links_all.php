<?php
/**
 * @var $this DefaultController
 * @var $month string
 * @var $commentators CommentatorWork[]
 * @author Alex Kireev <alexk984@gmail.com>
 */

$criteria = new EMongoCriteria();
$criteria->setSort(array('user_id'=>EMongoCriteria::SORT_ASC));
$commentators = CommentatorWork::model()->findAll($criteria);

?>
<?php $this->renderPartial('menu', array('month' => $month, 'active'=>null, 'url'=>'links')); ?>
<div class="block">

    <?php $this->renderPartial('_month_list', array('month' => $month)); ?>

    <table class="external-link external-link__thin">
        <tbody>
        <?php foreach ($commentators as $commentator): ?>
            <?php $user = $commentator->getUserModel() ?>
            <tr>
                <td class="external-link_empty w-50"></td>
                <td class="external-link_td-user">
                    <div class="user-info clearfix">
                        <?php $url = $this->createUrl('/commentators/default/links', array('month'=>$month, 'user_id'=>$user->id))?>
                        <a href="<?=$url ?>" class="ava small"><?=CHtml::image($user->getAva('small')) ?></a>
                        <div class="user-info_details">
                            <a href="<?=$url ?>" class="user-info_username"><?=$user->fullName ?></a>
                        </div>
                    </div>
                </td>
                <td class="external-link_empty"></td>
                <td class="external-link_td-count">
                    <div class="external-link_count"><?=$commentator->GetLinksCount($month) ?></div>
                </td>
                <td class="external-link_empty w-50"></td>
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