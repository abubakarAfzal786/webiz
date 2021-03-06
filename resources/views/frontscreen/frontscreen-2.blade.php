<!DOCTYPE html>
<html lang="en">
<head>
    <title>Template</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">

    <link rel="stylesheet" href="{{ asset('frontscreen/css/bundle.jq.css') }}" type="text/css"/>

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="images/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="images/favicon/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="images/favicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="images/favicon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="images/favicon/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="images/favicon/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="images/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="images/favicon/favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="mstile-310x310.png" />


    <!-- open graph -->
	<meta property="og:site_name" content="Template">
     <meta property="og:url" content="http://template/" />
     <meta property="og:type" content="website" />
     <meta property="og:title" content="template" />
     <meta property="og:description" content="template" />
     <meta property="og:image" content="http://template/" />
	 <meta property="og:locale" content="ru_RU">
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous"></script>
<script src="{{ asset('js/moment-timezone.js') }}"></script>
<style>
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
     <!-- open graph -->
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
                        <p>{{ $date }}</p>
                    </div>
                </div>
            </div>
            <div class="info">
                <div class="item">
                    <div class="icon">
                        <span class="icon-sun"></span>
                    </div>
                    <div class="text">
                        <h3>{{ $temp }}??</h3>
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
            <div class="list-wrap">
                <div class="list-slider">
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
                </div>
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
                        <a href="javascript:void(0)"><i class="icon-apple"></i></a>
                        <a href="javascript:void(0)"><i class="icon-android"></i></a>
                    </p>
                </div>
                <div class="qr">
                    <img src="images/qr.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>



<script src="{{asset('js/frontscreenjq/js/libs.js')}}" defer></script>
<script src="{{asset('js/frontscreenjq/js/common.js')}}" defer></script>

</body>
</html>