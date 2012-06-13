<?php
$cs = Yii::app()->clientScript;

$js = "
        $('div.community').delegate('h1', 'click', function() {
            $(this).next().toggle();
        });
    ";

$css = "
        div.rubric {
            display: none;
        }

        h1 {
            cursor: pointer;
        }
    ";

$cs
    ->registerScript('shortList', $js)
    ->registerCss('shortList', $css);
?>

<?php foreach ($contents as $c): ?>
<div class="community">
    <h1><?php echo CHtml::encode($c->title); ?></h1>
    <div class="rubric">
        <?php foreach ($c->rubrics as $r): ?>
            <h3><?php echo CHtml::ajaxLink(CHtml::encode($r->title), $this->createUrl('community/shortListContents'), array(
                'update' => '#' . $r->id,
                'data' => array(
                    'rubric_id' => $r->id,
                ),
            )); ?></h3>
            <ul id="<?php echo $r->id; ?>"></ul>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>