<?php

class AdminHelper
{
    static public function HideIfEmpty($attribute)
    {
        if (empty($attribute)) echo ' style="display:none;"';
    }

    static public function HideIfNotEmpty($attribute)
    {
        if (!empty($attribute)) echo ' style="display:none;"';
    }
}
