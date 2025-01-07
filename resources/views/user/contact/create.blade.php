@extends('user.layouts.app')
@section('title', 'Kirtanavali')

@section('content')
    <h3 class="mt-4 mb-4">{{ __('Contact Us') }}</h3>
    <form action="{{ route('user.contact.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Enter Name') }}"
                autofocus required>
        </div>
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="{{ __('Enter Email') }}"
                required>
        </div>
        <div class="form-group">
            <label for="song_code">{{ __('Songs') }}</label>
            <select class="form-control select2" id="song_code" name="song_code"
                data-placeholder="{{ __('Select Songs') }}">
                <!-- Songs will be loaded via AJAX -->
            </select>
            @error('song_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="message">{{ __('Message') }}</label>
            <textarea class="form-control" id="message" name="message" rows="1" placeholder="{{ __('Enter Message') }}"
                required oninput="autoResize(this)"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <a href="{{ route('user.contact.index') }}" class="btn btn-secondary ml-2">{{ __('Cancel') }}</a>
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
                    url: '{{ route('user.contact.create') }}', // The route for fetching songs
                    dataType: 'json',
                    delay: 250, // Delay in milliseconds between typing and sending the request
                    data: function(params) {
                        return {
                            q: params.term // Send the search term as query parameter
                        };
                    },
                    processResults: function(data) {
                        // console.log(data);

                        return {
                            results: data.map(function(song) {
                                return {
                                    id: song.song_code,
                                    text: song.title_en + '(' + song.song_code + ')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });

        function autoResize(textarea) {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = (textarea.scrollHeight) + 'px'; // Set to scroll height
        }
    </script>
@endsection
