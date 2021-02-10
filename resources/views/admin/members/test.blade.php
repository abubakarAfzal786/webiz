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
    {{--TODO implement functionality--}}
</div>
<div class="item left-border">
    <a href="{{ route('admin.members.create') }}" class="main-btn yellow-blank">{{ __('Add new member') }}</a>
</div>
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
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
//            buttons: [
//                'copy', 'csv', 'excel', 'pdf', 'print'
//            ]
        });

        $('#search-box').doneTyping(function () {
            myDataTable.search($(this).val()).draw();
        });

//        $(".export-excel-button").on("click", function () {
//            myDataTable.buttons('.excel').trigger();
//        });
    });
</script>
@endpush
