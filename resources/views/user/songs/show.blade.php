@extends('user.layouts.app')
@section('title', __('Kirtan') . ' - ' . $song->{'title_' . app()->getLocale()})

@section('style')
    <style>
        :root {
            --primary-color: #d7861b;
            --text-color: #333;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --border-color: #ddd;
            --tab-hover: #f5f5f5;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --text-color: #f8f9fa;
            --bg-color: #212529;
            --card-bg: #2c3034;
            --border-color: #495057;
            --tab-hover: #343a40;
            --shadow-color: rgba(0, 0, 0, 0.3);
        }

        .container-fluid {
            padding: var(--spacing);
            max-width: 1200px;
            margin: 0 auto;
            background-color: var(--bg-color);
        }

        .song-title {
            padding-top: 4rem;
            font-size: 2rem;
            color: var(--text-color);
            margin: 1.5rem 0;
            text-align: center;
            font-weight: 600;
        }

        #songTab {
            padding: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            border: none;
            margin-bottom: 1.5rem;
            justify-content: center;
        }

        .nav-item {
            flex: 0 1 auto;
        }

        #padBtn {
            padding: 12px 24px;
            border-radius: 8px;
            color: var(--text-color);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            margin: 4px;
            font-size: 16px;
            text-align: center;
            min-width: 120px;
            display: block;
            position: relative;
            overflow: hidden;
            background-color: var(--card-bg);
        }

        #padBtn:hover {
            background-color: var(--tab-hover);
            color: var(--text-color);
        }

        #padBtn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .tab-content {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 6px var(--shadow-color);
        }

        .song-content {
            max-width: 800px;
            margin: 0 auto;
            font-size: 16px;
            color: var(--text-color);
        }

        .lyrics {
            white-space: pre-line;
            text-align: center;
            padding: 16px;
            font-size: 24px;
            line-height: normal;
            color: var(--text-color);
        }

        .lyrics br {
            line-height: 8px;
            display: block;
            content: "";
        }

        .lyrics p {
            margin: 0;
            padding: 0;
            line-height: 20px;
            color: var(--text-color);
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 8px;
            }

            .song-title {
                padding-top: 12px;
                font-size: 24px;
                margin: 10px 0;
                line-height: 33px;
            }

            .lyrics {
                line-height: 28px;
            }

            #songTab {
                gap: 4px;
                flex-direction: row;
                width: 100%;
                display: flex;
                gap: 2px;
                padding: 8px;
            }

            .nav-item {
                flex: 0 0 calc(25% - 4px);
            }

            #padBtn {
                padding: 6px 4px;
                font-size: 14px;
                width: 100%;
                min-width: auto;
            }

            #padBtn:hover {
                color: var(--text-color);
                opacity: 0.8;
            }

            .tab-content {
                padding: 16px;
            }

            .song-content {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            #songTab {
                flex-direction: row;
                width: 100%;
            }

            .nav-item {
                width: 30%;
            }
        }

        /* Additional Dark Mode Specific Styles */
        [data-theme="dark"] .nav-link {
            color: var(--text-color);
        }

        [data-theme="dark"] .nav-link:hover {
            border-color: var(--primary-color);
        }

        [data-theme="dark"] .tab-content {
            border: 1px solid var(--border-color);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mb-3">
        <h1 class="song-title">{{ $song->{'title_' . app()->getLocale()} }}</h1>

        <ul class="nav nav-tabs" id="songTab" role="tablist">
            @foreach ($songsInPlaylists as $index => $playlistSong)
                <li class="nav-item" role="presentation">
                    <a id="padBtn" class="nav-link {{ $playlistSong->song_code == $song->song_code ? 'active' : '' }}"
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

                    <div class="song-content">
                        <!-- <h2 class="song-title">{{ $playlistSong->{'title_' . app()->getLocale()} }}</h2> -->
                        <a href="{{ route('user.contact.edit', $playlistSong->song_code) }}"><i class="fas fa-regular fa-flag"></i></a>
                        <div class="lyrics">
                            {!! nl2br($playlistSong->{'lyrics_' . app()->getLocale()}) !!}
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($songsInPlaylists->isEmpty())
                <div class="tab-pane fade show active" id="noPad" role="tabpanel" aria-labelledby="tab-noPad">
                    <div class="song-content">
                        <div class="lyrics">
                            {!! nl2br($song->{'lyrics_' . app()->getLocale()}) !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    </script>
@endsection
