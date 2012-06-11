<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatController extends SController
{
    public $cookie = '';
    public $session = 1;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionWordstatParse(){
        $parser = new WordstatParser();
//        $parser->start(0);

        $text = '<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" class="campaign">
                      <tbody>                            <tr valign="top">
                                <td style="text-align: right" colspan="3">
                                    <span>Обновлено: 07/06/2012</span>
                                </td>
                            </tr>
                        <tr valign="top">
                            <td>Что искали со словами <span class="bold-style">«беременность по не...»</span> &mdash; 34 показа в месяц.
                            </td>
                            <td></td>
                            <td>Что еще искали люди, искавшие <span class="bold-style">«беременность по не...»</span>:
                            </td>
                        </tr>
                        <tr valign="top">
                          <td width="45%"><table width="100%" cellspacing="0" cellpadding="5" border="0">
  <tbody>
    <tr valign="bottom" class="thead">
      <td width="80%" rowspan="1">Слова</td>
      <td><div style="width: 10px"></div> </td>
      <td width="20%" class="align-right-td">Показов в месяц</td>
    </tr>  </tbody>
</table>                          </td>
                          <td width="10%">
                              <div style="width:15px"></div>
                          </td>
                          <td width="45%"><table width="100%" cellspacing="0" cellpadding="5" border="0">
  <tbody>
    <tr valign="bottom" class="thead">
      <td width="80%" rowspan="1">Слова</td>
      <td><div style="width: 10px"></div> </td>
      <td width="20%" class="align-right-td">Показов в месяц</td>
    </tr>  </tbody>
</table>                            <br>
                          </td>
                        </tr>
                      </tbody>
                    </table>';

        $parser->parseData($text);
    }

    public function actionAddKeywords()
    {
        $keyword = Yii::app()->request->getPost('keyword');

        $allSearch = Yii::app()->search
            ->select('*')
            ->from('keywords')
            ->where(' ' . $keyword . ' ')
            ->limit(0, 100000)
            ->searchRaw();
        $count = 0;
        foreach ($allSearch['matches'] as $key => $m)
            if (ParsingKeywords::model()->addKeywordById($key))
                $count++;

        echo CJSON::encode(array(
            'status' => true,
            'count' => $count
        ));
    }

    public function actionAddCompetitors()
    {
        $keywords = Yii::app()->db_seo->createCommand('select distinct(keyword_id) from sites__keywords_visits')->queryColumn();
        $count = 0;
        foreach ($keywords as $keyword) {
            if (ParsingKeywords::model()->addKeywordById($keyword))
                $count++;
        }

        echo CJSON::encode(array(
            'status' => true,
            'count' => $count
        ));
    }

    public function actionRemovePlus()
    {
        $end = false;
        $i = 0;

        $criteria = new CDbCriteria;
        $criteria->order = 'id';
        $criteria->limit = 1000;
        while (!$end) {
            $criteria->condition = 'id >= ' . ($i * 1000) . ' AND id < ' . ($i*1000 + 1000);
            $models = Keywords::model()->findAll($criteria);

            foreach ($models as $model) {
                if (preg_match_all('/\+([а-яА-Я]+)/', $model->name, $matches)) {
                    echo $model->name.'<br>';
                    $new_name = str_replace('+', '', $model->name);

                    $keyword = Keywords::model()->findByAttributes(array('name' => $new_name));
                    if ($keyword !== null) {
                        //$model->delete();
                    } else {
                        $model->name = $new_name;
                        //$model->save();
                    }
                }
            }

            $i++;
            if ($i%100 == 0)
                echo $i.'<br>';

            if ($i > 230000)
                $end = true;
        }
    }
}
