<?php
namespace site\frontend\modules\posts\modules\buzz\commands;
use site\frontend\modules\editorialDepartment\behaviors\ConvertBehavior;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\som\modules\community\models\api\CommunityClub;

/**
 * @author Никита
 * @date 08/10/15
 */

class DefaultCommand extends \CConsoleCommand
{
    public $advExceptions = array(
        247154,

        240984,
        691779,
        675554,

        697054,
        691084,
        268736,
        691864,

        270589,
        676679,
        256624,
        252664,
        250794,
    );

    public function actionMigrate3($all = false, $id = null, $list = true)
    {
        $ids = array(
            710753,
            710748,
            710728,
            710738,
            723918,
            710863,
            710868,
            710973,
            710988,
            710993,
            711048,
            711088,
            711093,
            711098,
            711108,
            711123,
            711148,
            711153,
            711183,
            711193,
            711198,
            711203,
            711248,
            711253,
            711278,
            711283,
            711298,
            711303,
            711308,
            711343,
            711348,
            711353,
            711458,
            711463,
            711468,
            711483,
            711523,
            711528,
            711538,
            711578,
            711583,
            711588,
            711603,
            711608,
            711613,
            711628,
            711783,
            711818,
            711823,
            711828,
            711833,
            711858,
            712173,
            712218,
            712223,
            712323,
            712353,
            712413,
            712463,
            712528,
            712628,
            712643,
            712673,
            712747,
            712817,
            712822,
            712882,
            712887,
            712922,
            712987,
            713012,
            713022,
            713087,
            713092,
            713182,
            713382,
            713387,
            713412,
            713487,
            713582,
            713587,
            713592,
            713597,
            713682,
            713697,
            713702,
            713717,
            713737,
            713877,
            713887,
            713992,
            713997,
            714002,
            714027,
            714107,
            714162,
            714182,
            714204,
            714289,
            714366,
            714403,
            714428,
            714503,
            714508,
            714568,
            714613,
            714623,
            714628,
            714683,
            714753,
            714808,
            714828,
            714898,
            714963,
            714968,
            714973,
            714978,
            714983,
            714998,
            715018,
            715048,
            715068,
            715073,
            715138,
            715143,
            715153,
            715178,
            715183,
            715293,
            715298,
            715308,
            715313,
            715318,
            715323,
            715403,
            715408,
            715468,
            715473,
            715508,
            715583,
            715648,
            715688,
            715693,
            715708,
            715718,
            715723,
            715728,
            715743,
            715788,
            715798,
            715803,
            715808,
            715843,
            715848,
            715903,
            715908,
            715973,
            716048,
            716053,
            716093,
            716153,
            716158,
            716163,
            716168,
            716173,
            716178,
            716223,
            716233,
            716238,
            716313,
            716318,
            716328,
            716333,
            716403,
            716408,
            716443,
            716448,
            716488,
            716493,
            716498,
            716503,
            716523,
            716528,
            716573,
            716578,
            716613,
            716618,
            716623,
            716628,
            716638,
            716643,
            716648,
            716653,
            716733,
            716738,
            716763,
            716768,
            716773,
            716783,
            716788,
            716793,
            716908,
            716943,
            716963,
            716968,
            717003,
            717013,
            717018,
            717023,
            717073,
            717113,
            717128,
            717133,
            717138,
            717143,
            717148,
            717198,
            717203,
            717218,
            717223,
            717228,
            717233,
            717273,
            717278,
            717348,
            717353,
            717363,
            717433,
            717438,
            717443,
            717498,
            717503,
            717523,
            717538,
            717553,
            717558,
            717648,
            717673,
            717678,
            717698,
            717703,
            717718,
            717793,
            717848,
            717868,
            717873,
            717878,
            717938,
            717943,
            717948,
            717963,
            717998,
            718003,
            718008,
            718038,
            718068,
            718103,
            718178,
            718183,
            718188,
            718208,
            718213,
            718268,
            718338,
            718343,
            718348,
            718353,
            718363,
            718398,
            718403,
            718458,
            718463,
            718513,
            718618,
            718623,
            718643,
            718658,
            718743,
            718748,
            718758,
            718763,
            718768,
            718773,
            718853,
            718898,
            718983,
            718988,
            719998,
            719028,
            719033,
            719043,
            719118,
            719123,
            719148,
            719208,
            719213,
            719243,
            719248,
            719253,
            719258,
            719263,
            719268,
            719273,
            719298,
            719328,
            719338,
            719343,
            719348,
            719363,
            719373,
            719403,
            719498,
            719548,
            719593,
            719598,
            719603,
            719608,
            719613,
            719618,
            719638,
            719643,
            719728,
            719753,
            719843,
            719863,
            719928,
            719933,
            719938,
            719943,
            719953,
            719988,
            720003,
            720063,
            720068,
            720073,
            720078,
            720083,
            720088,
            720138,
            720158,
            720208,
            720223,
            720228,
            720233,
            720258,
            720293,
            720328,
            720348,
            720353,
            720448,
            720453,
            720458,
            720463,
            720468,
            720478,
            720493,
            720653,
            720678,
            720728,
            720758,
            720813,
            720818,
            720833,
            720838,
            720843,
            720848,
            720853,
            720858,
            720863,
            720878,
            720883,
            720888,
            720968,
            720993,
            721068,
            721073,
            721078,
            721093,
            721198,
            721208,
            721223,
            721233,
            721348,
            721388,
            721503,
            721508,
            721548,
            721553,
            721658,
            721678,
            721683,
            721723,
            721743,
            721748,
            721798,
            721833,
            721838,
            721843,
            721948,
            721953,
            721958,
            721963,
            721993,
            722088,
            722093,
            722118,
            722133,
            722138,
            722143,
            722193,
            722198,
            722203,
            722208,
            722213,
            722353,
            722358,
            722708,
            722728,
            722993,
            722998,
            723003,
            725263,
            725268,
            710853
        );

        $total = count($ids);
        foreach ($ids as $i => $id) {
            $mCriteria = new \EMongoCriteria();
            $mCriteria->addCond('entityId', '==', (int) $id);
            $mModel = \site\frontend\modules\editorialDepartment\models\Content::model()->find($mCriteria);
            if ($mModel) {
                $model = Content::model()->findByPk($id);

                if ($model) {
                    $mModel->label = Label::LABEL_BUZZ;
                    $mModel->save(false, array('label'));

                    if ($model) {
                        if ($mModel->rubricId !== null) {
                            $labels = Label::model()->findByRubric($mModel->rubricId);
                        } elseif ($mModel->forumId !== null) {
                            $labels = Label::model()->findByForum($mModel->forumId);
                        } elseif ($mModel->clubId !== null) {
                            $labels = Label::model()->findByClub($mModel->clubId);
                        } else {
                            $labels = Label::model()->findForBlog();
                        }

                        $labels = array_map(function($labelModel) {
                            return $labelModel->text;
                        }, $labels);
                        if ($mModel->label !== null) {
                            $labels[] = $mModel->label;
                        }
                    }
                }
            }
            echo '[' . ($i + 1) . '/' . $total . ']' . "\n";
        }
    }
    
