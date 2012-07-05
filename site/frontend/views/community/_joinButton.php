<?php if (! Yii::app()->user->model->isInCommunity($community_id)): ?>
    <a href="#joinClub" class="club-join-btn fancy">Вступить в клуб</a>
<?php else: ?>
    <?=HHtml::link('<span><span>Покинуть клуб</span></span>', array('community/join', 'action' => 'leave', 'community_id' => $community_id), array('class' => 'club-join-btn joinButton'), true)?>
<?php endif; ?>