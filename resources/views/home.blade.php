@extends('layouts.app_new', ['toolbar_menu_items' => [
    ['name' => 'Main information', /*'href' => '/'*/],
]])

@section('content')
    <div class="data col-lg-4 col-md-6 col-sm-12">
        <div class="data-bg">
            <div class="data-title no-border">
                <div class="title">
                    <p>Office space <br>occupancy</p>
                </div>
                <div class="more-options">
                    <div class="options-btn">
                        <p><span class="icon-more"></span></p>
                    </div>
                </div>
            </div>
            <div class="data-charts">
                <div class="description">
                    <div class="status">
                        <p><span class="icon-users"></span>{{ $occupancy }}</p>
                    </div>
                    <div class="name">
                        <p>Number of people</p>
                    </div>
                </div>
                <div class="charts-wrap"></div>
            </div>

        </div>
    </div>

    <div class="data col-lg-4 col-md-6 col-sm-12">
        <div class="data-bg">
            <div class="data-title no-border">
                <div class="title">
                    <a href="{{ route('admin.transactions.index') }}"><p>Today's <br>transactions</p></a>
                </div>
                <div class="more-options">
                    <div class="options-btn">
                        <p><span class="icon-more"></span></p>
                    </div>
                </div>
            </div>
            <div class="data-charts">
                <div class="description">
                    <div class="status">
                        <p><span class="icon-pay"></span>{{ $today_transactions_count }}</p>
                    </div>
                    <div class="name">
                        <p>Number of payments</p>
                    </div>
                </div>
                <div class="charts-wrap"></div>
            </div>

        </div>
    </div>

    <div class="data col-lg-4 col-sm-12">
        <div class="data-bg">
            <div class="data-title no-border no-padding">
                <div class="title">
                    <p>New <br>Reviews</p>
                </div>
                <div class="more-options">
                    <div class="options-btn">
                        <p><span class="icon-more"></span></p>
                    </div>
                </div>
            </div>
            <div class="reviews-slider">
                <div class="swiper-container">

                    <div class="slider-control">
                        <div class="arrows">
                            <div class="arrow-icon prev-slide">
                                <span class="icon-left"></span>
                            </div>
                            <div class="arrow-icon next-slide">
                                <span class="icon-right"></span>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-wrapper">
                        @foreach($new_reviews as $review)
                            <div class="swiper-slide">
                                <div class="review-item">
                                    <div class="data-wrap">
                                        <div class="img">
                                            <img
                                                src="{{ $review->member->avatar_url ? $review->member->avatar_url : asset('images/default-user.png') }}"
                                                alt="">
                                        </div>
                                        <div class="info">
                                            <div class="name">
                                                <p>{{ $review->member->name }}</p>
                                            </div>
                                            {!! get_rating_stars_div($review->rate) !!}
                                        </div>
                                    </div>
                                    <div class="text-wrap">
                                        <p>{{ $review->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="data col-lg-4 col-md-6 col-sm-12">
        <div class="data-bg">
            <div class="data-title no-border">
                <div class="title">
                    <a href="{{ route('admin.companies.index') }}"><p>Credits that are yet to be used</p></a>
                </div>
                <div class="more-options">
                    <div class="options-btn">
                        <p><span class="icon-more"></span></p>
                    </div>
                </div>
            </div>
            <div class="data-charts">
                <div class="description">
                    <div class="status">
                        <p><span class="icon-pay"></span>{{ $current_credits }}</p>
                    </div>
                    <div class="name">
                        <p>Number of credits</p>
                    </div>
                </div>
                <div class="charts-wrap"></div>
            </div>
        </div>
    </div>

    <div class="data col-lg-4 col-md-6 col-sm-12">
        <div class="data-bg">
            <div class="data-title no-border">
                <div class="title">
                    <a href="{{ route('admin.companies.index') }}"><p>Credits that have already been used <br> this month</p></a>
                </div>
                <div class="more-options">
                    <div class="options-btn">
                        <p><span class="icon-more"></span></p>
                    </div>
                </div>
            </div>
            <div class="data-charts">
                <div class="description">
                    <div class="status">
                        <p><span class="icon-pay"></span>{{ $used_credits }}</p>
                    </div>
                    <div class="name">
                        <p>Number of credits</p>
                    </div>
                </div>
                <div class="charts-wrap"></div>
            </div>
        </div>
    </div>

    <div class="data col-lg-4 col-md-6 col-sm-12">
        <div class="data-bg">
            <div class="data-title no-border">
                <div class="title">
                    <a href="{{ route('admin.companies.index') }}"><p>Overall credits</p></a>
                </div>
                <div class="more-options">
                    <div class="options-btn">
                        <p><span class="icon-more"></span></p>
                    </div>
                </div>
            </div>
            <div class="data-charts">
                <div class="description">
                    <div class="status">
                        <p><span class="icon-pay"></span>{{ $overall_credits }}</p>
                    </div>
                    <div class="name">
                        <p>Number of credits</p>
                    </div>
                </div>
                <div class="charts-wrap"></div>
            </div>
        </div>
    </div>

    <div class="data col-lg-8 col-md-6 col-sm-12" style="display: none">
        <div class="data-bg">
            <div class="data-title">
                <div class="title">
                    <p>Today's Support Activity <span>11 New</span></p>
                </div>
                <div class="more-options">
                    <div class="options-btn">
                        <p><span class="icon-more"></span></p>
                    </div>
                </div>
            </div>
            <div class="user-activity support">
                <ul>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox <span>Ticket 1214</span></p>
                            </div>
                            <div class="text">
                                <p>Hey Erin, thanks for shopping at Clothstore! We’ve got tons of
                                    exciting
                                    deals in our upcoming Fall Collection. Stay tuned or
                                    visit to learn more.</p>
                            </div>
                        </div>
                        <div class="post-time d-md-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox <span>Ticket 1214</span></p>
                            </div>
                            <div class="text">
                                <p>Hello Elize, thanks for subscribing to USWines. We’re eager to
                                    serve
                                    you
                                    better, pls reply to this msg now with R for Red Wine, W for
                                    White,
                                    P
                                    for Rose Wine.</p>
                            </div>
                        </div>
                        <div class="post-time d-md-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox <span>Ticket 1214</span></p>
                            </div>
                            <div class="text">
                                <p>Hi Bryan, your fav messaging partner now lets you instantly
                                    engage
                                    with
                                    social media leads! Tap</p>
                            </div>
                        </div>
                        <div class="post-time d-md-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox <span>Ticket 1214</span></p>
                            </div>
                            <div class="text">
                                <p>Hey Brandon, we’ve stocked our shelves with assorted mint cookie
                                    treats
                                    for you. Visit your local KookieU store. Hurry! This flavor is
                                    for a
                                    limited time only.</p>
                            </div>
                        </div>
                        <div class="post-time d-md-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox <span>Ticket 1214</span></p>
                            </div>
                            <div class="text">
                                <p>Hey Erin, thanks for shopping at Clothstore! We’ve got tons of
                                    exciting
                                    deals in our upcoming Fall Collection. Stay tuned or
                                    visit to learn more.</p>
                            </div>
                        </div>
                        <div class="post-time d-md-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox <span>Ticket 1214</span></p>
                            </div>
                            <div class="text">
                                <p>Hello Elize, thanks for subscribing to USWines. We’re eager to
                                    serve
                                    you
                                    better, pls reply to this msg now with R for Red Wine, W for
                                    White,
                                    P
                                    for Rose Wine.</p>
                            </div>
                        </div>
                        <div class="post-time d-md-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox <span>Ticket 1214</span></p>
                            </div>
                            <div class="text">
                                <p>Hi Bryan, your fav messaging partner now lets you instantly
                                    engage
                                    with
                                    social media leads! Tap</p>
                            </div>
                        </div>
                        <div class="post-time d-md-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox <span>Ticket 1214</span></p>
                            </div>
                            <div class="text">
                                <p>Hey Brandon, we’ve stocked our shelves with assorted mint cookie
                                    treats
                                    for you. Visit your local KookieU store. Hurry! This flavor is
                                    for a
                                    limited time only.</p>
                            </div>
                        </div>
                        <div class="post-time d-md-block">
                            <p>12:23</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="data col-lg-4 col-md-6 col-sm-12" style="display: none">
        <div class="data-bg">
            <div class="data-title">
                <div class="title">
                    <p>Today's Users Activity</p>
                </div>
                <div class="more-options">
                    <div class="options-btn">
                        <p><span class="icon-more"></span></p>
                    </div>
                </div>
            </div>
            <div class="user-activity today">
                <ul>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox</p>
                            </div>
                            <div class="action">
                                <p>Change Password</p>
                            </div>
                        </div>
                        <div class="post-time d-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox</p>
                            </div>
                            <div class="action">
                                <p>Change Password</p>
                            </div>
                        </div>
                        <div class="post-time d-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox</p>
                            </div>
                            <div class="action">
                                <p>Change Password</p>
                            </div>
                        </div>
                        <div class="post-time d-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox</p>
                            </div>
                            <div class="action">
                                <p>Change Password</p>
                            </div>
                        </div>
                        <div class="post-time d-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox</p>
                            </div>
                            <div class="action">
                                <p>Change Password</p>
                            </div>
                        </div>
                        <div class="post-time d-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox</p>
                            </div>
                            <div class="action">
                                <p>Change Password</p>
                            </div>
                        </div>
                        <div class="post-time d-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox</p>
                            </div>
                            <div class="action">
                                <p>Change Password</p>
                            </div>
                        </div>
                        <div class="post-time d-block">
                            <p>12:23</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img src="images/user.jpg" alt="">
                        </div>
                        <div class="data-wrap">
                            <div class="title">
                                <p>Robert Fox</p>
                            </div>
                            <div class="action">
                                <p>Change Password</p>
                            </div>
                        </div>
                        <div class="post-time d-block">
                            <p>12:23</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
