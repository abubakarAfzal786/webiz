<!DOCTYPE html>  
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    @stack('header-pre-scripts')
    <link rel="stylesheet" href="{{ asset('css/bundle_2.css') }}" type="text/css"/>
    @stack('header-post-scripts')

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/>



    <link rel="apple-touch-icon-precomposed" sizes="57x57"
          href="{{ asset('images/favicon/apple-touch-icon-57x57.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="{{ asset('images/favicon/apple-touch-icon-114x114.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="{{ asset('images/favicon/apple-touch-icon-72x72.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{ asset('images/favicon/apple-touch-icon-144x144.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="60x60"
          href="{{ asset('images/favicon/apple-touch-icon-60x60.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="120x120"
          href="{{ asset('images/favicon/apple-touch-icon-120x120.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="76x76"
          href="{{ asset('images/favicon/apple-touch-icon-76x76.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="152x152"
          href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-196x196.png') }}" sizes="196x196"/>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-96x96.png') }}" sizes="96x96"/>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-16x16.png') }}" sizes="16x16"/>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-128.png') }}" sizes="128x128"/>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
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
	<style>
input[type="date"]::-webkit-calendar-picker-indicator {
    background: none;
}
.office-slider .arrow-icon.prev-slide{

    position: absolute;
    top: 55px;
}
.office-slider .arrow-icon.next-slide{
       
    position: absolute;
    top: 55px;
}.slot.hold {
    background-color: #EABD37;
     color: white;
}.slot.active {
    background-color: #0A8FEF;
    color: white;
    /* height: 60px; */
}
	</style>
    <!-- open graph -->
</head>

<body>
    @include('partials.header')

    <div class="page-toolbar">
        <div class="container">
            <div class="flex wrap aCenter jBetween">
                <div class="title col-lg-2 d-lg-block">
                    <h1><i class="icon-dashboard"></i>WeBiz Office Dashboard</h1>
                </div>
                <div class="col-lg-10 col-md-12">
                    <div class="toolbar-menu">
                        <div class="main-data">
                            <div class="open-menu d-lg-none">
                                <button type="button"><i class="icon-dashboard"></i></button>
                            </div>
                            <div class="touch-scroll">
                                <div class="scroll-wrap">
                                    <ul>
                                        <li class="active"><a href="javascript:void(0)">Meeting Rooms Today</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="toolbar-options">
                            <!-- <div class="item">
                                <label class="select-field">
                                    <span class="name">Filters:</span>
                                    <select>
                                        <option>All statuses</option>
                                        <option>All statuses</option>
                                        <option>All statuses</option>
                                    </select>
                                </label>
                            </div>
                            <div class="item">
                                <label class="select-field">
                                    <select>
                                        <option>All offices</option>
                                        <option>All offices</option>
                                        <option>All offices</option>
                                    </select>
                                </label>
                            </div> --> 
                            <div class="item">
                                <label class="select-date">
                                    <input style="max-width: 181px;" id="date_selector" value="{{$search_date}}" type="date" placeholder="Select date">
                                    <span class="icon-calendar"></span>
                                </label>
                            </div>
                            <div class="item left-border">
                                <a href="#" id="filter_btn"><button type="button" class="main-btn yellow-blank"> Filter</button></a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-menu">
        <div class="container">
            <div class="flex wrap">
				@include('partials.side-menu')

                <div class="content-wrap col-lg-10 col-sm-11">

                    <div class="row">
                        <div class="col-1" style="max-width: 4.333333%; margin-top: 235px;">
                              <div class="">
                                                      
                               <div class="slot d-none">09:30</div>
                               <div class="slot">10:00</div>
                              
                               <div class="slot">11:00</div>
                             
                               <div class="slot">12:00</div>
                              
                               <div class="slot">13:00</div>
                              
                               <div class="slot">14:00</div>
                             
                               <div class="slot">15:00</div>
                             
                               <div class="slot">16:00</div>
                             
                               <div class="slot">17:00</div>
                             
                               <div class="slot">18:00</div>
                                <div class="slot">19:00</div>
                                 <div class="slot">20:00</div>
                                  <div class="slot">21:00</div>
                                   <div class="slot">22:00</div>
                                    <div class="slot">23:00</div>
                                    

                           </div>
                        </div>
                        <div class="data col-11">
                            <div class="a">
                                <div class="color-indicator">
                                    <div class="touch-scroll">
                                        <div class="scroll-wrap">
                                            <ul>
                                                <li>
                                                    <p><span style="background-color: #FF5260"></span>End</p>
                                                </li>
                                                <li>
                                                    <p><span style="background-color: #EABD37"></span>Hold</p>
                                                </li>
                                                <li>
                                                    <p><span style="background-color: #0A8FEF"></span>Active</p>
                                                </li>
                                                <li>
                                                    <p><span style="background-color: #BB6BD9"></span>Not paid</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="office-slider">
                                    <div class="arrow-icon next-slide"><span class="icon-right"></span></div>
                                    <div class="arrow-icon prev-slide"><span class="icon-left"></span></div>
                                    <!-- Slider main container -->
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">

                                @if(isset($rooms))
                                    @foreach($rooms as $key => $room)
                                    @php

                                        $bookings = \App\Models\Booking::where('room_id',$room->id)->whereDate('start_date','=',$search_date)->get();

                                        
                                        $booking_array = [];
                                        $booking_end = [];
                                        $last_block = null;
                                        $last_text = null;
                                        $member_name = null;

                                       
                                        foreach($bookings as $key=>$book){

                                            $member_name = $book->member->name;
                                            $booking_array = [];
                                            $booking_end = [];
                                            $last_block = null;
                                            $last_text = null;

                                            $multiplier = 1;
                                            $status = $book->status;
                                            if($status == 20){
                                                $multiplier = 20;
                                            }elseif($status == 30){
                                                $multiplier = 30;
                                            }
                                            elseif($status == 40){
                                                $multiplier = 40;
                                            }


                                            

                                             $start_date = \Carbon\Carbon::parse($book->start_date)->format('H') * $multiplier;
                                           
                                            
                                            $end_date = \Carbon\Carbon::parse($book->end_date)->format('H') * $multiplier;
                                                    
                                            $last_block = $end_date * $multiplier;
                                            $last_text = $start_date/$multiplier . ':00 - ' .$end_date/$multiplier . ':00';

                                            if($end_date != $start_date){
                                                while($end_date != $start_date){
                                                    array_push($booking_end,$end_date);
                                                    $end_date = $end_date - $multiplier;
                                                }
                                                 array_push($booking_end,$start_date);
                                            }                                            
                                           
                                        }

                                      
                                    @endphp
                                            <div class="swiper-slide">
                                                <div class="office-card">
                                                    <div class="img">
                                                        <span><img src="{{asset('images/office-slider/'.$room->image)}}" alt=""></span>
                                                    </div>
                                                <div class="">
                                                        <h3>{{$room->name}}</h3>

                                                      
                                                        <p><i class='bx bxs-user'></i>{{$room->seats}}</p>
                                                    <div class="slot pl-2 @if(in_array('10', $booking_end)) end @endif @if(in_array('200', $booking_end)) hold @endif @if(in_array('300', $booking_end)) active @endif " >@if($last_block == '10') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '200')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>
                                                   
                                                    <div class="slot pl-2 @if(in_array('11', $booking_end)) end @endif @if(in_array('220', $booking_end)) hold @endif @if(in_array('330', $booking_end)) active @endif">@if($last_block == '11') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '220')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>
                                                   
                                                    <div class="slot pl-2  @if(in_array('12', $booking_end)) end @endif @if(in_array('240', $booking_end)) hold @endif @if(in_array('360', $booking_end)) active @endif">@if($last_block == '12') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '240')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>
                                                  
                                                    <div class="slot pl-2  @if(in_array('13', $booking_end)) end @endif @if(in_array('260', $booking_end)) hold @endif @if(in_array('390', $booking_end)) active @endif">@if($last_block == '13') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '260')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>
                                                  
                                                    <div class="slot pl-2  @if(in_array('14', $booking_end)) end @endif @if(in_array('280', $booking_end)) hold @endif @if(in_array('420', $booking_end)) active @endif">@if($last_block == '14') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '280')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>
                                                   
                                                    <div class="slot pl-2 @if(in_array('15', $booking_end)) end @endif @if(in_array('300', $booking_end)) hold @endif @if(in_array('450', $booking_end)) active @endif">@if($last_block == '15') <i class='bx bxs-user'></i> {{$member_name}} <br> 
                                                        <i class='bx bx-time-five'></i> {{$last_text}}  @elseif($last_block == '300')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>@endif</div>
                                                   
                                                    <div class="slot pl-2 @if(in_array('16', $booking_end)) end @endif @if(in_array('320', $booking_end)) hold @endif @if(in_array('480', $booking_end)) active @endif">@if($last_block == '16') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '320')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>
                                                   
                                                    <div class="slot pl-2 @if(in_array('17', $booking_end)) end @endif @if(in_array('320', $booking_end)) hold @endif @if(in_array('480', $booking_end)) active @endif">@if($last_block == '17') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '340')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>

                                                    <div class="slot pl-2 @if(in_array('18', $booking_end)) end @endif @if(in_array('320', $booking_end)) hold @endif @if(in_array('480', $booking_end)) active @endif">@if($last_block == '18') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '360')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>

                                                    <div class="slot pl-2 @if(in_array('19', $booking_end)) end @endif @if(in_array('320', $booking_end)) hold @endif @if(in_array('480', $booking_end)) active @endif">@if($last_block == '19') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '380')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>

                                                    <div class="slot pl-2 @if(in_array('20', $booking_end)) end @endif @if(in_array('320', $booking_end)) hold @endif @if(in_array('480', $booking_end)) active @endif">@if($last_block == '20') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '400')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>

                                                    <div class="slot pl-2 @if(in_array('21', $booking_end)) end @endif @if(in_array('320', $booking_end)) hold @endif @if(in_array('480', $booking_end)) active @endif">@if($last_block == '21') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '420')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>

                                                    <div class="slot pl-2 @if(in_array('22', $booking_end)) end @endif @if(in_array('320', $booking_end)) hold @endif @if(in_array('480', $booking_end)) active @endif">@if($last_block == '22') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '440')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>

                                                    <div class="slot pl-2 @if(in_array('23', $booking_end)) end @endif @if(in_array('320', $booking_end)) hold @endif @if(in_array('480', $booking_end)) active @endif">@if($last_block == '23') <i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i>{{$last_text}} @elseif($last_block == '460')<i class='bx bxs-user'></i> {{$member_name}} <br> <i class='bx bx-time-five'></i> @endif</div>
                                                </div>
                                                </div>
                                            </div>



                                            @endforeach
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modals-section">

        <!--

    to call the modal use $.fancybox.open({src: "#mydiv"});

    to close the modal use $.fancybox.close(); or $.fancybox.close({src: "#mydiv"});

    add to a button "data-fancybox data-src='#mydiv'" to call a modal

    add to a button "data-fancybox-close" to close a modal


    to indicate error in .add-new .item label add class 'error'

    -->

        <div class="modal-wrap" id="test">
            <div class="go-back" data-fancybox-close>
                <button type="button"><i class="icon-back"></i>Back to Support Chat</button>
            </div>
            <div class="content">
                <div class="data">
                    <div class="scroll-wrap">
                        <div class="modal-title">
                            <p>New ticket <span>Ticket 1444</span></p>
                        </div>
                        <div class="data-content">

                            <div class="add-new">
                                <div class="item">
                                    <label class="text-option">
                                        <span class="label-wrap">
                                            <input type="text" value="Lena Hawkins" class="placeholder-effect">
                                            <span class="placeholder">User name</span>
                                        </span>
                                    </label>
                                    <div class="ticket-result">
                                        <ul>
                                            <li>
                                                <div class="member-data">
                                                    <div class="member-img">
                                                        <img src="{{asset('images/user.jpg')}}" alt="">
                                                    </div>
                                                    <div class="text">
                                                        <div class="name">
                                                            <p>Lena Hawkins</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="member-data">
                                                    <div class="member-img">
                                                        <img src="{{asset('images/user.jpg')}}" alt="">
                                                    </div>
                                                    <div class="text">
                                                        <div class="name">
                                                            <p>Lena Hawkins</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="member-data">
                                                    <div class="member-img">
                                                        <img src="{{asset('images/user.jpg')}}" alt="">
                                                    </div>
                                                    <div class="text">
                                                        <div class="name">
                                                            <p>Lena Hawkins</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="item">
                                    <label class="text-option">
                                        <span class="label-wrap">
                                            <textarea
                                                class="placeholder-effect">Hey Erin, thanks for shopping at Clothstore! We’ve got tons of exciting deals in our upcoming Fall Collection. Stay tuned or visit  to learn more.</textarea>
                                            <span class="placeholder">Answer</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="item">
                                    <label class="text-option">
                                        <span class="label-wrap">
                                            <span class="select">
                                                <select class="placeholder-effect">
                                                    <option disabled selected hidden> </option>
                                                    <option>BILLING</option>
                                                    <option>BILLING</option>
                                                    <option>BILLING</option>
                                                    <option>BILLING</option>
                                                </select>
                                                <span class="placeholder">Category</span>
                                            </span>
                                        </span>
                                    </label>
                                    <button class="main-btn yellow-blank">Add new category</button>
                                </div>
                                <div class="item offset-md-6">
                                    <label class="text-option">
                                        <span class="label-wrap">
                                            <input type="number" value="0" class="placeholder-effect">
                                            <span class="placeholder">Starting balance</span>
                                        </span>
                                        <span class="measure">credits</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="modal-title with-border">
                            <p>Review</p>
                        </div>
                        <div class="data-content">
                            <div class="add-review">
                                <ul>
                                    <li>
                                        <div class="review-data">
                                            <div class="member-data">
                                                <div class="member-img">
                                                    <img src="images/user.jpg" alt="">
                                                </div>
                                                <div class="text">
                                                    <div class="name">
                                                        <p>Lena Hawkins</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="set-rating">
                                                <p><span class="icon-empty" data-rate="5"></span>
                                                    <span class="icon-empty" data-rate="4"></span>
                                                    <span class="icon-empty" data-rate="3"></span>
                                                    <span class="icon-empty" data-rate="2"></span>
                                                    <span class="icon-empty" data-rate="1"></span></p>
                                            </div>
                                            <div class="time">
                                                <p>11:25</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                             <div class="add-new">
                                <div class="item">
                                    <label class="text-option">
                                        <span class="label-wrap">
                                            <textarea
                                                class="placeholder-effect">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using</textarea>
                                            <span class="placeholder">Review text</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-btn">
                            <p>After saving, automatically sent the link mail to activate account</p>
                            <button type="button" class="main-btn gray-blank" data-fancybox-close>cancel</button>
                            <button type="button" class="main-btn yellow-blank">create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-wrap" id="test-rooms">
            <div class="go-back" data-fancybox-close>
                <button type="button"><i class="icon-back"></i>Back to rooms</button>
            </div>
            <div class="content">
                <div class="data">
                    <div class="scroll-wrap">
                        <div class="modal-title with-border">
                            <p>Add room</p>
                        </div>
                        <div class="data-content room-options">
                            <div class="add-new">
                                <div class="row">
                                    <div class="item col-12">
                                        <span class="name">Name</span>
                                        <label class="text-option">
                                            <span class="label-wrap">
                                                <input type="text" class="placeholder-effect">
                                                <span class="placeholder">Name</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="item col-md-6 col-sm-12">
                                        <span class="name">Price</span>
                                        <label class="text-option">
                                            <span class="label-wrap">
                                                <input type="text" class="placeholder-effect">
                                                <span class="placeholder">Price</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="item col-md-6 col-sm-12">
                                        <span class="name">Number of seats</span>
                                        <label class="text-option">
                                            <span class="label-wrap">
                                                <input type="text" class="placeholder-effect">
                                                <span class="placeholder">Number of seats</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="item col-12">
                                        <span class="name">Facilities</span>
                                        <label class="checkbox-option">
                                            <input type="checkbox">
                                            <span class="option">Computer</span>
                                        </label>
                                        <label class="checkbox-option">
                                            <input type="checkbox">
                                            <span class="option">Phone</span>
                                        </label>
                                        <label class="checkbox-option">
                                            <input type="checkbox">
                                            <span class="option">Name</span>
                                        </label>
                                        <label class="checkbox-option">
                                            <input type="checkbox">
                                            <span class="option">Computer</span>
                                        </label>
                                        <label class="checkbox-option">
                                            <input type="checkbox">
                                            <span class="option">Phone</span>
                                        </label>
                                        <label class="checkbox-option">
                                            <input type="checkbox">
                                            <span class="option">Name</span>
                                        </label>
                                        <label class="checkbox-option">
                                            <input type="checkbox">
                                            <span class="option">Computer</span>
                                        </label>
                                        <label class="checkbox-option">
                                            <input type="checkbox">
                                            <span class="option">Phone</span>
                                        </label>
                                        <label class="checkbox-option">
                                            <input type="checkbox">
                                            <span class="option">Name</span>
                                        </label>
                                    </div>
                                    <div class="item col-12">
                                        <span class="name">Overview</span>
                                        <label class="text-option">
                                            <span class="label-wrap">
                                                <textarea placeholder="Overview text"></textarea>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="item col-12">
                                        <span class="name">Location</span>
                                        <label class="text-option">
                                            <span class="label-wrap">
                                                <input type="text" class="placeholder-effect">
                                                <span class="placeholder">Adress</span>
                                            </span>
                                            <span class="icon-location"></span>
                                        </label>
                                    </div>
                                    <div class="item col-12">
                                        <span class="name">Upload photos</span>
                                        <div class="photo-upload">
                                            <div class="upload-item">
                                                <div class="upload-wrap">
                                                    <div class="upload">
                                                        <label class="file"><input type="file" accept="image/*"
                                                                multiple></label>
                                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor
                                                            do
                                                            amet sint. Velit officia consequat duis enim velit mollit.
                                                        </p>
                                                        <button class="main-btn gray-blank" type="button">choose files
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="preview-wrap">
                                                    <div class="flex wrap">
                                                        <div class="photo-wrap">

                                                            <div class="add-extra">
                                                                <button type="button"><span class="icon-plus"></span>add
                                                                    image
                                                                </button>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-btn">
                            <button type="button" class="main-btn gray-blank" data-fancybox-close>cancel</button>
                            <button type="button" class="main-btn yellow-blank">create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-wrap" id="test-booking">
            <div class="go-back" data-fancybox-close>
                <button type="button"><i class="icon-back"></i>Back to bookings</button>
            </div>
            <div class="content">
                <div class="data">
                    <div class="scroll-wrap">
                        <div class="modal-title big with-border">
                            <p>Office with a sea view <i class="icon-info"></i></p>
                        </div>
                        <div class="data-content">
                            <div class="booking-options">
                                <div class="booking-main">
                                    <div class="row">
                                        <div class="main-item">
                                            <div class="member-data">
                                                <div class="member-img">
                                                    <img src="images/user.jpg" alt="">
                                                </div>
                                                <div class="text">
                                                    <div class="name">
                                                        <p>Lena Hawkins <i class="icon-info"></i></p>
                                                    </div>
                                                    <div class="status">
                                                        <p><span style="background-color: #EABD37"></span>Hold</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="main-item">
                                            <div class="title">
                                                <p>Date & Time:</p>
                                            </div>
                                            <div class="info">
                                                <p><span class="icon-timer"></span>10:30 - 11:30 / 25.07.2020</p>
                                                <p><a href="javascript:void(0)">Change date & time</a></p>
                                            </div>
                                        </div>
                                        <div class="main-item">
                                            <div class="title">
                                                <p>Book price:</p>
                                            </div>
                                            <div class="info">
                                                <p><span class="icon-pay"></span>300 credits / $210</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="booking-data">
                                    <div class="title">
                                        <p>Client balance</p>
                                    </div>

                                    <div class="balance">
                                        <p>4130 credits</p>
                                        <p><a href="javascript:void(0)">transactions history</a></p>
                                    </div>

                                </div>

                                <div class="booking-data">
                                    <div class="title">
                                        <p>Room information</p>
                                    </div>
                                    <div class="additional">
                                        <p>Door key</p>
                                        <p>3813</p>
                                    </div>
                                    <div class="additional">
                                        <p>Wi-Fi code</p>
                                        <p>826A843R7</p>
                                    </div>
                                </div>
                                <div class="booking-data">
                                    <div class="title">
                                        <p>Booking options</p>
                                    </div>
                                    <div class="table-wrap responsive-table">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td>Option name</td>
                                                    <td>Unit price</td>
                                                    <td>Total</td>
                                                    <td>Quantity</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Pens for board</td>
                                                    <td>300 Credits</td>
                                                    <td>300 Credits</td>
                                                    <td>
                                                        <div class="quantity-wrap">
                                                            <div class="quantity-btn">
                                                                <a href="javascript:void(0)" data-act="-">
                                                                    <span class="icon-minus"></span>
                                                                </a>
                                                            </div>
                                                            <label>
                                                                <input type="number" name="quantity[]" value="1"
                                                                    maxlength="4">
                                                            </label>
                                                            <div class="quantity-btn">
                                                                <a href="javascript:void(0)" data-act="+">
                                                                    <span class="icon-plus"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pens for board</td>
                                                    <td>300 Credits</td>
                                                    <td>300 Credits</td>
                                                    <td>
                                                        <div class="quantity-wrap">
                                                            <div class="quantity-btn">
                                                                <a href="javascript:void(0)" data-act="-">
                                                                    <span class="icon-minus"></span>
                                                                </a>
                                                            </div>
                                                            <label>
                                                                <input type="number" name="quantity[]" value="1"
                                                                    maxlength="4">
                                                            </label>
                                                            <div class="quantity-btn">
                                                                <a href="javascript:void(0)" data-act="+">
                                                                    <span class="icon-plus"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pens for board</td>
                                                    <td>300 Credits</td>
                                                    <td>300 Credits</td>
                                                    <td>
                                                        <div class="quantity-wrap">
                                                            <div class="quantity-btn">
                                                                <a href="javascript:void(0)" data-act="-">
                                                                    <span class="icon-minus"></span>
                                                                </a>
                                                            </div>
                                                            <label>
                                                                <input type="number" name="quantity[]" value="1"
                                                                    maxlength="4">
                                                            </label>
                                                            <div class="quantity-btn">
                                                                <a href="javascript:void(0)" data-act="+">
                                                                    <span class="icon-plus"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pens for board</td>
                                                    <td>300 Credits</td>
                                                    <td>300 Credits</td>
                                                    <td>
                                                        <div class="quantity-wrap">
                                                            <div class="quantity-btn">
                                                                <a href="javascript:void(0)" data-act="-">
                                                                    <span class="icon-minus"></span>
                                                                </a>
                                                            </div>
                                                            <label>
                                                                <input type="number" name="quantity[]" value="1"
                                                                    maxlength="4">
                                                            </label>
                                                            <div class="quantity-btn">
                                                                <a href="javascript:void(0)" data-act="+">
                                                                    <span class="icon-plus"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="booking-result">
                                    <div class="booking-main">
                                        <div class="main-item">
                                            <div class="title">
                                                <p>Changed price:</p>
                                            </div>
                                            <div class="info">
                                                <p><span class="icon-pay"></span>300 credits / $210</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="btn">
                                        <button type="button" class="main-btn gray-blank">cancel booking</button>
                                        <button type="button" class="main-btn yellow-blank">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-info" id="test-notification">
            <div class="scroll-wrap">
                <div class="info-text">
                    <p>Your changes have been successfully saved</p>
                </div>
                <div class="info-icon">
                    <p><span class="icon-done"></span></p>
                    <!--            <p><span class="icon-close"></span></p>-->
                </div>
                <div class="info-btn">
                    <button type="button" class="main-btn yellow-blank" data-fancybox-close>CLose</button>
                </div>
            </div>
        </div>

         

    </div>
    <script src="{{asset('js/extra/jquery-3.4.1.min.js')}}" defer></script>
    <script src="{{asset('js/extra/libs.js')}}" defer></script>
    <script src="{{asset('js/extra/common.js')}}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script>

        $("#date_selector").change(function(){
            var date = $("#date_selector").val();
             $("#filter_btn").attr("href", "/dashboard/booking-calender?search_date="+date);         
        });

        function getTimeStops(start, end){
          var startTime = moment(start, 'HH:mm');
          var endTime = moment(end, 'HH:mm');
        
          if( endTime.isBefore(startTime) ){
            endTime.add(1, 'day');
          }
      
          var timeStops = [];
      
          while(startTime <= endTime){
            timeStops.push(new moment(startTime).format('HH:mm'));
            startTime.add(30, 'minutes');
          }
          return timeStops;
        }

        var offices = document.getElementsByClassName('card-info');

        var timeStops = getTimeStops('09:00', '18:00');

        count = 0
        
        for (let index1 = 0; index1 < offices.length; index1++) {
            count = 0
            for (let index = 0; index < timeStops.length; index++) {
                var x = document.createElement("div");
                var t = document.createTextNode(timeStops[index]);
                x.classList.add('slot')
                x.appendChild(t);
                offices[index1].appendChild(x);
                if (count === 1) {
                    count = 0
                } else {
                    count++
                }
            }
        }
        var slots = document.getElementsByClassName('slot');
        // for (let index = 0; index < slots.length; index++) {
        //     if (index == 0) {
        //         slots[index].classList.add('end')
        //     }
        //     if (index == 21) {
        //         slots[index].classList.add('hold')
        //     }
        //     if (index == 38) {
        //         slots[index].classList.add('active')
        //     }
        //     if (index == 60) {
        //         slots[index].classList.add('no-paid')
        //     }
        //     // console.log(slots[index]);
        // }
        
    </script>

</body>

</html>