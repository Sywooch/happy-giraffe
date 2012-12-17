<?php

/**
 * This is the model class for table "cook__recipes".
 *
 * The followings are the available columns in table 'cook__recipes':
 * @property string $id
 * @property string $title
 * @property string $photo_id
 * @property integer $preparation_duration
 * @property integer $cooking_duration
 * @property integer $servings
 * @property string $text
 * @property string $cuisine_id
 * @property integer $type
 * @property string $author_id
 * @property string $full
 *
 * The followings are the available model relations:
 * @property CookRecipeIngredient[] $cookRecipeIngredients
 * @property User $author
 * @property AlbumPhoto $photo
 * @property CookRecipeTag $tags
 * @property CookCuisine $cuisine
 * @property AttachPhoto[] $attachPhotos
 */
class CookRecipe extends CActiveRecord
{
    const COOK_RECIPE_LOWFAT = 11;
    const COOK_RECIPE_LOWCAL = 40;
    const COOK_RECIPE_FORDIABETICS = 33;

    const COOK_DEFAULT_SECTION = 0;

    public $tagsIds = array();

    public $sectionsMap = array(
        0 => 'SimpleRecipe',
        1 => 'MultivarkaRecipe',
    );

    public $types = array(
        0 => 'Все рецепты',
        1 => 'Первые блюда',
        2 => 'Вторые блюда',
        3 => 'Салаты',
        4 => 'Закуски и бутерброды',
        5 => 'Сладкая выпечка',
        6 => 'Несладкая выпечка',
        7 => 'Торты и пирожные',
        8 => 'Десерты',
        9 => 'Напитки',
        10 => 'Соусы и кремы',
        11 => 'Консервация',
        12 => 'Блюда из молочных продуктов',
        13 => 'Рецепты для малышей',
        14 => 'Рецепты-дуэты',
    );

    public $durations = array(
        array(
            'label' => 'Меньше чем 15 минут',
            'min' => null,
            'max' => 15,
        ),
        array(
            'label' => 'От 15 до 30 минут',
            'min' => 15,
            'max' => 30,
        ),
        array(
            'label' => 'От 30 до 60 минут',
            'min' => 30,
            'max' => 60,
        ),
        array(
            'label' => 'От 1 часа до 2 часов',
            'min' => 60,
            'max' => 120,
        ),
        array(
            'label' => 'Более 2 часов',
            'min' => 120,
            'max' => null,
        ),
    );

    public $preparation_duration_h;
    public $preparation_duration_m;
    public $cooking_duration_h;
    public $cooking_duration_m;

