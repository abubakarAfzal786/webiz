<div class="modal-wrap" id="test-rooms">
    <div class="go-back" data-fancybox-close>
        <button type="button"><i class="icon-back"></i>{{ __('Back to rooms') }}</button>
    </div>
    <div class="content">
        <div class="data">
            <div class="scroll-wrap">
                <div class="modal-title with-border">
                    <p class="for-add">{{ __('Add room') }}</p>
                    <p class="for-edit d-none">{{ __('Edit room') }}</p>
                </div>
                <div class="data-content room-options">
                    <div class="add-new">
                        <form action="" id="rooms-form">
                            <div class="row">
                                <div class="item col-12">
                                    <span class="name">{{ __('Name') }}</span>
                                    <label class="text-option">
                                <span class="label-wrap">
                                <input id="name" type="text" name="name" class="placeholder-effect" required>
                                <span class="placeholder">{{ __('Name') }}</span>
                                </span>
                                    </label>
                                </div>
                                <div class="item col-md-6 col-sm-12">
                                    <span class="name">{{ __('Price') }}</span>
                                    <label class="text-option">
                                <span class="label-wrap">
                                <input class="placeholder-effect" id="price" type="number" min="0" step="0.1"
                                       name="price">
                                <span class="placeholder">{{ __('Price') }}</span>
                                </span>
                                    </label>
                                </div>
                                <div class="item col-md-6 col-sm-12">
                                    <span class="name">{{ __('Number of seats') }}</span>
                                    <label class="text-option">
                                <span class="label-wrap">
                                <input class="placeholder-effect" id="seats" type="number" min="0" step="1"
                                       name="seats">
                                <span class="placeholder">{{ __('Number of seats') }}</span>
                                </span>
                                    </label>
                                </div>

                                <div class="item col-12">
                                    <span class="name">{{ __('Type') }}</span>
                                    <label class="text-option">
                                <span class="label-wrap">
                                <span class="select">
                                    <select class="placeholder-effect" name="type_id" id="type_id" required>
                                        <option disabled selected hidden> </option>

                                        @foreach($types as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="placeholder">{{ __('Type') }}</span>
                                </span>
                                </span>
                                    </label>
                                </div>

                                <div class="item col-12">
                                    <span class="name">{{ __('Facilities') }}</span>
                                    @foreach($facilities as $facility)
                                        <label class="checkbox-option">
                                            <input type="checkbox" name="facilities[]" id="facility_{{ $facility->id }}"
                                                   value="{{ $facility->id }}">
                                            <span class="option">
                                            {{ $facility->name }}
                                                @if($facility->icon)
                                                    <i class="ml-1 {{ $facility->icon }}"></i>
                                                @endif
                                        </span>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="item col-12">
                                    <span class="name">{{ __('Overview') }}</span>
                                    <label class="text-option">
                                <span class="label-wrap">
                                <textarea placeholder="{{ __('Overview text') }}" id="overview" type="text"
                                          name="overview" required></textarea>
                                </span>
                                    </label>
                                </div>
                                <div class="item col-12">
                                    <span class="name">{{ __('Location') }}</span>
                                    <label class="text-option">
                                <span class="label-wrap">
                                    <input class="placeholder-effect" id="location" type="text" name="location"
                                           required>
                                <span class="placeholder">{{ __('Address') }}</span>
                                </span>
                                        <span class="icon-location"></span>
                                    </label>
                                </div>

                                <div class="item col-md-6 col-sm-12">
                                    <span class="name">{{ __('Wi-Fi SSID') }}</span>
                                    <label class="text-option">
                                <span class="label-wrap">
                                <input id="wifi_ssid" type="text" name="wifi_ssid" class="placeholder-effect">
                                <span class="placeholder">{{ __('Wi-Fi SSID') }}</span>
                                </span>
                                    </label>
                                </div>

                                <div class="item col-md-6 col-sm-12">
                                    <span class="name">{{ __('Wi-Fi Password') }}</span>
                                    <label class="text-option">
                                <span class="label-wrap">
                                <input id="wifi_pass" type="text" name="wifi_pass" class="placeholder-effect">
                                <span class="placeholder">{{ __('Wi-Fi Password') }}</span>
                                </span>
                                    </label>
                                </div>

                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lon" id="lon">

                                <div class="item col-12">
                                    <span class="name">{{ __('Upload photos') }}</span>
                                    <div class="photo-upload">
                                        <div class="upload-item">
                                            <div class="upload-wrap">
                                                <div class="upload">
                                                    <label class="file">
                                                        <input type="file" accept="image/*" multiple
                                                               name="images_input[]">
                                                    </label>
                                                    <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do
                                                        amet sint. Velit officia consequat duis enim velit mollit.</p>
                                                    <button class="main-btn gray-blank"
                                                            type="button">{{ __('Choose files') }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="preview-wrap">
                                                <div class="flex wrap">
                                                    <div class="photo-wrap">
                                                        <div class="add-extra">
                                                            <button type="button"><span
                                                                    class="icon-plus"></span>{{ __('Add image') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item col-12">
                                    <span class="name">{{ __('Room №') }}</span>
                                    <label class="text-option">
                                <span class="label-wrap">
                                <input class="placeholder-effect" id="number" type="number" min="0" step="1"
                                       name="number" pattern="[0-9]+">
                                <span class="placeholder">{{ __('Room №') }}</span>
                                </span>
                                    </label>
                                </div>

                                <div class="item col-12">
                                    <span class="name">{{ __('Monthly') }}</span>
                                    <label class="switcher-wrap">
                                        <input type="checkbox" id="room-monthly" name="monthly">
                                        <span class="switcher-condition">
                                            <span class="option">No</span>
                                            <span class="active-side"></span>
                                            <span class="option">Yes</span>
                                        </span>
                                    </label>
                                </div>

                                <div class="item col-12 for-monthly d-none">
                                    <span class="name">{{ __('Company') }}</span>
                                    <label class="text-option">
                                <span class="label-wrap">
                                <span class="select">
                                    <select class="placeholder-effect" name="company_id" id="company_id">
                                        <option disabled selected hidden> </option>

                                        @foreach($companies as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="placeholder">{{ __('Company') }}</span>
                                </span>
                                </span>
                                    </label>
                                </div>

                                <div class="item col-12 for-edit d-none">
                                    <span class="name">{{ __('Status') }}</span>
                                    <label class="switcher-wrap">
                                        <input type="checkbox" id="room-status" name="status">
                                        <span class="switcher-condition">
                                            <span class="option">Block</span>
                                            <span class="active-side"></span>
                                            <span class="option">Active</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bottom-btn">
                    <button type="button" class="main-btn gray-blank" data-fancybox-close>{{ __('Cancel') }}</button>
                    <button type="button" class="for-add main-btn yellow-blank submit-rooms-form"
                            data-type="add">{{ __('Create') }}</button>
                    <button type="button" class="for-edit d-none main-btn yellow-blank submit-rooms-form"
                            data-type="edit">{{ __('Update') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function () {
            $(document).on('click', '.submit-rooms-form', function () {
                let dataForm = new FormData($('#rooms-form')[0]);
                let isEdit = $(this).data('type') === 'edit' && Room.id;
                let images64 = $(document).find('.photo-wrap img');

                if (isEdit) dataForm.append('_method', 'put');

                for (let i = 0; i < images64.length; i++) {
                    if (!$(images64[i]).attr('data-id')) {
                        dataForm.append('images[]', dataURLtoFile($(images64[i]).attr('src'), 'tmp' + Math.random().toString(36).substring(5) + '.png'))
                    }
                }

                dataForm.append('images_to_delete', Room.imgToDelete);

                $.ajax({
                    url: isEdit ? ("/dashboard/rooms/" + Room.id) : "{{ route('admin.rooms.store')}}",
                    method: 'post',
                    processData: false,
                    contentType: false,
                    data: dataForm,
                    success: function (response) {
                        if (response.success) {
                            Room.myDataTable.draw();
                            $.fancybox.close({src: '#test-rooms'});
                            $.fancybox.open({src: '#test-notification'});
                        }
                    },
                    error: function (data) {
                        let errors = data.responseJSON;
                        if (errors !== undefined) {
                            $.each(errors.errors, function (key, value) {
                                $('[name="' + key + '"]').closest('.item ').append('<span class="modal-span-error">' + value[0] + '</span>');
                            });
                        }

                        if ($(document).find('.modal-span-error').length) {
                            $('.scroll-wrap').animate({
                                scrollTop: $(document).find('.modal-span-error').first().offset().top
                            }, 1000);
                        } else {
                            alert("{{ __('Something went wrong.') }}")
                        }
                    },
                    beforeSend: function () {
                        $('span.modal-span-error').remove()
                    }
                });
            })
        });
    </script>
@endpush
