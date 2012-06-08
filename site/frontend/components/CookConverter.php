<?php

class CookConverter extends CComponent
{
    public $from;
    public $to;
    public $ingredient;
    public $direction;
    public $result;
    public $error;
    public $from_weight;
    public $to_weight;

    private $doubleConvert = array('qty-volume', 'volume-qty');
    private $directConvertQty = array('qty-weight', 'weight-qty');
    private $directConvertVolume = array('volume-weight', 'weight-volume');

    public function convert($data)
    {

        $this->from = CookUnit::model()->findByPk($data['from']);
        $this->to = CookUnit::model()->findByPk($data['to']);
        $this->ingredient = CookIngredient::model()->findByPk($data['ingredient']);


        $this->direction = $this->from->type . '-' . $this->to->type;

        if ($this->from->type == 'qty')
            $this->from_weight = Yii::app()->db->createCommand()->select('weight')->from('cook__ingredient_units')
                ->where('ingredient_id=:iid AND unit_id = :uid', array(':iid' => $this->ingredient->id, 'uid' => $this->from->id))->queryRow();
        if ($this->to->type == 'qty')
            $this->to_weight = Yii::app()->db->createCommand()->select('weight')->from('cook__ingredient_units')
                ->where('ingredient_id=:iid AND unit_id = :uid', array(':iid' => $this->ingredient->id, 'uid' => $this->to->id))->queryRow();


        // direct conversion
        if (in_array($this->direction, $this->directConvertQty) or in_array($this->direction, $this->directConvertVolume)) {
            $this->result = array(
                'qty' => $this->subConvert($this->from, $this->to, $data['qty'])
            );
        }

        // double conversion
        if (in_array($this->direction, $this->doubleConvert)) {
            $swap = CookUnit::model()->findByPk(1);
            $swap_qty = $this->subConvert($this->from, $swap, $data['qty']);
            $this->result = array(
                'qty' => $this->subConvert($this->swap, $this->to, $swap_qty)
            );
        }

        // one unit type conversion
        if (($this->from->type == $this->to->type) and (in_array($this->from->type, array('weight', 'volume', 'qty')))) {
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
                /*if (!$this->ingredient->weight)
                    return null;*/
                return (($qty * $from->ratio) * $this->from_weight['weight']) / $to->ratio;
                }
            case 'weight-qty':
                {
                /* if (!$this->ingredient->weight)
               return null;*/
                return (($qty * $from->ratio) / $this->to_weight['weight']) / $to->ratio;
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
            case 'qty-qty':
                {
                return (($qty * $this->from_weight['weight']) / $this->to_weight['weight']);
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

    public function calculateNutritionals($components)
    {
        $converter = new CookConverter();
        $result = array(
            'total' => array(
                'weight' => 0,
                'nutritionals' => array()
            ),
            'g100' => array(
                'nutritionals' => array()
            )
        );

        foreach ($components as $component) {
            $ingredient = CookIngredient::model()->findByPk($component['ingredient_id']);
            $weight = $converter->convert(array(
                'from' => $component['unit_id'],
                'to' => 1,
                'ingredient' => $ingredient->id,
                'qty' => $component['value']
            ));

            $result['total']['weight'] += $weight['qty'];
            foreach ($ingredient->cookIngredientsNutritionals as $nutritional) {
                if (isset($result['total']['nutritionals'][$nutritional->nutritional_id])) {
                    $result['total']['nutritionals'][$nutritional->nutritional_id] += $nutritional->value * ($weight['qty'] / 100);
                } else {
                    $result['total']['nutritionals'][$nutritional->nutritional_id] = $nutritional->value * ($weight['qty'] / 100);
                }
            }
        }

        foreach ($result['total']['nutritionals'] as $key => $n) {
            $result['g100']['nutritionals'][$key] = $n * (100 / $result['total']['weight']);
        }


        return $result;
    }

}