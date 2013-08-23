<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.common.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.components.wordstat.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.seo.modules.traffic.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.frontend.helpers.*');

class SeoParsingCommand extends CConsoleCommand
{
    private $prev_month;
    private $prev_year;

    public function beforeAction($action)
    {
        Yii::import('site.seo.modules.competitors.components.*');
        $last_month = strtotime('last day of -1 month');
        $this->prev_month = '07';
        $this->prev_year = date("Y", $last_month);
        echo $this->prev_month . ' - ' . $this->prev_year . "\n";

        return true;
    }

    public function actionAdd()
    {
        $last_num = SeoUserAttributes::getAttribute('keyword_num', 1);
        echo $last_num . "\n";

        $handle = fopen("/home/giraffe/uniq_590m_ru.txt", "r");
        $i = 0;
        while (!feof($handle)) {
            $i++;
            $keyword = fgets($handle);
            if ($i < $last_num)
                continue;

            Keyword::GetKeyword($keyword, 1);

            if ($i % 10000 == 0)
                SeoUserAttributes::setAttribute('keyword_num', $i, 1);
        }
        fclose($handle);
    }

    public function actionLi($site)
    {
        $last_parsed = SeoUserAttributes::getAttribute('last_li_parsed_' . date("Y-m"), 1);
        if (empty($site)) {
            $parser = new LiParser(false, true);

            if (!empty($last_parsed))
                $sites = Site::model()->findAll('id > ' . $last_parsed . ' AND type = 1 AND url != ""');
            else
                $sites = Site::model()->findAll('type = 1 AND url != ""');

            foreach ($sites as $site) {
                echo $site->id . "\n";
                $parser->start($site->id, $this->prev_year, 1, 7);
                SeoUserAttributes::setAttribute('last_li_parsed_' . date("Y-m"), $site->id, 1);
            }
        } else {
            $parser = new LiParser(false, true);
            $parser->start($site, $this->prev_year, $this->prev_month, $this->prev_month);
        }
    }

    public function actionMailru($site)
    {
        $last_parsed = SeoUserAttributes::getAttribute('last_mailru_parsed_' . date("Y-m"), 1);
        if (empty($site)) {
            $parser = new MailruParser(false, true);

            if (!empty($last_parsed))
                $sites = Site::model()->findAll('id > ' . $last_parsed . ' AND type=2');
            else
                $sites = Site::model()->findAll('type=2');

            foreach ($sites as $site) {
                $parser->start($site->id, $this->prev_year, $this->prev_month, $this->prev_month);
                SeoUserAttributes::setAttribute('last_mailru_parsed_' . date("Y-m"), $site->id, 1);
            }
        } else {
            $parser = new MailruParser(false, true);
            $parser->start($site, $this->prev_year, $this->prev_month, $this->prev_month);
        }
    }

    public function actionLiKeywords($site)
    {
        $last_parsed = SeoUserAttributes::getAttribute('last_li_parsed_' . date("Y-m-d"), 1);
        $parser = new LiKeywordsParser;

        if (empty($site)) {
            if (!empty($last_parsed))
                $sites = Site::model()->findAll('id > ' . $last_parsed);
            else
                $sites = Site::model()->findAll();

            foreach ($sites as $site) {
                $parser->start($site->id);
                SeoUserAttributes::setAttribute('last_li_parsed_' . date("Y-m-d"), $site->id, 1);
            }
        } else {
            $parser = new LiKeywordsParser();
            $parser->start($site);
        }
    }

    public function actionParseSites($page)
    {
        $parser = new LiSitesParser;
        $parser->start($page);
    }

    public function actionLi2Parse($debug = false)
    {
        $parser = new Li2KeywordsParser(true, $debug);
        $parser->start();
    }

    public function actionLi2Private($debug = false)
    {
        $parser = new Li2KeywordsParser(true, $debug);
        $parser->rus_proxy = false;
        $parser->parse_private = true;
        $parser->period = Li2KeywordsParser::PERIOD_DAY;
        $parser->start();
    }

    public function actionPassword($debug = false)
    {
        $parser = new LiPassword(true, $debug);
        $parser->rus_proxy = false;
        $parser->start();
    }

    public function actionImport()
    {
        Yii::import('site.seo.modules.competitors.models.*');

        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->offset = 0;

        $i = 0;
        $count = SiteKeywordVisit2::model()->count();
        $models = array(0);
        while (!empty($models)) {
            $models = SiteKeywordVisit2::model()->findAll($criteria);

            foreach ($models as $model) {
                $keyword_id = Keyword::GetKeyword($model->keyword)->id;
                $model2 = SiteKeywordVisit::model()->findByAttributes(array(
                    'keyword_id' => $keyword_id,
                    'site_id' => $model->site_id,
                    'year' => $model->year,
                ));
                if ($model2 === null) {
                    $model2 = new SiteKeywordVisit();
                    $model2->keyword_id = $keyword_id;
                }
                foreach($model2->getAttributes() as $name => $value)
                    if (!empty($model->$name) && $name != 'id')
                        $model2->$name = $model->$name;
                $model2->save();
                $i++;
            }

            $criteria->offset += 1000;

            echo round(100 * $i / $count, 2) . "%\n";
        }
    }

    public function actionExport()
    {
        Yii::import('site.seo.modules.competitors.models.*');

        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->offset = 0;

        $i = 0;
        $count = SiteKeywordVisit::model()->count();
        $models = array(0);
        while (!empty($models)) {
            $models = SiteKeywordVisit::model()->findAll($criteria);

            foreach ($models as $model) {
                $model2 = SiteKeywordVisit2::model()->findByAttributes(array(
                    'keyword' => $model->keyword->name,
                    'site_id' => $model->site_id,
                    'year' => $model->year,
                ));
                if ($model2 === null) {
                    $model2 = new SiteKeywordVisit2();
                    $model2->keyword = $model->keyword->name;
                }
              foreach($model2->getAttributes() as $name => $value)
                  if (!empty($model->attributes[$name]))
                        $model2->attributes[$name] = $model->attributes[$name];
                $model2->save();
                $i++;
            }

            $criteria->offset += 1000;

            echo round(100 * $i / $count, 2) . "%\n";
        }
    }

    public function actionAddLiSite($id){
        $site = LiSite::model()->findByPk($id);
        $exist = Site::model()->findByAttributes(array('url'=>$site->url));
        if ($exist){
            echo "exist\n";
            Yii::app()->end();
        }
        $site2= new Site;
        $site2->name =$site->url;
        $site2->url =$site->url;
        $site2->password =$site->password;
        $site2->type = Site::TYPE_LI;
        if ($site2->save()){
            echo $site2->id."\n";
        }else
            echo "error\n";
    }
}

