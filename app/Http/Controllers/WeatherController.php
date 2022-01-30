<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\Rule\Parameters;

class WeatherController extends Controller
{
    public $parameters = ['valid_date', 'temp', 'min_temp', 'max_temp', 'wind_spd', 'weather'];
    public function show_forecast(Request $request){
        $client = new Client(['base_uri' => 'https://api.weatherbit.io']);
        $api_key = env('API_KEY_WEATHER');
        $location = 'city=Barcelona&country=Spain';
        $response = $client->get('/v2.0/forecast/daily?key='.$api_key.'&'.$location);
        $forecast = json_decode($response->getBody()->getContents(), true)['data'];
        array_splice($forecast, 14);

        $sort_by = $request->query('sort_by');
        $sort_dir = 0;
        if ($sort_by !== null){
            $sort_dir = 1;
            if ($sort_by[0] === '-'){
                $sort_dir = -1;
                $sort_by = substr($sort_by, 1);
            }
            if (array_search($sort_by, $this->parameters) === false or $sort_by === 'weather'){
                $sort_by = null;
                $sort_dir = 0;
            }
        }
        if ($sort_by !== null){
            for($i = 0; $i < 14; $i++){
                for($j = 0; $j < $i; $j++){
                    if ($forecast[$i][$sort_by] < $forecast[$j][$sort_by]){
                        $tmp = $forecast[$i];
                        $forecast[$i] = $forecast[$j];
                        $forecast[$j] = $tmp;
                    }
                }
            }
            if ($sort_dir === -1){
                $forecast = array_reverse($forecast);
            }
        }
        return view('weather', ['forecast' => $forecast, 'parameters' => $this->parameters, 'sort_by' => $sort_by, 'sort_dir' => $sort_dir]);
    }
}
