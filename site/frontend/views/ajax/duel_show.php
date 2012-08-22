<div id="duel-takeapart" class="popup">
    <a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>

    <div class="activity-duel">

        <div class="title">Дуэль</div>

        <?php $this->renderPartial('application.widgets.activity.views_old._duel', array('question' => $question, 'votes' => true)); ?>

    </div>

</div>