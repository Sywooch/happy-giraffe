<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 * @param $user User
 */
Yii::app()->clientScript
    ->registerScriptFile('/javascripts/location.js')
    ->registerScriptFile('/javascripts/jquery.flip.js')
    ->registerCoreScript('jquery.ui');


if ($this->isMyProfile && empty($user->address->country_id)):?>
<div class="user-map user-add">
    <a href="#" onclick="UserLocation.OpenEdit();return false;"><big>Я живу<br>здесь</big><img
        src="/images/user_map_cap.png"></a>
    <?php $this->widget('application.widgets.mapWidget.MapWidget', array('user' => $this->user))?>
</div><?php

else:

?><div class="user-map">
    <div class="header">
        <?php if ($this->isMyProfile): ?>
        <a href="#" class="edit tooltip" onclick="UserLocation.OpenEdit();return false;" title="Изменить"></a>
        <?php endif ?>
        <div class="box-title">Я здесь</div>
        <div class="sep"><img src="/images/map_marker.png"></div>
        <div class="location">
            <?php echo $this->user->address->getFlag() ?> <?= $user->address->getCountryTitle() ?>
            <p><?= $user->address->getUserFriendlyLocation() ?></p>
        </div>
    </div>

    <?php $this->widget('application.widgets.mapWidget.MapWidget', array('user' => $this->user))?>
</div>
<?php endif;
