<?php
/* @var $this Controller
 * @var $positions SearchPhrasePosition[]
 */
?><div class="positions">

    <div class="block-title">Позиции <i class="icon-<?=($se == 2)?'yandex':'google' ?>"></i></div>

    <ul>
       <?php for($i=0;$i<count($positions);$i++){
        if ($i+1<count($positions)){
            $next = $positions[$i+1];
            if ($next->position < $positions[$i]->position)
                $icon = '<i class="icon-arr-u"></i>';
            elseif ($next->position > $positions[$i]->position)
                $icon = '<i class="icon-arr-d"></i>';
            else
                $icon = '';
        }
        else
            $icon = '';
        ?>
            <li>
                <div class="date"><?= Yii::app()->dateFormatter->format("d MMM y", $positions[$i]->date); ?></div>
                <div class="num"><?=$positions[$i]->position ?> <?=$icon ?></div>
            </li>
       <?php } ?>
    </ul>

</div>