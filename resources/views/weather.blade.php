@extends('base')
@section('title')
    Weather
@endsection
@section('content')

    <div class="alert alert-success text-center" role="alert">
        <p>Прогноз на {{ date('d.m.Y', $fact->time) }}</p>
        <p>{{ $fact->name }}, {{ $fact->country }}</p>
    </div>
    <table class="table table-bordered table-hover text-center">
        <thead>
        <th>
            Сейчас
        </th>
        <th>
            Температура
        </th>
        <th>
            Скорость ветра
        </th>
        <th>
            Давление
        </th>
        <th>
            Влажность
        </th>
        </thead>

    <tbody>
    <tr>
        <td>
            @if($fact->daytime == 'n')
                Ночь
            @elseif($fact->daytime == 'd')
                День
            @elseif($fact->daytime == 'm')
                Утро
            @else
                Вечер
            @endif
        </td>
        <td>
            {{ $fact->temp }}
        </td>
        <td>
            {{ $fact->wind_speed }}
        </td>
        <td>
            {{ $fact->pressure_mm }}
        </td>
        <td>
            {{ $fact->humidity }}
        </td>

    </tr>
    </tbody>
    </table>
    <div class="alert alert-warning text-center" role="alert">
       Недельный прогноз
    </div>
    <div class="row">
        @foreach($forecasts as $forecast)
            <div class="col-md-3">
                <div class="alert alert-info text-center" role="alert">
                {{ date('d.m.Y', $forecast['date']) }}
                    </div>
            </div>
            <div class="col-md-9">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                    <tr>
                        <th>
                            Половина дня
                        </th>
                        <th>
                            Температура
                        </th>
                        <th>
                            Давление
                        </th>
                        <th>
                            Влажность
                        </th>
                        <th>
                            Ветер
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td> {{ $forecast['morning']['part'] }}</td>
                        <td> {{ $forecast['morning']['temp_min'] }} ... {{ $forecast['morning']['temp_max'] }} C</td>
                        <td>
                            {{ $forecast['morning']['pressure_mm'] }}
                        </td>
                        <td>
                            {{ $forecast['morning']['humidity'] }}
                        </td>
                        <td>
                            {{ $forecast['morning']['wind_speed'] }}
                        </td>
                    </tr>
                    <tr>
                        <td> {{ $forecast['day']['part'] }}</td>
                        <td> {{ $forecast['day']['temp_min'] }} ... {{ $forecast['day']['temp_max'] }} C</td>
                        <td>
                            {{ $forecast['day']['pressure_mm'] }}
                        </td>
                        <td>
                            {{ $forecast['day']['humidity'] }}
                        </td>
                        <td>
                            {{ $forecast['day']['wind_speed'] }}
                        </td>
                    </tr>
                    <tr>
                        <td> {{ $forecast['evening']['part'] }}</td>
                        <td> {{ $forecast['evening']['temp_min'] }} ... {{ $forecast['evening']['temp_max'] }} C</td>
                        <td>
                            {{ $forecast['evening']['pressure_mm'] }}
                        </td>
                        <td>
                            {{ $forecast['evening']['humidity'] }}
                        </td>
                        <td>
                            {{ $forecast['evening']['wind_speed'] }}
                        </td>
                    </tr>
                    <tr>
                        <td> {{ $forecast['night']['part'] }}</td>
                        <td> {{ $forecast['night']['temp_min'] }} ... {{ $forecast['night']['temp_max'] }} C</td>
                        <td>
                            {{ $forecast['night']['pressure_mm'] }}
                        </td>
                        <td>
                            {{ $forecast['night']['humidity'] }}
                        </td>
                        <td>
                            {{ $forecast['night']['wind_speed'] }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>


@endsection