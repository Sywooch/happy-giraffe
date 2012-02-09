<div class="hg-like">
    <button onclick="pushYohoho();" class="btn btn-green-smedium"><span><span>+2</span></span></button>
    <div class="count"><?php echo Rating::countByEntity($this->model, 'yh'); ?></div>
</div>
<?php
$js = 'function pushYohoho() {
            ' . (Yii::app()->user->isGuest ? 'return false;' : '') . '
            $.post(
                "' . Yii::app()->createUrl('/ajax/rate') . '",
                {
                    modelName : "' . get_class($this->model) . '",
                    objectId : ' . $this->model->primaryKey . ',
                    key : "yh",
                    r : 2
                },
                function(response) {
                    $(".like-block div.rating span").text(response.count);
                    $(".hg-like div.count").text(response.entity);
                },
                "json"
            )
        }';
Yii::app()->clientScript->registerScript('yohoho_script', $js, CClientScript::POS_HEAD);
?>