<?php

/**
 * @author Никита
 * @date 05/08/16
 */
class NewSeoCommand extends CConsoleCommand
{
    public function actionFixActivity($delete = false)
    {
        \Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();

        $patterns = array(
            '#\/community\/(?:\d+)\/forum\/advpost\/(\d+)\/#' => 'AdvPost',
            '#\/community\/(?:\d+)\/forum\/(?:\w+)\/(\d+)\/#' => 'CommunityContent',
            '#\/user\/(?:\d+)\/blog\/post(\d+)\/#' => 'CommunityContent',
            '#\/morning\/(\d+)\/#' => 'CommunityContent',
            '#\/news\/post(\d+)\/#' => 'CommunityContent',
            '#\/buzz\/advpost(\d+)\/#' => 'AdvPost',
            '#\/user\/(?:\d+)\/blog\/nppost(\d+)\/#' => 'NewPhotoPost',
            '#\/user\/(?:\d+)\/blog\/status(\d+)\/#' => 'NewStatus',
            '#\/contractubex\/post(\d+)\/#' => 'CommunityContent',
            '#\/contractubex\/advpost(\d+)\/#' => 'AdvPost',
        );

        $offset = 0;
        $limit = 1000;
        $c = 0;
        do {
            $rows = Yii::app()->db->createCommand('SELECT * FROM som__activity ORDER BY id ASC' . ' LIMIT ' . $limit . ' OFFSET ' . $offset)->queryAll();

            foreach ($rows as $row) {
                $data = CJSON::decode($row['data']);
                $url = $data['url'];

                if ($url === false && isset ($data['content']) && isset($data['content']['url'])) {
                    $url = $data['content']['url'];
                }

                $id = false;
                foreach ($patterns as $pattern => $originEntity) {
                    if (preg_match($pattern, $url, $matches)) {
                        $id = $matches[1];
                        $post = \site\frontend\modules\posts\models\Content::model()->resetScope()->byEntity($originEntity, $id)->find();
                        if (! $post || $post->isRemoved == 1) {
                            $c++;
                            if ($delete) {
                                Yii::app()->db->createCommand()->delete('som__activity', 'id = :id', [':id' => $row['id']]);
                                echo $row['id'] . " delete\n";
                            }
                        }
                        break;
                    }
                }

                if ($id === false) {
                    echo $row['id'] . " " . $url . "unknown pattern\n";
                }
            }

            $offset += $limit;
        } while (count($rows) > 0);

        echo "Итого " . $c . "\n";
    }
}