<?php

class ProfileStringAttribute extends ProfileAttribute
{
    public function input($name, $value)
    {
        echo CHtml::textField($name, $value);
    }
}
