@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header">
                        {{ __('Transactions') }}
                        <label class="float-right">
                            <input type="month" id="month" class="form-control-sm" name="month"
                                   value="{{ request()->get('month') ?? null }}">
                        </label>
                        @if(request()->get('month'))
                            <button type="button" class="btn btn-sm btn-primary float-right mr-2 reset-month">Reset</button>
                        @endif
                    </div>
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
        function changeMonth(month) {
            let url = new URL(window.location.href);
            let search_params = url.searchParams;

            search_params.set('month', month);
            url.search = search_params.toString();

            return url.toString()
        }

        $(document).ready(function () {
            $(document).on('click', '.reset-month', function () {
                $(document).find('#month').val('').change();
            });

            $(document).on('change', '#month', function () {
                let month = $(this).val();
                window.location.href = changeMonth(month);
            });
        });
    </script>
@endpush
