@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div class="card-header">{{ isset($package) ? __('Edit') : __('Create') }} {{ __('Package') }}</div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($package) ? route('admin.packages.update', $package) : route('admin.packages.store') }}">
                        @csrf
                        @isset($package)
                            @method('PUT')
                        @endisset

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name">{{ __('Name') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="name" type="text" placeholder="{{ __('Name') }}"
                                       name="name" required
                                       value="{{ old('name', isset($package) ? $package->name : null) }}">
                                @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="privileges">{{ __('Privileges') }}</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="privileges" type="text"
                                          placeholder="{{ __('Privileges') }}" name="privileges" rows="4"
                                          required>{{ old('privileges', isset($package) ? $package->privileges : null) }}</textarea>
                                @error('privileges')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="price">{{ __('Price') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="price" type="number" min="0" step="0.1"
                                       placeholder="{{ __('Price') }}" name="price"
                                       value="{{ old('price', isset($package) ? $package->price : 0) }}">
                                @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($package) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($package) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('header-post-scripts')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            CKEDITOR.config.autoParagraph = false;
            CKEDITOR.replace('privileges');
        })
    </script>
@endpush
