<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 5/24/13
 * Time: 7:08 PM
 * To change this template use File | Settings | File Templates.
 */

class TagsController extends HController
{
    const POPULAR_TAGS_LIMIT = 100;
    const TYPE_POPULAR = 0;
    const TYPE_BY_LETTER = 1;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($type = 0, $letter = null)
    {
        $letters = TagsManager::getFirstLetters(Yii::app()->user->id);

        if ($type == self::TYPE_BY_LETTER) {
            $letter = $letter === null ? $letters[0] : $letter;
            $tags = TagsManager::getTagsByFirstLetter(Yii::app()->user->id, $letter);
        }
        else
            $tags = TagsManager::getPopularTags(Yii::app()->user->id, self::POPULAR_TAGS_LIMIT);

        $cloud = TagsManager::processForCloud($tags);

        $menu = array();
        $nonZero = 0;
        foreach ($this->module->entities as $entity => $config) {
            $count = FavouritesManager::getCountByUserId(Yii::app()->user->id, $entity);
            if ($count > 0)
                $nonZero++;
            $menu[] = array(
                'entity' => $entity,
                'title' => $config['title'],
                'count' => $count,
            );
        }
        $showMenu = $nonZero > 1;

        $this->pageTitle = 'Избранное';
        $this->render('index', compact('type', 'letter', 'letters', 'cloud', 'menu', 'showMenu'));
    }
}