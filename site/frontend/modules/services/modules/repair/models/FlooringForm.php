<?php

class FlooringForm extends HFormModel
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
            array('flooringType', 'required', 'message' => 'Укажите тип покрытия'),
            array('flooringLength', 'validateFloorLength'),
            array('flooringLength, flooringWidth, floorLength, floorWidth', 'required', 'message' => 'Укажите длину {attribute}'),
            array('flooringLength, flooringWidth, floorLength, floorWidth', 'ext.validators.positiveNumber'),
            array('flooringLength, flooringWidth, floorLength, floorWidth', 'ext.validators.normalizeNumber'),
            array('flooringLength, flooringWidth, floorLength, floorWidth', 'numerical', 'message' => '{attribute} должна быть числом')
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
            }
        }
    }

    public function calculate()
    {
        if ($this->flooringType > $this->t) {
            $result['qty'] = ceil($this->floorWidth / $this->flooringWidth) * $this->floorLength;
            $result['noun'] = Str::GenerateNoun(array('метр', 'метра', 'метров'), $result['qty']);
        } else {
            $result['qty'] = ceil($this->floorLength / $this->flooringLength) * ceil($this->floorWidth / $this->flooringWidth);
            $result['noun'] = Str::GenerateNoun(array('штука', 'штуки', 'штук'), $result['qty']);
        }

        return $result;
    }

}