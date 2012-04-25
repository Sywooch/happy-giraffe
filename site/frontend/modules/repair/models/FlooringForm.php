<?php

class FlooringForm extends CFormModel
{
    public $flooringLength;
    public $flooringWidth;
    public $floorLength;
    public $floorWidth;
    public $flooringType;

    public $flooringTypes = array(1 => 'Керамическая плитка', 2 => 'Паркет', 3 => 'Паркетная доска', 4 => 'Ламинат', 5 => 'Линолеум', 6 => 'Ковролин');
    public $t = 4;

    public function rules()
    {
        return array(
            //array('flooringLength', 'required', 'message' => 'Укажите длину покрытия'),

            array('flooringType', 'required', 'message' => 'Укажите тип покрытия'),
            array('flooringLength', 'validateFloorLength'),
            array('flooringWidth', 'required', 'message' => 'Укажите ширину покрытия'),
            array('floorLength', 'required', 'message' => 'Укажите длину пола'),
            array('floorWidth', 'required', 'message' => 'Укажите ширину пола'),
            array('flooringLength, flooringWidth, floorLength, floorWidth', 'numerical', 'message' => 'Введите десятичное число'),
            array('flooringLength, flooringWidth, floorLength, floorWidth', 'normalizeLength')
        );
    }

    public function attributeLabels()
    {
        return array(
            'flooringType' => 'Тип покрытия',
            'flooringLength' => 'Длина покрытия',
            'flooringWidth' => 'Ширина покрытия',
            'floorLength' => 'Длина пола',
            'floorWidth' => 'Ширина пола'
        );
    }

    public function validateFloorLength($attribute, $params)
    {
        if ($this->flooringType <= $this->t) {
            if (!$this->$attribute) {
                $this->addError($attribute, 'Укажите длину покрытия');
                $this->normalizeLength($attribute, $params);
                if (!is_float($this->$attribute)) {
                    $this->addError($attribute, 'Введите десятичное число');
                }
            }
        }

    }

    public function normalizeLength($attribute, $params)
    {
        $this->$attribute = trim(str_replace(',', '.', $this->$attribute));
        $this->$attribute = preg_replace('#[^0-9\.]+#', '', $this->$attribute);
    }

    public function calculate()
    {
        if ($this->flooringType > $this->t) {
            $result = ceil($this->floorLength / $this->flooringLength) * ceil($this->floorWidth / $this->flooringWidth);
            $result .= ' м.';
        } else {
            $result = ceil($this->floorWidth / $this->flooringWidth) * $this->floorLength;
            $result .= ' шт.';
        }

        return $result;
    }

}