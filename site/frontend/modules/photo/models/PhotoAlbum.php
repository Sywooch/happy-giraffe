<?php

/**
 * This is the model class for table "photo__albums".
 *
 * The followings are the available columns in table 'photo__albums':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $created
 * @property string $updated
 * @property string $author_id
 *
 * The followings are the available model relations:
 * @property \User $author
 */

namespace site\frontend\modules\photo\models;

use site\frontend\modules\photo\components\IPhotoCollection;

class PhotoAlbum extends \HActiveRecord  implements \IHToJSON
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'photo__albums';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title', 'required'),
			array('title', 'length', 'max' => 150),
			array('description', 'length', 'max' => 450),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок альбома',
			'description' => 'Описание альбома',
			'created' => 'Created',
			'updated' => 'Updated',
			'author_id' => 'Author',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PhotoAlbum the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
            'PhotoCollectionBehavior' => array(
                'class' => 'site\frontend\modules\photo\components\PhotoCollectionBehavior',
            ),
            'AuthorBehavior' => array(
                'class' => 'site\common\behaviors\AuthorBehavior',
            ),
            'UrlBehavior' => array(
                'class' => 'site\common\behaviors\UrlBehavior',
                'route' => '/photo/albums/view',
                'params' => array(
                    'id' => 'id',
                    'authorId' => 'author_id',
                ),
            ),
        );
    }

    public function user($userId)
    {
        $this->getDbCriteria()->compare($this->getTableAlias() . '.author_id', $userId);
        return $this;
    }

    public function toJSON()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'photoCollections' => $this->photoCollections,
        );
    }


}
