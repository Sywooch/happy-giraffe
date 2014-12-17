<li class="post-list-simple_li">
    <div class="post-list-simple_top"><a href="<?= $data->user->profileUrl ?>" class="a-light"><?= $data->user->getFullName() ?></a>
        <?= HHtml::timeTag($data, array('class' => 'tx-date')) ?>
    </div>
    <div class="post-list-simple_t"><a href="<?= $data->parsedUrl ?>" class="post-list-simple_t-a"><?= $data->title ?></a></div>
</li>