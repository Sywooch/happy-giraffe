<ul class="clearfix">
    <?php foreach ($commentator->clubs as $club_id): ?>
        <?php $club = Community::model()->findByPk($club_id) ?>
        <li class="club" data-id="<?=$club->id ?>"><?=$club->title ?>
            <a class="remove" href="javascript:;" onclick="ClubsDistribution.remove(this, <?=$commentator->user_id ?>, <?=$club->id ?>);"></a>
        </li>
    <?php endforeach; ?>
</ul>