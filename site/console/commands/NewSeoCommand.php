<?php

include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

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

    public function actionFindLinks()
    {
        $posts = new CActiveDataProvider(\site\frontend\modules\posts\models\Content::model());
        $count = $posts->totalItemCount;
        $iterator = new CDataProviderIterator($posts, 1000);
        $data = [];
        foreach ($iterator as $i => $post) {
            if (($i % 1000) == 0) {
                echo $i . "/" . $count . "\n";
            }

            $links = $this->getLinks($post->html);
            foreach ($links as $link) {
                if (! isset($data[$link])) {
                    $data[$link] = [
                        'from' => $post->url,
                        'status' => '0',
                        'url' => $link,
                    ];
                } else {
                    $data[$link]['from'] .= "\n" . $post->url;
                }
            }
        }
        $linksCount = count($data);

        echo $linksCount . " links rdy\n";

        $client = new \Guzzle\Http\Client();
        $requests = array_map(function($row) use ($client) {
            return $client->get($row['url']);
        }, $data);

        echo "Requests rdy\n";

        for ($i = 0; $i < ceil(count($requests) / 1000); $i++) {
            echo $i * 1000 . "/" . $linksCount . "\n";

            try {
                $responses = $client->send(array_slice($requests, $i * 1000, 1000));
            } catch (\Guzzle\Http\Exception\MultiTransferException $e) {
                foreach ($e->getFailedRequests() as $request) {
                    $data[$request->getUrl()]['status'] = 2;
                }

                foreach ($e->getSuccessfulRequests() as $request) {
                    $data[$request->getUrl()]['status'] = 1;
                }
            }
        }

        $this->writeCsv('links', $data);
    }

    public function actionTestWrite()
    {
        $data = [
            [1, 2, 3]
        ];

        $this->writeCsv('data', $data);
    }

    protected function writeCsv($name, $data)
    {
        $path = Yii::getPathOfAlias('site.frontend.www-submodule') . DIRECTORY_SEPARATOR . $name . '.csv';
        if (is_file($path)) {
            unlink($path);
        }
        $fp = fopen($path, 'w');

        foreach ($data as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }

    protected function getLinks($html)
    {
        $doc = str_get_html($html);
        if (! $doc) {
            return [];
        }

        $links = $doc->find('a');
        $urls = [];
        foreach ($links as $link) {
            $urls[] = (strpos($link->href, '/') == 0) ? ('http://www.happy-giraffe.ru' . $link->href) : $link->href;
        }
        return $urls;
    }
}