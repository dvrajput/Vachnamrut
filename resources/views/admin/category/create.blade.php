@extends('admin.layouts.app')
@section('title', __('Create Category'))
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Add New Category') }}</h3>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="category_en">{{ __('English Category') }}</label>
            <input type="text" class="form-control id="category_en" name="category_en" placeholder="{{__('Enter English Title')}}"
                required>
        </div>

        <div class="form-group">
            <label for="category_gu">{{ __('Gujarati Category') }}</label>
            <input type="text" class="form-control" id="category_gu" name="category_gu" placeholder="{{__('Enter English Title')}}"
                required>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ml-2">{{ __('Cancel') }}</a>
    </form>
@endsection
