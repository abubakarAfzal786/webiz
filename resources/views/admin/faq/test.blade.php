@extends('layouts.app_new', ['toolbar_menu_items' => [
    ['name' => __('FAQ'), 'active' => true /*'href' => '/'*/],
]])

@push('toolbar-options')
    <div class="item">
        <label class="select-field">
            <span class="name">{{ __('Categories') }}:</span>
            <select id="category-select">
                <option value="">{{ __('All') }}</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </label>
    </div>
    <div class="item">
        <a href="{{ route('admin.faq-category.index') }}" class="main-btn yellow-blank">{{ __('Categories') }}</a>
    </div>
    <div class="item left-border">
        <a href="{{ route('admin.faq.create') }}" class="main-btn yellow-blank">{{ __('Add new') }}</a>
    </div>
@endpush

@section('content')
    <div class="data col-12">
        <div class="table-intro">
            <label class="search-field">
                <input type="text" placeholder="{{ __('Search FAQ') }}" id="search-box">
                <button type="button"><span class="icon-search"></span></button>
            </label>
            <div class="total">
                <p>{{ __('FAQ Quantity') }}: <span>{{ $faq_count }}</span></p>
            </div>
        </div>
        <div class="data-bg">
            <div class="faq-list">
                <ul id="data-holder">
                    @include('admin.faq._item', ['data' => $data])
                </ul>
                <b id="no-data"
                   style="display: {{ $data->count() ? 'none' : '' }}">{{ __('No matching records found') }}</b>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $(document).on('click', '.delete-swal', function () {
                let item_id = $(this).data('id');
                let to_delete = $(this).closest('li');

                if (confirm("Are you sure?")) {
                    $.ajax({
                        url: '/dashboard/faq/' + item_id,
                        type: 'DELETE',
                        success: function () {
                            if ($('#data-holder').find('li').length < 2) {
                                window.location.reload();
                            } else {
                                to_delete.remove();
                            }
                        },
                        error: function () {
                            alert("{{ __('Something went wrong.') }}")
                        }
                    });
                }
            });

            $search_box = $('#search-box');
            $category_select = $('#category-select');
            $no_data = $('#no-data');

            $category_select.change(function () {
                searchAjax();
            });

            $search_box.doneTyping(function () {
                searchAjax();
            });

            let searchAjax = function () {
                $.ajax({
                    url: '{{ route('admin.faq.index') }}',
                    type: 'GET',
                    data: {
                        search: $search_box.val(),
                        category_id: $category_select.val(),
                    },
                    success: function (data) {
                        $('#data-holder').html(data.html);
                        if (data.html) {
                            $no_data.hide();
                        } else {
                            $no_data.show();
                        }
                    },
                    error: function (e) {
                        console.log(e.message);
                    }
                });
            }
        });
    </script>
@endpush
