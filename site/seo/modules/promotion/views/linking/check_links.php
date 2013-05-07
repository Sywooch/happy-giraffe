<div>
    <?php $this->widget('zii.widgets.CListView', array(
        'cssFile'=>false,
        'dataProvider' => $link->search(),
        'itemView' => '_link',
        'sortableAttributes' => array(
            'title',
            'create_time' => 'Post Time',
        ),
));

    ?>
</div>
<script type="text/javascript">
    var CheckLinks = {
        remove:function (page_id, page_to_id, el) {
            if (confirm("Точно удалить?")) {
                $.post('/promotion/linking/remove/', {
                    page_to_id:page_to_id,
                    page_id:page_id
                }, function (response) {
                    if (response.status)
                        $(el).parent().remove();
                    else
                        $.pnotify({
                            pnotify_title:'Ошибка',
                            pnotify_type:'error',
                            pnotify_text:'Обратитесь к разработчикам'
                        });
                }, 'json');
            }
        }
    }
</script>