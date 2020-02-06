<?php


namespace App\Controller;
use GuzzleHttp\Client;
use League\Csv\Reader;
use GuzzleHttp\Pool;
use Psr\Log;


class ApiController
{
    public function test() {

        $file = './report/yokoi-san-sba-test.csv';

        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        foreach ($records as $index => $record) {
            $urls[] ='http://www.tokyo-star-auction.com/auction/upload/save_image/'.$record['manage_number'].'.JPG';
            $manage_number[] = $record['manage_number'];
        }

        $client = new Client();
        $requests = function ($urls) use ($client) {
            foreach ($urls as $url) {
                yield function () use ($client, $url) {
                    return $client->getAsync($url);
                };
            }
        };

        $pool = new Pool($client, $requests($urls), [
            'concurrency' => 5,
            'fulfilled' => function ($response, $index) use ($urls, $manage_number) {
                //echo '成功 url:' . '<a href="' .$urls[$index] . '">'. "ok" . '</a><br>';
            },
            'rejected' => function ($reason, $index) use ($urls, $manage_number) {
                //echo '<a href="' .$urls[$index] . '">' . "$manage_number[$index]" . '</a><br>';
                echo "$manage_number[$index]" . '<br>';
            }
        ]);

        $promise = $pool->promise();
        $promise->wait();

    }
}