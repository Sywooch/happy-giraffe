<div class="content">
    <div class="meta">
        <span class="date"><?php echo HDate::GetFormattedTime($data->created, ', '); ?></span>
    </div>
    <div class="content-in">
        <?php echo $data->text; ?>
    </div>
    <?php $this->render('_admin_actions', compact('data')) ?>
</div>