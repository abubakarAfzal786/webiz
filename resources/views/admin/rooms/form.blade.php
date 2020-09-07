@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div class="card-header">{{ isset($room) ? __('Edit') : __('Create') }} {{ __('Room') }}</div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data"
                          action="{{ isset($room) ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}">
                        @csrf
                        @isset($room)
                            @method('PUT')
                        @endisset
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name">{{ __('Name') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="name" type="text" placeholder="{{ __('Name') }}"
                                       name="name"
                                       required value="{{ old('name', isset($room) ? $room->name : null) }}">
                                @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="price">{{ __('Price') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="price" type="number" min="0" step="0.1"
                                       placeholder="{{ __('Price') }}" name="price"
                                       value="{{ old('p.rice', isset($room) ? $room->price : 0) }}">
                                @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="seats">{{ __('Seats') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="seats" type="number" min="0" step="1"
                                       placeholder="{{ __('Seats') }}" name="seats"
                                       value="{{ old('seats', isset($room) ? $room->seats : 0) }}">
                                @error('seats')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="overview">{{ __('Overview') }}</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="overview" type="text"
                                          placeholder="{{ __('Overview') }}"
                                          name="overview"
                                          required>{{ old('overview', isset($room) ? $room->overview : null) }}</textarea>
                                @error('overview')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">{{ __('Facilities') }}</label>
                            <div class="col-sm-10">
                                <div class="container-fluid">
                                    <div class="row">
                                        @foreach($facilities as $facility)
                                            <div class="form-check col-md-6 col-lg-4 mb-3">
                                                <input class="form-check-input" type="checkbox" name="facilities[]"
                                                       value="{{ $facility->id }}" id="facility_{{ $facility->id }}"
                                                @if(old('facilities'))
                                                    {{ in_array($facility->id, old('facilities')) ? 'checked' : '' }}
                                                    @else
                                                    {{ isset($roomFacilities) && in_array($facility->id, $roomFacilities) ? 'checked' : '' }}
                                                    @endif
                                                >
                                                <label class="form-check-label" for="facility_{{ $facility->id }}">
                                                    <span class="badge badge-secondary" role="button">
                                                        {{ $facility->name }}
                                                        @if($facility->icon)
                                                            <i class="ml-1 {{ $facility->icon }}"></i>
                                                        @endif
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('facilities.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('facilities')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="location">{{ __('Location') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="location" type="text" placeholder="{{ __('Location') }}"
                                       name="location"
                                       required value="{{ old('location', isset($room) ? $room->location : null) }}">
                                @error('location')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="type_id">{{ __('Type') }}</label>
                            <div class="col-sm-10">
                                <select name="type_id" id="type_id" class="form-control" required>
                                    <option></option>
                                    @foreach($types as $key => $value)
                                        <option value="{{ $key }}" {{ old('type_id', isset($room) ? $room->type_id : null) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @isset($room)
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="status">{{ __('Room Status') }}</label>
                                <div class="col-sm-10">
                                    <input id="status" type="checkbox" name="status"
                                        {{ old('status') ? 'checked' : (!old('_token') && isset($room) && $room->status ? 'checked' : '') }}>
                                    @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endisset

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">{{ __('Upload photos') }}</label>
                            <div class="col-sm-10">
                                @isset($room)
                                    @foreach($room->images as $photo)
                                        <img class="img-thumbnail" src="{{ $photo->url }}" alt="">
                                    @endforeach
                                @endisset
                                <input type="file" class="form-control mt-2 p-1" name="images[]" placeholder="images" multiple>
                                @error('images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="lat">
                        <input type="hidden" name="lon">

                        {{--                        TODO implement autocomplete with google --}}

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($room) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($room) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
