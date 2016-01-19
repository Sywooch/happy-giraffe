<?php

namespace site\frontend\modules\som\modules\idea\behaviors;

use \site\frontend\modules\posts\models\Content;

class ConvertBehavior extends \CActiveRecordBehavior
{
    const SERVICE = 'idea';

    public function events()
    {
        return array_merge(parent::events(), array(
            'onAfterSoftDelete' => 'afterSoftDelete',
            'onAfterSoftRestore' => 'afterSoftRestore',
        ));
    }

    public function getPost($entity)
    {
        $post = Content::model()->findByAttributes(array(
            'originEntity' => $entity,
            'originEntityId' => $this->owner->id,
            'originService' => self::SERVICE
        ));

        return $post ? $post : new Content();
    }

    public function afterSoftDelete($event)
    {
        $entity = array_search(get_class($this->owner), Content::$entityAliases);
        $post = $this->getPost($entity);
        $post->isRemoved = true;
        $post->save();
    }

    public function afterSoftRestore($event)
    {
        $entity = array_search(get_class($this->owner), Content::$entityAliases);
        $post = $this->getPost($entity);
        $post->isRemoved = false;
        $post->save();
    }

    public function afterSave()
    {
        $entity = array_search(get_class($this->owner), Content::$entityAliases);
        $post = $this->getPost($entity);

        $post->labels = $this->owner->labels;
        $post->url = $this->owner->getUrl();
        $post->authorId = $this->owner->authorId;
        $post->dtimeCreate = $post->dtimePublication = $this->owner->dtimeCreate;
        $post->dtimeUpdate = time();
        $post->isRemoved = 1;//чтобы скрыть в дефолт скопе //$this->owner->isRemoved;
        $post->title = htmlspecialchars(trim($this->owner->title));;
        $post->text = '';
        $post->preview = $post->html = $this->getIdeaTag();

        $post->originEntity = $entity;
        $post->originEntityId = $this->owner->id;
        $post->originService = self::SERVICE;

        $post->isAutoMeta = true;
        $post->meta = array(
            'description' => '',
            'title' => $post->title,
        );

        $post->social = array(
            'description' => $post->meta['description'],
        );

        $post->originManageInfo = array(
            'params' => array(
                'edit' => array(
                    'link' => array(
                        'url' => /*'/post/edit/photopost'*/
                            '' . $this->owner->id . '/', //хз какуй урл сюда, да и не надо.
                    )
                ),
                'remove' => array(
                    'api' => array(
                        'url' => '/api/idea/remove/',
                        'params' => array(
                            'id' => $this->owner->id,
                        ),
                    ),
                ),
                'restore' => array(
                    'api' => array(
                        'url' => '/api/idea/restore/',
                        'params' => array(
                            'id' => $this->owner->id,
                        ),
                    ),
                ),
            ),
        );

        $post->meta = \CJSON::encode($post->meta);
        $post->social = \CJSON::encode($post->social);
        $post->originManageInfo = \CJson::encode($post->originManageInfo);

        $post->save();
    }
     private function getIdeaTag()
     {
         return 'ideaTag';
     }
}
