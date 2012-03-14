<li class="clearfix">
    <?php $this->widget('AvatarWidget', array(
        'user' => $data,
    )); ?>
    <div class="details">
        <?php echo CHtml::link($data->fullName, $data->url, array('class' => 'username')); ?>
    </div>
</li>