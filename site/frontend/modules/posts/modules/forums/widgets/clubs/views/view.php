<?php
/**
 * @var \CommunitySection[] $sections
 * @var \site\frontend\modules\posts\models\Content[] $posts
 * @var \site\frontend\components\api\models\User[] $users
 */
?>

<?php foreach ($sections as $i => $section): ?>
    <a class="forum_heading_block">
        <div class="forum_heading"><?=$section->title?></div>
        <ul class="homepage-clubs_ul">
            <?php foreach ($section->clubs as $j => $club): ?>
            <li class="homepage-clubs_li">
                <a class="clubs_cont" href="<?=$club->url?>">
                    /* "Fix clubs icons" by Ivan Sinyavin  */
                    <div class="ico-clubs_a ico-clubs-medium">
                        <div class="ico-clubs-medium_ico-hold">
                            <div class="ico-club ico-club__<?=$club->id?>"></div>
                        </div>
                    </div>
                    <div class="forum_subheading"><?=$club->title?></div>
                    <div class="forum_subheading_desc"><?=$club->description?></div>
                </a>
                <div class="clubs_info">
                    <div class="counter-block"><span class="rating_count counter-text"><?=\site\frontend\modules\community\helpers\StatsHelper::getPosts($club->id)?></span>
                        <div class="rating_text counter-hint">темы</div>
                    </div>
                    <div class="counter-block"><span class="rating_count counter-text"><?=\site\frontend\modules\community\helpers\StatsHelper::getComments($club->id)?></span>
                        <div class="rating_text counter-hint">комментарии</div>
                    </div>
                    <?php if (isset($posts[$club->id])): ?>
                    <div class="clubs_info_activity live-user">
                        <div class="live-user_hint">последняя активность</div>
                        <span href="<?=$users[$posts[$club->id]->authorId]->profileUrl?>" class="ava ava__small ava__female">
                            <?php if ($users[$posts[$club->id]->authorId]->avatarUrl): ?>
                            <img alt="" src="<?=$users[$posts[$club->id]->authorId]->avatarUrl?>" class="ava_img">
                            <?php endif; ?>
                        </span>
                        <div class="username">
                            <a href="<?=$users[$posts[$club->id]->authorId]->profileUrl?>"><?=$users[$posts[$club->id]->authorId]->fullName?></a>
                            <?=HHtml::timeTag($posts[$club->id], array('class' => 'tx-date'))?>
                        </div>
                        <a class="live-user_text" href="<?=$posts[$club->id]->url?>"><?=\site\common\helpers\HStr::truncate($posts[$club->id]->title, 50)?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </li>
            <?php if ($j < (count($section->clubs) - 1)): ?>
                <div class="clubs_separator"></div>
            <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="clearfix"></div>

    <?php if (false): ?>
    <h1><?=$section->title?></h1>
    <ul>
        <?php foreach ($section->clubs as $club): ?>
            <li>
                <p><?=$club->title?></p>
                <p><?=$club->description?></p>
                <p><?=\site\frontend\modules\community\helpers\StatsHelper::getPosts($club->id)?></p>
                <p><?=\site\frontend\modules\community\helpers\StatsHelper::getComments($club->id)?></p>
                <?php if (isset($posts[$club->id])): ?>
                    <p><?=CHtml::link($posts[$club->id]->title, $posts[$club->id]->url)?></p>
                    <p><?=CHtml::link($users[$posts[$club->id]->authorId]->fullName, $users[$posts[$club->id]->authorId]->profileUrl)?></p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
<?php endforeach; ?>