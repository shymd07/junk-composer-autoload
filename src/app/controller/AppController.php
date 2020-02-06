<?php
namespace App\controller;
use GuzzleHttp\Client;
use League\Csv\Reader;
use League\Csv\Statement;
use Intervention\Image;


class AppController
{
    public function test2()
    {
        ini_set('max_execution_time', 1800);

//-        $file = './report/12-11-accessary/20191206105433_salescheck_report.csv';
//-        $file = './report/12-11-apparel/20191206105504_salescheck_report.csv';
//        $file = './report/12-11-shoes/20191206105616_salescheck_report.csv';
//-        $file = './report/12-11-silverbrand/20191206105547_salescheck_report.csv';
//-        $file = './report/12-12-watch/20191206105410_salescheck_report.csv';
//-        $file = './report/12-13-BJ/20191206105032_salescheck_report.csv';
//-        $file = './report/12-13-J/20191206105138_salescheck_report.csv';
//-        $file = './report/12-14-bag/20191206104953_salescheck_report.csv';
        $file = './report/yokoi-san-sba.csv';

        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0);
        // $header = $csv->getHeader();

        $records = $csv->getRecords();
        foreach ($records as $index => $record) {
            $urls[] ='http://www.tokyo-star-auction.com/auction/upload/save_image/'.$record['manage_number'].'.JPG';
            $item_id[] =  $record['item_id'];
            $manage_number[] = $record['manage_number'];
            //.mkdir("./images/".$record['item_id'], 0777);

        }

        $client = new \GuzzleHttp\Client(['debug' => false]);
        $requests = function () use ($client, $urls, $item_id, $manage_number) {
            foreach ($urls as $idx => $uri) {
                yield function () use ($client, $uri, $idx, $item_id,$manage_number) {
                    return $client->getAsync($uri, [
                        "sink" => './images/'.$manage_number[$idx].'.JPG',
                        //"sink" => './images/'.$item_id[$idx].'/'.$manage_number[$idx].'.JPG',

                        "http_errors" => false,
                        ]);
                };
            }
        };
        $pool = new \GuzzleHttp\Pool($client, $requests(), [
            'concurrency' => 100,
            'fulfilled' => function ($response, $index) use ($urls) {
                //var_dump('SBAからの画像取得 成功：　'. $index.' --'.$urls[$index]);
            },
            'rejected' => function ($reason, $index) use ($urls) {
                //var_dump('SBAからの画像取得 失敗：　'.$urls[$index]);
                var_dump($reason->getMessage());
                var_dump('SBAからの画像取得 失敗: '.$index. "---" . $urls[$index]);

                //throw new \Exception('SBAからの画像取得 失敗: '.$index. "---" . $urls[$index]);
            },
        ]);
        $promise = $pool->promise();
        $promise->wait();
        //\File::deleteDirectory($temp);
        exit;
    }

    public function getStatusCode()
    {
        ini_set('max_execution_time', 1800);

        $file = './report/yokoi-san-sba.csv';

        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0);


        $client = new \GuzzleHttp\Client();



        $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

        echo $response->getStatusCode(); // 200
    }

}

