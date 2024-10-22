@extends('admin.layouts.app')
@section('title', __('Edit Playlist'))
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Edit Playlist') }}</h3>
    <form action="{{ route('admin.playlists.update', $playlist->playlist_code) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="playlist_en">{{ __('English Playlist') }}</label>
            <input type="text" class="form-control id="playlist_en" name="playlist_en"
                placeholder="{{ __('Enter English Playlist') }}" value="{{ old('title_en', $playlist->playlist_en) }}"
                required>
        </div>
        <div class="form-group">
            <label for="playlist_gu">{{ __('Gujarati Playlist') }}</label>
            <input type="text" class="form-control id="playlist_gu" name="playlist_gu"
                placeholder="{{ __('Enter Gujarati Playlist') }}" value="{{ old('title_en', $playlist->playlist_gu) }}"
                required>
        </div>

        {{-- <div class="form-group">
            <label for="song_code">Song</label>
            <select class="form-control select2" id="song_code" name="song_code[]" multiple="multiple"
                data-placeholder="Select Songs">
                @foreach ($songs as $song)
                    <option value="{{ $song->song_code }}">
                        {{ $song->title_en }}
                    </option>
                @endforeach
            </select>
            @error('song_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div> --}}

        <div class="form-group">
            <label for="song_code">{{ __('Song') }}</label>
            <select class="form-control select2" id="song_code" name="song_code[]" multiple="multiple"
                data-placeholder="{{ __('Select Songs') }}">
                @foreach ($allSongs as $song)
                    <option value="{{ $song->song_code }}"
                        {{ $songs->contains('song_code', $song->song_code) ? 'selected' : '' }}>
                        {{ $song->title_en }} ({{ $song->title_gu }})
                    </option>
                @endforeach
            </select>
            @error('song_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        <a href="{{ route('admin.playlists.index') }}" class="btn btn-secondary ml-2">{{ __('Cancel') }}</a>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: '{{ __('Select Songs') }}',
                allowClear: true
            });
        });
    </script>
@endsection
