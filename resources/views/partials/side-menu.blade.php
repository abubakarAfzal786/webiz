<div class="menu-list col-lg-2">
    <div class="close-list d-lg-none">
        <button type="button"><span class="icon-close"></span></button>
    </div>
    <div class="item-wrap">
        <div class="item">
            <ul>
                <li class="{{ request()->is(['dashboard']) ? 'active' : '' }}"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                <li class="{{ request()->is(['dashboard/bookings', 'dashboard/bookings/*']) ? 'active' : '' }}"><a href="{{ route('admin.bookings.index') }}">{{ __('Bookings') }}</a></li>
                <li class="{{ request()->is(['dashboard/companies', 'dashboard/companies/*']) ? 'active' : '' }}"><a href="{{ route('admin.companies.index') }}">{{ __('Companies') }}</a></li>
                <li class="{{ request()->is(['dashboard/members', 'dashboard/members/*']) ? 'active' : '' }}"><a href="{{ route('admin.members.index') }}">{{ __('Members') }}</a></li>
            </ul>
        </div>
        <div class="item">
            <p>{{ __('Support') }}</p>
            <ul>
                <li class="{{ request()->is(['dashboard/support-chat', 'dashboard/support-chat/*']) ? 'active' : '' }}"><a href="{{ route('admin.support-chat.index') }}">{{ __('Support Chat') }}</a>
                    <counter></counter>
                </li>
                <li class="{{ request()->is(['dashboard/faq', 'dashboard/faq/*']) ? 'active' : '' }}"><a href="{{ route('admin.faq.index') }}">{{ __('FAQ Base') }}</a></li>
            </ul>
        </div>
        <div class="item">
            <p>{{ __('Service Administration') }}</p>
            <ul>
                <li class="{{ request()->is(['dashboard/rooms', 'dashboard/rooms/*']) ? 'active' : '' }}"><a href="{{ route('admin.rooms.index') }}">{{ __('Rooms') }}</a></li>
                <li class="{{ request()->is(['dashboard/reviews', 'dashboard/reviews/*']) ? 'active' : '' }}"><a href="{{ route('admin.reviews.index') }}">{{ __('Reviews') }}</a></li>
                <li><a href="javascript:void(0)">{{ __('Notifications') }}</a></li>
            </ul>
        </div>
        <div class="item">
            <ul>
                <li class="{{ request()->is(['dashboard/packages', 'dashboard/packages/*']) ? 'active' : '' }}"><a href="{{ route('admin.packages.index') }}">{{ __('Packages') }}</a></li>
                <li class="{{ request()->is(['dashboard/settings', 'dashboard/settings/*']) ? 'active' : '' }}"><a href="{{ route('admin.settings.index') }}">{{ __('Settings') }}</a></li>
                <li class="{{ request()->is(['dashboard/transactions', 'dashboard/transactions/*']) ? 'active' : '' }}"><a href="{{ route('admin.transactions.index') }}">{{ __('Transactions') }}</a></li>
                <li class="{{ request()->is(['dashboard/statistics', 'dashboard/statistics/*']) ? 'active' : '' }}"><a href="{{ route('admin.statistics.index') }}">{{ __('Statistics') }}</a></li>
                <li class="{{ request()->is(['dashboard/customer-service', 'dashboard/customer-service/*']) ? 'active' : '' }}"><a href="{{ route('admin.members.customer-service') }}">{{ __('Customer Service') }}</a></li>
                <li class="{{ request()->is(['dashboard/booking-calender', 'dashboard/customer-service/*']) ? 'active' : '' }}"><a href="{{ route('admin.booking.calender') }}">{{ __('Booking Calender') }}</a></li>
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
