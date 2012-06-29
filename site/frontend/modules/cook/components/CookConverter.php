<?php

class CookConverter extends CComponent
{
    public $from;
    public $to;
    public $ingredient;
    public $direction;
    public $result = array('qty' => 0);
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
        $this->result['unit'] = $this->to;

        $data['qty'] = trim(str_replace(',', '.', $data['qty']));
        $data['qty'] = preg_replace('#[^0-9\.]+#', '', $data['qty']);

        $this->from = CookUnit::model()->findByPk($data['from']);
        $this->to = CookUnit::model()->findByPk($data['to']);
        $this->ingredient = CookIngredient::model()->findByPk($data['ingredient']);

        $this->direction = $this->from->type . '-' . $this->to->type;

        // direct conversion
        if (in_array($this->direction, $this->directConvertQty) or in_array($this->direction, $this->directConvertVolume)) {
            $this->result = array(
                'qty' => $this->subConvert($this->from, $this->to, $data['qty'], $this->ingredient)
            );
        }

        // double conversion
        if (in_array($this->direction, $this->doubleConvert)) {
            $swap = CookUnit::model()->findByPk(1);
            $swap_qty = $this->subConvert($this->from, $swap, $data['qty'], $this->ingredient);
            $this->result = array(
                'qty' => $this->subConvert($swap, $this->to, $swap_qty, $this->ingredient)
            );
        }

        // one unit type conversion
        if (($this->from->type == $this->to->type) and (in_array($this->from->type, array('weight', 'volume', 'qty')))) {
            $this->result = array(
                'qty' => $this->subConvert($this->from, $this->to, $data['qty'], $this->ingredient)
            );
        }

        return (isset($this->result['qty'])) ? $this->result : array('qty' => 0);
    }

    /**
     * protected function used from
     *
     * @param $from unit_id
     * @param $to unit_id
     * @param $qty
     * @return float|null qty or null if unsupported conversion
     */
    protected function subConvert($from, $to, $qty, $ingredient)
    {
        if ($qty == 0)
            return 0;

        $direction = $from->type . '-' . $to->type;

        switch ($direction) {
            case 'qty-weight':
                {
                $ingredientUnit = CookIngredientUnit::model()->findByAttributes(array(
                    'unit_id' => $from->id,
                    'ingredient_id' => $ingredient->id
                ));

                if ($ingredientUnit == NULL or !$ingredientUnit->weight)
                    return 0;

                return (($qty * $ingredientUnit->weight) / $to->ratio);
                }
            case 'weight-qty':
                {
                $ingredientUnit = CookIngredientUnit::model()->findByAttributes(array(
                    'unit_id' => $to->id,
                    'ingredient_id' => $ingredient->id
                ));
                if ($ingredientUnit == null or !$ingredientUnit->weight)
                    return 0;

                return (($qty * $from->ratio) / $ingredientUnit->weight);
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

                $ingredientUnitFrom = CookIngredientUnit::model()->findByAttributes(array(
                    'unit_id' => $from->id,
                    'ingredient_id' => $ingredient->id
                ));
                if ($ingredientUnitFrom == null or !$ingredientUnitFrom->weight)
                    return 0;

                $ingredientUnitTo = CookIngredientUnit::model()->findByAttributes(array(
                    'unit_id' => $to->id,
                    'ingredient_id' => $ingredient->id
                ));
                if ($ingredientUnitTo == null or !$ingredientUnitTo->weight)
                    return 0;

                return (($qty * $ingredientUnitFrom->weight) / $ingredientUnitTo->weight);
                }
            case 'volume-volume':
                {
                return ($qty * $from->ratio) / $to->ratio;
                }
            default:
                {
                return 0;
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
            'total' => array('weight' => 0, 'nutritionals' => array()),
            'g100' => array('nutritionals' => array()));

        $nutritionals = CookNutritional::model()->cache(3600)->findAll();
        foreach ($nutritionals as $n)
            $result['total']['nutritionals'][$n->id] = 0;
        $result['g100']['nutritionals'] = $result['total']['nutritionals'];

        foreach ($components as $component) {
            $ingredient = CookIngredient::model()->findByPk($component['ingredient_id']);
            $weight = $converter->convert(array(
                'from' => $component['unit_id'],
                'to' => 1,
                'ingredient' => $ingredient->id,
                'qty' => $component['value']
            ));

            if (!$weight)
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