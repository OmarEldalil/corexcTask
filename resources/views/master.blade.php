<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{env('APP_NAME')}}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
</head>
<body>
<div id="app">
    <div class="loading" v-if="loading">
        <i class="fa fa-spinner fa-spin"></i>
    </div>
    @include('partials.nav-bar')
    <div class="container">
        <div class="d-flex justify-content-around">
            <div style="flex: 1">
                @include('partials.side-bar')
            </div>
            <div style="flex: 3">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@yield('body-scripts')
</body>
</html>
