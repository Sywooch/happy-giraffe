<div class="content wysiwyg-content">
    <div class="meta">
        <span class="date"><?php echo HDate::GetFormattedTime($data->created, ', '); ?></span>
    </div>
    <div class="content-in">
        <?php if (empty($data->commentAttaches)):?>
            <?php echo $data->text; ?>
        <?php else: ?>
        <?php foreach($data->commentAttaches as $attach) echo $attach->content; ?>
        <?php endif ?>
    </div>
    <?php $this->render('_admin_actions', compact('data')) ?>
</div>