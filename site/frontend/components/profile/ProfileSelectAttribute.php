<?php

class ProfileSelectAttribute extends ProfileAttribute
{
    public $choices;

    public function __construct(array $options = null)
    {
        parent::__construct($options);

        if (empty($this->choices))
        {
            throw new CException('Select attributes must declare the available choices');
        }
    }

    public function input($name, $value)
    {
        echo CHtml::dropDownList($name, $value, $this->choices);
    }
}
