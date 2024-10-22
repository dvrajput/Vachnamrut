@extends('admin.layouts.app')
@section('title', 'Create Song')
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Add New Song') }}</h3>
    <form action="{{ route('admin.songs.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title_en">{{ __('English Title') }}</label>
                    <input type="text" class="form-control" id="title_en" name="title_en"
                        placeholder="{{ __('Enter English Title') }}" required>
                </div>
                <div class="form-group">
                    <label for="lyrics_en">{{ __('English Lyrics') }}</label>
                    <textarea class="form-control @error('lyrics_en') is-invalid @enderror" id="lyrics_en" name="lyrics_en" rows="1"
                        placeholder="{{ __('Enter English Lyrics') }}" required oninput="autoResize(this)"></textarea>
                    @error('lyrics_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="title_gu">{{ __('Gujarati Title') }}</label>
                    <input type="text" class="form-control" id="title_gu" name="title_gu"
                        placeholder="{{ __('Enter Gujarati Title') }}" required>
                </div>
                <div class="form-group">
                    <label for="lyrics_gu">{{ __('Gujarati Lyrics') }}</label>
                    <textarea class="form-control" id="lyrics_gu" name="lyrics_gu" rows="1"
                        placeholder="{{ __('Enter Gujarati Lyrics') }}" required oninput="autoResize(this)"></textarea>
                </div>
            </div>
        </div>

        <div class="form-group mt-4">
            <label for="sub_category_code">{{ __('Sub Category') }}</label>
            <select class="form-control select2" id="sub_category_code" name="sub_category_code[]" multiple="multiple"
                data-placeholder="{{ __('Select Sub Categories') }}">
                @foreach ($subCategories as $scategory)
                    <option value="{{ $scategory->sub_category_code }}">
                        {{ $scategory->sub_category_en }} ({{ $scategory->sub_category_gu }})
                    </option>
                @endforeach
            </select>
            @error('sub_category_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <a href="{{ route('admin.songs.index') }}" class="btn btn-secondary ml-2">{{ __('Cancel') }}</a>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: '{{ __('Select Sub Categories') }}',
                allowClear: true
            });
        });

        function autoResize(textarea) {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = (textarea.scrollHeight) + 'px'; // Set to scroll height
        }
    </script>
@endsection
