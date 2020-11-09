@extends('layouts.app_new', ['toolbar_menu_items' => [
    ['name' => __('New tickets'), 'active' => true /*'href' => '/'*/],
    ['name' => __('Tickets history'), 'active' => false /*'href' => '/'*/],
    ['name' => __('Favorites'), 'active' => false /*'href' => '/'*/],
]])

@push('toolbar-options')
    <div class="item">
        <a href="javascript:void(0)" type="button" class="main-btn yellow-blank">{{ __('New Ticket') }}</a>
    </div>
@endpush
@section('content')

    <div class="data chat-list-wrap col-lg-5">
        <div class="data-bg">
            <div class="chat-list">
                <div class="scroll-list">
                    <ul>
                        <li class="active">
                            <div class="member-data">
                                <div class="member-img">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                                <div class="text">
                                    <div class="name">
                                        <p>Lena Hawkins <span class="">Ticket 1214</span> <i
                                                class="icon-star"></i></p>
                                        <p class="time">12:23</p>
                                    </div>
                                    <div class="message">
                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua..</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="member-data">
                                <div class="member-img">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                                <div class="text">
                                    <div class="name">
                                        <p>Lena Hawkins <span class="">Ticket 1214</span> <i
                                                class="icon-empty"></i></p>
                                        <p class="time">12:23</p>
                                    </div>
                                    <div class="message">
                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua..</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="member-data">
                                <div class="member-img">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                                <div class="text">
                                    <div class="name">
                                        <p>Lena Hawkins <span class="">Ticket 1214</span> <i
                                                class="icon-star"></i></p>
                                        <p class="time">12:23</p>
                                    </div>
                                    <div class="message">
                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua..</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="member-data">
                                <div class="member-img">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                                <div class="text">
                                    <div class="name">
                                        <p>Lena Hawkins <span class="">Ticket 1214</span> <i
                                                class="icon-empty"></i></p>
                                        <p class="time">12:23</p>
                                    </div>
                                    <div class="message">
                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua..</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="member-data">
                                <div class="member-img">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                                <div class="text">
                                    <div class="name">
                                        <p>Lena Hawkins <span class="">Ticket 1214</span> <i
                                                class="icon-empty"></i></p>
                                        <p class="time">12:23</p>
                                    </div>
                                    <div class="message">
                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua..</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="member-data">
                                <div class="member-img">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                                <div class="text">
                                    <div class="name">
                                        <p>Lena Hawkins <span class="">Ticket 1214</span> <i
                                                class="icon-star"></i></p>
                                        <p class="time">12:23</p>
                                    </div>
                                    <div class="message">
                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua..</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="member-data">
                                <div class="member-img">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                                <div class="text">
                                    <div class="name">
                                        <p>Lena Hawkins <span class="">Ticket 1214</span> <i
                                                class="icon-empty"></i></p>
                                        <p class="time">12:23</p>
                                    </div>
                                    <div class="message">
                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua..</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="member-data">
                                <div class="member-img">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                                <div class="text">
                                    <div class="name">
                                        <p>Lena Hawkins <span class="">Ticket 1214</span> <i
                                                class="icon-empty"></i></p>
                                        <p class="time">12:23</p>
                                    </div>
                                    <div class="message">
                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua..</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="member-data">
                                <div class="member-img">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                                <div class="text">
                                    <div class="name">
                                        <p>Lena Hawkins <span class="">Ticket 1214</span> <i
                                                class="icon-star"></i></p>
                                        <p class="time">12:23</p>
                                    </div>
                                    <div class="message">
                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua..</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="member-data">
                                <div class="member-img">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                                <div class="text">
                                    <div class="name">
                                        <p>Lena Hawkins <span class="">Ticket 1214</span> <i
                                                class="icon-empty"></i></p>
                                        <p class="time">12:23</p>
                                    </div>
                                    <div class="message">
                                        <p>Amet minim mollit non deserunt ullamco est sit aliqua..</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="close-chat-list d-lg-none">
                <button type="button" class="main-btn yellow-blank">Close</button>
            </div>
        </div>
    </div>

    <div class="data col-lg-7 col-md-12">
        <div class="data-bg">
            <div class="active-chat">
                <div class="member-data">
                    <div class="open-chat-list d-lg-none">
                        <button type="button"><span class="icon-menu"></span></button>
                    </div>
                    <div class="member-img">
                        <img src="{{ asset('images/user.jpg') }}" alt="">
                    </div>
                    <div class="text">
                        <div class="name">
                            <p>Lena Hawkins <span class="">Ticket 1214</span></p>
                            <p><i class="icon-empty"></i></p>
                        </div>
                    </div>
                    <div class="btn">
                        <button type="button">Close Request</button>
                    </div>
                </div>
                <div class="chat-message">
                    <div class="chat-scroll">
                        <div class="chat-wrap">
                            <div class="message-text received">
                                <div class="content">
                                    <div class="name">
                                        <p>Leslie Alexander</p>
                                    </div>
                                    <div class="text">
                                        <p>Lorem Ipsum is simply dummy text of the printing and
                                            typesetting
                                            industry. Lorem Ipsum has been the industry's</p>
                                    </div>
                                    <div class="status">
                                        <p>10:55 AM <span class="icon-seen"></span></p>
                                    </div>
                                </div>
                                <div class="user">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                            </div>

                            <div class="message-text sent">
                                <div class="content">
                                    <div class="name">
                                        <p>You</p>
                                    </div>
                                    <div class="text">
                                        <p>Lorem Ipsum is simply dummy text of the printing and
                                            typesetting
                                            industry. Lorem Ipsum has been the industry's</p>
                                    </div>
                                    <div class="status">
                                        <p>10:55 AM <span class="icon-seen"></span></p>
                                    </div>
                                </div>
                                <div class="user">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                            </div>

                            <div class="message-text received">
                                <div class="content">
                                    <div class="name">
                                        <p>Leslie Alexander</p>
                                    </div>
                                    <a href="javascript:void(0)" class="file">
                                                <span class="icon">
                                                    <span class="icon-document"></span>
                                                </span>
                                        <span class="info">
                                                    <span class="text">IMG_912.jpeg <span
                                                            class="weight">2,4 MB</span></span>
                                                </span>
                                    </a>
                                    <div class="status">
                                        <p>10:55 AM</p>
                                    </div>
                                </div>
                                <div class="user">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                            </div>

                            <div class="message-text sent">
                                <div class="content">
                                    <div class="name">
                                        <p>Leslie Alexander</p>
                                    </div>
                                    <a href="javascript:void(0)" class="file">
                                                <span class="icon">
                                                    <span class="icon-document"></span>
                                                </span>
                                        <span class="info">
                                                    <span class="text">IMG_912.jpeg <span
                                                            class="weight">2,4 MB</span></span>
                                                </span>
                                    </a>
                                    <div class="status">
                                        <p>10:55 AM</p>
                                    </div>
                                </div>
                                <div class="user">
                                    <img src="{{ asset('images/user.jpg') }}" alt="">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="chat-control">
                    <label>
                        <textarea placeholder="Type your message here..."></textarea>
                    </label>
                    <div class="btn">
                        <button type="button"><span class="icon-smile"></span></button>
                        <button type="button"><label><input type="file"><span class="icon-file"></span></label>
                        </button>
                        <button type="button"><span class="icon-send"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
