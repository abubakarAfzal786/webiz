@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header">{{ __('Packages') }}</div>
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
            $(document).on('click', '.delete-swal[data-id]', function () {
                let item_id = $(this).data('id');

                if (confirm("Are you sure?")) {
                    $.ajax({
                        url: '/dashboard/packages/' + item_id,
                        type: 'DELETE',
                        success: function () {
                            $('#packages-table').DataTable().draw();
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
