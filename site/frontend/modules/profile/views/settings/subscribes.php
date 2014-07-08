<?php
/**
 * @var SubscribesForm $form
 */
?>

<div id="subscribes">
    <?php foreach ($form->attributeLabels() as $name => $label): ?>
        <div class="form-settings_label-row clearfix">
            <div class="form-settings_label form-settings_label__long">
                <?=$label?>
            </div>
            <div class="display-ib">
                <a class="a-checkbox" data-bind="click: function() {settings.toggle('<?=$name?>')}, css: { active : settings.<?=$name?> }"></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script type="text/javascript">
    function SubscribesViewModel(data) {
        var self = this;
        self.settings = new UserSettings(data);
    }

    vm = new SubscribesViewModel(<?=$form->toJSON()?>);
    ko.applyBindings(vm, document.getElementById('subscribes'));
</script>