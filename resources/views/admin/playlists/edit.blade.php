@extends('admin.layouts.app')
@section('title', 'Edit Playlist')
@section('content')
    <h3 class="mt-4 mb-4">Edit Playlist</h3>
    <form action="{{ route('admin.playlists.update', $playlist->playlist_code) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="playlist_name">Title (English)</label>
            <input type="text" class="form-control id="playlist_name" name="playlist_name" placeholder="Enter Playlist Name"
                value="{{ old('title_en', $playlist->playlist_name) }}" required>
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
            <label for="song_code">Song</label>
            <select class="form-control select2" id="song_code" name="song_code[]" data-placeholder="Select Songs">
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
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.playlists.index') }}" class="btn btn-secondary ml-2">Cancel</a>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select Sub Categories',
                allowClear: true
            });
        });
    </script>
@endsection
