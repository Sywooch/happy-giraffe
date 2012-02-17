<?php

class ProfileAttribute extends CComponent
{
    public $label;
    public $default;

    public function __construct(array $options = null)
    {
        if (! empty($options))
        {
            foreach ($options as $key => $value)
            {
                $this->$key = $value;
            }
        }
    }
}
