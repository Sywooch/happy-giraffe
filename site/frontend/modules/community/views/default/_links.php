<div class="clearfix">
    <ul class="b-section_ul margin-l30 clearfix<?php if (isset($root)) echo ' b-section_ul__white'; ?>">
        <li class="b-section_li">
            <a href="<?=$this->createUrl('/community/default/forum', array('community_id'=>$community->id)) ?>"
               class="b-section_li-a<?php if (isset($forum)) echo ' active' ?>">Форум</a>
        </li>
        <?php if (!empty($community->services)):?>
            <li class="b-section_li">
                <a href="<?=$this->createUrl('/community/default/services', array('community_id'=>$community->id)) ?>"
                    class="b-section_li-a<?php if (isset($service)) echo ' active' ?>">Сервисы</a>
            </li>
        <?php endif ?>
    </ul>
</div>