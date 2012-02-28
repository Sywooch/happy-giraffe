<?php
$cs = Yii::app()->clientScript;

$js = "
        $('div.community').delegate('h1', 'click', function() {
            $(this).next().toggle();
        });
        $('div.community').delegate('h2', 'click', function() {
            $(this).next().toggle();
        });
    ";

$css = "
        div.rubric {
            display: none;
        }

        ul.contents {
            display: none;
        }

        h1, h2 {
            cursor: pointer;
        }
    ";

$cs
    ->registerScript('shortList', $js)
    ->registerCss('shortList', $css);
?>

<?php foreach ($contents as $c): ?>
<div class="community">
    <h1><?=$c->name?></h1>
    <div class="rubric">
        <?php foreach ($c->rubrics as $r): ?>
        <h2><?=$r->name?></h2>
        <ul class="contents">
            <?php foreach ($r->contents as $cn): ?>
            <li><?php echo CHtml::link($cn->name, array(
                    'community/view',
                    'community_id' => $c->id,
                    'content_type_slug' => $cn->type->slug,
                    'content_id' => $cn->id,
                )
            ); ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>