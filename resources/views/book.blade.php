<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name', 'WeBiz') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">

    <link rel="stylesheet" href="{{ asset('book/css/bundle.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('book/css/custom.css') }}" type="text/css"/>

    <!-- open graph -->
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ config('app.url') }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
    <meta property="og:image" content="{{ asset('images/logo.png') }}"/>
    <meta property="og:locale" content="he">
    <!-- open graph -->
</head>
<body>

<div class="container">
    <div class="info-section">
        <div class="title">
            <span class="icon-info"></span>
            <h1>Invitation information</h1>
        </div>
        <div class="info-list">
            <ul>
                <li>
                    <div class="icon">
                        <span class="icon-payment"></span>
                    </div>
                    <div class="data">
                        <h2>Date</h2>
                        <p>{{ $booking->start_date->format('d.m.Y') }}</p>
                        @if($booking->start_date->format('d.m.Y') != $booking->end_date->format('d.m.Y'))
                            -<p> {{ $booking->end_date->format('d.m.Y') }}</p>
                        @endif
                    </div>
                </li>
                <li>
                    <div class="icon">
                        <span class="icon-time"></span>
                    </div>
                    <div class="data">
                        <h2>Time</h2>
                        <p>{{ $booking->start_date->format('H:i') }} - {{ $booking->end_date->format('H:i') }}</p>
                    </div>
                </li>
                <li>
                    <div class="icon">
                        <span class="icon-location"></span>
                    </div>
                    <div class="data">
                        <h2>Address</h2>
                    </div>
                    <div class="location">
                        <p>{{ $booking->room->location }}</p>
                    </div>
                </li>
            </ul>
            <div class="btn-wrap">
                <a class="main-btn" href="{{ $geo_href }}" target="_blank" style="">Open in map</a>
            </div>
        </div>
        <div class="logo-wrap">
            <a href="javascript:void(0)"><img src="{{ asset('book/images/logo.png') }}" alt=""></a>
        </div>
    </div>
    <div class="add-btn">
        <button class="main-btn" type="button">+ Add to Calendar</button>
    </div>
</div>
</body>
</html>
