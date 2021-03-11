@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header">{{ __('Bookings') }}</div>
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
        $(document).ready(function () {
            $.fn.dataTable.ext.errMode = 'none';
            $(document).on('click', '.delete-swal', function () {
                let item_id = $(this).data('id');

                if (confirm("Are you sure?")) {
                    $.ajax({
                        url: '/dashboard/bookings/' + item_id,
                        type: 'DELETE',
                        success: function () {
                            $('#bookings-table').DataTable().draw();
                        },
                        error: function () {
                            alert("{{ __('Something went wrong.') }}")
                        }
                    });
                }
            });

            $(document).on('click', '.end-booking', function () {
                let item_id = $(this).data('id');

                if (confirm("Booking will be completed. Are you sure?")) {
                    $.ajax({
                        url: '/dashboard/bookings/end/' + item_id,
                        type: 'POST',
                        success: function (res) {
                            alert(res.message);
                            $('#bookings-table').DataTable().draw();
                        },
                        error: function () {
                            alert("{{ __('Something went wrong.') }}")
                        }
                    });
                }
            });
        });
    </script>
@endpush
