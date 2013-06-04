<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 5/17/13
 * Time: 10:26 AM
 * To change this template use File | Settings | File Templates.
 */
class FavouritesDataProvider extends CActiveDataProvider
{
    public function __construct($config=array())
    {
        $this->modelClass='Favourite';
        $this->model=CActiveRecord::model($this->modelClass);
        $this->setId($this->modelClass);
        foreach($config as $key=>$value)
            $this->$key=$value;
    }

    protected function fetchData()
    {
        $criteria=clone $this->getCriteria();

        if(($pagination=$this->getPagination())!==false)
        {
            $pagination->setItemCount($this->getTotalItemCount());
            $pagination->applyLimit($criteria);
        }

        $baseCriteria=$this->model->getDbCriteria(false);

        if(($sort=$this->getSort())!==false)
        {
            // set model criteria so that CSort can use its table alias setting
            if($baseCriteria!==null)
            {
                $c=clone $baseCriteria;
                $c->mergeWith($criteria);
                $this->model->setDbCriteria($c);
            }
            else
                $this->model->setDbCriteria($criteria);
            $sort->applyOrder($criteria);
        }

        $this->model->setDbCriteria($baseCriteria!==null ? clone $baseCriteria : null);
        $data=$this->model->findAll($criteria);
        $this->model->setDbCriteria($baseCriteria);  // restore original criteria

        //получение необходимых id для выборки
        $entities = array();
        foreach ($data as $favourite)
            $entities[$favourite->entity][$favourite->entity_id] = null;

        //выборка и создание моделей
        foreach ($entities as $entity => $ids) {
            $criteria = new CDbCriteria(array(
                'index' => 'id',
            ));
            $criteria->addInCondition('t.id', array_keys($ids));
            if (isset(Yii::app()->controller->module->relatedModelCriteria[$entity]))
                $criteria->mergeWith(new CDbCriteria(Yii::app()->controller->module->relatedModelCriteria[$entity]));
            $models = CActiveRecord::model($entity)->findAll($criteria);
            foreach ($models as $m)
                $entities[$entity][$m->id] = $m;
        }

        //присваивание моделей соответсвующим элементам избранного
        foreach ($data as $favourite)
            $favourite->relatedModel = $entities[$favourite->entity][$favourite->entity_id];

        return $data;
    }
}
