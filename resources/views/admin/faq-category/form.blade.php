@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div class="card-header">{{ isset($member) ? __('Edit') : __('Create') }} {{ __('FAQ Category') }}</div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($faqCategory) ? route('admin.faq-category.update', $faqCategory) : route('admin.faq-category.store') }}">
                        @csrf
                        @isset($faqCategory)
                            @method('PUT')
                        @endisset
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name">{{ __('Name') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="name" type="text" placeholder="{{ __('Name') }}"
                                       name="name"
                                       required value="{{ old('name', isset($faqCategory) ? $faqCategory->name : null) }}">
                                @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($faqCategory) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($faqCategory) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
