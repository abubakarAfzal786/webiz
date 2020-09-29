@extends('layouts.app_new', ['toolbar_menu_items' => [
    ['name' => __('Reviews'), 'active' => true, /*'href' => '/'*/],
]])

@push('toolbar-options')
<div class="item">
    <label class="select-field">
        <span class="name">{{ __('Rates') }}</span>
        <select>
            <option>{{ __('All') }}</option>
        </select>
        {{--TODO implement--}}
    </label>
</div>
<div class="item left-border">
    <label class="select-date">
        <span class="name">{{ __('Date') }}:</span>
        <input type="text" placeholder="Select date">
        {{--TODO implement--}}
        <span class="icon-calendar"></span>
    </label>
</div>
@endpush

@section('content')
    <div class="data col-12">
        <div class="table-intro">
        </div>
        <div class="data-bg">
            <div class="table-wrap responsive-table">
                <table id="myDataTable">
                    <thead>
                    <tr>
                        <td></td>
                        <td>{{ __('Use name') }}</td>
                        <td>{{ __('Short text') }}</td>
                        <td>{{ __('Office name') }}</td>
                        <td>{{ __('Rate') }}</td>
                        <td>{{ __('Date') }}</td>
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
            ajax: "{{ route('admin.reviews.index') }}",
            columns: [
                {data: 'avatar', name: 'avatar'},
                {data: 'member_name', name: 'member_name'},
                {data: 'description', name: 'description'},
                {data: 'room_name', name: 'room_name'},
                {data: 'rate', name: 'rate'},
                {data: 'date', name: 'date'},
            ]
        });
    });
</script>
@endpush