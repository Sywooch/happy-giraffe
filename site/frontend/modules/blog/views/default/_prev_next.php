<?php
/**
 * @var $data BlogContent
 */
$prev = $data->getPrevPost();
$next = $data->getNextPost();
?>

<?php if ($next !== null || ! $prev !== null): ?>
    <table class="article-nearby clearfix" ellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <?php if ($prev !== null): ?>
                <td>
                    <div class="article-nearby_hint">Предыдущая запись</div>
                </td>
            <?php endif; ?>
            <?php if ($next !== null): ?>
                <td class="article-nearby_r">
                    <div class="article-nearby_hint">Следующая запись</div>
                </td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if ($prev !== null): ?>
                <td>
                    <?php $this->renderPartial('blog.views.default._prev_next_one', array('data' => $prev)); ?>
                </td>
            <?php endif; ?>
            <?php if ($next !== null): ?>
                <td class="article-nearby_r">
                    <?php $this->renderPartial('blog.views.default._prev_next_one', array('data' => $next)); ?>
                </td>
            <?php endif; ?>
        </tr>
        </tbody>
    </table>
<?php endif; ?>