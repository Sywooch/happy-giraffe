<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 21/04/14
 * Time: 11:52
 * To change this template use File | Settings | File Templates.
 */

class MailComment extends Comment
{
    protected $processedText;

    public function init()
    {
        $this->processedText = strip_tags($this->text);
    }

    public function getCommentText($length)
    {
        $text = $this->processedText;
        $text = Str::truncate($text, $length);
        return $text;
    }

    public function exceedsLength($length)
    {
        return strlen($this->processedText) > $length;
    }
}