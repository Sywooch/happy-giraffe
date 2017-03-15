<?php

namespace site\frontend\modules\geo2\components\combined\modifier;
use site\frontend\modules\geo2\components\combined\models\Geo2City;
use site\frontend\modules\geo2\components\combined\models\Geo2Country;
use site\frontend\modules\geo2\components\combined\models\Geo2Region;

/**
 * @author Никита
 * @date 14/03/17
 */
abstract class Modifier
{
    const TYPE_COUNTRY = 'country';
    const TYPE_REGION = 'region';
    const TYPE_CITY = 'city';
    
    abstract public function convertCountry($row);
    abstract public function convertRegion($row);
    abstract public function convertCity($row);
    abstract protected function getType($table, $row);
    abstract protected function getFk();

    private static $_instance;

    public static function instance()
    {
        if (! self::$_instance) {
            self::$_instance = new static();
        }
        return self::$_instance;
    }

    protected function __construct()
    {

    }
    
    public function insert($table, $row)
    {
        $this->wrap(function() use ($table, $row) {
            $type = $this->getType($table, $row);
            \Yii::app()->db->createCommand()->insert($table, $row);
            if ($type) {
                \Yii::app()->db->createCommand()->insert($this->getDestinationTable($type), $this->process($type, $row));
            }
        });
    }
    
    public function update($table, $row, $pk)
    {
        $this->wrap(function() use ($table, $row, $pk) {
            $type = $this->getType($table, $row);
            \Yii::app()->db->createCommand()->update($table, $row, 'id = :id', [':id' => $pk]);
            if ($type) {
                \Yii::app()->db->createCommand()->update($this->getDestinationTable($type), $this->process($type, $row), "{$this->getFk()} = :fk", [':fk' => $pk]);
            }
        });
    }

    public function delete($table, $row, $pk)
    {
        $this->wrap(function() use ($table, $row, $pk) {
            $type = $this->getType($table, $row);
            \Yii::app()->db->createCommand()->delete($table, 'id = :id', [':id' => $pk]);
            if ($type) {
                \Yii::app()->db->createCommand()->delete($this->getDestinationTable($type), "{$this->getFk()} = :fk", [':fk' => $pk]);
            }
        });
    }

    protected function wrap($callback)
    {
        if (! \Yii::app()->db->getCurrentTransaction()) {
            $transaction = \Yii::app()->db->beginTransaction();
            try {
                $callback();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        } else {
            $callback();
        }
    }

    protected function getDestinationTable($type)
    {
        return [
            self::TYPE_COUNTRY => Geo2Country::model()->tableName(),
            self::TYPE_REGION => Geo2Region::model()->tableName(),
            self::TYPE_CITY => Geo2City::model()->tableName(),
        ][$type];
    }

    protected function process($type, $row)
    {
        switch ($type) {
            case self::TYPE_COUNTRY;
                return $this->convertCountry($row);
            case self::TYPE_REGION;
                return $this->convertRegion($row);
            case self::TYPE_CITY;
                return $this->convertCity($row);
            default:
                throw new \CException('Unknown type');
        }
    }
}