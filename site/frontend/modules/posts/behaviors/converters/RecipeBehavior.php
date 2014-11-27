<?php

namespace site\frontend\modules\posts\behaviors\converters;

/**
 * Description of RecipeBehavior
 *
 * @author Кирилл
 * 
 * @property \CookRecipe $owner Owner
 */
class RecipeBehavior extends \CActiveRecordBehavior
{

    public function convertToNewPost()
    {
        $oldPost = $this->owner;

        $service = 'oldRecipe';
        $entity = get_class($this->owner);
        $entityId = $this->owner->id;

        $newPost = \site\frontend\modules\posts\models\Content::model()->resetScope()->findByAttributes(array(
            'originService' => $service,
            'originEntity' => $entity,
            'originEntityId' => $entityId,
        ));
        if (!$newPost)
            $newPost = new \site\frontend\modules\posts\models\Content('oldRecipe');

        $newPost->originService = $service;
        $newPost->originEntity = $entity;
        $newPost->originEntityId = $entityId;

        $newPost->title = $oldPost->title;
        $newPost->authorId = $oldPost->author_id;
        $newPost->url = $oldPost->getUrl(false, true);
        $newPost->text = 'fake';
        $newPost->html = 'fake';
        $newPost->preview = 'fake';
        $newPost->dtimeCreate = strtotime($oldPost->created);
        $newPost->dtimeUpdate = $newPost->dtimeCreate;
        $newPost->dtimePublication = $newPost->dtimeCreate;
        // $newPost->originManageInfoObject
        $newPost->isDraft = false;
        $newPost->isNoindex = false;
        $newPost->isNofollow = false;
        $newPost->isAutoMeta = false;
        $newPost->isAutoSocial = false;
        $newPost->isRemoved = $oldPost->removed;
        // $newPost->metaObject
        // $newPost->socialObject
        $newPost->templateObject->layout = 'fake';

        return $newPost->save();
    }

    public function afterSave($event)
    {
        parent::afterSave($event);
        $this->addTaskToConvert();
    }

    public function addTaskToConvert()
    {
        if (!\site\frontend\modules\posts\commands\ConvertCommand::addConvertTask($this->owner))
            $this->convertToNewPost();
    }

    protected function render($file, $data)
    {
        $file = \Yii::getPathOfAlias($file) . '.php';
        if (\Yii::app() instanceof \CConsoleApplication) {
            return \Yii::app()->command->renderFile($file, $data, true);
        } else {
            return \Yii::app()->controller->renderInternal($file, $data, true);
        }
    }

}
