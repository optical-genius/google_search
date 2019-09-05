<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class Image extends Model
{
    protected $fillable = ['user_id', 'img_url', 'user_request', 'img_name', 'img_color', 'created_at', 'updated_at'];
    protected $guarded = ['id'];

    public static function get_images_google($request)
    {
        // Токен и cx идентификатор
        $key = env ('GOOGLE_SEARCH_API_KEY');
        $cx = env ('GOOGLE_SEARCH_SECRET_KEY');

        // Формируем запрос
        $q = http_build_query(array(
            'key' => $key,
            'cx'  => $cx,
            'q'   => $request['search_request'][0], // запрос для поиска
            'filter' => 1,
            'imgColorType' => 'color',
            'imgDominantColor' => $request['color'],
            "imgSize" => "xlarge",
            "lr" => "lang_ru",
            "imgType" => "photo",
            "num" => 10,
            "searchType" => "image",
        ));

        // Инициализируем клиент

        $client = new Client(array(
            'base_uri' => 'https://www.googleapis.com/customsearch/v1',
            'query'    => $q,
            'timeout'  => 3.0,
            'debug'    => false,
            'headers'  => array(
                'Accept' => 'application/json'
            ),
        ));

        // Отправялем запрос, получаем результаты поиска
        $response = $client->request('GET');
        $results = json_decode($response->getBody()->getContents(), true);
        return $results;
    }
}
