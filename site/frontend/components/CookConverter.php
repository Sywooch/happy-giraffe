<?php

class CookConverter extends CComponent
{
    public $from;
    public $to;
    public $ingredient;
    public $direction;
    public $result;
    public $error;

    private $doubleConvert = array('qty-volume', 'volume-qty');
    private $directConvertQty = array('qty-weight', 'weight-qty');
    private $directConvertVolume = array('volume-weight', 'weight-volume');

    public function convert($data)
    {
        $this->from = CookUnits::model()->findByPk($data['from']);
        $this->to = CookUnits::model()->findByPk($data['to']);
        $this->ingredient = CookIngredients::model()->findByPk($data['ingredient']);

        $this->direction = $this->from->type . '-' . $this->to->type;

        // direct conversion
        if (in_array($this->direction, $this->directConvertQty) or in_array($this->direction, $this->directConvertVolume)) {
            $this->result = array(
                'qty' => $this->subConvert($this->from, $this->to, $data['qty'])
            );
        }

        // double conversion
        if (in_array($this->direction, $this->doubleConvert)) {
            $swap = CookUnits::model()->findByPk(1);
            $swap_qty = $this->subConvert($this->from, $swap, $data['qty']);
            $this->result = array(
                'qty' => $this->subConvert($this->swap, $this->to, $swap_qty)
            );
        }

        // one unit type conversion
        if (($this->from->type == $this->to->type) and (in_array($this->from->type, array('weight', 'volume')))) {
            $this->result = array(
                'qty' => $this->subConvert($this->from, $this->to, $data['qty'])
            );
        }
        $this->result['unit'] = $this->to;
        return ($this->result['qty']) ? $this->result : null;
    }

    protected function subConvert($from, $to, $qty)
    {
        $direction = $from->type . '-' . $to->type;


        switch ($direction) {
            case 'qty-weight':
                {
                if (!$this->ingredient->weight)
                    return null;
                return (($qty * $from->ratio) * $this->ingredient->weight) / $to->ratio;
                }
            case 'weight-qty':
                {
                if (!$this->ingredient->weight)
                    return null;
                return (($qty * $from->ratio) / $this->ingredient->weight) / $to->ratio;
                }
            case 'volume-weight':
                {
                if (!$this->ingredient->density)
                    return null;
                return (($qty * $from->ratio) * $this->ingredient->density) / $to->ratio;
                }
            case 'weight-volume':
                {
                if (!$this->ingredient->density)
                    return null;
                return (($qty * $from->ratio) / $this->ingredient->density) / $to->ratio;
                }
            case 'weight-weight':
                {
                return ($qty * $from->ratio) / $to->ratio;
                }
            case 'volume-volume':
                {
                return ($qty * $from->ratio) / $to->ratio;
                }
            default:
                {
                return null;
                }
        }
    }


}