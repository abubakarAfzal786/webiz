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
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@1&display=swap" rel="stylesheet">


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
    <script src="{{ asset('js/moment-timezone.js') }}"></script>

    <style type="text/css">
      .company-card {
        float: left;
        display: block;
        width: 490px;
        height: 271px !important;
        margin-left: 15px;
        margin-top: 15px;
      }

      .company-card img { border-radius: 10px }

      .swiper-wrapper-2 { height: 1445px; overflow: hidden }

      .swiper-slide { height: 270px !important; }

      .name { font-weight: bold; overflow: auto !important }

      .no-logo {
        disply: block;
        height: 100%;
        padding-top:50px;
        font-family: 'Open Sans';
      }
      .no-logo .logo {
        display: none;
      }

      .no-logo .name {
        height: 100%;
        max-height: 100%;
      }

      .no-logo .name > p {
        font-size: 40px !important;
      }
    </style>
    <script>
    setInterval(function () {
        $('#time').html(moment().utc().tz('Asia/Jerusalem').format('HH:mm'));
    }, 1000);
    </script>
</head>
<body>

<div class="page-wrap">
    <div class="container">
        <div class="intro">
            <div class="logo">
                <span><img src="images/logo.png" alt=""></span>
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
            </div>
            <div class="info">
                <div class="item">
                    <div class="icon">
                        <span class="icon-sun"></span>
                    </div>
                    <div class="text">
                        <h3><span id="temp">{{ $temp }}</span>°</h3>
                        <p>Tel Aviv District, Israel</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="company-list">
            <div class="title">
                <h1>Company list</h1>
            </div>
            @if($bookings->count() || $rooms->count())
            <div class="list-wrap" style="counter-reset: none">
                <div class="swiper-container-">
                    <div class="swiper-wrapper-2">
                        @foreach($bookings as $key => $booking)
                          <div class="company-card">
                              <div class="office">
                                  <p>Office: <b>{{ $booking->room->number }}</b></p>
                              </div>
                              <div class="data {{!$booking->logo && !$booking->member->company->first_logo_url ? 'no-logo' : ''}}">
                                  <div class="logo">
                                      <img src="{{ $booking->logo ? $booking->logo->url : $booking->member->company->first_logo_url }}" alt="">
                                  </div>
                                  <div class="name">
                                      <p>{{ $booking->member->company ? $booking->member->company->name : $booking->member->name }}</p>
                                  </div>
                              </div>
                          </div>
                        @endforeach
                        @foreach($rooms as $room)
                          <div class="company-card">
                              <div class="office">
                                  <p>Office: <b>{{ $room->number }}</b></p>
                              </div>
                              <div class="data">
                                  <div class="logo">
                                      <img src="{{ $room->company->logo ? $room->company->logo_url : $room->company->first_logo_url }}" alt="">
                                  </div>
                                  <div class="name">
                                      <p>{{ $room->company ? $room->company->name : $room->name }}</p>
                                  </div>
                              </div>
                          </div>
                        @endforeach
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>
            @endif
            @if($coming->count())
            <div class="list-wrap" style="counter-reset: none">
                <div class="swiper-container-">
                    <div class="swiper-wrapper-2">
                        @foreach($coming as $key => $booking)
                          <div class="company-card">
                              <div class="office">
                                  <p>Office: <b>{{ $booking->room->number }}</b></p>
                              </div>
                              <div class="data {{!$booking->logo && !$booking->member->company->first_logo_url ? 'no-logo' : ''}}">
                                  <div class="logo">
                                      <img src="{{ $booking->logo ? $booking->logo->url : $booking->member->company->first_logo_url }}" alt="">
                                  </div>
                                  <div class="name">
                                      <p>{{ $booking->member->company ? $booking->member->company->name : $booking->member->name }}</p>
                                  </div>
                              </div>
                          </div>
                        @endforeach
                    </div>
                </div>
                <div style="clear: both"></div>
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
                        <a href="https://apps.apple.com/us/app/webiz/id1491648662" target="_blank"><i
                                class="icon-apple"></i></a>
                        <a href="https://play.google.com/store/apps/details?id=com.cyberfuze.webiz" target="_blank"><i
                                class="icon-android"></i></a>
                    </p>
                </div>
                <div class="qr2" style="margin-left: 30px;">
                    <img src="https://www.onelink.to/gmarb6.png?rnd=779625465" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('frontscreen/js/libs.js')}}" defer></script>
<!--<script src="{{asset('js/frontscreen.js')}}" defer></script>-->
<script>
    $(document).ready(function () {
        {{--let api_key = '{{ config("other.openweather_api") }}';--}}
        {{--let settings = {--}}
        {{--    "async": true,--}}
        {{--    "crossDomain": true,--}}
        {{--    "url": "https://api.openweathermap.org/data/2.5/weather?units=metric&id=293397&appid=" + api_key,--}}
        {{--    "method": "GET",--}}
        {{--}--}}
        {{--$.ajax(settings).done(function (response) {--}}
        {{--    if (response.main.temp) $('#temp').html(parseInt(response.main.temp));--}}
        {{--});--}}
    });
</script>
</body>
</html>
