@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($member) ? route('admin.members.update', $member) : route('admin.members.store') }}">
                        @csrf
                        @isset($member)
                            @method('PUT')
                        @endisset

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name">{{ __('Name') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="name" type="text" placeholder="{{ __('Name') }}"
                                       name="name" required
                                       value="{{ old('name', isset($member) ? $member->name : null) }}">
                                @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="email">{{ __('E-mail') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="email" type="email" placeholder="{{ __('E-mail') }}"
                                       name="email" required
                                       value="{{ old('email', isset($member) ? $member->email : null) }}">
                                @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="phone">{{ __('Phone Number') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="phone" type="text"
                                       placeholder="{{ __('Phone Number') }}" name="phone"
                                       required value="{{ old('phone', isset($member) ? $member->phone : null) }}">
                                @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="balance">{{ __('Starting Balance') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="balance" type="number" min="0" step="0.1"
                                       placeholder="{{ __('Starting Balance') }}" name="balance"
                                       value="{{ old('balance', isset($member) ? $member->balance : 0) }}">
                                @error('balance')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($member) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($member) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
