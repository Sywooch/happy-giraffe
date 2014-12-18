<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 14/08/14
 * Time: 16:29
 */

class MultiModelDataProvider extends CDataProvider
{
    protected $modelsConfig;

    public function __construct($modelsConfig)
    {
        foreach ($modelsConfig as &$modelConfig) {
            if (! isset($modelConfig['criteria'])) {
                $modelConfig['criteria'] = new CDbCriteria();
            } elseif (is_array($modelConfig['criteria'])) {
                $modelConfig['criteria'] = new CDbCriteria($modelConfig['criteria']);
            }
        }
        $this->modelsConfig = $modelsConfig;
    }

    protected function fetchData()
    {
        if(($pagination = $this->getPagination()) !== false)
        {
            $pagination->setItemCount($this->getTotalItemCount());
        }

        $data = array();

        foreach ($this->modelsConfig as $modelClass => $config) {
            $criteria = $config['criteria'];
            $criteria->limit = $this->pagination->pageSize * ($this->pagination->currentPage + 1);
            $modelData = \CActiveRecord::model($modelClass)->findAll($criteria);
            foreach ($modelData as $model) {
                $data[] = $model;
            }
        }

        $this->sort($data);

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
        foreach ($this->modelsConfig as $modelClass => $config) {
            $total += (int) \CActiveRecord::model($modelClass)->count($config['criteria']);
        }

        return $total;
    }

    protected function sort(&$data)
    {
        $config = $this->modelsConfig;

        usort($data, function($a, $b) use ($config) {
            $aSortColumn = $config[get_class($a)]['sortColumn'];
            $bSortColumn = $config[get_class($b)]['sortColumn'];

            if ($a->$aSortColumn == $b->$bSortColumn) {
                return 0;
            }
            return ($a->$aSortColumn < $b->$bSortColumn) ? -1 : 1;
        });
    }
} 