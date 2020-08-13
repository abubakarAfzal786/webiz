@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($faq) ? route('admin.faq.update', $faq) : route('admin.faq.store') }}">
                        @csrf
                        @isset($faq)
                            @method('PUT')
                        @endisset
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="question">{{ __('Question') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="question" type="text" placeholder="{{ __('Question') }}"
                                       name="question"
                                       required value="{{ old('question', isset($faq) ? $faq->question : null) }}">
                                @error('question')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="answer">{{ __('Answer') }}</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="answer" type="text" placeholder="{{ __('Answer') }}"
                                          name="answer"
                                          required>{{ old('answer', isset($faq) ? $faq->answer : null) }}</textarea>
                                @error('answer')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="category_id">{{ __('Category') }}</label>
                            <div class="col-sm-10">
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option></option>
                                    @foreach($categories as $key => $value)
                                        <option value="{{ $key }}" {{ old('category_id', isset($faq) ? $faq->category_id : null) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($faq) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($faq) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
