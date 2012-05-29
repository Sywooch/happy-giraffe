<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatParser
{
    public function getCaptcha()
    {

        $oc = new OCR();
        $oc->SystemKey = "e0d903d95bae559de224c88eb3a3f6e6";

        $res = $oc->RecognizeExt( _PATH_TO_FILE_, 2, 0, 0, 3, 10, 0);
        $oc->Report(true);

        echo $res;
    }
}
