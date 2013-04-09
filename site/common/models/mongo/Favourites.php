<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class Favourites extends EMongoDocument
{
    const BLOCK_SIMPLE = 1;
    const BLOCK_INTERESTING = 2;
    const BLOCK_BLOGS = 3;
    const BLOCK_THEME = 4;
    const BLOCK_VIDEO = 5;
    const WEEKLY_MAIL = 6;
    const BLOCK_SOCIAL_NETWORKS = 7;

    public $block;
    public $entity;
    public $entity_id;
    public $index = 0;
    public $date;
    public $created;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'favourites';
    }

    public function beforeSave()
    {
        return parent::beforeSave();
    }

    /**
     * Соединение с базой данных
     * @return EMongoDB
     */
    public function getMongoDBComponent()
    {
        return Yii::app()->getComponent('mongodb_production');
    }

    /**
     * Добавить в список если нет или удалить если есть в списке
     *
     * @param $model CActiveRecord
     * @param $block int
     * @return bool
     */
    public static function toggle($model, $block)
    {
        $block = (int)$block;
        $criteria = new EMongoCriteria;
        $criteria->entity('==', get_class($model));
        $criteria->entity_id('==', (int)$model->primaryKey);
        $criteria->block('==', $block);

        $fav = self::model()->find($criteria);
        if ($fav !== null) {
            return $fav->delete();
        } else {
            $fav = new Favourites;
            $fav->entity = get_class($model);
            $fav->entity_id = (int)$model->primaryKey;
            if ($block == self::WEEKLY_MAIL)
                $fav->date = date("Y-m-d", strtotime('next monday'));
            else
                $fav->date = date("Y-m-d", strtotime('+1 day'));

            $criteria = new EMongoCriteria;
            $criteria->date('==', $fav->date);
            $criteria->block('==', $block);
            $fav->index = (int)self::model()->count($criteria);
            $fav->block = $block;

            return $fav->save();
        }
    }

    /**
     * Находиться элемент в списке
     * @param $model CActiveRecord
     * @param $block int
     * @return bool
     */
    public static function inFavourites($model, $block)
    {
        $criteria = new EMongoCriteria;
        $criteria->entity('==', get_class($model));
        $criteria->entity_id('==', (int)$model->primaryKey);
        $criteria->block('==', (int)$block);

        $fav = self::model()->find($criteria);
        return $fav !== null;
    }

    /**
     * Возворащает список id статей на дату
     * @param $index int блок
     * @param $date string дата
     * @return array
     */
    public static function getIdListByDate($index, $date)
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', (int)$index);
        $criteria->date('==', $date);
        $criteria->sort('index', EMongoCriteria::SORT_ASC);

        $models = self::model()->findAll($criteria);
        $ids = array();
        foreach ($models as $model)
            $ids [] = $model->entity_id;

        return $ids;
    }

    /**
     * Возворащает список статей на дату, сортирует модели по их позиции
     * @param $index
     * @param $date
     * @param $limit
     * @return CommunityContent[]
     */
    public static function getArticlesByDate($index, $date, $limit = null)
    {
        $ids = self::getIdListByDate($index, $date);
        $criteria = new CDbCriteria;
        $criteria->limit = $limit;
        $criteria->with = array(
            'rubric' => array(
                'select' => array('community_id', 'user_id'),
            ),
            'type' => array(
                'select' => array('slug')
            ),
            'post',
            'video'
        );
        $criteria->select = array('t.id', 't.title', 't.type_id', 't.rubric_id', 't.author_id');
        $criteria->compare('t.id', $ids);
        $models = CommunityContent::model()->findAll($criteria);

        $sorted_models = array();
        foreach ($ids as $id) {
            foreach ($models as $model) {
                if ($model->id == $id)
                    $sorted_models[] = $model;
            }
        }

        return $sorted_models;
    }

    public static function getListByDate($index, $date)
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', (int)$index);
        $criteria->date('==', $date);
        $criteria->sort('index', EMongoCriteria::SORT_ASC);

        $models = self::model()->findAll($criteria);
        return $models;
    }

    /**
     * Возвращает список id постов для комментирования
     *
     * @param $index
     * @return array
     */
    public static function getListForCommentators($index)
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', (int)$index);
        $criteria->date('==', date("Y-m-d", strtotime('+1 day')));
        $criteria->limit(self::getLimit($index));
        #TODO добавить ограничения чтобы не комментировали те, которые уже неактуальны, например в email-рассылке

        $models = self::model()->findAll($criteria);
        $ids = array();
        foreach ($models as $model)
            $ids [] = $model->entity_id;

        return $ids;
    }

    /**
     * Возвращает лимит постов для комментирования
     *
     * @param $index тип блока
     * @return int
     */
    public static function getLimit($index)
    {
        switch ($index) {
            case self::BLOCK_BLOGS:
                return 12;
            case self::BLOCK_INTERESTING:
                return 4;
            case self::BLOCK_SOCIAL_NETWORKS:
                return 10;
            case self::WEEKLY_MAIL:
                return 6;
        }

        return 1;
    }

    /**
     * Изменяет позицию элемента в списке и дату когда будет показан элемент
     *
     * @param $date string новая дата
     * @param $index int новая позиция в списке
     */
    public function changePosition($date, $index)
    {
        $criteria = new EMongoCriteria();
        $criteria->addCond('block', '==', (int)$this->block);
        $criteria->addCond('date', '==', $this->date);
        $criteria->setSort(array('index', EMongoCriteria::SORT_ASC));
        $elements = self::model()->findAll($criteria);
        foreach ($elements as $key => $element)
            if ($element->_id == $this->_id)
                unset($elements[$key]);
        $elements = array_values($elements);

        $found = false;
        for ($i = 0; $i < count($elements); $i++) {
            if ($index == $i) {
                $this->index = $i;
                $found = true;
                $elements[$i]->index = $i + 1;
            } else {
                if ($found)
                    $elements[$i]->index = $i + 1;
                else
                    $elements[$i]->index = $i;
            }
            $elements[$i]->save();
        }
        if (!$found)
            $this->index = count($elements);

        $this->date = $date;
        $this->save();
    }

    /**
     * @return CActiveRecord
     */
    public function getArticle()
    {
        return CActiveRecord::model($this->entity)->full()->findByPk($this->entity_id);
    }
}