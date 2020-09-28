<div class="page-toolbar">
    <div class="container">
        <div class="flex wrap aCenter jBetween">
            <div class="title col-lg-2 d-lg-block">
                <h1><i class="icon-dashboard"></i>{{ __('WeBiz Office Dashboard') }}</h1>
            </div>
            <div class="col-lg-10 col-md-12">
                <div class="toolbar-menu">
                    <div class="main-data">
                        <div class="open-menu d-lg-none">
                            <button type="button"><i class="icon-dashboard"></i></button>
                        </div>
                        <ul>
                            @foreach($toolbar_menu_items as $item)
                                <li class="{{ isset($item['active']) && $item['active'] ? 'active' : '' }}">
                                    <a href="{{ $item['href'] ?? 'javascript:void(0)' }}">{{ $item['name'] ?? '' }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="toolbar-options">
                        @stack('toolbar-options')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>