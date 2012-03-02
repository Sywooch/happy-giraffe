<div class="default-comments">
    <div class="comments-meta">
        <a href="#add_comment" class="btn btn-orange a-right"><span><span>Добавить запись</span></span></a>
        <div class="title"><?php echo $this->title; ?></div>
        <div class="count"><?php echo $dataProvider->totalItemCount; ?></div>
    </div>
    <?php
    $this->widget('MyListView', array(
        'dataProvider' => $dataProvider,
        //'summaryText' => 'Показано',
        'itemView' => '_comment', // refers to the partial view named '_post'
        'summaryText' => 'показано: {start} - {end} из {count}',
        'pager' => array(
            'class' => 'MyLinkPager',
            'header' => 'Страницы',
        ),
        'id' => 'comment_list',
        'template' => '<ul>{items}</ul>
                <div class="pagination pagination-center clearfix">
                    {summary}
                    {pager}
                </div>
            ',
        'viewData' => array(
            'currentPage' => $dataProvider->pagination->currentPage,
        ),
    ));
    ?>
</div>
<script id="comment_delete_by_author_tmpl" type="text/x-jquery-tmpl">
    <div class="popup-confirm popup" id="deleteComment">
        <a class="popup-close" onclick="$.fancybox.close();" href="javascript:void(0);">Закрыть</a>
        <div class="confirm-before">
            <form method="post" action="<?php echo Yii::app()->createUrl('/ajax/removeEntity'); ?>">
                <input type="hidden" name="Removed[entity]" value="${entity}" />
                <input type="hidden" name="Removed[entity_id]" value="${entity_id}" />
                <input type="hidden" name="Removed[type]" value="0" />
                <div class="confirm-question">
                    <p>Вы уверены, что<br>хотите удалить этот<br>комментарий?</p>
                </div>
                <div class="bottom  bottom-center">
                    <a onclick="$.fancybox.close();" class="btn btn-gray-medium" href="javascript:void(0);"><span><span>Отменить</span></span></a>
                    <button onclick="confirmMessage(this, Comment.remove);return false;" class="btn btn-red-medium"><span><span>Удалить</span></span></button>
                </div>
            </form>
        </div>
        <div class="confirm-after">
            <p>Комментарий успешно удален!</p>
        </div>
    </div>
</script>
<script id="comment_delete_tmpl" type="text/x-jquery-tmpl">
    <div class="popup-confirm popup" id="deletePost">
        <a class="popup-close" onclick="$.fancybox.close();" href="javascript:void(0);">Закрыть</a>
        <div class="confirm-before">
            <form method="post" action="<?php echo Yii::app()->createUrl('/ajax/removeEntity'); ?>">
                <input type="hidden" name="Removed[entity]" value="${entity}" />
                <input type="hidden" name="Removed[entity_id]" value="${entity_id}" />
                <div class="confirm-question clearfix">
                    <div class="reason">
                        <div class="title">Причина удаления:</div>
                        <?php echo CHtml::radioButtonList('Removed[type]', 1, Removed::$types); ?>
                        <input type="text" name="Removed[text]" class="other-reason">
                    </div>

                    <div class="question-in">
                        <p>Вы уверены, что<br>хотите удалить эту<br>запись?</p>
                    </div>
                </div>
                <div class="bottom">
                    <a onclick="$.fancybox.close();" class="btn btn-gray-medium" href="javascript:void(0);"><span><span>Отменить</span></span></a>
                    <button onclick="confirmMessage(this, Comment.remove);return false;" class="btn btn-red-medium"><span><span>Удалить</span></span></button>
                </div>
            </form>
        </div>
        <div class="confirm-after">
            <p>Запись успешно удалена!</p>
        </div>
    </div>
</script>
<script type="text/javascript">
    $(document).ready(function() {});
</script>