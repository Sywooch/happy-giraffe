<?php
/* @var $this Controller
 * @var $data User
 */
?><li class="newuser-list_item">
    <?php if ($data->online):?>
        <div class="online-status">На сайте</div>
    <?php endif ?>
    <?php
    $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
        'user' => $data,
        'friendButton' => true,
        'location' => true,
    )) ?>
</li>