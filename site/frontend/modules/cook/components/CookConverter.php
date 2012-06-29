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

    /**
     * connverts ingredient from one unit into other
     *
     * @param $data array contains 'from','to' - unit_id, 'ingredient' - ingredient_id, 'qty'
     * @return null
     */
    public function convert($data)
    {
        $data['qty'] = trim(str_replace(',', '.', $data['qty']));
        $data['qty'] = preg_replace('#[^0-9\.]+#', '', $data['qty']);

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
                'qty' => $this->subConvert($swap, $this->to, $swap_qty)
            );
        }

        // one unit type conversion
        if (($this->from->type == $this->to->type) and (in_array($this->from->type, array('weight', 'volume', 'qty')))) {
            $this->result = array(
                'qty' => $this->subConvert($this->from, $this->to, $data['qty'])
            );
        }

        if (!isset($this->result['qty']))
            return 0;

        $this->result['unit'] = $this->to;
        return ($this->result['qty']) ? $this->result : null;
    }

    /**
     * protected function used from
     *
     * @param $from unit_id
     * @param $to unit_id
     * @param $qty
     * @return float|null qty or null if unsupported conversion
     */
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


    /**Calculate nutritionals by ingredients and qty
     *
     * @param $components array of components, each must contain 'unit_id', 'ingredient_id', 'value'
     * @return array with 'total' nutritionals and 'g100' for 100 grams
     */
    public function calculateNutritionals($components)
    {
        $converter = new CookConverter();
        $result = array(
            'total' => array(
                'weight' => 0,
                'nutritionals' => array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 7 => 0)
            ),
            'g100' => array(
                'nutritionals' => array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 7 => 0)
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

            if ($weight == null)
                continue;

            $result['total']['weight'] += $weight['qty'];
            foreach ($ingredient->nutritionals as $nutritional) {
                $result['total']['nutritionals'][$nutritional->nutritional_id] += $nutritional->value * ($weight['qty'] / 100);
            }
        }

        foreach ($result['total']['nutritionals'] as $key => $n) {
            $result['g100']['nutritionals'][$key] = $n * (100 / $result['total']['weight']);
        }

        return $result;
    }
}