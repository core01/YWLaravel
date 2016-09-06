<div class="header clearfix">
    <nav>
        <ul class="nav nav-pills pull-right">
            <li role="presentation" class="{{ Request::is('/') ? 'active' : null }}"><a href="{{ route('main') }}">Home</a></li>
            <li role="presentation" class="{{ Request::is('parseWeather') ? 'active' : null }}"><a href="{{ route('parser') }}">Parser</a></li>
            <li role="presentation" class="{{ Request::is('weather') ? 'active' : null }}"><a href="{{ route('weather') }}">Weather</a></li>
        </ul>
    </nav>
    <h3 class="text-muted">Yandex Weather Laravel</h3>
</div>