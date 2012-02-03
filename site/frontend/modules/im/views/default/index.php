Поиск
<input type="text" id="search-dialog">
<br>
<?php
foreach ($dialogs as $dialog) {
    echo CHtml::link($dialog->lastMessage->user->last_name.' : '.$dialog->lastMessage->text.'<br>',
        $this->createUrl('/im/default/dialog', array('id'=>$dialog->id)));
}?>
<script type="text/javascript">
    $('#search-dialog').keyup(function(){
        var term = $(this).val().toLowerCase();
        $('.main-in a').each(function(index, Element){
            var name = $(this).text().toLowerCase();
            console.log(name);
            if (name.substring(0, term.length) !== term){
                $(this).hide();
            }else
                $(this).show();
        })
    });
</script>