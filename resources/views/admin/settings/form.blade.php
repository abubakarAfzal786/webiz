@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div class="card-header">{{ isset($member) ? __('Edit') : __('Create') }} {{ __('Setting') }}</div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($setting) ? route('admin.settings.update', $setting) : route('admin.settings.store') }}">
                        @csrf
                        @isset($setting)
                            @method('PUT')
                        @endisset
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="key">{{ __('Key') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="key" type="text" placeholder="{{ __('Key') }}"
                                       name="key"
                                       required value="{{ old('key', isset($setting) ? $setting->key : null) }}">
                                @error('key')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="value">{{ __('Value') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="value" type="text" placeholder="{{ __('Value') }}"
                                       name="value"
                                       value="{{ old('value', isset($setting) ? $setting->value : null) }}">
                                @error('value')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="title">{{ __('Title') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="title" type="text" placeholder="{{ __('Title') }}"
                                       name="title"
                                       value="{{ old('title', isset($setting) ? $setting->title : null) }}">
                                @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="additional">{{ __('Additional') }}</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="additional" type="text"
                                          placeholder="{{ __('Additional') }}"
                                          name="additional"
                                >{{ old('additional', isset($faq) ? $faq->additional : null) }}</textarea>
                                @error('additional')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($setting) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($setting) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
