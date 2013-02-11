<?php
/*
 * @var $data CommunityContent
 */

$mobileCommunity = $data->rubric->community->mobileCommunity;
$full = $this->action == 'view';
?>

<div class="entry">
    <div class="margin-b10">
        <?=CHtml::link($mobileCommunity->title, $mobileCommunity->url, array('class' => 'text-small'))?>
    </div>
    <?php $this->renderPartial('/_entry_header', array('data' => $data, 'full' => $full)); ?>
    <div class="entry-content wysiwyg-content clearfix">

        <p>Как правило, кроватку новорожденному приобретают незадолго до его появления на свет. При этом многие молодые <b>родители</b> обращают внимание главным <u>образом</u> на ее <strike>внешний</strike> вид. Но, прельстившись яркими красками, многие платят баснословные суммы, <strong>даже не поинтересовавшись</strong>, из чего сделано это покорившее вас чудо...</p>
    </div>


</div>