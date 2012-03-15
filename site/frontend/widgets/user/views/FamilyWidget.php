<?php if ((count($this->user->babies) > 0) || (
    User::relationshipStatusHasPartner($this->user->relationship_status)
        && isset($this->user->partner))
):?>
<div class="user-family">
    <div class="t"></div>
    <div class="c">
        <ul>
            <?php if (User::relationshipStatusHasPartner($user->relationship_status) && isset($user->partner)): ?>
            <li class="clearfix">
                <big><?php echo $user->getPartnerTitle($user->relationship_status) ?></big>

                <div class="img"><a href="" onclick="return false;"><img
                    src="<?php echo $user->getPartnerPhotoUrl() ?>"></a><span><?php echo $user->partner->name ?></span>
                </div>
                <p><?php echo $user->partner->notice ?></p>
            </li>
            <?php endif ?>
            <?php foreach ($user->babies as $baby): ?>
            <li class="clearfix">
                <big><?php echo $baby->getGenderString() ?></big>

                <div class="img"><a href="" onclick="return false;"><img src="<?php echo $baby->getImageUrl() ?>"></a>
                    <span><?php echo $baby->name ?>
                        , <span><?php echo HDate::normallizeAge($baby->getAge()) ?></span></span></div>
                <p><?php echo $baby->notice ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="b"></div>
</div>
<?php else: ?>
<?php if ($this->user->relationship_status == 0): ?>
    <div class="user-family user-family-cap">
        <div class="t"></div>
        <div class="c">
            <a href="<?=Yii::app()->createUrl('/profile/family') ?>"
               class="cap"><span>Расскажите<br>о своей семье</span></a>
        </div>
        <div class="b"></div>
    </div>
    <?php endif ?>
<?php endif ?>