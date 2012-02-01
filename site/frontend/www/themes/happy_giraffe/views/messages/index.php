<?php echo CHtml::link('send_message', '#',array('id'=>'send_message')) ?>
<script type="text/javascript" src="/javascripts/dklab_realplexor.js"></script>
<script type="text/javascript">
    $('a#send_message').click(function(){
        $.ajax({
            url: '<?php echo Yii::app()->createUrl("messages/CreateMessage") ?>',
            data: {dialog:1,text:'dfdfdf'},
            type: 'POST',
            dataType:'JSON',
            success: function(response) {

            },
            context: $(this)
        });
        return false;
    });

    var realplexor = new Dklab_Realplexor(
        "http://chat.happy-giraffe.com/",  // Realplexor's engine URL; must be a sub-domain
        "demo_" // namespace
    );

    // Subscribe a callback to channel Alpha.
    realplexor.subscribe("Alpha", function (result, id) {
        alert(result);
    });

    // Subscribe a callback to channel Beta.
    realplexor.subscribe("Beta", function (result, id) {
        div.innerHTML = result;
    });

    // Apply subscriptions. Сallbacks are called asynchronously on data arrival.
    realplexor.execute();
</script>