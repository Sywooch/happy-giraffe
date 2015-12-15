<?php

namespace site\frontend\modules\v1\actions;

interface IPostProcessable
{
    function postProcessing(&$data);
}