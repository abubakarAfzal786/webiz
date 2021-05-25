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
    <chat></chat>
@endsection
