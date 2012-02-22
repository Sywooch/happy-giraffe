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
                if (Yii::app()->authManager->checkAccess('изменение рубрик в темах', Yii::app()->user->getId())) {
                    echo CHtml::hiddenField('rubric-id', $r->id);
                    echo '<br>'.CHtml::link('удалить', '#', array('class'=>'remove-rubric')).' ';
                    echo CHtml::link('редактировать', '#', array('class'=>'edit-rubric'));
                }
                ?>
            </li>
            <? endforeach; ?>

        </ul>


    </div>

    <div class="leftbanner">
        <a href=""><img src="/images/leftban.png"></a>
    </div>
    <script type="text/javascript">
        $('a.remove-rubric').click(function () {
            if (confirm('Вы точно хотите удалить рубрику?')) {
                var id = $(this).prev().val();
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl("/admin/CommunityRubric/delete") ?>',
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
    </script>
</div>