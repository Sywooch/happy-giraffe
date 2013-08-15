<?php 
$user = $data->friend;
?><div class="friends-list_i">
    <?php $this->widget('UserAvatarWidget', array('user' => $user, 'size' => 200, 'age' => true)) ?>
    <div class="friends-list_location clearfix">
        <?php
        if (!empty($user->address->country_id))
            echo $user->address->getFlag(false, 'span') . ' ' . $user->address->country->name;
        if (!empty($user->address->city_id) || !empty($user->address->region_id))
            echo ', ' . $user->address->getUserFriendlyLocation();
        ?>
    </div>
    <div class="find-friend-famyli">

    </div>
</div>