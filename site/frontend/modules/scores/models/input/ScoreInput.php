<?php
/**
 * Class ScoreInput
 *
 * Начисление баллов пользователям
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInput extends HMongoModel
{
    const TYPE_6_STEPS = 1;

    const TYPE_FIRST_BLOG_RECORD = 2;
    const TYPE_POST_ADDED = 3;
    const TYPE_VIDEO = 4;

    const TYPE_FRIEND_ADDED = 5;

    const TYPE_COMMENT_ADDED = 7;
    const TYPE_PHOTOS_ADDED = 8;

    const TYPE_DUEL_PARTICIPATION = 9;
    const TYPE_DUEL_WIN = 10;

    const TYPE_VISIT = 11;

    const TYPE_CONTEST_PARTICIPATION = 20;
    const TYPE_CONTEST_WIN = 21;
    const TYPE_CONTEST_2_PLACE = 22;
    const TYPE_CONTEST_3_PLACE = 23;
    const TYPE_CONTEST_4_PLACE = 24;
    const TYPE_CONTEST_5_PLACE = 25;
    const TYPE_CONTEST_ADDITIONAL_PRIZE = 26;

    const TYPE_AWARD = 100;
    const TYPE_ACHIEVEMENT = 101;

    protected $_collection_name = 'score_input_new';

    public $user_id;
    public $type;
    public $scores;
    public $updated;

    /**
     * @var ScoreInput
     */
    private static $_instance;

    /**
     * @return ScoreInput
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {}

    /**
     * Добавляет индекс если не создан
     */
    protected function ensureIndex()
    {
        $this->getCollection()->ensureIndex(array(
            'user_id' => EMongoCriteria::SORT_DESC,
            'updated' => EMongoCriteria::SORT_DESC,
            'type' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'find_one_index'));

        $this->getCollection()->ensureIndex(array(
            'user_id' => EMongoCriteria::SORT_DESC,
            'updated' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'list_index'));
    }

    protected function sendSignal($scores)
    {
        $comet = new CometModel;
        $comet->send($this->user_id, array('scores' => $scores), CometModel::TYPE_SCORES_EARNED);
    }

    /**
     * Создаение нового уведомления о получении баллов
     *
     * @param $specific_fields array массив специфических полей уведомления
     */
    protected function insert($specific_fields)
    {
        $this->getCollection()->insert(
            array_merge(array(
                'type' => (int)$this->type,
                'user_id' => (int)$this->user_id,
                'scores' => (int)$this->scores,
                'updated' => time(),
            ), $specific_fields)
        );

        $this->sendSignal($this->scores);
    }













    public function add($user_id, $type, $params = array(), $blockData = null)
    {
        $score_value = ScoreAction::getActionScores($type, $params);

        if (($stack = $this->getStack($user_id, $type, $blockData)) !== null) {
            $newData = $stack->getDataByParams($params);
            if (array_search($newData, $stack->data) === FALSE) {
                $stack->updated = time();
                $stack->data[] = $newData;
                $stack->scores_earned += $score_value;
                $stack->save();
            }
        } else {
            $action = new self;
            $action->user_id = (int)$user_id;
            $action->type = $type;
            $action->updated = time();
            $action->data = (in_array($type, $this->_stackableActions)) ? array($action->getDataByParams($params)) : $action->getDataByParams($params);
            if ($blockData !== null)
                $action->blockData = $blockData;

            $action->scores_earned += $score_value;
            $action->save();
        }
        $this->addScores($user_id, $score_value);
    }

    public function remove($user_id, $type, $params = array(), $blockData = null)
    {
        $score_value = ScoreAction::getActionScores($type, $params);

        $found = false;
        if (($stack = $this->getStack($user_id, $type, $blockData)) !== null) {
            $newData = $stack->getDataByParams($params);
            $stack->updated = time();

            foreach ($stack->data as $key => $data)
                if ($data == $newData) {
                    unset($stack->data[$key]);
                    $found = true;
                }

            if ($found) {
                $stack->scores_earned -= $score_value;
                $stack->save();
            }
        }

        if (!$found) {
            $action = new self;
            $action->user_id = (int)$user_id;
            $action->type = $type;
            $action->updated = time();
            $action->data = (in_array($type, $this->_stackableActions)) ? array($action->getDataByParams($params)) : $action->getDataByParams($params);
            if ($blockData !== null)
                $action->blockData = $blockData;

            $action->scores_earned -= $score_value;
            $action->save();
        }
        $this->addScores($user_id, -$score_value);
    }

    public function getStack($user_id, $type, $blockData)
    {
        if (!in_array($type, $this->_stackableActions))
            return null;

        $criteria = new EMongoCriteria();
        $criteria->type = $type;
        $criteria->user_id = (int)$user_id;
        if ($blockData !== null)
            $criteria->blockData = $blockData;
        $criteria->sort('updated', EMongoCriteria::SORT_DESC);
        $criteria->created('>=', strtotime(date("Y-m-d") . '00:00:00'));

        $stack = self::model()->find($criteria);
        if ($stack === null)
            return null;

        switch ($type) {
            case self::SCORE_ACTION_PHOTOS_ADDED:
                $result = (time() - $stack->updated < 300) && HDate::isSameDate($stack->updated, time());
                break;
            default:
                $result = HDate::isSameDate($stack->created, time());
        }

        return $result ? $stack : null;
    }

    public function addScores($user_id, $scores)
    {
        $userScore = User::getUserById($user_id)->getScores();
        $userScore->scores += $scores;
        $userScore->save();
    }

    /****************************************************************************************************************/
    /****************************************************************************************************************/

    public function getIcon()
    {
        return $this->type;
    }

    public function getPoints()
    {
        if ($this->scores_earned > 0)
            return '+' . $this->scores_earned;
        else
            return $this->scores_earned;
    }

    /**
     * Получить текст события
     *
     * @return string
     */
    public function getText()
    {
        if (isset($this->data['id']))
            $id = $this->data['id'];
        $text = '';
        switch ($this->type) {
            case self::SCORE_ACTION_6_STEPS:
                $text = 'за первые 6 шагов на сайте: теперь вы чувствуете себя как дома, поздравляем!';
                break;

            case self::SCORE_ACTION_FIRST_BLOG_RECORD:
                $model = CommunityContent::model()->resetScope()->findByPk($id);
                $text = ($this->scores_earned > 0) ?
                    'за первую запись ' . $this->getLink($model) . ' вашем в блоге: поздравляем с дебютом!'
                    :
                    'за удаление единственной записи ' . $this->getLink($model) . ' в вашем блоге: может, стоит написать другую запись?';
                break;

            case self::SCORE_ACTION_BLOG_CONTENT_ADDED:
                $model = CommunityContent::model()->resetScope()->findByPk($id);
                $text = ($this->scores_earned > 0) ?
                    'за новую запись ' . $this->getLink($model) . ' в вашем  блоге:  обязательно напишите еще!'
                    :
                    'за удаление записи ' . $this->getLink($model) . ' в вашем блоге: жаль, хорошая была запись...';
                break;

            case self::SCORE_ACTION_COMMUNITY_CONTENT_ADDED:
                $model = CommunityContent::model()->resetScope()->findByPk($id);
                $text = ($this->scores_earned > 0) ?
                    'за вашу запись ' . $this->getLink($model) . ' в клуб ' . $this->getLink($model->rubric->community) . ':  спасибо, что поделились с нами своими мыслями!'
                    :
                    'за удаление записи ' . $this->getLink($model) . ' в клубе ' . $this->getLink($model->rubric->community) . ' жаль, хорошая была запись...';
                break;

            case self::SCORE_ACTION_RECIPE_ADDED:
                $model = CookRecipe::model()->resetScope()->findByPk($id);
                $text = ($this->scores_earned > 0) ?
                    'за кулинарный рецепт ' . $this->getLink($model) . ' спасибо, что поделились с нами вкусненьким!'
                    :
                    'за удаление кулинарного рецепта ' . $this->getLink($model) . ': жаль, хороший был рецепт...';
                break;

            case self::SCORE_ACTION_FOLK_RECIPE_ADDED:
                $model = RecipeBookRecipe::model()->resetScope()->findByPk($id);
                $text = ($this->scores_earned > 0) ?
                    'за народный рецепт ' . $this->getLink($model) . ': спасибо за полезные советы!'
                    :
                    'за удаление народного рецепта ' . $this->getLink($model) . ': жаль, хороший был рецепт...';
                break;

            case self::SCORE_ACTION_VIDEO:
                $text = $this->getVideoText();
                break;

            case self::SCORE_ACTION_VISIT:
                HDate::isSameDate($this->created, time()) ?
                    $text = 'за посещение сайта: здорово, что вы снова с нами!'
                    :
                    $text = 'За посещение сайта ' . Yii::app()->dateFormatter->format("d MMMM", $this->created) . ':здорово, что вы снова с нами!';
                break;
            case self::SCORE_ACTION_5_DAYS_ATTEND:
                $text = 'за 5 дней на сайте: продолжайте  в том же духе!';
                break;
            case self::SCORE_ACTION_20_DAYS_ATTEND:
                $text = 'за 20 дней подряд на сайте: спасибо, что вы с нами!';
                break;

            case self::SCORE_ACTION_COMMENT_ADDED:
                $text = $this->getOwnCommentText();
                break;

            case self::SCORE_ACTION_10_COMMENTS:
                $text = $this->get10CommentsText();
                break;
            case self::SCORE_ACTION_100_VIEWS:
                $text = $this->getViewsArticleText();
                break;
            case self::SCORE_ACTION_10_LIKES:
                $text = $this->getLikesArticleText();
                break;

            case self::SCORE_ACTION_PHOTOS_ADDED:
                $text = $this->getPhotoText();
                break;

            case self::SCORE_ACTION_CONTEST_PARTICIPATION:
                $model = Contest::model()->findByPk($id);
                $text = 'за участие в конкурсе "' . $model->title . '": вперед, к победе!';
                break;
            case self::SCORE_ACTION_CONTEST_WIN:
                $model = Contest::model()->findByPk($id);
                $text = 'за победу в конкурсе "' . $model->title . '": Йу-ху! Вы победитель!';
                break;
            case self::SCORE_ACTION_CONTEST_2_PLACE:
                $model = Contest::model()->findByPk($id);
                $text = 'за второе место в конкурсе "' . $model->title . '": Поздравляем! Все впереди!';
                break;
            case self::SCORE_ACTION_CONTEST_3_PLACE:
                $model = Contest::model()->findByPk($id);
                $text = 'за третье место в конкурсе "' . $model->title . '": Поздравляем! Все впереди!';
                break;
            case self::SCORE_ACTION_CONTEST_4_PLACE:
                $model = Contest::model()->findByPk($id);
                $text = 'за четвертое место в конкурсе "' . $model->title . '": Поздравляем! Все впереди!';
                break;
            case self::SCORE_ACTION_CONTEST_5_PLACE:
                $model = Contest::model()->findByPk($id);
                $text = 'за пятое место в конкурсе "' . $model->title . '": Поздравляем! Все впереди!';
                break;
            case self::SCORE_ACTION_CONTEST_ADDITIONAL_PRIZE:
                $model = Contest::model()->findByPk($id);
                $text = 'за дополнительный приз в конкурсе "' . $model->title . '": Поздравляем! Молодцом!';
                break;

            case self::SCORE_ACTION_DUEL_PARTICIPATION:
                $model = DuelAnswer::model()->findByPk($id);
                $text = 'за участие в дуэли "' . $model->question->text . '": самое время победить!';
                break;
            case self::SCORE_ACTION_DUEL_WIN:
                $model = DuelAnswer::model()->findByPk($id);
                $text = 'за победу в дуэли "' . $model->question->text . '": поздравляем, вы мастерски сражались!';
                break;

            case self::SCORE_ACTION_AWARD:
                $model = ScoreAward::model()->findByPk($this->data['award_id']);
                $text = 'Ого! У вас новый трофей - ' . CHtml::link($model->title, '#', array('onclick' => 'Scores.openTrophy(' . $model->id . ')')) . '!';
                break;
            case self::SCORE_ACTION_ACHIEVEMENT:
                $model = ScoreAchievement::model()->findByPk($this->data['achieve_id']);
                $text = 'Ух-ты! У вас новое достижение - ' . CHtml::link($model->title, '#', array('onclick' => 'Scores.openAchieve(' . $model->id . ')')) . '!';
                break;
        }

        return $text;
    }

    public function getLink($model)
    {
        return CHtml::link($model->title, $model->url);
    }

    /**
     * Получить текст для 100 просмотров статьи юзера
     * @return string
     */
    public function getViewsArticleText()
    {
        $class = $this->blockData['entity'];
        $model = CActiveRecord::model($class)->resetScope()->findByPk($this->blockData['entity_id']);

        if ($class == 'CommunityContent' || $class == 'BlogContent') {
            if ($model->isFromBlog)
                return 'за ' . (100 * count($this->data)) . ' просмотров вашей записи ' . $this->getLink($model) . ' в блоге: слава уже близка!';
            else
                return 'за ' . (100 * count($this->data)) . ' просмотров вашей записи ' . $this->getLink($model) . ' в клубе ' . $this->getLink($model->rubric->community) . ': слава уже близка!';
        }
        if ($class == 'CookContent')
            return 'за ' . (100 * count($this->data)) . ' просмотров вашего рецепта ' . $this->getLink($model) . ': слава уже близка!';

        return '';
    }

    public function getLikesArticleText()
    {
        $id = $this->data['entity_id'];
        $class = $this->data['entity'];
        $model = $class::model()->resetScope()->findByPk($id);

        if ($class == 'CommunityContent' || $class == 'BlogContent') {
            if ($model->isFromBlog)
                return 'за 10 лайков к вашей записи ' . $this->getLink($model) . ' в блоге: это действительно всем нравится!';
            else
                return 'за 10 лайков к вашей записи ' . $this->getLink($model) . ' в клубе ' . $this->getLink($model->rubric->community) . ': это действительно всем нравится!';
        }

        return '';
    }

    public function getVideoText()
    {
        $id = $this->data['id'];
        $model = CommunityContent::model()->resetScope()->findByPk($id);

        if ($model->isFromBlog)
            $text = ($this->scores_earned > 0) ?
                'за размещение видео ' . $this->getLink($model) . ' в блоге: ждем от вас еще больше видеозаписей!'
                :
                'за удаление видео ' . $this->getLink($model) . ' в блоге: может, стоит выложить другое видео?';

        else
            $text = ($this->scores_earned > 0) ?
                'за размещение видео ' . $this->getLink($model) . ' в клубе ' . $this->getLink($model->rubric->community) . ': ждем от вас еще больше видеозаписей!'
                :
                'за удаление видео ' . $this->getLink($model) . ': в клубе ' . $this->getLink($model->rubric->community) . ': может, стоит выложить другое видео?';

        return $text;
    }

    /**
     * Получить текст для 100 просмотров статьи юзера
     * @return string
     */
    public function get10CommentsText()
    {
        $class = $this->data['entity'];
        $model = CActiveRecord::model($class)->resetScope()->findByPk($this->data['entity_id']);

        $text = '';
        if ($class == 'CommunityContent' || $class == 'BlogContent') {
            if ($model->isFromBlog)
                $text = 'за 10 комментариев к вашей записи в блоге ' . $this->getLink($model) . ': присоединяйся к обсуждению!';
            else
                $text = 'за 10 комментариев к вашей записи ' . $this->getLink($model) . ' в клубе ' . $this->getLink($model->rubric->community) . ': присоединяйся к обсуждению!';
        } elseif ($class == 'RecipeBookRecipe')
            $text = 'за 10 комментариев к народному рецепту ' . $this->getLink($model) . ': присоединяйся к обсуждению!'; elseif ($class == 'CookRecipe')
            $text = 'за 10 комментариев к вашему рецепту ' . $this->getLink($model) . ': присоединяйся к обсуждению!';


        return $text;
    }

    /**
     * Получить текст для добавления/удаления фото
     * @return string
     */
    public function getPhotoText()
    {
        $model = Album::model()->resetScope()->findByPk($this->blockData['album_id']);

        if ($this->scores_earned < 0) {
            return 'Вы удалили фото из альбома <span>' . $this->getLink($model) . '</span>';
        } elseif (count($this->data) == 1)
            return 'Добавлено фото в фотоальбом <span>' . $this->getLink($model) . '</span>'; elseif (count($this->data) > 1)
            return 'Добавлено ' . count($this->data) . ' фото в фотоальбом <span>' . $this->getLink($model) . '</span>';

        return '';
    }

    /**
     * Получить текст для Созданных/удаленных юзером комментариев
     * @return string
     */
    public function getOwnCommentText()
    {
        $model = Comment::model()->resetScope()->findByPk($this->data['id']);
        if ($model === null) {
            $this->delete();
            return '';
        }

        if ($model->entity == 'User') {
            if ($this->user_id == $model->entity_id)
                $text = 'за запись в гостевой';
            else {
                $user = User::model()->findByPk($model->entity_id);
                $text = 'за запись в гостевой ' . $this->getLink($user) . ': порадовали друга!';
            }
            return $text;
        }

        if ($model->entity == 'AlbumPhoto') {
            $photo = AlbumPhoto::model()->resetScope()->findByPk($model->entity_id);
            if (!empty($photo->title))
                $photo_title = CHtml::link($photo->title, $photo->url);
            else
                $photo_title = CHtml::link(CHtml::image($photo->getPreviewUrl(30, 30)), $photo->url);

            if ($photo->author_id == $this->user_id)
                $text = ($this->scores_earned >= 0) ?
                    'за ваш комментарий к фото ' . $photo_title . ' в альбоме ' . $this->getLink($photo->album) . ': ждем от вас новых!' :
                    'за удаление вашего комментария к фото ' . $photo_title . ' в альбоме ' . $this->getLink($photo->album) . ': может, попробовать выразиться иначе?';
            else
                $text = ($this->scores_earned >= 0) ?
                    'за ваш комментарий к фото ' . $photo_title . '"> в альбоме ' . $this->getLink($photo->album) . ' пользователя ' . $this->getLink($photo->album->author) . ': ждем от вас новых!' :
                    'за удаление вашего комментария к фото ' . $photo_title . ' в альбоме ' . $this->getLink($photo->album) . ' пользователя ' . $this->getLink($photo->album->author) . ': может, попробовать выразиться иначе?';

            return $text;
        }

        if ($model->entity == 'CommunityContent') {
            $content = CommunityContent::model()->resetScope()->findByPk($model->entity_id);
            $text = ($this->scores_earned >= 0) ?
                'за ваш комментарий к записи ' . $this->getLink($content) . ' в клубе ' . $this->getLink($content->rubric->community) . ': ждем от вас новых!' :
                'за удаление комментария к записи ' . $this->getLink($content) . ' в клубе ' . $this->getLink($content->rubric->community) . ': может, попробовать выразиться иначе?';
            return $text;
        }

        if ($model->entity == 'BlogContent') {
            $content = CommunityContent::model()->resetScope()->findByPk($model->entity_id);
            if ($content->author_id == $this->user_id)
                $text = ($this->scores_earned >= 0) ?
                    'за ваш комментарий к записи ' . $this->getLink($content) . ' в вашем блоге: ждем от вас новых!' :
                    'за удаление комментария к записи ' . $this->getLink($content) . ' в вашем блоге: может, попробовать выразиться иначе?';
            else {
                $text = ($this->scores_earned >= 0) ?
                    'за ваш комментарий к записи ' . $this->getLink($content) . ' в блоге ' . $this->getLink($content->author) . ': ждем от вас новых!' :
                    'за удаление комментария к записи ' . $this->getLink($content) . ' в блоге' . $this->getLink($content->author) . ': может, попробовать выразиться иначе?';
            }

            return $text;
        }

        if ($model->entity == 'CookRecipe') {
            $recipe = CookRecipe::model()->resetScope()->findByPk($model->entity_id);
            $text = ($this->scores_earned >= 0) ?
                'за ваш комментарий к кулинарному рецепту ' . $this->getLink($recipe) . ': ждем от вас новых!' :
                'за удаление комментария к кулинарному рецепту ' . $this->getLink($recipe) . ': может, попробовать выразиться иначе?';

            return $text;
        }
        if ($model->entity == 'RecipeBookRecipe') {
            $recipe = RecipeBookRecipe::model()->resetScope()->findByPk($model->entity_id);
            $text = ($this->scores_earned >= 0) ?
                'за ваш комментарий к народному рецепту ' . $this->getLink($recipe) . ': ждем от вас новых!' :
                'за удаление комментария к народному рецепту ' . $this->getLink($recipe) . ': может, попробовать выразиться иначе?';

            return $text;
        }

        return '';
    }

    public function getDate()
    {
        return HDate::isSameDate($this->updated, time()) ?
            'сегодня<br>' . date("H:i", $this->updated)
            :
            Yii::app()->dateFormatter->format('dd MMM', $this->updated) . '<br>' . date("H:i", $this->updated);
    }
}