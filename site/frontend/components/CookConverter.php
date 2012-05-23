<?php

class CookConverter extends CComponent
{
    public $from;
    public $to;
    public $ingredient;
    public $direction;
    public $result;

    public function convert($data)
    {
        $this->from = CookUnits::model()->findByPk($data['from']);
        $this->to = CookUnits::model()->findByPk($data['to']);
        $this->ingredient = CookIngredients::model()->findByPk($data['ingredient']);

        $this->direction = $this->from->type . '-' . $this->to->type;
        $doubleConvert = array('qty-volume', 'volume-qty');
        $singleConvertQty = array('qty-weight', 'weight-qty');
        $singleConvertVolume = array('volume-weight', 'weight-volume');

        if (in_array($this->direction, $singleConvertQty) or in_array($this->direction, $singleConvertVolume)) {
            $this->result = array(
                'qty' => $this->subConvert($this->from, $this->to, $data['qty']),
                'unit_title' => $this->to->title
            );
        }
        if (in_array($this->direction, $doubleConvert)) {
            $swap = CookUnits::model()->findByPk(1);
            $swap_qty = $this->subConvert($this->from, $swap, $data['qty']);
            $this->result = array(
                'qty' => $this->subConvert($this->swap, $this->to, $swap_qty),
                'unit_title' => $this->to->title
            );
        }

        if (($this->from->type == $this->to->type) and (in_array($this->from->type, array('weight', 'volume')))) {
            $this->result = array(
                'qty' => $this->subConvert($this->from, $this->to, $data['qty']),
                'unit_title' => $this->to->title
            );
        }

        return $this->result;
    }

    protected function subConvert($from, $to, $qty)
    {
        $direction = $from->type . '-' . $to->type;
        // echo $direction;

        //todo ratio or ratiov
        $qty = $qty * $from->ratio;

        switch ($direction) {
            case 'qty-weight':
                {
                return ($qty * $this->ingredient->weight) / $to->ratio;
                }
            case 'weight-qty':
                {
                return ($qty / $this->ingredient->weight) / $to->ratio;
                }
            case 'volume-weight':
                {
                return ($qty * $this->ingredient->density) / $to->ratio;
                }
            case 'weight-volume':
                {
                return ($qty / $this->ingredient->density) / $to->ratio;
                }
            case 'weight-weight':
                {
                return $qty / $to->ratio;
                }
            case 'volume-volume':
                {
                return $qty / $to->ratio;
                }
        }
    }


}