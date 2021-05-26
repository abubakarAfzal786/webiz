@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header">{{ $room->name . ': ' .  __('Devices') }}</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {!! $dataTable->table(['class' => 'display table table-striped table-bordered dataTable']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
    <script>
        $(document).on('click', '.toggle-device', function () {
                let item_id = $(this).data('id');

               
                    $.ajax({
                        url: '/dashboard/device/toggle',
                        type: 'POST',
                        data:{
                            device_id:item_id
                        },
                        success: function (res) {
                            alert(res.message);
                            $('#bookings-table').DataTable().draw();
                        },
                        error: function () {
                            alert("{{ __('Something went wrong.') }}")
                        }
                    });
                
            });
    </script>
@endpush