    public function actionMigrate2($all = false, $id = null)
    {
        ConvertBehavior::$migration = true;

        if ($all === false && $id === null) {
            throw new \CException("Invalid parameters");
        }

        $criteria = new \EMongoCriteria();
        if ($id !== null) {
            $criteria->addCond('entityId', '==', (int) $id);
        }

        $criteria->sort('dtimeCreated', \EMongoCriteria::SORT_ASC);

        //$criteria->addCond('entityId', '>=', 690624);

        $dp = new \EMongoDocumentDataProvider(MigrateContent::model(), array(
            'criteria' => $criteria,
        ));
        $total = $dp->totalItemCount;
        $iterator = new \CDataProviderIterator($dp);

        $ids = \Yii::app()->db->createCommand("SELECT id
FROM post__contents
WHERE originEntity = 'AdvPost' AND isRemoved = 0;")->queryColumn();

        foreach ($iterator as $i => $model) {
            echo $model->entityId . "\n";
            if (array_search($model->entityId, $ids) === false) {
                continue;
            }

            $model->scenario = 'buzz';
            $model->label = Label::LABEL_BUZZ;
            if (array_search($model->entityId, $this->advExceptions) === false) {
                $model->save();
            }
            echo '[' . ($i + 1) . '/' . $total . ']' . "\n";
        }
    }

    public function actionMigrate($all = false, $id = null)
    {
        if ($all === false && $id === null) {
            throw new \CException("Invalid parameters");
        }

        $criteria = new \CDbCriteria();
        $criteria->addCondition('buzzMigrate = 0');
        $criteria->addInCondition('originService', array('advPost', 'oldCommunity'));
        if ($id !== null) {
            $criteria->compare('originEntityId', $id);
        }

        $dp = new \CActiveDataProvider(Content::model(), array(
            'criteria' => $criteria,
        ));
        $total = $dp->totalItemCount;

        $iterator = new \CDataProviderIterator($dp, 100);

        $newsCommunity = \Community::model()->findByPk(\Community::COMMUNITY_NEWS);

        $rubricToClub = array(
            6302 => 2,
            6303 => 4,
            6304 => 15,
            6305 => 13,
            6306 => 7,
            6307 => 6,
            6308 => 8,
            6309 => 21,
        );

        $fakeModel = new \site\frontend\modules\posts\models\api\Content();
        $fakeClass = get_class($fakeModel);

        /** @var \site\frontend\modules\posts\models\Content $model */
        foreach ($iterator as $i => $model) {
            $labels = $model->labelsArray;
            if ($model->originService == 'advPost') {
                if (array_search($model->originEntityId, $this->advExceptions) === false) { // обычный эмоциональный пост
                    $labels[] = Label::LABEL_BUZZ;
                    $model->templateObject->data['authorView'] = 'club';
                    $model->templateObject->data['clubData'] = CommunityClub::getClub($labels);
//                    $model->originManageInfoObject->params['edit'] = array(
//                        'link' => array(
//                            'url' => '/editorialDepartment/redactor/editBuzz/?' . http_build_query(array('entity' => $fakeClass, 'entityId' => $model->id)),
//                        )
//                    );
                } else { // рекламный эмоциональный пост
                    $labels[] = Label::LABEL_FORUMS;
                }
            } elseif (array_search($newsCommunity->toLabel(), $labels) !== false) {
                $clubLabel = null;

                foreach ($labels as $label) {
                    if (strpos($label, 'Рубрика') !== false) {
                        $parts = explode(': ', $label);
                        $title = $parts[1];
                        $rubric = \CommunityRubric::model()->findByAttributes(array('title' => $title, 'community_id' => \Community::COMMUNITY_NEWS));

                        $clubId = $rubricToClub[$rubric->id];
                        $club = \CommunityClub::model()->findByPk($clubId);
                        $clubLabel = $club->toLabel();
                    }
                }

                if ($clubLabel === null) {
                    echo $model->id . "\n";
                    break;
                }

                $labels[] = Label::LABEL_NEWS;
                $labels[] = $clubLabel;

                $model->templateObject->data['authorView'] = 'empty';
            } else {
                $labels[] = Label::LABEL_FORUMS;
            }

            $model->buzzMigrate = 1;
            $model->labelsArray = $labels;
            $model->save();
            echo '[' . ($i + 1) . '/' . $total . ']' . "\n";
        }
    }
}

class MigrateContent extends \site\frontend\modules\editorialDepartment\models\Content
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            // Обязательность
            array('title, markDown, htmlText, authorId, fromUserId', 'required'),
            array('clubId, forumId, rubricId', 'required', 'on' => 'forums'),
            array('clubId', 'required', 'on' => 'buzz, news'),

            // Сделаем числа числами
            array('authorId, fromUserId', '\site\common\components\HIntegerFilter'),
            array('clubId, forumId, rubricId', '\site\common\components\HIntegerFilter', 'on' => 'forums'),
            array('clubId', '\site\common\components\HIntegerFilter', 'on' => 'buzz, news'),
        );
    }
}