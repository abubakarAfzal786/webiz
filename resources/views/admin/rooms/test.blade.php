@extends('layouts.app_new', ['toolbar_menu_items' => [
    ['name' => __('Rooms'), 'active' => true, /*'href' => '/'*/],
]])

@push('toolbar-options')
    <div class="item">
        <a href="{{ route('admin.device-type.index') }}" class="main-btn yellow-blank">{{ __('Device Types') }}</a>
    </div>
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
        <button type="button" class="main-btn yellow-blank" id="open-test-rooms">{{ __('Add new room') }}</button>
    </div>
@endpush

@push('header-pre-scripts')
    <link rel="stylesheet" href="//cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
@endpush
@push('header-post-scripts')
    <style>
        div.pac-container.pac-logo {
            z-index: 999999;
        }

        .dataTables_length {
            text-align: right;
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
                        <td>{{ __('Name') }}</td>
                        <td>{{ __('Credit/hr') }}</td>
                        <td>{{ __('Photos') }}</td>
                        <td>{{ __('Number of seats') }}</td>
                        <td>{{ __('PIN') }}</td>
                        <td>{{ __('Room №') }}</td>
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
        let Room = {
            id: 0,
            data: {},
            imgToDelete: [],
            myDataTable: null,
            fillData: function () {
                $.each(Room.data, function (ind, val) {
                    if (ind === 'facilities') {
                        $.each(val, function (fac_ind, fac_val) {
                            $('#facility_' + fac_val.id).prop('checked', true).trigger('change');
                        });
                    }

                    if (ind === 'images' && !$.isEmptyObject(val)) {
                        $('.upload-wrap').hide();
                        $('.preview-wrap').show();

                        $.each(val, function (img_ind, img_val) {
                            $('.photo-wrap').prepend(
                                '<div class="ready-photo">' +
                                '<span class="icon-close"></span>' +
                                '<img src="' + img_val.url + '" alt="" data-id="' + img_val.id + '">' +
                                '</div>'
                            )
                        });
                    }

                    if (ind === 'status' && val) $('#room-status').attr('checked', 'checked');
                    if (ind === 'monthly' && val) $('#room-monthly').attr('checked', 'checked');

                    $('#' + ind).val(val).trigger('change');
                });
            },
            cleanData: function () {
                Room.data = {};
                $('#test-rooms span.modal-span-error').remove()
                $('#rooms-form')[0].reset();
            }
        }

        function triggerMonthly() {
            if ($('#room-monthly').is(':checked')) {
                $('.for-monthly').removeClass('d-none');
            } else {
                $('.for-monthly').addClass('d-none');
            }
        }

        $(function () {
            Room.myDataTable = $('#myDataTable').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: true,
                bLengthChange: true,
                bInfo: true,
                sDom: 'lrtip',
                ajax: "{{ route('admin.rooms.index') }}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'images', name: 'images'},
                    {data: 'seats', name: 'seats'},
                    {data: 'pin', name: 'pin'},
                    {data: 'number', name: 'number'},
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
                Room.myDataTable.search($(this).val()).draw();
            });

            $(document).on('input', '#number', function () {
                if ($(this).val()) {
                    if ($(this).val() < 0) $(this).val(0)
                    $(this).val(+$(this).val())
                }
            });

            $('#open-test-rooms').on('click', function () {
                Room.id = 0;
                Room.data = {};
                Room.imgToDelete = [];
                $('.for-add').removeClass('d-none');
                $('.for-edit').addClass('d-none');
                $.fancybox.open({
                    src: '#test-rooms',
                    afterShow: function () {
                        triggerMonthly();
                    },
                    afterClose: function () {
                        $(document).find('.ready-photo').remove();
                        $('.preview-wrap').hide();
                        $('.upload-wrap').show();
                    }
                });
                $(document).find('input.pac-target-input').removeAttr('placeholder');
            });

            $(document).on('click', '.edit-room', function () {
                Room.id = $(this).data('id');
                $('.for-add').addClass('d-none');
                $('.for-edit').removeClass('d-none');

                $.ajax({
                    url: '/dashboard/rooms/' + Room.id,
                    type: 'GET',
                    success: function (data) {
                        Room.data = data.room;
                        Room.fillData();
                        $.fancybox.open({
                            src: '#test-rooms',
                            afterShow: function () {
                                triggerMonthly();
                            },
                            afterClose: function () {
                                Room.cleanData();
                                Room.imgToDelete = [];
                                $(document).find('.ready-photo').remove();
                                $('#room-status').removeAttr('checked')
                                $('#room-monthly').removeAttr('checked')
                                $('.preview-wrap').hide();
                                $('.upload-wrap').show();
                            }
                        });
                        $(document).find('input.pac-target-input').removeAttr('placeholder');
                    },
                    error: function () {
                        alert("{{ __('Something went wrong.') }}")
                    }
                });
            });

            $(document).on('change', '#room-monthly', function () {
                triggerMonthly();
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
