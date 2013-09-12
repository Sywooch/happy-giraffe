<ul class="b-family_ul">
    <?php foreach ($data as $member): ?>
        <li class="b-family_li">
            <div class="b-family_img-hold">
                <?php if ($member['thumbSrc'] !== null): ?>
                    <?=CHtml::image($member['thumbSrc'], '', array('class' => 'b-family_img'))?>
                <?php else: ?>
                    <div class="ico-family ico-family__<?=$member['iconCssClass']?>"></div>
                <?php endif; ?>
            </div>
            <div class="b-family_tx">
                <span><?=$member['title']?></span>
                <?php if (strlen($member['name']) > 0): ?>
                    <br><span><?=$member['name']?></span>
                <?php endif; ?>
                <?php if (strlen($member['age']) > 0): ?>
                    <br><span><?=$member['age']?></span>
                <?php endif; ?>
            </div>
        </li>
    <?php endforeach; ?>
    <?php if ($showMore): ?>
        <li class="b-family_li">
            <div class="b-family_img-hold">
                <a href="<?=$this->user->getFamilyUrl()?>" class="b-family_more">еще <?=$membersCount - 5?></a>
            </div>
            <div class="b-family_tx">
            </div>
        </li>
    <?php endif; ?>
</ul>