<?php

    namespace App\Http\Controllers;

    use App\fact;
    use App\forecast;
    use Illuminate\Http\Request;

    use App\Http\Requests;
    use Illuminate\Support\Facades\DB;

    class YandexWeather extends Controller
    {
        //
        public function parseWeather()
        {
            $timestamp = time();
            $token = md5('eternalsun'.$timestamp);

            $uuid = "8211637137c4408898aceb1097921872";
            $deviceid = "315f0e802b0b49eb8404ea8056abeaaf";

            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "User-Agent: yandex-weather-android/4.2.1\n".
                        "X-Yandex-Weather-Client: YandexWeatherAndroid/4.2.1\n".
                        "X-Yandex-Weather-Device: os=null;os_version=21;manufacturer=chromium;model=App Runtime for Chrome Dev;device_id=$deviceid;uuid=$uuid;\n".
                        "X-Yandex-Weather-Token: $token\n".
                        "X-Yandex-Weather-Timestamp: $timestamp\n".
                        "X-Yandex-Weather-UUID: $uuid\n".
                        "X-Yandex-Weather-Device-ID: $deviceid\n".
                        "Accept-Encoding: gzip, deflate\n".
                        "Host: api.weather.yandex.ru\n".
                        "Connection: Keep-Alive",
                ),
            );

            $context = stream_context_create($opts);
            $file = file_get_contents('https://api.weather.yandex.ru/v1/forecast?geoid=213&locality=ru', false,
                $context);
            $resultsjson = gzdecode($file);
            $results = json_decode($resultsjson, true);
            $time = $results['now'];
            $cityId = $results['geo_object']['locality']['id'];
            $name = $results['geo_object']['locality']['name'];
            $country = $results['geo_object']['country']['name'];

            $factData = $results['fact'];

            if (!$fact = fact::where([
                'city_id' => $cityId,
                'country' => $country,
            ])->first()
            ) {
                $fact = new fact();
                $fact->city_id = $cityId;
                $fact->name = $name;
                $fact->country = $country;
            }
            $fact->time = $time;
            $fact->condition = $factData['condition'];
            $fact->wind_speed = $factData['wind_speed'];
            $fact->wind_gust = $factData['wind_gust'];
            $fact->wind_dir = $factData['wind_dir'];
            $fact->temp = $factData['temp'];
            $fact->feels_like = $factData['feels_like'];

            $fact->pressure_mm = $factData['pressure_mm'];
            $fact->pressure_pa = $factData['pressure_pa'];
            $fact->humidity = $factData['humidity'];
            $fact->daytime = $factData['daytime'];

            $fact->save();

            $forecasts = [];


            foreach ($results['forecasts'] as $forecast) {
                $f = [];
                $date = $forecast['date'];
                foreach ($forecast['parts'] as $key => $value) {

                    if (in_array($key, array('night', 'day', 'evening', 'morning'))) {
                        $f[$key] = $value;
                        $f[$key]['city_id'] = $cityId;
                        $f[$key]['date'] = $date;
                        $f[$key]['part'] = $key;
                    }
                }
                $forecasts[] = $f;
            }

            foreach ($forecasts as $arr) {
                foreach ($arr as $forecast) {
                    if (!$fc = forecast::where([
                        'city_id' => $forecast['city_id'],
                        'date'    => strtotime($forecast['date']),
                        'part'    => $forecast['part'],
                    ])->first()
                    ) {
                        $fc = new forecast();
                        $fc->city_id = $forecast['city_id'];
                        $fc->date = strtotime($forecast['date']);
                        $fc->part = $forecast['part'];
                    }
                    $fc->temp_min = $forecast['temp_min'];
                    $fc->temp_max = $forecast['temp_max'];
                    $fc->temp_avg = $forecast['temp_avg'];
                    $fc->feels_like = $forecast['feels_like'];
                    $fc->condition = $forecast['condition'];
                    $fc->daytime = $forecast['daytime'];
                    $fc->wind_speed = $forecast['wind_speed'];
                    $fc->wind_gust = $forecast['wind_gust'];
                    $fc->wind_dir = $forecast['wind_dir'];
                    $fc->pressure_mm = $forecast['pressure_mm'];
                    $fc->pressure_pa = $forecast['pressure_pa'];
                    $fc->humidity = $forecast['humidity'];

                    $fc->save();
                }
            }
            /* Код ниже менее производителен, но выглядит наглядно */

            /*
                if(!forecast::where([
                    'city_id' => $cityId,
                    'date' => strtotime($forecast['date']),
                    'part' => $forecast['part'],
                    'temp_min'    => $forecast['temp_min'],
                    'temp_max'    => $forecast['temp_max'],
                    'temp_avg'    => $forecast['temp_avg'],
                    'feels_like'  => $forecast['feels_like'],
                    'condition'   => $forecast['condition'],
                    'daytime'     => $forecast['daytime'],
                    'wind_speed'  => $forecast['wind_speed'],
                    'wind_gust'   => $forecast['wind_gust'],
                    'wind_dir'    => $forecast['wind_dir'],
                    'pressure_mm' => $forecast['pressure_mm'],
                    'pressure_pa' => $forecast['pressure_pa'],
                    'humidity'    => $forecast['humidity'],
                ])->first()){
                    forecast::updateOrCreate(array('city_id' => $cityId, 'date' => strtotime($forecast['date'])), $fc);
                }
             */

            return view('parser');
        }

        public function getWeather()
        {
            $date = strtotime(date("Y.m.d"));
            $dateEnd = strtotime('+7 days');
            $fact = DB::table('facts')->first();
            //orderBy('created_at', 'desc')->get();
            $forecasts = forecast::where(
                [
                    ['date', '>=', $date],
                    ['date', '<', $dateEnd],
                ])->orderBy('date', 'asc')->get();
            $output = [];
            foreach ($forecasts as $forecast) {
                $date = $forecast->date;
                $output[$date]['date'] = $date;
                $part = '';
                switch ($forecast->part) {
                    case 'night':
                        $part = 'Ночь';
                        break;
                    case 'day':
                        $part = 'День';
                        break;
                    case 'evening':
                        $part = 'Вечер';
                        break;
                    case 'morning':
                        $part = 'Утро';
                        break;
                }
                $output[$date][$forecast->part] = [
                    'temp_min'    => $forecast->temp_min,
                    'temp_max'    => $forecast->temp_max,
                    'pressure_mm' => $forecast->pressure_mm,
                    'humidity'    => $forecast->humidity,
                    'wind_speed'  => $forecast->wind_speed,
                    'part'        => $part,
                ];
            }

            return view('weather', ['fact' => $fact, 'forecasts' => $output]);
        }
    }
