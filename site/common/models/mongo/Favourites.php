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
    const CLUB_MORE = 8;
    const BLOCK_MAIL = 9;

    public $block;
    public $entity;
    public $entity_id;
    public $index = 0;
    public $date;
    public $created;

    /**
     * @param string $className
     * @return Favourites
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'favourites';
    }

    public function indexes()
    {
        return array(
            'find_one' => array(
                'key' => array(
                    'entity' => 1,
                    'entity_id' => -1,
                )
            ),
            'date' => array(
                'key' => array(
                    'date' => -1,
                    'block' => 1,
                )
            )
        );
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
        $block = (int) $block;
        $criteria = new EMongoCriteria;
        $criteria->entity('==', get_class($model));
        $criteria->entity_id('==', (int) $model->primaryKey);
        $criteria->block('==', $block);

        $fav = self::model()->find($criteria);
        if ($fav !== null)
        {
            return $fav->delete();
        }
        else
        {
            $fav = new Favourites;
            $fav->entity = get_class($model);
            $fav->entity_id = (int) $model->primaryKey;

            switch ($block)
            {
                case self::WEEKLY_MAIL:
                    $fav->date = date("Y-m-d", strtotime('next monday', time() - 3600 * 24));
                    break;
                case self::BLOCK_MAIL:
                    Yii::import('application.modules.mail.components.senders.*');
                    $fav->date = MailSenderDaily::nextDate();
                    break;
                default:
                    $fav->date = date("Y-m-d", strtotime('+1 day'));
            }

            $criteria = new EMongoCriteria;
            $criteria->date('==', $fav->date);
            $criteria->block('==', $block);
            $fav->index = (int) self::model()->count($criteria);
            $fav->block = $block;
            $fav->created = date("Y-m-d H:i:s");

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
        $criteria->entity_id('==', (int) $model->primaryKey);
        $criteria->block('==', (int) $block);

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
        $criteria->block('==', (int) $index);
        $criteria->date('==', $date);
        $criteria->sort('index', EMongoCriteria::SORT_ASC);

        $models = self::model()->findAll($criteria);

        var_dump($models);
        die;

        $ids = array();
        foreach ($models as $model)
            $ids [] = $model->entity_id;

        return $ids;
    }

    /**
     * Возворащает список статей на дату, сортирует модели по их позиции
     * @param $index int блок
     * @param $date string дата
     * @param $limit
     * @return CommunityContent[]
     */
    public static function getArticlesByDate($index, $date, $limit = null)
    {
        $ids = self::getIdListByDate($index, $date);

        if (empty($ids))
            return array();
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
        $criteria->select = array('t.*');
        $criteria->compare('t.id', $ids);
        $criteria->order = 't.id ASC';
        $models = CommunityContent::model()->findAll($criteria);

        $sorted_models = array();
        foreach ($ids as $id)
        {
            foreach ($models as $model)
            {
                if ($model->id == $id)
                    $sorted_models[] = $model;
            }
        }

        return $sorted_models;
    }

    public function getWeekPosts($date = null)
    {
        if ($date === null) {
            $date = date("Y-m-d");
        }
        return $this->getArticlesByDate(self::WEEKLY_MAIL, $date);
    }

    /**
     * Возвращает модели на определенную дату для определенного блока
     * @param $index int блок
     * @param $date string дата
     * @return Favourites[]
     */
    public static function getListByDate($index, $date)
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', (int) $index);
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
        if ($index == self::WEEKLY_MAIL)
        {
            return self::getIdsByDate($index, date("next monday"));
        }
        else
        {
            return array_merge(
                self::getIdsByDate($index, date("Y-m-d")), self::getIdsByDate($index, date("Y-m-d", strtotime('+1 day')))
            );
        }
    }

    public static function getIdsByDate($index, $date)
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', (int) $index);
        $criteria->date('==', $date);

        $models = self::model()->findAll($criteria);
        $ids = array();
        foreach ($models as $model)
            $ids [] = $model->entity_id;

        return $ids;
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
        $criteria->addCond('block', '==', (int) $this->block);
        $criteria->addCond('date', '==', $this->date);
        $criteria->setSort(array('index', EMongoCriteria::SORT_ASC));
        $elements = self::model()->findAll($criteria);
        foreach ($elements as $key => $element)
            if ($element->_id == $this->_id)
                unset($elements[$key]);
        $elements = array_values($elements);

        $found = false;
        for ($i = 0; $i < count($elements); $i++)
        {
            if ($index == $i)
            {
                $this->index = $i;
                $found = true;
                $elements[$i]->index = $i + 1;
            }
            else
            {
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
     * Возвращает связанную с модель статью
     * @return CActiveRecord
     */
    public function getArticle()
    {
        return CActiveRecord::model($this->entity)->resetScope()->findByPk($this->entity_id);
    }

    public static function getIdListByBlock($block)
    {
        $criteria = new EMongoCriteria();
        $criteria->addCond('block', '==', $block);
        $models = self::model()->findAll($criteria);
        $modelsIds = array_map(function($model)
            {
                return $model->entity_id;
            }, $models);
        return $modelsIds;
    }

}