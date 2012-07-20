<?php
/**
 * User: Eugene
 * Date: 04.03.12
 */
class RemoveWidget extends CWidget
{
    /**
     * @var CActiveRecord
     */
    public $model;
    public $modelName = null;

    /**
     * @var
     * JavaScript callback function
     */
    public $callback;

    /**
     * @var boolean
     */
    public $author = false;

    public $template = '<i class="icon"></i>';

    public $cssClass = 'remove';

    public function run()
    {
        if($this->model)
            $this->render('index');
    }

    public function registerTemplates()
    {
        if(Yii::app()->user->isGuest)
            return false;
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
            $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/remove_widget.js')
            ->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.tmpl.min.js');
        echo '<script id="comment_delete_by_author_tmpl" type="text/x-jquery-tmpl">
                        <div class="popup-confirm popup" id="deleteComment">
                            <a class="popup-close" onclick="$.fancybox.close();" href="javascript:void(0);">Закрыть</a>
                            <div class="confirm-before">
                                <form method="post" action="' . Yii::app()->createUrl('/ajax/removeEntity') . '">
                                    <input type="hidden" name="Removed[entity]" value="${entity}" />
                                    <input type="hidden" name="Removed[entity_id]" value="${entity_id}" />
                                    <input type="hidden" name="Removed[type]" value="0" />
                                    <div class="confirm-question">
                                        <p>Вы уверены, что<br>хотите удалить <span class="title0"></span>?</p>
                                    </div>
                                    <div class="bottom  bottom-center">
                                        <a onclick="$.fancybox.close();" class="btn btn-gray-medium" href="javascript:void(0);"><span><span>Отменить</span></span></a>
                                        <button onclick="RemoveWidget.remove(this, ${callback});return false;" class="btn btn-red-medium"><span><span>Удалить</span></span></button>
                                    </div>
                                </form>
                            </div>
                            <div class="confirm-after">
                                <p><span class="title1"></span>!</p>
                            </div>
                        </div>
                    </script>
                    <script id="comment_delete_tmpl" type="text/x-jquery-tmpl">
                        <div class="popup-confirm popup" id="deletePost">
                            <a class="popup-close" onclick="$.fancybox.close();" href="javascript:void(0);">Закрыть</a>
                            <div class="confirm-before">
                                <form method="post" action="' . Yii::app()->createUrl('/ajax/removeEntity') . '">
                                    <input type="hidden" name="Removed[entity]" value="${entity}" />
                                    <input type="hidden" name="Removed[entity_id]" value="${entity_id}" />
                                    <div class="confirm-question clearfix">
                                        <div class="reason">
                                            <div class="title">Причина удаления:</div>
                                            ' . CHtml::radioButtonList('Removed[type]', 1, Removed::$types) . '
                                            <input type="text" name="Removed[text]" class="other-reason">
                                        </div>

                                        <div class="question-in">
                                            <p>Вы уверены, что<br>хотите удалить <span class="title0"></span>?</p>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <a onclick="$.fancybox.close();" class="btn btn-gray-medium" href="javascript:void(0);"><span><span>Отменить</span></span></a>
                                        <button onclick="RemoveWidget.remove(this, ${callback});return false;" class="btn btn-red-medium"><span><span>Удалить</span></span></button>
                                    </div>
                                </form>
                            </div>
                            <div class="confirm-after">
                                <p><span class="title1"></span>!</p>
                            </div>
                        </div>
                    </script>';
    }

    public function getTitle($entity)
    {
        if ($entity == 'Comment')
            return array('этот<br>комментарий','Комментарий успешно удален');
        if ($entity == 'CommunityContent')
            return array('эту<br>статью', 'Статья успешно удалена');
        if ($entity == 'BlogContent')
            return array('эту<br>запись', 'Запись успешно удалена');
        if ($entity == 'Album')
            return array('этот<br>альбом', 'Альбом успешно удален');
        if ($entity == 'AlbumPhoto')
            return array('эту<br>фотографию', 'Фотография успешно удалена');
        return array('эту<br>запись', 'Запись успешно удалена');
    }
}
