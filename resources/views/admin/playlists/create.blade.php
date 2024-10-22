@extends('admin.layouts.app')
@section('title', __('Create Playlist'))
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Add New Playlist') }}</h3>
    <form action="{{ route('admin.playlists.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="playlist_en">{{ __('English Playlist') }}</label>
            <input type="text" class="form-control id="playlist_en" name="playlist_en"
                placeholder="{{ __('Enter English Playlist') }}" required>
        </div>
        <div class="form-group">
            <label for="playlist_gu">{{ __('Gujarati Playlist') }}</label>
            <input type="text" class="form-control id="playlist_gu" name="playlist_gu"
                placeholder="{{ __('Enter Gujarati Playlist') }}" required>
        </div>

        <div class="form-group">
            <label for="song_code">{{ __('Songs') }}</label>
            <select class="form-control select2" id="song_code" name="song_code[]" multiple="multiple"
                data-placeholder="{{ __('Select Songs') }}">
                @foreach ($songs as $song)
                    <option value="{{ $song->song_code }}">
                        {{ $song->title_en }}
                    </option>
                @endforeach
            </select>
            @error('song_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <a href="{{ route('admin.playlists.index') }}" class="btn btn-secondary ml-2">{{ __('Cancel') }}</a>
    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select Songs',
                allowClear: true
            });
        });
    </script>
@endsection
