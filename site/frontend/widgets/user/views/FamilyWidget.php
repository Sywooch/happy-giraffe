<?php
/**
 * Author: alexk984
 * Date: 01.03.12
 */
?>
<div class="user-family">
    <div class="t"></div>
    <div class="c">
        <ul>
            <?php if (User::relationshipStatusHasPartner($user->relationship_status) && isset($user->partner)):?>
                <li class="clearfix">
                    <big><?php echo $user->getPartnerTitle($user->relationship_status) ?></big>
                    <div class="img"><a href="" onclick="return false;"><img src="<?php echo $user->getPartnerPhotoUrl() ?>"></a><span><?php echo $user->partner->name ?></span></div>
                    <p><?php echo $user->partner->notice ?></p>
                </li>
            <?php endif ?>
            <?php foreach ($user->babies as $baby): ?>
                <li class="clearfix">
                    <big><?php echo $baby->getGenderString() ?></big>
                    <div class="img"><a href="" onclick="return false;"><img src="<?php echo $baby->getImageUrl() ?>"></a>
                        <span><?php echo $baby->name ?>, <span><?php echo $baby->getAgeString() ?></span></span></div>
                    <p><?php echo $baby->notice ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="b"></div>
</div>