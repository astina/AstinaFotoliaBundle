<?php

namespace Astina\Bundle\FotoliaBundle\Tests\Client;

use Astina\Bundle\FotoliaBundle\Client\Client;

class MockClient extends Client
{
    public function loginUser($login, $pass)
    {
    }

    public function logoutUser()
    {
    }

    public function getMedia($id, $license_name, $subaccount_id = null)
    {
        $media = array(
            'url' => 'http://placehold.it/1600x1200.jpg',
            'name' => 'test.jpg',
            'extension' => 'jpg',
        );

        return $media;
    }

    public function getMediaData($id, $thumbnail_size = 110, $language_id = Client::LANGUAGE_ID_EN_US)
    {
        return array(
            'id' => $id,
            'title' => 'scientist with test tube radiant gradient bg',
            'creator_name' => 'Jos Gil',
            'creator_id' => 6537,
            'width' => 3200,
            'height' => 2400,
            'thumbnail_url' => 'http://static-p1.fotolia.com/jpg/00/01/38/40/110_F_1384045_waKUmRkPuVSQSK9T4lDNc5YvkqSp4x.jpg',
            'thumbnail_400_url' => 'http://static-p1.fotolia.com/jpg/00/01/38/40/110_F_1384045_waKUmRkPuVSQSK9T4lDNc5YvkqSp4x.jpg',
            'thumbnail_400_width' => 300,
            'thumbnail_400_height' => 400,
            'thumbnail_width' => 81,
            'thumbnail_height' => 110,
            'licenses' => array(
                array(
                    'name' => 'XXL',
                    'price' => 3,
                )
            ),
            'licenses_details' => array(
                'XXL' => array(
                    'width' => 10000,
                    'height' => 10000
                )
            ),
        );
    }

    public function downloadMedia($download_url, $output_file = null)
    {
        $src = fopen ($download_url, 'rb');
        $tgt = fopen ($output_file, 'wb');
        while(!feof($src)) {
            fwrite($tgt, fread($src, 1024 * 8 ), 1024 * 8 );
        }
        fclose($src);
        fclose($tgt);
    }

    public function getSearchResults(array $search_params, array $result_columns = null)
    {
        return json_decode('{
            "nb_results":2,
            "0":{
                "id":1384045,
                "title":"scientist with test tube radiant gradient bg",
                "creator_name":"Jose Gil",
                "creator_id":6537,
                "width":3200,
                "height":2400,
                "thumbnail_url":"http:\/\/static-p1.fotolia.com\/jpg\/00\/01\/38\/40\/110_F_1384045_waKUmRkPuVSQSK9T4lDNc5YvkqSp4x.jpg",
                "thumbnail_400_url":"http:\/\/static-p1.fotolia.com\/jpg\/00\/01\/38\/40\/110_F_1384045_waKUmRkPuVSQSK9T4lDNc5YvkqSp4x.jpg",
                "thumbnail_html_tag":"",
                "thumbnail_400_width":300,
                "thumbnail_400_height":400,
                "thumbnail_width":81,
                "thumbnail_height":110,
                "licences":[
                    {
                        "name":"M",
                        "price":1
                    },
                    {
                        "name":"L",
                        "price":2
                    },
                    {
                        "name":"X",
                        "price":50
                    }
                ]
            },
            "1":{
                "id":1247723,
                "title":"antique tube tester",
                "creator_name":"James Steidl",
                "creator_id":140159,
                "width":3200,
                "height":2400,
                "thumbnail_url":"http:\/\/static-p2.fotolia.com\/jpg\/00\/01\/24\/77\/110_F_1247723_MB9BPAu0TMbhI2UEUNCQKCRpvXdEyR.jpg",
                "thumbnail_400_url":"http:\/\/static-p2.fotolia.com\/jpg\/00\/01\/24\/77\/110_F_1247723_MB9BPAu0TMbhI2UEUNCQKCRpvXdEyR.jpg",
                "thumbnail_html_tag":"",
                "thumbnail_400_width":280,
                "thumbnail_400_height":400,
                "thumbnail_width":74,
                "thumbnail_height":110,
                "licences":[
                    {
                        "name":"M",
                        "price":1
                    },
                    {
                        "name":"L",
                        "price":2
                    },
                    {
                        "name":"XL",
                        "price":3
                    },
                    {
                        "name":"X",
                        "price":20
                    }
                ]
            }
        }', true);
    }
}
