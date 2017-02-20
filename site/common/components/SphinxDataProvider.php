<?php
namespace site\common\components;

class SphinxDataProvider extends \CActiveDataProvider
{
    private $_sphinxCriteria;
    private $_result;

    protected function getResult()
    {
        if (! $this->_result) {
            $this->_result = \Yii::app()->search->searchRaw($this->_sphinxCriteria);
            if (count($this->_result['matches']) == 0) {
                $sphinxCriteria = $this->getSphinxCriteria();
                $sphinxCriteria->paginator->itemCount = $this->_result['total_found'];
                $this->_result = \Yii::app()->search->searchRaw($this->_sphinxCriteria);
            }
        }
        return $this->_result;
    }

    protected function fetchData()
    {
        $resIterator = $this->getResult();
        $ids = array_keys($resIterator['matches']);

        $criteria = $this->getCriteria();
        $criteria->addInCondition($this->model->tableAlias . '.id', $ids);

        $criteria=clone $this->getCriteria();

        if(($pagination=$this->getPagination())!==false)
        {
            $pagination->setItemCount($this->getTotalItemCount());
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
            {
                $this->model->setDbCriteria($criteria);
            }
            $sort->applyOrder($criteria);
        }

        $this->model->setDbCriteria($baseCriteria!==null ? clone $baseCriteria : null);
        $data=$this->model->findAll($criteria);
        $this->model->setDbCriteria($baseCriteria);  // restore original criteria
        return $data;
    }

    protected function calculateTotalItemCount()
    {
        $resIterator = $this->getResult();
        return $resIterator['total_found'];
    }

    public function getSphinxCriteria()
    {
        return $this->_sphinxCriteria;
    }

    public function setSphinxCriteria($criteria)
    {
        if ($criteria instanceof \stdClass) {
            $this->_sphinxCriteria = $criteria;
        } else {
            $object = new \stdClass();
            foreach ($criteria as $k => $val) {
                $object->{$k} = $val;
            }
            $this->_sphinxCriteria = $object;
        }
        $this->_sphinxCriteria->paginator = $this->pagination;
        $this->_sphinxCriteria->paginator->itemCount = PHP_INT_MAX;
    }
}