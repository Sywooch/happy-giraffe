<?php

namespace site\frontend\modules\v1\actions;

/**
 * Implementing this interface grant action to access final response array and modify it.
 */
interface IPostProcessable
{
    function postProcessing(&$data);
}