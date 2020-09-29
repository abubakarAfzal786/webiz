@extends('layouts.app_new', ['toolbar_menu_items' => [
    ['name' => __('Rooms'), 'active' => true, /*'href' => '/'*/],
]])

@push('toolbar-options')
<div class="item">
    <a href="{{ route('admin.rooms.create') }}" class="main-btn yellow-blank">{{ __('Add new room') }}</a>
</div>
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
@push('scripts')

<script type="text/javascript">
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
        })
    });
</script>
@endpush