<div class="menu-list col-lg-2">
    <div class="close-list d-lg-none">
        <button type="button"><span class="icon-close"></span></button>
    </div>
    <div class="item-wrap">
        <div class="item">
            <ul>
                <li class="active"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                <li><a href="{{ route('admin.bookings.index') }}">{{ __('Bookings') }}</a><span>4</span></li>
                <li><a href="{{ route('admin.members.index') }}">{{ __('Members') }}</a></li>
            </ul>
        </div>
        <div class="item">
            <p>Support</p>
            <ul>
                <li><a href="javascript:void(0)">{{ __('Support Chat') }}</a><span>45</span></li>
                <li><a href="{{ route('admin.faq.index') }}">{{ __('FAQ Base') }}</a></li>
            </ul>
        </div>
        <div class="item">
            <p>{{ __('Service Administration') }}</p>
            <ul>
                <li><a href="{{ route('admin.rooms.index') }}">{{ __('Rooms') }}</a></li>
                <li><a href="{{ route('admin.reviews.index') }}">{{ __('Reviews') }}</a></li>
                <li><a href="javascript:void(0)">{{ __('Notifications') }}</a><span>10</span></li>
            </ul>
        </div>
    </div>
    <div class="user-data d-sm-none">
        <div class="info">
            <div class="img">
                <img src="{{ asset(auth()->user()->avatar ?? 'images/user.jpg') }}" alt="">
            </div>
            <button type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</button>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>