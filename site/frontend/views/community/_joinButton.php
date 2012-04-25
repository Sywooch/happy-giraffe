<?php if (! Yii::app()->user->model->isInCommunity($community_id)): ?>
    <a href="#joinClub" class="club-join-btn fancy">Вступить в клуб</a>
<?php else: ?>
    <a href="<?php echo $this->createUrl('community/join', array('action' => 'leave', 'community_id' => $community_id)); ?>" class="club-join-btn joinButton">Покинуть клуб</a>
<?php endif; ?>