<?php

namespace site\frontend\modules\som\modules\photopost\models;

/**
 * This is the model class for table "som__photopost".
 *
 * The followings are the available columns in table 'som__photopost':
 * @property string $id
 * @property string $title
 * @property string $collectionId
 * @property string $authorId
 * @property integer $isDraft
 * @property integer $isRemoved
 * @property string $dtimeCreate
 * @property string $labels
 * @property integer $forumId
 */
class Photopost extends \CActiveRecord implements \IHToJSON
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'som__photopost';
    }

    public function behaviors()
    {
        return array(
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
                'removeAttribute' => 'isRemoved',
            ),
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => null,
            ),
            'UrlBehavior' => array(
                'class' => 'site\common\behaviors\UrlBehavior',
                'route' => function($model) {
                    // Если из форума, то в клубы, иначе в блоги
                    return $model->forumId ? 'posts/community/view' : 'posts/post/view';
                },
                'params' => function($model) {
                    // Если из форума, то в клубы, иначе в блоги
                    if ($model->forumId) {
                        return array(
                            'forum_id' => $model->forumId,
                            'content_type_slug' => 'nppost',
                            'content_id' => $model->id,
                        );
                    } else {
                        return array(
                            'user_id' => $model->authorId,
                            'content_id' => $model->id,
                        );
                    }
                },
                    ),
                );
            }

            /**
             * @return array validation rules for model attributes.
             */
            public function rules()
            {
                // NOTE: you should only define rules for those attributes that
                // will receive user inputs.
                return array(
                    array('title, collectionId, authorId', 'required'),
                    array('isDraft, isRemoved', 'numerical', 'integerOnly' => true),
                    array('title', 'length', 'max' => 255),
                );
            }

            /**
             * @return array customized attribute labels (name=>label)
             */
            public function attributeLabels()
            {
                return array(
                    'id' => 'ID',
                    'title' => 'Title',
                    'collectionId' => 'Collection',
                    'authorId' => 'Author',
                    'isDraft' => 'Is Draft',
                    'isRemoved' => 'Is Removed',
                    'dtimeCreate' => 'Dtime Create',
                    'labels' => 'Labels',
                    'forumId' => 'Forum',
                );
            }

            /**
             * Returns the static model of the specified AR class.
             * Please note that you should have this exact method in all your CActiveRecord descendants!
             * @param string $className active record class name.
             * @return Photopost the static model class
             */
            public static function model($className = __CLASS__)
            {
                return parent::model($className);
            }

            public function toJSON()
            {
                return array(
                    'id' => (int) $this->id,
                    'url' => $this->getUrl(),
                    'collectionId' => (int) $this->collectionId,
                    'title' => $this->title,
                    'isDraft' => (int) $this->isDraft,
                    'isRemoved' => (int) $this->isRemoved,
                    'dtimeCreate' => (int) $this->dtimeCreate,
                    'lables' => $this->labels,
                    'forumId' => is_null($this->forumId) ? null : (int) $this->forumId,
                );
            }

            public function afterSave()
            {
                $result = parent::afterSave();
                
                $post = new \site\frontend\modules\posts\models\api\Content();
                
                return $result;
            }

        }
        