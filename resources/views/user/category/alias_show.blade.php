@extends('user.layouts.app')
@section('title', 'Kirtanavali')

@section('style')
    <style>
        /* Global variables for theme support */
        :root {
            --primary-color: #bf7a1f;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #212529;
            --border-color: #d7861b;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        /* Dark theme variables */
        [data-theme="dark"] {
            --bg-color: #212529;
            --card-bg: #2c3034;
            --text-color: #f8f9fa;
            --shadow-color: rgba(0, 0, 0, 0.3);
        }

        /* Navbar-specific overrides to prevent shrinking */
        .navbar .nav-link i {
            font-size: 1.25rem !important;
        }

        .navbar .dropdown-toggle::after {
            display: inline-block !important;
        }

        /* Song container styles */
        .song-container {
            max-width: 70%;
            margin: 0 auto;
            background-color: var(--card-bg);
            padding: 25px;
            padding-top: 0px;
            border-radius: 0;
            box-shadow: 0 4px 15px var(--shadow-color);
            min-height: calc(100vh - 60px);
            position: relative;
        }

        .search-container {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: var(--card-bg);
            padding-bottom: 20px;
            padding-top: 15px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        /* No results message styling */
        .no-results {
            text-align: center;
            padding: 30px 20px;
            color: var(--text-color);
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 150px;
            border-bottom: none !important;
        }

        .no-results div {
            opacity: 0.7;
            font-weight: 500;
        }

        .search-box {
            width: 70%;
            margin-top: 20px;
            padding: 15px;
            border: 2px solid var(--border-color);
            border-radius: 25px;
            font-size: 16px;
            outline: none;
            background-color: var(--card-bg);
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .search-box:focus {
            box-shadow: 0 0 8px rgba(215, 134, 27, 0.4);
        }

        .song-list {
            list-style: none;
            padding: 0;
            margin-top: 20px;
            height: calc(100vh - 180px);
            overflow-y: auto;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            scrollbar-width: none;
            /* Firefox */
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .song-list::-webkit-scrollbar {
            display: none;
        }

        .song-list li {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            font-size: 25px;
            transition: background-color 0.2s ease;
            text-align: center;
            position: relative;
        }

        .song-list li a {
            text-decoration: none;
            font-weight: 500;
            color: var(--text-color);
            display: block;
        }

        .song-list li:hover {
            background: rgba(215, 134, 27, 0.15);
        }

        .loading {
            text-align: center;
            padding: 15px;
            display: none;
            color: var(--text-color);
        }

        /* Pad count badge styles */
        .pad-count {
            display: inline-block;
            margin-left: 10px;
            background-color: rgba(215, 134, 27, 0.3);
            color: var(--text-color);
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            vertical-align: middle;
        }

        .song-title-container {
            position: relative;
            padding-right: 70px;
            /* Make space for the counter */
            margin-bottom: 1.5rem;
        }

        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .pad-count {
                font-size: 14px;
                padding: 2px 8px;
                margin-left: 8px;
            }

            .song-title-container {
                padding-right: 60px;
            }

            .container {
                transform: translateY(-5px);
            }

            .song-container {
                max-width: 100%;
                padding: 15px;
            }

            .search-box {
                width: 90%;
                margin-top: 0px;
            }

            .song-list li {
                font-size: 20px;
                padding: 15px;
            }

            .song-list li a {
                font-weight: 500;
            }

            .pad-count {
                font-size: 14px;
                padding: 4px 10px;
                right: 10px;
                background-color: rgba(215, 134, 27, 0.4);
            }
        }

        .search-container {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: var(--card-bg);
            padding-bottom: 20px;
            padding-top: 15px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .search-box {
            width: 70%;
            padding: 15px;
            border: 2px solid var(--border-color);
            border-radius: 25px;
            font-size: 16px;
            outline: none;
            background-color: var(--card-bg);
            color: var(--text-color);
            transition: all 0.3s ease;
        }
    </style>
@endsection

@section('content')
    @include('user.layouts.catbar')
    <div class="song-container">
        <div class="search-container">
            <input type="text" id="search" class="search-box" placeholder="{{ __('Search Kirtan...') }}">
            <input type="hidden" id="searchQueryHolder" value="">
        </div>

        <ul id="songsList" class="song-list"></ul>

        <div id="loading" class="loading">Loading...</div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let page = 1;
            let isLoading = false;
            let searchQuery = '';
            let hasMorePages = true;
            let searchTimeout;

            // Configuration
            const config = {
                ajaxUrl: '{{ route('user.categories.aliasShow', $category->alias) }}',
                categoryAlias: '{{ $category->alias }}',
                searchDelay: 300,
                loadThreshold: 100
            };

            function showLoading() {
                $('#loading').show();
                isLoading = true;
            }

            function hideLoading() {
                $('#loading').hide();
                isLoading = false;
            }

            function showNoResults() {
                $('#songsList').html(
                    '<li class="no-results"><div>{{ __('No results found') }}</div></li>'
                );
            }

            function buildSongUrl(songCode) {
                return `{{ route('user.categories.aliasShow', $category->alias) }}/${songCode}`;
            }

            function renderSong(song) {
                let currentPad = song.current_pad || 0;
                let totalPads = song.total_pads || 0;
                let padInfo = '';

                if (totalPads > 0) {
                    padInfo = `<span class="pad-count">${currentPad} / ${totalPads}</span>`;
                }

                return `
            <li>
                <a href="${buildSongUrl(song.vachnamrut_code)}">
                    ${song.title || song.title_en || 'Untitled'}
                    ${padInfo}
                </a>
            </li>
        `;
            }

            function loadSongs(reset = false) {
                if (isLoading || (!hasMorePages && !reset)) {
                    return;
                }

                if (reset) {
                    page = 1;
                    hasMorePages = true;
                    $('#songsList').empty();
                }

                showLoading();

                // Prepare AJAX data
                const ajaxData = {
                    page: page,
                    search: searchQuery.trim(),
                    _token: $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
                };

                $.ajax({
                    url: config.ajaxUrl,
                    type: 'GET',
                    data: ajaxData,
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    timeout: 30000,
                    success: function(response) {
                        hideLoading();

                        if (!response.success) {
                            console.error('Server returned error:', response.message);
                            if (page === 1) {
                                showNoResults();
                            }
                            return;
                        }

                        // Handle empty results on first page
                        if (page === 1 && (!response.songs || response.songs.length === 0)) {
                            showNoResults();
                            hasMorePages = false;
                            return;
                        }

                        // Render songs
                        if (response.songs && response.songs.length > 0) {
                            response.songs.forEach(song => {
                                $('#songsList').append(renderSong(song));
                            });

                            // Update pagination info
                            hasMorePages = response.pagination.has_more_pages;
                            page++;
                        } else {
                            hasMorePages = false;
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.error('AJAX Error:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText
                        });

                        if (page === 1) {
                            $('#songsList').html(
                                '<li class="no-results"><div>{{ __('Error loading songs. Please try again.') }}</div></li>'
                            );
                        }
                    }
                });
            }

            function performSearch() {
                const newQuery = $('#search').val().trim();
                if (newQuery !== searchQuery) {
                    searchQuery = newQuery;
                    $('#searchQueryHolder').val(searchQuery);
                    loadSongs(true); // Reset and load
                }
            }

            // Initialize
            loadSongs();

            // Search with debouncing
            $('#search').on('input keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, config.searchDelay);
            });

            // Infinite scroll
            $('#songsList').on('scroll', function() {
                const scrollTop = $(this).scrollTop();
                const scrollHeight = this.scrollHeight;
                const clientHeight = $(this).innerHeight();

                if (scrollTop + clientHeight >= scrollHeight - config.loadThreshold) {
                    loadSongs();
                }
            });

            // Language change handler
            $(document).on('languageChanged', function() {
                searchQuery = $('#searchQueryHolder').val() || '';
                $('#search').val(searchQuery);
                loadSongs(true);
            });

            // Handle browser back/forward
            $(window).on('popstate', function() {
                const urlParams = new URLSearchParams(window.location.search);
                const searchParam = urlParams.get('search') || '';

                if (searchParam !== searchQuery) {
                    searchQuery = searchParam;
                    $('#search').val(searchQuery);
                    $('#searchQueryHolder').val(searchQuery);
                    loadSongs(true);
                }
            });
        });
    </script>
@endsection
