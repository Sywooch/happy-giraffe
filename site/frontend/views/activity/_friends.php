<ul class="clearfix">
    <?php foreach ($friends as $f): ?>
    <?php $this->renderPartial('application.widgets.activity.views._friend', array('f' => $f)); ?>
    <?php endforeach; ?>
</ul>