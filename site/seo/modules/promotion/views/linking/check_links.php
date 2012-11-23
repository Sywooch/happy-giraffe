<div>
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$link->search(),
        'itemView'=>'_link',
        'sortableAttributes'=>array(
            'title',
            'create_time'=>'Post Time',
        ),
    ));

    ?>
</div>