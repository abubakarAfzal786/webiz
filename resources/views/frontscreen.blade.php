<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name', 'WeBiz') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">

    <link rel="stylesheet" href="{{ asset('frontscreen/css/bundle.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('frontscreen/css/custom.css') }}" type="text/css"/>

    <link rel="apple-touch-icon-precomposed" sizes="57x57"
          href="{{ asset('frontscreen/images/favicon/apple-touch-icon-57x57.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="{{ asset('frontscreen/images/favicon/apple-touch-icon-114x114.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="{{ asset('frontscreen/images/favicon/apple-touch-icon-72x72.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{ asset('frontscreen/images/favicon/apple-touch-icon-144x144.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="60x60"
          href="{{ asset('frontscreen/images/favicon/apple-touch-icon-60x60.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="120x120"
          href="{{ asset('frontscreen/images/favicon/apple-touch-icon-120x120.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="76x76"
          href="{{ asset('frontscreen/images/favicon/apple-touch-icon-76x76.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="152x152"
          href="{{ asset('frontscreen/images/favicon/apple-touch-icon-152x152.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('frontscreen/images/favicon/favicon-196x196.png') }}"
          sizes="196x196"/>
    <link rel="icon" type="image/png" href="{{ asset('frontscreen/images/favicon/favicon-96x96.png') }}" sizes="96x96"/>
    <link rel="icon" type="image/png" href="{{ asset('frontscreen/images/favicon/favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ asset('frontscreen/images/favicon/favicon-16x16.png') }}" sizes="16x16"/>
    <link rel="icon" type="image/png" href="{{ asset('frontscreen/images/favicon/favicon-128.png') }}" sizes="128x128"/>
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#FFFFFF"/>
    <meta name="msapplication-TileImage" content="mstile-144x144.png"/>
    <meta name="msapplication-square70x70logo" content="mstile-70x70.png"/>
    <meta name="msapplication-square150x150logo" content="mstile-150x150.png"/>
    <meta name="msapplication-wide310x150logo" content="mstile-310x150.png"/>
    <meta name="msapplication-square310x310logo" content="mstile-310x310.png"/>

    <!-- open graph -->
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ config('app.url') }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
    <meta property="og:image" content="{{ asset('images/logo.png') }}"/>
    <meta property="og:locale" content="he">
    <!-- open graph -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous"></script>
</head>
<body>

<div class="page-wrap">
    <div class="container">
        <div class="intro">
            <div class="logo">
                <img src="{{ asset('frontscreen/images/logo_high.png') }}" alt="">
            </div>
            <div class="info">
                <div class="item">
                    <div class="icon">
                        <span class="icon-calendar"></span>
                    </div>
                    <div class="text">
                        <h3 id="time">{{ $time }}</h3>
                        <p id="date">{{ $date }}</p>
                    </div>
                </div>
                <div class="item">
                    <div class="icon">
                        <span class="icon-sun"></span>
                    </div>
                    <div class="text">
                        <h3><span id="temp">{{ $temp }}</span>°</h3>
                        <p>Tel Aviv, Tel Aviv District, Israel</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="company-list">
            <div class="title">
                <h1>Company list</h1>
            </div>
            @if($bookings->count())
                <div class="list-wrap">
                    <ul>
                        @foreach($bookings as $key => $booking)
                            <li>
                                <div class="data">
                                    <div class="counter">{{ $booking->room->number }}</div>
                                    <div class="name">
                                        <p>{{ $booking->member->company ? $booking->member->company->name : $booking->member->name }}</p>
                                    </div>
                                </div>

                                <div class="logo">
                                    <img src="{{ $booking->logo ? $booking->logo->url : $booking->member->company->first_logo_url }}" alt="">
                                </div>
                            </li>
                        @endforeach
                        @foreach($rooms as $room)
                            <li>
                                <div class="data">
                                    <div class="counter">{{ $room->number }}</div>
                                    <div class="name">
                                        <p>{{ $room->company ? $room->company->name : $room->name }}</p>
                                    </div>
                                </div>
                                <div class="logo">
                                    <img src="{{ $room->company->logo ? $room->company->logo_url : $room->company->first_logo_url }}" alt="">
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="contacts">
            <div class="item">
                <div class="icon">
                    <span class="icon-phone"></span>
                </div>
                <div class="text">
                    <p>You have questions?</p>
                    <a href="tel:073-3856888">073-3856888</a>
                </div>
            </div>
            <div class="item">
                <div class="icon">
                    <span class="icon-mobile"></span>
                </div>
                <div class="text">
                    <p><span>Download our app:</span>
                        <a href="https://apps.apple.com/us/app/webiz/id1491648662" target="_blank"><i class="icon-apple"></i></a>
                        <a href="https://play.google.com/store/apps/details?id=com.cyberfuze.webiz" target="_blank"><i class="icon-android"></i></a>
                    </p>
                </div>
                <div class="qr">
                    <img src="{{ asset('frontscreen/images/webiz-qr.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $('#time').html(moment().format('HH:mm'));--}}
{{--        $('#date').html(moment().format('ddd, DD MMM YYYY').toUpperCase());--}}

{{--        let api_key = '{{ config("other.openweather_api") }}';--}}
{{--        let settings = {--}}
{{--            "async": true,--}}
{{--            "crossDomain": true,--}}
{{--            "url": "https://api.openweathermap.org/data/2.5/weather?units=metric&id=293397&appid=" + api_key,--}}
{{--            "method": "GET",--}}
{{--        }--}}

{{--        $.ajax(settings).done(function (response) {--}}
{{--            if (response.main.temp) $('#temp').html(parseInt(response.main.temp));--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
</body>
</html>
