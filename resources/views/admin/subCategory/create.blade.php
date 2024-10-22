@extends('admin.layouts.app')
@section('title', __('Create Sub Category'))
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Add New Sub Category') }}</h3>
    <form action="{{ route('admin.subCategories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="category_code">{{ __('Category') }}</label>
            <select class="form-control select2" id="category_code" name="category_code[]" multiple="multiple"
                data-placeholder="{{ __('Select Categories') }}">
                @foreach ($categories as $category)
                    <option value="{{ $category->category_code }}">
                        {{ $category->category_en }} ({{ $category->category_gu }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="category_en">{{ __('English Sub Category') }}</label>
            <input type="text" class="form-control id="sub_category_en" name="sub_category_en"
                placeholder="{{ __('Enter English Sub Category') }}" required>
        </div>

        <div class="form-group">
            <label for="category_gu">{{ __('Gujarati Sub Category') }}</label>
            <input type="text" class="form-control" id="sub_category_gu"
                placeholder="{{ __('Enter Gujarati Sub Category') }}" name="sub_category_gu">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <a href="{{ route('admin.subCategories.index') }}" class="btn btn-secondary ml-2">{{ __('Cancel') }}</a>
    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select Categories',
                allowClear: true
            });
        });
    </script>
@endsection
