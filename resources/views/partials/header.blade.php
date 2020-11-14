<header class="page-intro">
    <div class="container">
        <div class="flex wrap aCenter jBetween">
            <div class="main-links">
                <ul>
                    <li><a href="javascript:void(0)">{{ __('WeBiz website') }}</a></li>
                    <li><a href="javascript:void(0)">{{ __('How to use the dashboard') }}</a></li>
                </ul>
            </div>
            <div class="user-data">
                <p>{{ auth()->user()->name }}</p>
                <div class="info">
                    <div class="img">
                        <img src="{{ asset(auth()->user()->avatar ?? 'images/default-user.png') }}" alt="">
                    </div>
                    <button type="button"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('LOGOUT') }}</button>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
