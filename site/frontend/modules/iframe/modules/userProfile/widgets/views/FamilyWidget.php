<?php
$content = $this->widget('application.modules.iframe.modules.userProfile.widgets.UserFamilyWidget', array('user' => $this->user), true);
?>
<?php if ($content !== ''): ?>
<div class="b-family b-family__bg-dark b-family__bg">
    <div class="b-family_top b-family-iframe_top">дети</div>
    <?=$content?>
</div>
<?php endif; ?>