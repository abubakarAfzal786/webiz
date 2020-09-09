@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div class="card-header">{{ isset($review) ? __('Edit') : __('Create') }} {{ __('Review') }}</div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($review) ? route('admin.reviews.update', $review) : route('admin.reviews.store') }}">
                        @csrf
                        @isset($review)
                            @method('PUT')
                        @endisset

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="room_id">{{ __('Room') }}</label>
                            <div class="col-sm-10">
                                <select name="room_id" id="room_id" class="form-control" required>
                                    <option></option>
                                    @foreach($rooms as $key => $value)
                                        <option
                                            value="{{ $key }}" {{ old('room_id', isset($review) ? $review->room_id : null) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="member_id">{{ __('Member') }}</label>
                            <div class="col-sm-10">
                                <select name="member_id" id="member_id" class="form-control" required>
                                    <option></option>
                                    @foreach($members as $key => $value)
                                        <option
                                            value="{{ $key }}" {{ old('member_id', isset($review) ? $review->member_id : null) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="description">{{ __('Description') }}</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description" type="text"
                                          placeholder="{{ __('Description') }}" name="description"
                                          required>{{ old('description', isset($review) ? $review->description : null) }}</textarea>
                                @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="rate">{{ __('Rate') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="rate" type="number" min="0" max="5" step="0.1"
                                       placeholder="{{ __('Rate') }}" name="rate"
                                       value="{{ old('rate', isset($review) ? $review->rate : 0) }}">
                                @error('rate')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($review) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($review) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
