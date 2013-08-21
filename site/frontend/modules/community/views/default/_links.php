<div class="clearfix">
    <ul class="b-section_ul b-section_ul__white margin-l30 clearfix">
        <li class="b-section_li"><a href="<?=$this->createUrl('/community/default/forum', array('community_id'=>$community->id)) ?>" class="b-section_li-a">Форум</a></li>
        <?php if (!empty($community->services)):?>
            <li class="b-section_li"><a href="<?=$this->createUrl('/community/default/services', array('community_id'=>$community->id)) ?>" class="b-section_li-a">Сервисы</a></li>
        <?php endif ?>
    </ul>
</div>