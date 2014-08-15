<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 14/08/14
 * Time: 16:29
 */

class MultiModelDataProvider extends CDataProvider
{
    protected $models;
    protected $sortColumn;

    public function __construct($models, $sortColumn, $config = array())
    {
        foreach ($models as $modelClass => $criteria) {
            $this->sortColumn = $sortColumn;
            $this->models[$modelClass] = $criteria instanceof \CDbCriteria ? $criteria : new \CDbCriteria($criteria);
            foreach ($config as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    protected function fetchData()
    {
        $data = array();

        foreach ($this->models as $modelClass => $criteria) {
            $criteria->limit = $this->pagination->pageSize * ($this->pagination->currentPage + 1);
            $modelData = \CActiveRecord::model($modelClass)->findAll($criteria);
            foreach ($modelData as $model) {
                $data[] = $model;
            }
        }

        $sortColumn = $this->sortColumn;
        usort($data, function($a, $b) use ($sortColumn) {
            if ($a->$sortColumn == $b->$sortColumn) {
                return 0;
            }
            return ($a->$sortColumn < $b->$sortColumn) ? -1 : 1;
        });

        return array_slice($data, $this->pagination->pageSize * ($this->pagination->currentPage - 1), $this->pagination->pageSize);
    }

    protected function fetchKeys()
    {
        $keys = array();
        foreach ($this->getData() as $i => $data)
        {
            $key = $data->primaryKey();
            $keys[$i] = is_array($key) ? implode(',',$key) : $key;
        }
        return $keys;
    }

    protected function calculateTotalItemCount()
    {
        $total = 0;
        foreach ($this->models as $modelClass => $criteria) {
            $total += \CActiveRecord::model($modelClass)->count($criteria);
        }

        return $total;
    }

} 