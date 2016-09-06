@extends('base')
@section('title')
    Main page
@endsection
@section('content')
    <div class="row">
        <div class="alert alert-info text-center" role="alert">Yandex Weather Parser</div>
        <div class="col-md-2 col-md-offset-4">
            <a href="{{ route('parser') }}" class="btn btn-primary">Parser</a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('weather') }}" class="btn btn-success">Weather</a>
        </div>
    </div>
    <p></p>
@endsection