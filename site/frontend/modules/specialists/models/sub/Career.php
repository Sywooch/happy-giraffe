<?php
/**
 * @author Никита
 * @date 24/08/16
 */

namespace site\frontend\modules\specialists\models\sub;


class Career extends Common implements \IHToJSON
{
    public $yearFrom;
    public $yearTo;

    public function __construct()
    {
        $this->attachEventHandler('onBeforeValidate', function() {
            $parts = explode('-', $this->years);
            if (count($parts) == 2) {
                $this->yearFrom = $parts[0];
                $this->yearTo = $parts[1];
            }
        });
        $this->attachEventHandler('onAfterValidate', function() {
            if ($this->getErrors('yearFrom') || $this->getErrors('yearTo')) {
                $this->addError('years', 'Неверный формат');
                foreach (['yearFrom', 'yearTo'] as $attribute) {
                    $this->clearErrors($attribute);
                }
            }
        });
    }

    public function attributeLabels()
    {
        return [
            'years' => 'Период',
            'place' => 'Место работы',
        ];
    }

    public function rules()
    {
        return  [
            ['yearFrom, yearTo, place', 'required'],
            ['yearFrom, yearTo', 'filter', 'filter' => 'trim'],
            ['yearFrom, yearTo', 'numerical', 'integerOnly' => true, 'max' => date('Y'), 'min' => date('Y') - 100],
            ['years', 'filter', 'filter' => function() {return $this->yearFrom . ' - ' . $this->yearTo;}],
        ];
    }
//
//    public function validateYears($attribute, $params)
//    {
//        $parts = explode('-', $this->$attribute);
//        if (count($parts) != 2) {
//            $this->addError($attribute, 'Неверный формат');
//        } else {
//            foreach ($parts as $part) {
//                $val = intval($part);
//                if ($val < 1900 || $val > 2100) {
//                    $this->addError($attribute, 'Неверный формат');
//                    break;
//                }
//            }
//        }
//    }
//
//    protected function formatYears($string)
//    {
//        $parts = explode('-', $string);
//        if (count($parts) != 2) {
//            return $string;
//        }
//
//        return implode(' - ', array_map(function($year) {
//            return trim($year);
//        }, $parts));
//    }
}