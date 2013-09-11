<?php
$content = $this->widget('application.modules.family.widgets.UserFamilyWidget', array('user' => $this->user, 'return' => true));
?>
<?php if ($content !== null): ?>
<div class="b-family b-family__bg-dark b-family__bg">
    <div class="b-family_top b-family_top__white"></div>
    <?=$content?>
</div>
<?php endif; ?>