    private $_nutritionals = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CookRecipe the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cook__recipes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, text, type, author_id', 'required'),
            array('title', 'length', 'max' => 255),
            array('photo_id', 'exist', 'attributeName' => 'id', 'className' => 'AlbumPhoto'),
            array('cuisine_id', 'exist', 'attributeName' => 'id', 'className' => 'CookCuisine'),
            array('author_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
            array('type', 'in', 'range' => array_keys($this->types)),
            array('servings', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => 10),
            array('preparation_duration, cooking_duration', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => 9999),
            array('preparation_duration_h, preparation_duration_m, cooking_duration_h, cooking_duration_m', 'safe'),
            array('cuisine_id', 'default', 'value' => null),
            array('photo_id', 'default', 'value' => null),
            array('section', 'in', 'range' => array_keys($this->sectionsMap)),
            array('tagsIds', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, photo_id, preparation_duration, cooking_duration, servings, text, cuisine_id, type, author_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tags' => array(self::MANY_MANY, 'CookRecipeTag', 'cook__recipe_recipes_tags(recipe_id, tag_id)'),
            'ingredients' => array(self::HAS_MANY, 'CookRecipeIngredient', 'recipe_id'),
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
            'cuisine' => array(self::BELONGS_TO, 'CookCuisine', 'cuisine_id'),
            'attachPhotos' => array(
                self::HAS_MANY,
                'AttachPhoto',
                'entity_id',
                'on' => 'entity = :entity',
                'params' => array(':entity' => 'CookRecipe'),
                'with' => array(
                    'photo' => array(
                        'alias' => 'attachPhoto',
                    ),
                ),
                'order' => 'attachPhoto.created ASC',
            ),
            'commentsCount' => array(self::STAT, 'Comment', 'entity_id', 'condition' => 'entity = :entity', 'params' => array(':entity' => 'CookRecipe')),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Название блюда',
            'photo_id' => 'Фото блюда',
            'preparation_duration' => 'Время подготовки',
            'cooking_duration' => 'Время приготовления',
            'servings' => 'На сколько порций',
            'text' => 'Описание приготовления',
            'cuisine_id' => 'Кухня',
            'type' => 'Тип блюда',
            'author_id' => 'Автор',

            'ingredients' => 'Из чего готовим?',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('photo_id', $this->photo_id, true);
        $criteria->compare('preparation_duration', $this->preparation_duration);
        $criteria->compare('cooking_duration', $this->cooking_duration);
        $criteria->compare('servings', $this->servings);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('cuisine_id', $this->cuisine_id, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('author_id', $this->author_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            ),
            'purified' => array(
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => array('text'),
            ),
            'pingable' => array(
                'class' => 'site.common.behaviors.PingableBehavior',
            ),
            'CAdvancedArBehavior' => array(
                'class' => 'site.frontend.extensions.CAdvancedArBehavior',
            ),
        );
    }

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => 't.removed = 0',
            ),
        );
    }

    protected function beforeValidate()
    {
        if (!empty($this->preparation_duration_h) || !empty($this->preparation_duration_m)) {
            $this->preparation_duration = $this->preparation_duration_h * 60 + $this->preparation_duration_m;
        } else {
            $this->preparation_duration = null;
        }
        if (!empty($this->cooking_duration_h) || !empty($this->cooking_duration_m)) {
            $this->cooking_duration = $this->cooking_duration_h * 60 + $this->cooking_duration_m;
        } else {
            $this->cooking_duration = null;
        }

        return parent::beforeValidate();
    }

    protected function afterFind()
    {
        if (!empty($this->tags)) {
            foreach ($this->tags as $service)
                $this->tagsIds[] = $service->id;
        }

        if ($this->preparation_duration !== null) {
            $this->preparation_duration_h = sprintf("%02d", floor($this->preparation_duration / 60));
            $this->preparation_duration_m = sprintf("%02d", $this->preparation_duration % 60);
        }

        if ($this->cooking_duration !== null) {
            $this->cooking_duration_h = sprintf("%02d", floor($this->cooking_duration / 60));
            $this->cooking_duration_m = sprintf("%02d", $this->cooking_duration % 60);
        }

        parent::afterFind();
    }

    protected function beforeSave()
    {
        $this->tags = $this->tagsIds;

        if ($this->ingredients) {
            if ($this->servings) {
                $this->lowFat = $this->getNutritionalsPerServing(2) <= self::COOK_RECIPE_LOWFAT;
                $this->forDiabetics = $this->getNutritionalsPerServing(4) <= self::COOK_RECIPE_FORDIABETICS;
            }
            $this->lowCal = $this->getNutritionalsPer100g(1) <= self::COOK_RECIPE_LOWCAL;
        }

        if ($this->isNewRecord)
            $this->last_updated = new CDbExpression('NOW()');

        return parent::beforeSave();
    }

    protected function afterSave()
    {
        if ($this->isNewRecord) {
            if ($this->isNewRecord)
                $this->sendEvent();

            UserAction::model()->add($this->author_id, UserAction::USER_ACTION_RECIPE_ADDED, array('model' => $this));
            FriendEventManager::add(FriendEvent::TYPE_RECIPE_ADDED, array('model' => $this));

            //send signals to commentator panel
            if (Yii::app()->user->checkAccess('commentator_panel')) {
                Yii::import('site.frontend.modules.signal.models.*');
                CommentatorWork::getCurrentUser()->refreshCurrentDayPosts();
                $comet = new CometModel;
                $comet->send(Yii::app()->user->id, array(
                    'update_part' => CometModel::UPDATE_CLUB,
                ), CometModel::TYPE_COMMENTATOR_UPDATE);
            }
        } else {
            $text = 'User: ' . Yii::app()->user->id . "\n" .
                'Route: ' . Yii::app()->controller->route . "\n" .
                'ID: ' . $this->id . "\n";
            Yii::log($text, 'warning');
        }

        parent::afterSave();
    }

    public function getNutritionals()
    {
        if ($this->_nutritionals === null) {
            $ingredients = array();
            foreach ($this->ingredients as $ingredient) {
                $ingredients[] = array(
                    'ingredient_id' => $ingredient->ingredient_id,
                    'unit_id' => $ingredient->unit_id,
                    'value' => $ingredient->value,
                );
            }
            $converter = new CookConverter();
            $this->_nutritionals = $converter->calculateNutritionals($ingredients);
        }

        return $this->_nutritionals;
    }

    public function getNutritionalsPer100g($nutritional_id)
    {
        return round($this->nutritionals['g100']['nutritionals'][$nutritional_id], 2);
    }

    public function getNutritionalsPerServing($nutritional_id)
    {
        return round($this->nutritionals['total']['nutritionals'][$nutritional_id] / $this->servings, 2);
    }

    public function getBakeryItems()
    {
        return round($this->getNutritionalsPerServing(4) / 11, 1);
    }

    public function getBakeryItemsCssClass()
    {
        $xe = $this->getBakeryItems();
        if ($xe < 11)
            return 'val33';
        if ($xe < 22)
            return 'val66';
        return 'val100';
    }

    public function getBakeryItemsText()
    {
        $xe = $this->getBakeryItems();
        if ($xe < 11)
            return 'Подходит для диабетиков';
        if ($xe < 22)
            return 'Подходит для диабетиков';
        return 'Не подходит для диабетиков';
    }

    public function getUrlParams()
    {
        return array(
            '/cook/recipe/view',
            array(
                'id' => $this->id,
                'section' => $this->section,
            ),
        );
    }

    public function getUrl($comments = false, $absolute = false)
    {
        list($route, $params) = $this->urlParams;

        if ($comments)
            $params['#'] = 'comment_list';

        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method($route, $params);
    }

    public function getPreview($imageWidth = 167, $height = null)
    {
        if ($this->mainPhoto !== null) {
            $preview = HHtml::link(CHtml::image($this->mainPhoto->getPreviewUrl($imageWidth, $height, false, true)), $this->url, array(), true);
        } else {
            $preview = CHtml::tag('p', array(), Str::truncate($this->text));
        }

        return $preview;
    }


    public function getMainPhoto()
    {
        if ($this->photo !== null)
            return $this->photo;

        if (!empty($this->attachPhotos)) {
            return $this->attachPhotos[0]->photo;
        }

        return null;
    }

    public function getThumbs()
    {
        $thumbs = $this->attachPhotos;
        if (!empty($thumbs))
            $thumbs = array_slice($thumbs, 0, 3);

        return $thumbs;
    }

    public function getPhotoCollection()
    {
        $photos = array();
        if ($this->photo !== null) {
            $photos[] = $this->photo;
        }
        foreach ($this->attachPhotos as $p) {
            $photos[] = $p->photo;
        }

        foreach ($photos as $i => $p) {
            $p->w_title = 'Фото рецепта &laquo;' . $this->title . '&raquo; - ' . ($i + 1);
        }

        return array(
            'title' => 'Фотоальбом к рецепту ' . CHtml::link($this->title, $this->url),
            'photos' => $photos,
        );
    }

    public function getDurationLabels()
    {
        $labels = array();
        foreach ($this->durations as $d)
            $labels[] = $d['label'];
        return $labels;
    }

    public function getTypeString($type = null)
    {
        return ($type === null) ? $this->types[$this->type] : $this->types[$type];
    }

    public function getCookingDurationString()
    {
        if ($this->cooking_duration < 60) {
            return $this->cooking_duration_m . ' мин';
        } elseif ($this->cooking_duration % 60 == 0) {
            return $this->cooking_duration_h . ' ч';
        } else {
            return $this->cooking_duration_h . ' ч' . $this->cooking_duration_m . ' мин';
        }
    }

    public function getRssContent()
    {
        return ($this->mainPhoto !== null) ?
            CHtml::image($this->mainPhoto->getPreviewUrl(441, null, Image::WIDTH), $this->mainPhoto->title) . $this->text
            :
            $this->text;
    }

    public function getContentImage()
    {
        return ($this->mainPhoto !== null) ? $this->mainPhoto->getPreviewUrl(303, null, Image::WIDTH) : false;
    }

    public function getEvent()
    {
        $row = array(
            'id' => $this->id,
            'last_updated' => time(),
            'type' => Event::EVENT_RECIPE,
        );

        $event = Event::factory(Event::EVENT_RECIPE);
        $event->attributes = $row;
        return $event;
    }

    public function sendEvent()
    {
        $event = $this->event;
        $params = array(
            'blockId' => $event->blockId,
            'code' => $event->code,
        );

        $comet = new CometModel;
        $comet->send('whatsNewIndex', $params, CometModel::WHATS_NEW_UPDATE);
    }

    public function getArticleCommentsCount()
    {
        return $this->commentsCount;
    }

    /******************************************************************************************************************/
    /************************************************* Selections *****************************************************/
    /******************************************************************************************************************/

    public function getByTag($tag_id, $type)
    {
        $criteria = new CDbCriteria(array(
            'with' => array('photo', 'attachPhotos', 'tags'),
            'order' => 't.created DESC',
        ));
        $criteria->condition = 'tags.id=' . $tag_id . ' AND tags.id IS NOT NULL';
        $criteria->together = true;

        if ($type !== null)
            $criteria->compare('type', $type);

        $dp = new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        return $dp;
    }

    public function getByType($type)
    {
        $criteria = new CDbCriteria(array(
            'with' => array('photo', 'attachPhotos', 'commentsCount', 'tags', 'author', 'cuisine'),
            'order' => 't.created DESC',
        ));
        if (!empty($type))
            $criteria->compare('type', $type);

        $count_criteria = clone $criteria;
        $count_criteria->with = array();

        $dp = new CActiveDataProvider(get_class($this), array(
            'totalItemCount' => CookRecipe::model()->count($count_criteria),
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        return $dp;
    }

    public function getByCookBook($type)
    {
        $criteria = new CDbCriteria(array(
            'with' => array('photo', 'attachPhotos', 'commentsCount', 'tags', 'author'),
            'join'=>'LEFT JOIN cook__cook_book as book ON book.recipe_id = t.id',
            'order' => 'book.created DESC',
            'condition'=>'book.user_id = :me',
            'params'=>array(':me' => Yii::app()->user->id)
        ));
        if (!empty($type))
            $criteria->compare('type', $type);

        $count_criteria = clone $criteria;
        $count_criteria->with = array();

        $dp = new CActiveDataProvider('CookRecipe', array(
            'totalItemCount' => CookRecipe::model()->count($count_criteria),
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        return $dp;
    }

    public function getLastCommentators($limit = 3)
    {
        return Comment::model()->with('author', 'author.avatar')->findAll(array(
            'condition' => 'entity = :entity AND entity_id = :entity_id',
            'params' => array(':entity' => 'CookRecipe', ':entity_id' => $this->id),
            'order' => 't.created DESC',
            'limit' => $limit,
            'group' => 't.author_id',
        ));
    }

    public function getLastRecipes($limit = 9)
    {
        $criteria = new CDbCriteria(array(
            'limit' => $limit,
            'order' => 't.created DESC',
            'with' => array(
                'photo',
                'tags',
                'author' => array(
                    'select' => array('id', 'first_name', 'last_name', 'avatar_id', 'online', 'blocked', 'deleted')
                )
            )
        ));

        return $this->findAll($criteria);
    }

    public function getMore()
    {
        $prev = $this->findAll(
            array(
                'condition' => 't.id < :current_id AND type = :type',
                'params' => array(':current_id' => $this->id, ':type' => $this->type),
                'limit' => 2,
                'order' => 't.id DESC',
            )
        );

        $next = $this->findAll(
            array(
                'condition' => 't.id > :current_id AND type = :type',
                'params' => array(':current_id' => $this->id, ':type' => $this->type),
                'limit' => 2,
                'order' => 't.id',
            )
        );

        return CMap::mergeArray(array_reverse($prev), $next);
    }


    /******************************************************************************************************************/
    /*************************************************  Search  *******************************************************/
    /******************************************************************************************************************/

    public function findAdvanced($cuisine_id, $type, $preparation_duration, $cooking_duration, $lowFat, $lowCal, $forDiabetics)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('photo', 'attachPhotos');

        if ($cuisine_id !== null)
            $criteria->compare('cuisine_id', $cuisine_id);
        if ($type !== null)
            $criteria->compare('type', $type);

        if ($preparation_duration !== null) {
            if ($this->durations[$preparation_duration]['min'] !== null)
                $criteria->compare('preparation_duration', '>=' . $this->durations[$preparation_duration]['min']);
            if ($this->durations[$preparation_duration]['max'] !== null)
                $criteria->compare('preparation_duration', '<' . $this->durations[$preparation_duration]['max']);
        }

        if ($cooking_duration !== null) {
            if ($this->durations[$cooking_duration]['min'] !== null)
                $criteria->compare('cooking_duration', '>=' . $cooking_duration['min']);
            if ($this->durations[$cooking_duration]['max'] !== null)
                $criteria->compare('cooking_duration', '<' . $cooking_duration['max']);
        }

        if ($lowFat) {
            $criteria->compare('lowFat', 1);
        }

        if ($lowCal) {
            $criteria->compare('lowCal', 1);
        }

        if ($forDiabetics) {
            $criteria->compare('forDiabetics', 1);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 36,
            ),
        ));
    }

    public function findByIngredients($ingredients, $type = null)
    {
        $subquery = Yii::app()->db->createCommand()
            ->select('count(distinct ingredient_id)')
            ->from('cook__recipe_ingredients')
            ->where(array('and', 'recipe_id = t.id', array('in', 'cook__recipe_ingredients.ingredient_id', $ingredients)))
            ->text;

        $criteria = new CDbCriteria;
        $criteria->with = array('photo', 'attachPhotos');
        $criteria->condition = '(' . $subquery . ') = :count';
        $criteria->params = array(':count' => count($ingredients));
        if ($type !== null)
            $criteria->compare('type', $type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 36,
            ),
        ));
    }

    /**
     * @param int $ingredient_id
     * @param int $limit
     * @return CookRecipe []
     */
    public function findByIngredient($ingredient_id, $limit)
    {
        $subquery = Yii::app()->db->createCommand()
            ->select('t.id')
            ->from($this->tableName() . ' as t')
            ->join(CookRecipeIngredient::model()->tableName(), CookRecipeIngredient::model()->tableName() . '.recipe_id = t.id')
            ->where(CookRecipeIngredient::model()->tableName() . '.ingredient_id = :ingredient_id')
            ->text;

        $criteria = new CDbCriteria;
        $criteria->with = array('ingredients', 'ingredients.ingredient', 'ingredients.unit', 'author', 'photo');
        $criteria->together = true;
        $criteria->condition = 't.id IN (' . $subquery . ')';
        $criteria->params = array(':ingredient_id' => $ingredient_id);
        $criteria->limit = $limit;

        return $this->findAll($criteria);
    }

    public function searchByName($text, $type = null)
    {
        if (empty($text))
            return array(new CActiveDataProvider($this, array(
                'criteria' => new CDbCriteria,
                'pagination' => array(
                    'pageSize' => 36,
                ),
            )), $this->getCounts());

        $pages = new CPagination();
        $pages->pageSize = 100000;

        $criteria = new stdClass();
        $criteria->from = 'recipe';
        $criteria->select = '*';
        $criteria->paginator = $pages;
        $criteria->query = $text;

        $idArray = $this->getSearchResultIdArray($criteria);
        $criteria = new CDbCriteria;
        if (empty($idArray)){
            $criteria->compare('id', 0);
        }else{
            $criteria->compare('id', $idArray);
            $criteria->compare('type', $type);
        }

        return array(new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 36,
            ),
        )), $this->getCountsByIds($idArray));
    }

    public function getCountsByTag($tag)
    {
        $_counts = array();

        foreach ($this->types as $k => $v)
            $_counts[$k] = 0;

        $counts = Yii::app()->db->createCommand()
            ->select('type, count(*)')
            ->from('cook__recipe_recipes_tags')
            ->group('type')
            ->join('cook__recipes', 'cook__recipes.id = cook__recipe_recipes_tags.recipe_id')
            ->where('tag_id = :tag_id AND removed=0', array(':tag_id'=>$tag))
            ->queryAll();

        foreach ($counts as $c){
            $_counts[$c['type']] = $c['count(*)'];
            $_counts[0] += $c['count(*)'];
        }

        return $_counts;
    }

    public function getCountsByCookBook()
    {
        $_counts = array();

        foreach ($this->types as $k => $v)
            $_counts[$k] = 0;

        $counts = Yii::app()->db->createCommand()
            ->select('type, count(*)')
            ->from($this->tableName())
            ->join('cook__cook_book', 'cook__recipes.id = cook__cook_book.recipe_id')
            ->group('type')
            ->where('cook__cook_book.user_id = :me AND removed=0', array(':me' => Yii::app()->user->id))
            ->queryAll();

        foreach ($counts as $c){
            $_counts[$c['type']] = $c['count(*)'];
            $_counts[0] += $c['count(*)'];
        }

        return $_counts;
    }

    public function getCountsByIds($idArray)
    {
        $_counts = array();
        foreach ($this->types as $k => $v)
            $_counts[$k] = 0;
        if (empty($idArray))
            return $_counts;

        $counts = Yii::app()->db->createCommand()
            ->select('type, count(*)')
            ->from($this->tableName())
            ->where('id IN (' . implode(',', $idArray) . ')')
            ->group('type')
            ->queryAll();
        foreach ($counts as $c)
            $_counts[$c['type']] = $c['count(*)'];

        $_counts[0] = count($idArray);
        return $_counts;
    }

    public function getSearchResultIdArray($criteria)
    {
        $allSearch = Yii::app()->search->select('*')->from('recipe')->where($criteria->query)->limit(0, 10000)->searchRaw();

        $res = array();
        foreach ($allSearch['matches'] as $key => $m)
            $res[] = $key;

        return $res;
    }


    /******************************************************************************************************************/
    /*************************************************  CookBook  *****************************************************/
    /******************************************************************************************************************/

    public static function userBookCount()
    {
        return Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from('cook__cook_book')
            ->where('user_id=:user_id', array(':user_id' => Yii::app()->user->id))
            ->queryScalar();
    }

    /**
     * Returns count of users, who added recipe to there cookbook
     *
     * @return mixed
     */
    public function getBookedCount()
    {
        return Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from('cook__cook_book')
            ->where('recipe_id=:recipe_id', array(':recipe_id' => $this->id))
            ->queryScalar();
    }

    /**
     * Get users, who added recipe to there cookbook
     *
     * @return User[]
     */
    public function getBookedUsers()
    {
        $criteria = new CDbCriteria;
        $criteria->select = array('id', 'avatar_id', 'blocked');
        $criteria->scopes = array('active');
        $criteria->join = 'LEFT JOIN cook__cook_book as book ON book.user_id = t.id';
        $criteria->condition = 'recipe_id=:recipe_id AND id != :me';
        $criteria->params = array(':recipe_id' => $this->id, ':me' => Yii::app()->user->id);
        $criteria->limit = 20;

        return User::model()->findAll($criteria);
    }

    /**
     * Add recipe to user cookbook
     *
     * @param int $user_id
     * @return int
     */
    public function book($user_id = null)
    {
        if (empty($user_id))
            $user_id = Yii::app()->user->id;

        if ($this->isBooked()) {
            Yii::app()->db->createCommand()->delete('cook__cook_book',
                'recipe_id=:recipe_id AND user_id=:user_id',
                array(
                    ':recipe_id' => $this->id,
                    ':user_id' => $user_id
                ));
            return 0;
        } else {
            Yii::app()->db->createCommand()->insert('cook__cook_book',
                array(
                    'recipe_id' => $this->id,
                    'user_id' => $user_id
                ));
            return 1;
        }
    }

    /**
     * Recipe added to cookbook by user
     *
     * @param int $user_id
     * @return int
     */
    public function isBooked($user_id = null)
    {
        if (empty($user_id))
            $user_id = Yii::app()->user->id;

        return Yii::app()->db->createCommand()
            ->select('recipe_id')
            ->from('cook__cook_book')
            ->where('recipe_id=:recipe_id AND user_id=:user_id',
            array(
                ':recipe_id' => $this->id,
                ':user_id' => $user_id
            ))
            ->queryScalar();
    }
}
