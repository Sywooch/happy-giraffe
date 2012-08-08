<div class="user-map list-item">
    <div class="header">
        <div class="box-title">Я здесь</div>
        <div class="sep"><img src="/images/map_marker.png"></div>
        <div class="location">
            <?=$action->data['flag']?> <?=$action->data['country_name']?>
            <p><?=$action->data['locationWithoutCountry']?></p>
        </div>
    </div>

    <?php $this->widget('application.widgets.mapWidget.MapWidget', array(
        'country_id' => $action->data['country_id'],
        'locationString' => $action->data['locationString'],
    ))?>
</div>