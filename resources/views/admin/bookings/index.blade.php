@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header">{{ __('Bookings') }}</div>
                    <div class="card-body">
                            <div class="col-md-12" style="margin-bottom:2%;">
                                <div class="card acik-renk-form">
                                    <div class="card-body">
                                        <form action="" id="filtersForm">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label for="reservation start date">Select Reservation Start
                                                            Date</label>
                                                        <input type="date" name="start_date" class="form-control mr-2"
                                                            id="start_date"
                                                            value="{{ request()->get('start_date')?request()->get('start_date'):'' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label for="reservation start date">Select Reservation End
                                                            Date</label>
                                                        <input type="date" name="end_date" class="form-control mr-2"
                                                            id="end_date"
                                                            value="{{ request()->get('end_date')?request()->get('end_date'):'' }}">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12  text-right">
                                                    <button class="btn btn-primary" id="date_filter_button"
                                                        value="Filter">Search</button>
                                              <button class="btn btn-light" id="date_reset_button"
                                                        type="reset">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
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
        var onTable = $("#bookings-table").DataTable();
        $("#date_filter_button").on('click', function (e) {

            onTable.draw();
        })
        $(document).on('change', '#start_date', function () {
            currentDate = $('#start_date').val();
            $('#end_date').attr('min', currentDate);
        })
$(document).on('click','#date_reset_button',function(){
window.location.href="{{url('dashboard/bookings')}}"
});
        $(document).ready(function () {
            currentDate = $('#start_date').val();
            $('#end_date').attr('min', currentDate);
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
