@extends('layouts.app')
@push('header-post-scripts')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-iconpicker.min.css') }}"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div
                    class="card-header">{{ isset($roomFacility) ? __('Edit') : __('Create') }} {{ __('Room Facility') }}</div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($roomFacility) ? route('admin.room-facility.update', $roomFacility) : route('admin.room-facility.store') }}">
                        @csrf
                        @isset($roomFacility)
                            @method('PUT')
                        @endisset
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name">{{ __('Name') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="name" type="text" placeholder="{{ __('Name') }}"
                                       name="name" required
                                       value="{{ old('name', isset($roomFacility) ? $roomFacility->name : null) }}">
                                @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="icon">{{ __('Icon') }}</label>

                            <div class="col-sm-10">
                                <button class="btn btn-secondary" role="iconpicker" name="icon"
                                        data-icon="{{ old('icon', isset($roomFacility) ? $roomFacility->icon : null) }}"></button>
                                @error('icon')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($roomFacility) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($roomFacility) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush
