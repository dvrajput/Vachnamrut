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
            // Initialize select2
            $('.select2').select2({
                placeholder: 'Select Songs',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.songSearch') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // Search term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(song) {
                                return {
                                    id: song.song_code,
                                    text: song.title_en,
                                    is_used: '{{ json_encode($existingSongs) }}'.includes(song
                                        .song_code)
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1 // Minimum characters to start search
            });

            // Highlight already used songs in grey
            $('.select2').on('select2:select', function(e) {
                var data = e.params.data;
                if (data.is_used) {
                    $(this).find('option[value="' + data.id + '"]').css('color', 'grey');
                }
            });
        });
    </script>
@endsection
