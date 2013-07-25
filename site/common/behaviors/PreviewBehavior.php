<?php

class PreviewBehavior extends CActiveRecordBehavior
{
    const LIMIT_SMALL = 180;
    const LIMIT_BIG = 500;
    public $small_preview = false;

    public function beforeSave($event)
    {
        parent::beforeSave($event);

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
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $doc = phpQuery::newDocumentXHTML($text, $charset = 'utf-8');

        if (Str::htmlTextLength($text) == 0)
            return '';

        if ($this->small_preview || strstr($text, '<img') === TRUE) {
            //если есть фото или известно что нужно показаться короткое превью, берем первый параграф
            $p_list = $doc->find('p');
            if (empty($p_list))
                return '<p>' . Str::getDescription($text, self::LIMIT_SMALL) . '</p>';

            foreach ($p_list as $p) {
                $p_text = pq($p)->text();
                if (!empty($p_text))
                    return '<p>' . Str::getDescription($p_text, self::LIMIT_SMALL) . '</p>';
            }
            return '';
        } else {
            $preview = '';
            $p_list = $doc->find('p');
            if (empty($p_list))
                return '<p>' . Str::getDescription($text, self::LIMIT_BIG) . '</p>';

            foreach ($p_list as $p) {
                $p_text = trim(pq($p)->text());
                if (self::LIMIT_BIG - Str::htmlTextLength($preview) < 100)
                    return $preview;

                if (!empty($p_text))
                    $preview .= '<p>' . Str::getDescription($p_text, self::LIMIT_BIG - Str::htmlTextLength($preview)) . '</p>';

                if (self::LIMIT_BIG - Str::htmlTextLength($preview) < 10)
                    return $preview;
            }

            return $preview;
        }
    }
}