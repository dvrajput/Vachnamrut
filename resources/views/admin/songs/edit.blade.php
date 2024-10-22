@extends('admin.layouts.app')
@section('title', 'Edit Song')
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Edit Song') }}</h3>
    <form action="{{ route('admin.songs.update', $song->song_code) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title_en">{{ __('English Title') }}</label>
                    <input type="text" class="form-control @error('title_en') is-invalid @enderror" id="title_en"
                        name="title_en" value="{{ old('title_en', $song->title_en) }}" required>
                    @error('title_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="lyrics_en">{{ __('English Lyrics') }}</label>
                    <textarea class="form-control @error('lyrics_en') is-invalid @enderror" id="lyrics_en" name="lyrics_en" rows="1"
                        required oninput="autoResize(this)">{{ old('lyrics_en', $song->lyrics_en) }}</textarea>
                    @error('lyrics_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title_gu">{{ __('Gujarati Title') }}</label>
                    <input type="text" class="form-control" id="title_gu" name="title_gu"
                        value="{{ old('title_gu', $song->title_gu) }}">
                </div>
                <div class="form-group">
                    <label for="lyrics_gu">{{ __('Gujarati Lyrics') }}</label>
                    <textarea class="form-control" id="lyrics_gu" name="lyrics_gu" rows="1" oninput="autoResize(this)">{{ old('lyrics_gu', $song->lyrics_gu) }}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="sub_category_code">{{ __('Sub Category') }}</label>
            <select class="form-control select2" id="sub_category_code" name="sub_category_code[]" multiple="multiple"
                data-placeholder="{{ __('Select Sub Categories') }}">
                @foreach ($allSubCategories as $category)
                    <option value="{{ $category->sub_category_code }}"
                        {{ $subCategories->contains('sub_category_code', $category->sub_category_code) ? 'selected' : '' }}>
                        {{ $category->sub_category_en }} ({{ $category->sub_category_gu }})
                    </option>
                @endforeach
            </select>
            @error('sub_category_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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

            autoResize(document.getElementById('lyrics_en'));
            autoResize(document.getElementById('lyrics_gu'));
        });

        function autoResize(textarea) {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = (textarea.scrollHeight) + 'px'; // Set to scroll height
        }
    </script>
@endsection
