<div class="section-banner" style="height: 297px;">
    <div class="section-nav" style="left:330px;top:40px;">
        <?php
        /*
              $items = array();
              foreach ($content_types as $ct)
              {
                  $params = array('community_id' => $community->id);
                  if ($current_rubric !== null) $params['rubric_id'] = $current_rubric;
                  if ($content_type != null) $params['content_type_slug'] = $content_type->slug;
                  $items[] = array(
                      'label' => '<span><span>' . $ct->name_plural . '</span></span></a>',
                      'url' => array('/community/list', 'community_id' => $community->id, 'content_type_slug' => $ct->slug),
                      'active' => $content_type !== null AND $content_type->slug == $ct->slug,
                      'linkOptions' => array(
                          'class' => 'btn btn-blue-shadow',
                      ),
                  );
              }

              $this->widget('zii.widgets.CMenu', array(
                  'encodeLabel' => false,
                  'items' => $items,
              ));
              */
        ?>
    </div>
    <img src="/images/community/<?php echo $community->id; ?>.jpg"/>
</div>

<div class="left-inner">

    <div class="add">
        <a href="" class="btn btn-green-arrow-down"><span><span>Добавить</span></span></a>
        <ul class="leftadd">
            <? foreach ($content_types as $ct): ?>
            <?
            if ($ct->slug == 'travel' && $community->id != 21) break;
            $add_params = array('community_id' => $community->id, 'content_type_slug' => $ct->slug);
            if (!is_null($current_rubric)) $add_params['rubric_id'] = $current_rubric;
            if (Yii::app()->user->isGuest) {
                $url = '#login';
                $htmlOptions = array('class' => 'fancy');
            }
            else
            {
                $url = ($ct->slug == 'travel') ? CController::createUrl('community/addTravel') : CController::createUrl('community/add', $add_params);
                $htmlOptions = array();
            }

            $htmlOptions['rel'] = 'nofollow';
            ?>
            <?= CHtml::tag('li', array(), CHtml::link($ct->name_accusative, $url, $htmlOptions)) ?>
            <? endforeach; ?>
        </ul>
    </div>

    <div class="themes">
        <div class="theme-pic">Рубрики</div>
        <ul class="leftlist">
            <? foreach ($community->rubrics as $r): ?>
            <li>
                <?php
                $params = array('community_id' => $community->id, 'rubric_id' => $r->id);
                if ($content_type !== null)
                    $params['content_type_slug'] = $content_type->slug;
                echo CHtml::link($r->name, CController::createUrl('community/list', $params), $r->id == $current_rubric ? array('class' => 'current') : array());
                if (Yii::app()->authManager->checkAccess('edit rubrics', Yii::app()->user->getId(), array('community_id'=>$community->id))) {
                    echo '<br>'.CHtml::hiddenField('rubric-'.$r->id, $r->id,array('class'=>'rubric-id'));
                    echo CHtml::link('удалить', '#', array('class'=>'remove-rubric')).' ';
                    echo CHtml::link('редактировать', '#', array('class'=>'edit-rubric'));
                }?>
            </li>
            <? endforeach; ?>
            <?php if (Yii::app()->authManager->checkAccess('edit rubrics', Yii::app()->user->getId(), array('community_id'=>$community->id))) {
                echo CHtml::link('добавить', '#', array('class'=>'add-rubric'));
        } ?>
        </ul>
        <?php $res = Yii::app()->authManager->checkAccess('delete post', Yii::app()->user->getId());
        var_dump($res);
        ?>
    </div>

    <div class="leftbanner">
        <a href=""><img src="/images/leftban.png"></a>
    </div>
</div>
<script type="text/javascript">
    $('a.remove-rubric').click(function () {
        if (confirm('Вы точно хотите удалить рубрику?')) {
            var id = $(this).parent().find('input.rubric-id').val();
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("communityRubric/delete") ?>',
                data: {id:id},
                type: 'POST',
                dataType:'JSON',
                success: function(response) {
                    if (response.status)
                        $(this).parent().remove();
                    else
                        alert('Рубрика должна быть пустой');
                },
                context: $(this)
            });
        }
        return false;
    });

    $('.edit-rubric').click(function(){
        var text = $(this).parent().find('a:first').text();
        $(this).parent().append('<input type="text" class="edit-field" value="'+text+'"><a href="#" class="send-edit-rubric">OK</a>');
        return false;
    });

    $('body').delegate('a.send-edit-rubric', 'click', function(){
        var id = $(this).parent().find('input.rubric-id').val();
        var text = $(this).prev().val();
        $.ajax({
            url: '<?php echo Yii::app()->createUrl("communityRubric/update") ?>',
            data: {id:id,text:text},
            type: 'POST',
            dataType:'JSON',
            success: function(response) {
                if (response.status){
                    $(this).parent().parent().find('a:first').text(text);
                    $(this).prev().remove();
                    $(this).remove();
                }else{
                    alert('Ошибка, обратитесь к разработчикам');
                }
            },
            context: $(this)
        });
        return false;
    });
</script>
<style type="text/css">
    .edit-field{
        background: #fff;
    }
</style>