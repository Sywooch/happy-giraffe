<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */
class ConvertNewCommand extends CConsoleCommand
{
    public function actionFix()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 2000;
        $criteria->order = 'id desc';
        $models = CommunityPost::model()->findAll($criteria);
        foreach($models as $model)
            $model->save();
    }

    /**
     * вычисление ширины/высоты фоток
     */
    public function actionUpdatePhotos()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 3000;
        $criteria->offset = 0;
        $criteria->condition = 'width IS NULL';

        $models = array(0);
        while (!empty($models)) {
            $models = AlbumPhoto::model()->findAll($criteria);

            foreach ($models as $model)
                $model->save();

            echo AlbumPhoto::model()->count($criteria) . "\n";
        }
    }

    /**
     * Создание фото-постов из постов с галереями
     */
    public function actionConvertPostPhotos()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->with = array('content');
        $criteria->condition = 'content.id > 55000';
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = CommunityPost::model()->findAll($criteria);
            foreach ($models as $model) {
                if (strpos($model->text, '<img') !== false && strpos($model->text, '<!-- widget:') === false)
                    $model->save();
                echo $model->content_id . "\n";
            }

            $criteria->offset += 1000;
            echo $criteria->offset . "\n";
        }
    }

    /**
     * Создание фото-галерей в комментах
     */
    public function actionConvertCommentPhotos()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->condition = "`t`.`text` LIKE '%<img%' AND `t`.`text` NOT LIKE '%<!--%' ";
        $criteria->order = 'id asc';
        $criteria->offset = 0;
        $criteria->compare('t.id', 167062);

        $models = array(0);
        while (!empty($models)) {
            $models = Comment::model()->findAll($criteria);
            foreach ($models as $model) {
                $model->save();
                $max_id = $model->id;
            }

            $criteria->condition = "`t`.`text` LIKE '%<img%' AND `t`.`text` NOT LIKE '%<!--%' AND `t`.`id` > " . $max_id;
            echo $max_id . "\n";
        }
    }

    public function actionConvertPhotoTest($id)
    {
        $model = CommunityPost::model()->findByAttributes(array('content_id' => $id));
        if (strpos($model->text, '<img') !== false && strpos($model->text, '<!-- widget:') === false) {
            $model->save();
        }
    }

    /**
     * пересчитать рейтинг статей, нужен для блока "лучшие записи блога"
     */
    public function actionRating()
    {
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.modules.favourites.models.*');

        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = CommunityContent::model()->findAll($criteria);
            foreach ($models as $model)
                PostRating::reCalc($model);

            $criteria->offset += 100;
            echo $criteria->offset . "\n";
        }
    }

    /**
     * Установить рубрику для постов у которых её нет
     */
    public function actionSetStatusesRubric()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->offset = 0;
        $criteria->condition = 'rubric_id IS NULL';

        $models = array(0);
        while (!empty($models)) {
            $models = CommunityContent::model()->resetScope()->findAll($criteria);
            foreach ($models as $model) {
                if (empty($model->rubric_id))
                    $model->rubric_id = CommunityRubric::getDefaultUserRubric($model->author_id);
                if (!empty($model->rubric_id))
                    $model->update(array('rubric_id'));
                else
                    echo 1;
            }
        }
    }

    public function actionFixVideos()
    {
        Yii::import('site.frontend.components.OEmbed');
        Yii::import('site.frontend.components.video.*');

        $dp = new CActiveDataProvider('CommunityVideo', array(
            'criteria' => array(
                'with' => array('content'),
                'condition' => 'content.removed = 0',
            ),
        ));
        $iterator = new CDataProviderIterator($dp);

        foreach ($iterator as $model) {
            echo $model->id . "\n";
            $model->save();
        }
    }

    public function actionAddViews()
    {
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', array(99587, 99669, 99675, 99761, 99766, 99771, 99775, 99787, 99807, 99811, 99813, 99816, 99821, 99823, 99828, 99834, 99837, 99841, 99844, 99847, 99643, 99672, 99680, 99698, 99737, 99796, 99773, 99791, 99815, 99836, 99843, 99853, 99871, 99883, 99911, 99925, 99937, 99981, 100003, 100022, 99601, 99683, 99735, 99754, 99760, 99801, 99806, 99822, 99832, 99857, 99861, 99876, 99888, 99892, 99899, 99902, 99904, 99915, 100043, 100045, 99605, 99620, 99646, 99856, 99858, 99862, 99865, 99867, 99872, 99886, 99887, 99889, 99895, 99897, 99901, 99903, 99905, 99909, 99912, 99914, 99575, 99704, 99707, 99708, 99712, 99713, 99715, 99717, 99719, 99722, 99726, 99731, 99733, 99734, 99736, 99738, 99739, 99740, 99741, 99742, 99921, 99926, 99929, 99930, 99932, 99936, 99938, 99940, 99955, 99992, 100001, 100038, 100052, 100054, 100056, 100057, 100059, 100060, 100061, 100062, 99579, 99591, 99594, 99607, 99616, 99626, 99633, 99636, 99641, 99645, 99656, 99657, 99663, 99666, 99670, 99673, 99679, 99681, 99686, 99689, 99583, 99590, 99595, 99638, 99644, 99652, 99654, 99658, 99662, 99667, 99671, 99676, 99684, 99687, 99692, 99697, 99699, 99718, 99724, 99730, 99655, 99690, 99777, 99866, 100035, 99703, 99637, 99900, 99721, 99727, 99732, 99750, 99751, 99756, 99763, 99767, 99770, 99782, 99786, 99840, 99874, 99851, 99854, 99881, 99882, 99688, 99753, 99755, 99758, 99759, 99762, 99765, 99768, 99772, 99774, 99776, 99779, 99783, 99784, 99785, 99788, 99789, 99793, 99795, 99797, 99798, 99803, 99630, 99635, 99642, 99693, 99695, 99725, 99749, 99827, 99830, 99839, 99891, 99906, 99908, 99910, 99927, 99933, 99939, 99941, 100016, 100018, 99804, 99916, 99919, 99922, 99924, 99934, 99935, 99942, 99953, 99978, 99999, 100020, 100028, 100032, 100036, 100040, 100042, 100044, 100048, 100050, 99585, 99599, 99610, 99627, 99650, 99660, 99668, 99677, 99682, 99691, 99694, 99696, 99700, 99702, 99705, 99706, 99711, 99716, 99720, 99723, 99744, 99746, 99757, 99778, 99790, 99799, 99809, 99814, 99819, 99831, 99833, 99845, 99846, 99848, 99855, 99868, 99869, 99870, 99873, 99875));
        $models = CommunityContent::model()->findAll($criteria);

        foreach ($models as $m)
            PageView::model()->cheat($m->url, 70, 200);
    }
}

