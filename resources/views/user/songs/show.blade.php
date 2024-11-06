@extends('user.layouts.app')
@section('title', __('Kirtan') . ' - ' . $song->{'title_' . app()->getLocale()})

@section('style')
    <style>
        .container-fluid {
            padding: 20px;
        }

        h3 {
            margin-bottom: 20px;
            text-align: center;
        }

        .nav-tabs {
            margin-bottom: 20px;
        }

        .nav-link {
            color: #007bff;
        }

        .nav-link.active {
            background-color: #d7861b;
            color: white;
        }

        .tab-content {
            background-color: white;
            border: 1px solid #d7861b;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .display {
            text-align: center;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
        }

        @media (max-width: 768px) {
            .nav-tabs {
                flex-direction: column;
            }

            .nav-link {
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>{{ $song->{'title_' . app()->getLocale()} }}</h3>
        </div>

        <ul class="nav nav-tabs" id="songTab" role="tablist">
            @foreach ($songsInPlaylists as $index => $playlistSong)
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $playlistSong->song_code == $song->song_code ? 'active' : '' }}"
                        id="tab-{{ $playlistSong->song_code }}" href="{{ url('songs/' . $playlistSong->song_code) }}"
                        role="tab" aria-controls="content-{{ $playlistSong->song_code }}"
                        aria-selected="{{ $playlistSong->song_code == $song->song_code ? 'true' : 'false' }}">
                        {{ __('Pad') }} {{ $index + 1 }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="songTabContent">
            @foreach ($songsInPlaylists as $playlistSong)
                <div class="tab-pane fade {{ $playlistSong->song_code == $song->song_code ? 'show active' : '' }}"
                    id="content-{{ $playlistSong->song_code }}" role="tabpanel"
                    aria-labelledby="tab-{{ $playlistSong->song_code }}">

                    <div class="d-flex justify-content-between mb-3 mt-2">
                        <h3>{{ $playlistSong->{'title_' . app()->getLocale()} }}</h3>
                    </div>

                    <center>
                        <p>{!! nl2br($playlistSong->{'lyrics_' . app()->getLocale()}) !!}</p>
                    </center>
                </div>
            @endforeach

            @if ($songsInPlaylists->isEmpty())
                <div class="tab-pane fade show active" id="noPad" role="tabpanel" aria-labelledby="tab-noPad">
                    {{-- <h3>{{ __('Pad Not Added') }}</h3> --}}
                    <center>
                        <p>{!! nl2br($song->{'lyrics_' . app()->getLocale()}) !!}</p>
                        {{-- <p>{{ __('This song has not been added to any pad.') }}</p> --}}
                    </center>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // No need for tab switching logic since we're redirecting
        });
    </script>
@endsection
