<div class="content wysiwyg-content">
    <div class="meta">
        <span class="num" id="cp_<?php echo $data->position; ?>"><?php echo $data->position; ?></span>
        <span class="date"><?php echo HDate::GetFormattedTime($data->created, ', '); ?></span>
        <?php if (($data->response_id !== null && $response = $data->response) || ($data->quote_id !== null && $response = $data->quote)): ?>
        <div class="answer">
            Ответ для
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $response->author, 'sendButton' => false, 'small' => true, 'size' => 'small', 'hideLinks'=>true)); ?>
            на <span class="num"><a href="#" onclick="return <?php echo $this->objectName; ?>.goTo(<?php echo $response->position; ?>, <?php echo $currentPage + 1; ?>);"><?php echo $response->position; ?></a></span>
        </div>
        <?php endif; ?>
    </div>
    <?php if($this->vote && $data->rating != 0): ?>
        <div class="rating">
            <?php for($i = 0;$i < $data->rating; $i++): ?>
                <span class="s1"></span>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
    <?php if (($data->quote_id !== null && $data->quote)): ?>
    <input type="hidden" name="selectable_quote" value="<?php echo $data->quote_text != '' ? 1 : 0; ?>"/>
    <div class="quote" id="commentQuote_<?php echo $data->quote->id; ?>">
        <?php echo $data->quote_text != '' ? $data->quote_text : $data->quote->text; ?>
    </div>
    <?php endif; ?>
    <div class="content-in">
        <?php echo $data->purified->text; ?>
    </div>
    <?php $this->render('_admin_actions', compact('data')) ?>
</div>
