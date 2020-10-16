<div class="modal-wrap" id="test-rooms">
    <div class="go-back" data-fancybox-close>
        <button type="button"><i class="icon-back"></i>{{ __('Back to rooms') }}</button>
    </div>
    <div class="content">
        <div class="data">
            <div class="scroll-wrap">
                <div class="modal-title with-border">
                    <p>{{ __('Add room') }}</p>
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
                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lon" id="lon">
                                <div class="item col-12">
                                    <span class="name">{{ __('Upload photos') }}</span>
                                    <div class="photo-upload">
                                        <div class="upload-item">
                                            <div class="upload-wrap">
                                                <div class="upload">
                                                    <label class="file">
                                                        <input type="file" accept="image/*" multiple name="images[]">
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
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bottom-btn">
                    <button type="button" class="main-btn gray-blank" data-fancybox-close>{{ __('Cancel') }}</button>
                    <button type="button" class="main-btn yellow-blank"
                            id="submit-rooms-form">{{ __('Create') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function () {
        $('#submit-rooms-form').click(function () {
            let dataForm = new FormData($('#rooms-form')[0]);
            $.ajax({
                url: "{{ route('admin.rooms.store')}}",
                method: 'post',
                processData: false,
                contentType: false,
                data: dataForm,
                success: function (response) {
                    if (response.success) {
                        $.fancybox.open({
                            src: '#test-notification',
                            afterClose: function () {
                                location.reload();
                            }
                        });
                    }
                },
                error: function (data) {
                    let errors = data.responseJSON;
                    $.each(errors.errors, function (key, value) {
                        $('[name="' + key + '"]').closest('.item ').append('<span class="modal-span-error">' + value[0] + '</span>');
                    });

                    $('.scroll-wrap').animate({
                        scrollTop: $(document).find('.modal-span-error').first().offset().top
                    }, 1000);
                },
                beforeSend: function () {
                    $('span.modal-span-error').remove()
                }
            });
        })
    });
</script>
@endpush