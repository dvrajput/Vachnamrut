@extends('admin.layouts.app')
@section('title', __('Create Playlist'))

@section('content')
    <h3 class="mt-4 mb-4">{{ __('Add New Playlist') }}</h3>
    <form action="{{ route('admin.playlists.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="playlist_en">{{ __('English Playlist') }}</label>
            <input type="text" class="form-control" id="playlist_en" name="playlist_en"
                placeholder="{{ __('Enter English Playlist') }}" required>
        </div>
        <div class="form-group">
            <label for="playlist_gu">{{ __('Gujarati Playlist') }}</label>
            <input type="text" class="form-control" id="playlist_gu" name="playlist_gu"
                placeholder="{{ __('Enter Gujarati Playlist') }}" required>
        </div>

        <div class="form-group">
            <label for="song_code">{{ __('Songs') }}</label>
            <select class="form-control select2" id="song_code" name="song_code[]" multiple="multiple"
                data-placeholder="{{ __('Select Songs') }}">
                <!-- Songs will be loaded via AJAX -->
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
            // Initialize select2 with AJAX support
            $('#song_code').select2({
                placeholder: 'Select Songs',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.playlists.create') }}', // The route for fetching songs
                    dataType: 'json',
                    delay: 250, // Delay in milliseconds between typing and sending the request
                    data: function (params) {
                        return {
                            q: params.term // Send the search term as query parameter
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (song) {
                                return {
                                    id: song.song_code,
                                    text: song.title_en + '('+song.song_code+')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
