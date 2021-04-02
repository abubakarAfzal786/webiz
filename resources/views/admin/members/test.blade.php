@extends('layouts.app_new', ['toolbar_menu_items' => [
    ['name' => __('Members'), 'active' => true /*'href' => '/'*/],
    ['name' => __('Managers'), 'active' => false /*'href' => '/'*/],
    // TODO implement
]])

@push('toolbar-options')
    <div class="item">
        <label class="select-field">
            <span class="name">{{ __('Filters') }}:</span>
            <select>
                <option>{{ __('All') }}</option>
                {{--TODO add filters--}}
            </select>
        </label>
    </div>
    <div class="item">
        <button type="button" class="main-btn gray-blank export-excel-button">{{ __('EXPORT (EXCEL)') }}</button>
    </div>
    <div class="item left-border">
        <a href="{{ route('admin.members.create') }}" class="main-btn yellow-blank">{{ __('Add new member') }}</a>
    </div>
@endpush

@push('header-pre-scripts')
    <link rel="stylesheet" href="//cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
@endpush

@push('header-post-scripts')
    <style>
        .dataTables_length {
            text-align: right;
        }
    </style>
@endpush

@section('content')
    <div class="data col-12">
        <div class="table-intro">
            <label class="search-field">
                <input type="text" placeholder="Find a member" id="search-box">
                <button type="button"><span class="icon-search"></span></button>
            </label>
            <div class="total">
                <p>{{ __('Total members') }}: <span>{{ $members_count }}</span></p>
            </div>
        </div>
        <div class="data-bg">
            <div class="table-wrap responsive-table">
                <table id="myDataTable">
                    <thead>
                    <tr>
                        <td>{{ __('Photo') }}</td>
                        <td>{{ __('Member name') }}</td>
                        <td>{{ __('Mobile') }}</td>
                        <td>{{ __('E-mail') }}</td>
                        <td>{{ __('Status') }}</td>
                        <td>{{ __('Registered') }}</td>
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
                bPaginate: true,
                bLengthChange: true,
                bInfo: true,
                sDom: 'lrtip',
                ajax: {
                    "url": "{{ route('admin.members.index') }}",
                    "data": function (d) {
                        d.company_id = "{{ request('company_id') }}";
                    }
                },
                columns: [
                    {data: 'avatar', name: 'avatar'},
                    {data: 'name', name: 'name'},
                    {data: 'phone', name: 'phone'},
                    {data: 'email', name: 'email'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                buttons: [
                    'excel',
                ]
            });

            $('#search-box').doneTyping(function () {
                myDataTable.search($(this).val()).draw();
            });

            $(".export-excel-button").on('click', function () {
                $('#myDataTable').DataTable().buttons(0, 0).trigger();
            });
        });
    </script>
@endpush
