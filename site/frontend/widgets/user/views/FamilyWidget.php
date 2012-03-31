<?php if ((count($this->user->babies) > 0) || (
    User::relationshipStatusHasPartner($this->user->relationship_status)
        && isset($this->user->partner))
):?>

<div class="user-family">
    <div class="t"></div>
    <div class="c">
        <ul>
            <?php if (User::relationshipStatusHasPartner($user->relationship_status) && isset($user->partner)): ?>
            <li>
                <big><?= $user->partner->name ?> &nbsp; <small><?php echo $user->getPartnerTitle($user->relationship_status) ?></small></big>
                <?php if (!empty($user->partner->notice)):?>
                    <div class="comment purple">
                        <?= $user->partner->notice ?>
                        <span class="tale"></span>
                    </div>
                <?php endif ?>
                <?php if (count($user->partner->photos) != 0):?>
                <div class="img">
                    <img src="<?php echo $user->partner->getRandomPhotoUrl() ?>">
                </div>
                <?php endif ?>
            </li>
            <?php endif ?>
            <?php foreach ($user->babies as $baby): ?>
            <?php if (empty($baby->type)):?>
                <li>
                    <big><?php echo $baby->name ?>, <span><?php echo $baby->getTextAge(false) ?></span></big>
                    <?php if (!empty($baby->notice)):?>
                    <div class="comment purple">
                        <?= $baby->notice ?>
                        <span class="tale"></span>
                    </div>
                    <?php endif ?>

                    <?php if (count($baby->photos) != 0):?>
                        <div class="img">
                            <img src="<?php echo $baby->getRandomPhotoUrl() ?>">
                        </div>
                    <?php endif ?>
                </li>
            <?php endif ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="b"></div>
</div>
<?php else: ?>
<?php if ($this->user->relationship_status == 0 && $this->user->id == Yii::app()->user->id): ?>
    <div class="user-family user-family-cap">
        <div class="t"></div>
        <div class="c">
            <a href="<?=Yii::app()->createUrl('/family') ?>" class="cap"><span>Расскажите<br>о своей семье</span></a>
        </div>
        <div class="b"></div>
    </div>
    <?php endif ?>
<?php endif ?>