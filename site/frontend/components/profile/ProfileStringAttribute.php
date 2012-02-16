<?php

class ProfileStringAttribute extends ProfileAttribute
{
    public function input($name)
    {
        echo CHtml::textField($name, $this->default);
    }
}
