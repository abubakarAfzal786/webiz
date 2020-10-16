@extends('layouts.app_new', ['toolbar_menu_items' => [
    ['name' => __('Rooms'), 'active' => true, /*'href' => '/'*/],
]])

@push('toolbar-options')
<div class="item">
    <a href="{{ route('admin.room-facility.index') }}" class="main-btn yellow-blank">{{ __('Facilities') }}</a>
</div>
<div class="item">
    <a href="{{ route('admin.room-type.index') }}" class="main-btn yellow-blank">{{ __('Types') }}</a>
</div>
<div class="item">
    <a href="{{ route('admin.room-attribute.index') }}" class="main-btn yellow-blank">{{ __('Attributes') }}</a>
</div>

<div class="item left-border">
    {{--    <a href="{{ route('admin.rooms.create') }}" class="main-btn yellow-blank">{{ __('Add new room') }}</a>--}}
    <button type="button" class="main-btn yellow-blank" data-fancybox id="open-test-rooms"
            data-src='#test-rooms'>{{ __('Add new room') }}</button>
</div>
@endpush

@push('header-post-scripts')
<style>
    div.pac-container.pac-logo {
        z-index: 999999;
    }
</style>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api_key') }}&libraries=places"></script>
@endpush

@section('content')
    <div class="data col-12">
        <div class="table-intro">
            <label class="search-field">
                <input type="text" placeholder="Find a room" id="search-box">
                <button type="button"><span class="icon-search"></span></button>
            </label>
            <div class="total">
                <p>{{ __('Total rooms') }}: <span>{{ $rooms_count }}</span></p>
            </div>
        </div>
        <div class="data-bg">
            <div class="table-wrap responsive-table">
                <table id="myDataTable">
                    <thead>
                    <tr>
                        <td>{{ __('Room name') }}</td>
                        <td>{{ __('Credit/hr') }}</td>
                        <td>{{ __('Photos') }}</td>
                        <td>{{ __('Number of seats') }}</td>
                        <td>{{ __('Status') }}</td>
                        <td>{{ __('Action') }}</td>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
@include('admin.rooms.modal')
@endpush

@push('scripts')
<script>
    $(function () {
        let myDataTable = $('#myDataTable').DataTable({
            processing: true,
            serverSide: true,
            bPaginate: false,
            bLengthChange: false,
            bInfo: false,
            sDom: 'lrtip',
            ajax: "{{ route('admin.rooms.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'price', name: 'price'},
                {data: 'images', name: 'images'},
                {data: 'seats', name: 'seats'},
                {data: 'status', name: 'status'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#search-box').doneTyping(function () {
            myDataTable.search($(this).val()).draw();
        });

        $('#open-test-rooms').on('click', function () {
            $(document).find('input.pac-target-input').removeAttr('placeholder');
        });

        let autocomplete = new google.maps.places.Autocomplete(document.getElementById("location"));

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            let place = autocomplete.getPlace();

            $('#lat').val(place.geometry.location.lat());
            $('#lon').val(place.geometry.location.lng());
        });
    });
</script>
@endpush