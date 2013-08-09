<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 7/30/13
 * Time: 5:06 PM
 * To change this template use File | Settings | File Templates.
 */

class AlbumPhotoCollection extends PhotoCollection
{
    public $albumId;

    public function generateIds()
    {
        return Yii::app()->db->createCommand("SELECT id FROM album__photos WHERE album_id = :album_id")->queryColumn(array(':album_id' => $this->albumId));
    }

    protected function getIdsCacheDependency()
    {
        $dependency = new CDbCacheDependency("SELECT COUNT(*) FROM album__photos WHERE album_id = :album_id");
        $dependency->params = array(':album_id' => $this->albumId);
        return $dependency;
    }

    protected function generateModels($ids)
    {
        $criteria = new CDbCriteria(array(
            'with' => array('author'),
            'order' => new CDbExpression('FIELD(t.id, ' . implode(',', $ids) . ')')
        ));
        $criteria->addInCondition('t.id', $ids);
        return AlbumPhoto::model()->findAll($criteria);
    }

    protected function toJSON($model)
    {
        return array(
            'id' => $model->id,
            'title' => $model->title,
            'description' => 'У проекта, финансированием которого займется компания Universal, пока нет официального названия. Известно, что в фильме будут показаны известнейшие боксерские поединки 1960-х и 1970-х (в частности, состоявшийся в январе 1974 года бой Джо Фрейзера с Мохаммедом Али), однако информации о сюжете картины пока нет. Предполагаемая дата премьеры также не указывается. Ли не только займется постановкой фильма, но и выступит в качестве продюсера. Сценарий картины поручили написать Питеру Моргану («Королева», «Последний король Шотландии», «Еще одна из рода Болейн», «Фрост против Никсона», «Потустороннее»). Последней завершенной режиссерской работой Энга Ли сейчас является экранизация приключенческого романа Яна Мартелла «Жизнь Пи» («Life of Pi»). Фильм и книга рассказывают о подростке, который после кораблекрушения вынужден дрейфовать на спасательной шлюпке в компании с тигром. Экранизация вышла в прокат в ноябре 2012 года (в РФ — в январе 2013-го).',
            'src' => $model->getPreviewUrl(804, null, Image::WIDTH),
            'date' => HDate::GetFormattedTime($model->created),
            'user' => array(
                'id' => $model->author->id,
                'firstName' => $model->author->first_name,
                'lastName' => $model->author->last_name,
                'gender' => $model->author->gender,
                'ava' => $model->author->getAva('small'),
                'url' => $model->author->url,
            ),
        );
    }
}