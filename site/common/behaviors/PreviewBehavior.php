<?php

class PreviewBehavior extends CActiveRecordBehavior
{
    const LIMIT_SMALL = 180;
    const LIMIT_BIG = 500;
    public $small_preview = false;

    public function afterSave($event)
    {
        parent::afterSave($event);

        $this->owner->content->preview = $this->generatePreview($this->owner->text);
        $this->owner->content->save(false);
    }

    /**
     * Создает превью из полного текста
     * @param string $text
     * @return string
     */
    private function generatePreview($text)
    {
        include_once Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';
        $text = trim(preg_replace('/\t+/', ' ', $text));
        $doc = str_get_html($text);

        if (Str::htmlTextLength($text) == 0)
            return '';

        if ($this->small_preview || isset($this->owner->photo_id) && !empty($this->owner->photo_id) && $this->owner->photo->width >= 580) {
            //если есть фото или известно что нужно показаться короткое превью, берем первый параграф
            $p_list = $doc->find('p');
            echo '1';
            if (count($p_list) == 0)
                return '<p>' . Str::truncate($text, self::LIMIT_SMALL * 2) . '</p>';

            echo '2';
            foreach ($p_list as $p) {
                echo $p->plaintext."\n";
                $p_text = $this->getParagraphText($p);
                echo $p_text."\n";
                //Yii::app()->end();
                if (!empty($p_text))
                    return '<p>' . Str::truncate($p_text, self::LIMIT_SMALL * 2) . '</p>';
            }
            return '';
        } else {
            $preview = '';
            $p_list = $doc->find('p');
            if (count($p_list) == 0)
                return '<p>' . Str::truncate($text, self::LIMIT_BIG * 2) . '</p>';

            foreach ($p_list as $p) {
                $p_text = $this->getParagraphText($p);
                if (empty($p_text))
                    continue;

                if (self::LIMIT_BIG - Str::htmlTextLength($preview) < 100)
                    return $preview;

                $preview .= '<p>' . Str::truncate($p_text, (self::LIMIT_BIG - Str::htmlTextLength($preview)) * 2) . '</p>';

                if (self::LIMIT_BIG - Str::htmlTextLength($preview) < 10)
                    return $preview;
            }

            return $preview;
        }
    }

    private function getParagraphText($p)
    {
        #TODO смайлы тоже удаляет из превью
        $text = trim(str_replace('&nbsp;', ' ', $p->plaintext));
        if (empty($text))
            return '';

        $text = strip_tags($text, '<a><br><br/><strong><b><i><u><strike><h2><h3><ul><ol><li>');
        return trim($text);
    }
}