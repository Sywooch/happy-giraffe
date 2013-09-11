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
            </div>
        </li>
    <?php endforeach; ?>
</ul>