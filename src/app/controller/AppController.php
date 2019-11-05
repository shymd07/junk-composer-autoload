<?php
namespace App\controller;
use GuzzleHttp\Client;
use League\Csv\Reader;
use League\Csv\Statement;


class AppController
{
    public function test()
    {




        $temp = './123456';
//        if (\File::isDirectory($temp)) {
//            \File::deleteDirectory($temp);
//        }
//        \File::makeDirectory($temp, 0777);


        $urls = [
            '0' => 'http://www.tokyo-star-auction.com/auction/upload/save_image/OU004094.JPG',
            '1' => 'http://www.tokyo-star-auction.com/auction/upload/save_image/YC010550.JPG',
            '2' => 'http://www.tokyo-star-auction.com/auction/upload/save_image/RZ005616.JPG'
        ];

        $client = new \GuzzleHttp\Client();
        $requests = function () use ($client, $urls) {
            foreach ($urls as $uri) {
                yield function () use ($client, $uri) {
                    return $client->getAsync($uri);
                };
            }
        };
        $pool = new \GuzzleHttp\Pool($client, $requests(), [
            'concurrency' => 100,
            'fulfilled' => function ($response, $index) use ($urls) {
                var_dump('SBAからの画像取得 成功：　'.$urls[$index]);

                $im = new Imagick ();
                $im->newImage (300, 225, "blue");
                $im->writeImage ("test_0.jpg"); // fails with no error message
                //instead
                $im->setImageFormat ("jpeg");
                file_put_contents ("test_1.jpg", $im); // works, or:
                $im->imageWriteFile (fopen ("test_2.jpg", "wb")); //also works

                $image = \Image::make($response->getBody())
                    ->save('./'.$index, 100);
                $image->destroy();
            },
            'rejected' => function ($reason, $index) use ($urls) {
                var_dump('SBAからの画像取得 失敗：　'.$urls[$index]);
                var_dump($reason->getMessage());
                throw new \Exception('SBAからの画像取得 失敗');
            },
        ]);
        $promise = $pool->promise();
        $promise->wait();
        //\File::deleteDirectory($temp);

        exit;










        $csv = Reader::createFromPath('./2019-11-Auctions/11-11_Accessories/sba_collaboration_20191028_101406_001.csv', 'r');
        // ここでヘッダーのオフセットは0、つまり1行目がヘッダーですよーと指定しています
        $csv->setHeaderOffset(0);
        // $header = $csv->getHeader();

        $records = $csv->getRecords();
        foreach ($records as $index => $record) {
            var_dump($record['manage_number']);
            $client = new \GuzzleHttp\Client();
            $url ='http://www.tokyo-star-auction.com/auction/upload/save_image/'.$record['manage_number'].'.JPG';
            $path = './images/'.$record['manage_number'].'.jpg';
            $file_path = fopen($path,'w');
            $response = $client->get($url, [
                'save_to' => $file_path,
                'http_errors' => false
            ]);
            $code = $response->getStatusCode();
        }

        exit;

        //print_r($header);
        //$url = 'http://www.tokyo-star-auction.com/auction/upload/save_image/OU004032.JPG';


        $images = [
            '0' => 'http://www.tokyo-star-auction.com/auction/upload/save_image/OU004094.JPG',
            '1' => 'http://www.tokyo-star-auction.com/auction/upload/save_image/YC010550.JPG',
            '2' => 'http://www.tokyo-star-auction.com/auction/upload/save_image/RZ005616.JPG'
        ];

        $client = new \GuzzleHttp\Client();
        $promises = [];
        $results  = [];

        // それぞれのURLに対して非同期でURLを投げる
        foreach ($images as $key => $url) {
            $promises[$key] = $client->requestAsync('GET', $url);
        }

        // requestが完了するのを待った後、結果によって処理を行う
        foreach (\GuzzleHttp\Promise\settle($promises)->wait() as $key => $obj) {


            switch ($obj['state']) {
                case 'fulfilled':
                    // 成功時
                    var_dump($obj['value']);
                    $results[$key] = $obj['value'];
                    break;
                case 'rejected':
                    // 失敗時
                    $results[$key] = new \GuzzleHttp\Psr7\Response($obj['reason']->getCode());
                    break;
                default:
                    // 想定外としてエラー扱いにする
                    $results[$key] = new \GuzzleHttp\Psr7\Response(0);
            }
        }

        // 成功したrequestの結果だけ表示する
        foreach ($results as $index => $result) {

            if ($result->getReasonPhrase() === 'OK') {
                $path = './images/'.$index.'.jpg';
            } else {
                $path = './images/false.jpg';
            }
            //var_dump(json_decode($result->getBody()->getContents(), true));
            $file_path = fopen($path,'w');
            $response = $client->get($url, ['save_to' => $file_path]);
        }







        $client = new \GuzzleHttp\Client();

        $res = $client->get('http://www.yahoo.co.jp');

        $body = $res->getBody();
        $url ='http://www.tokyo-star-auction.com/auction/upload/save_image/RG006774.JPG';
        $path = './terada.jpg';
        $file_path = fopen($path,'w');
        $response = $client->get($url, ['save_to' => $file_path]);
        return ['response_code'=>$response->getStatusCode(), 'name' => 'shige'];

        echo $body->getContents();


    }
}