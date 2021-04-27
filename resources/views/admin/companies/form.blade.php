@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div class="card-header">{{ isset($company) ? __('Edit') : __('Create') }} {{ __('Company') }}</div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data"
                          action="{{ isset($company) ? route('admin.companies.update', $company) : route('admin.companies.store') }}">
                        @csrf
                        @isset($company)
                            @method('PUT')
                        @endisset

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name">{{ __('Name') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="name" type="text" placeholder="{{ __('Name') }}"
                                       name="name" required
                                       value="{{ old('name', isset($company) ? $company->name : null) }}">
                                @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="balance">{{ __('Starting Balance') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="balance" type="number" min="0" step="0.1"
                                       placeholder="{{ __('Starting Balance') }}" name="balance"
                                       value="{{ old('balance', isset($company) ? $company->balance : 0) }}">
                                @error('balance')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">{{ __('Logo') }}</label>
                            <div class="col-sm-10">
                                @if(isset($company) && $company->logo_url)
                                    <img class="img-thumbnail p-1 col-md-3 col-sm-6" src="{{ $company->logo_url }}"
                                         alt="">
                                @endif
                                <input type="file" class="form-control mt-2 p-1" name="logo" placeholder="logo">
                                @error('logo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="expiration_date">{{ __('Expiration Date') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="expiration_date" type="datetime-local" name="expiration_date"
                                       value="{{ old('expiration_date', isset($company) && $company->expiration_date ? $company->toDateTimeLocal('expiration_date', true) : null) }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($company) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($company) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
