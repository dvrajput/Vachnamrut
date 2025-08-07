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
            --hover-bg: rgba(215, 134, 27, 0.15);
        }

        /* Dark theme variables */
        [data-theme="dark"] {
            --bg-color: #212529;
            --card-bg: #2c3034;
            --text-color: #f8f9fa;
            --shadow-color: rgba(0, 0, 0, 0.3);
        }

        /* Navbar-specific overrides */
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
            padding: 25px 25px 0;
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
            padding: 15px 0 20px;
            display: flex;
            justify-content: center;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .search-box {
            width: 70%;
            padding: 15px 20px;
            border: 2px solid var(--border-color);
            border-radius: 25px;
            font-size: 16px;
            outline: none;
            background-color: var(--card-bg);
            color: var(--text-color);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .search-box:focus {
            box-shadow: 0 0 8px rgba(215, 134, 27, 0.4);
            border-color: var(--primary-color);
        }

        .search-box::placeholder {
            color: rgba(var(--text-color), 0.6);
        }

        .song-list {
            list-style: none;
            padding: 0;
            margin: 0;
            height: calc(100vh - 200px);
            overflow-y: auto;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            scrollbar-width: thin;
            scrollbar-color: var(--border-color) transparent;
        }

        .song-list::-webkit-scrollbar {
            width: 6px;
        }

        .song-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .song-list::-webkit-scrollbar-thumb {
            background-color: var(--border-color);
            border-radius: 3px;
        }

        .song-list li {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            font-size: 24px;
            transition: background-color 0.2s ease;
            text-align: center;
            position: relative;
        }

        .song-list li:last-child {
            border-bottom: none;
        }

        .song-list li a {
            text-decoration: none;
            font-weight: 500;
            color: var(--text-color);
            display: block;
            transition: color 0.2s ease;
        }

        .song-list li:hover {
            background: var(--hover-bg);
        }

        .song-list li:hover a {
            color: var(--primary-color);
        }

        /* Status messages */
        .status-message {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-color);
            font-size: 18px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 200px;
            opacity: 0.7;
        }

        .status-message i {
            font-size: 48px;
            margin-bottom: 15px;
            color: var(--border-color);
        }

        .loading {
            text-align: center;
            padding: 20px;
            display: none;
            color: var(--text-color);
            font-size: 16px;
        }

        .loading i {
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Pad count badge */
        .pad-count {
            display: inline-block;
            margin-left: 12px;
            background-color: rgba(215, 134, 27, 0.2);
            color: var(--text-color);
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 600;
            vertical-align: middle;
            border: 1px solid rgba(215, 134, 27, 0.3);
        }

        /* Error message */
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
            display: none;
        }

        [data-theme="dark"] .error-message {
            background-color: #2c1114;
            color: #f8d7da;
            border-color: #4a1e24;
        }

        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .song-container {
                max-width: 100%;
                padding: 15px 15px 0;
                min-height: calc(100vh - 50px);
            }

            .search-box {
                width: 95%;
                font-size: 14px;
                padding: 12px 16px;
            }

            .song-list {
                height: calc(100vh - 160px);
            }

            .song-list li {
                font-size: 18px;
                padding: 16px 12px;
            }

            .pad-count {
                font-size: 12px;
                padding: 3px 8px;
                margin-left: 8px;
            }

            .status-message {
                font-size: 16px;
                padding: 30px 15px;
                min-height: 150px;
            }

            .status-message i {
                font-size: 36px;
            }
        }

        @media (max-width: 480px) {
            .song-list li {
                font-size: 16px;
                padding: 14px 10px;
            }
        }
    </style>
@endsection

@section('content')
    @include('user.layouts.catbar')
    <div class="song-container">
        <div class="search-container">
            <input type="text" id="search" class="search-box" placeholder="{{ __('Search Kirtan...') }}" autocomplete="off"
                spellcheck="false">
            <input type="hidden" id="searchQueryHolder" value="">
        </div>

        <div id="errorMessage" class="error-message"></div>
        <ul id="songsList" class="song-list"></ul>
        <div id="loading" class="loading">
            <i class="fas fa-spinner"></i> {{ __('Loading...') }}
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Application state
        const AppState = {
            page: 1,
            isLoading: false,
            searchQuery: '',
            hasMorePages: true,
            searchTimeout: null,
            categoryAlias: '{{ $category->alias }}',
            ajaxRequest: null
        };

        // Utility functions
        const Utils = {
            debounce(func, delay) {
                let timeoutId;
                return function(...args) {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => func.apply(this, args), delay);
                };
            },

            escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, function(m) {
                    return map[m];
                });
            },

            showError(message) {
                const errorDiv = $('#errorMessage');
                errorDiv.text(message).fadeIn();
                setTimeout(() => errorDiv.fadeOut(), 5000);
            },

            hideError() {
                $('#errorMessage').fadeOut();
            }
        };

        // Main application functions
        const SongApp = {
            init() {
                this.bindEvents();
                this.loadSongs();
            },

            bindEvents() {
                // Infinite scroll
                $('#songsList').on('scroll', this.handleScroll.bind(this));

                // Search with debouncing
                $('#search').on('keyup', Utils.debounce(this.handleSearch.bind(this), 300));

                // Language change event
                $(document).on('languageChanged', this.handleLanguageChange.bind(this));

                // Handle window resize for responsive adjustments
                $(window).on('resize', Utils.debounce(this.handleResize.bind(this), 250));
            },

            handleScroll() {
                const list = $('#songsList')[0];
                if (!AppState.isLoading && AppState.hasMorePages &&
                    list.scrollTop + list.clientHeight >= list.scrollHeight - 100) {
                    this.loadSongs();
                }
            },

            handleSearch() {
                const newQuery = $('#search').val().trim();
                if (newQuery !== AppState.searchQuery) {
                    AppState.searchQuery = newQuery;
                    $('#searchQueryHolder').val(newQuery);
                    this.resetAndLoad();
                }
            },

            handleLanguageChange() {
                AppState.searchQuery = $('#searchQueryHolder').val();
                $('#search').val(AppState.searchQuery);
                this.resetAndLoad();
            },

            handleResize() {
                // Handle any resize-specific logic if needed
                console.log('Window resized');
            },

            resetAndLoad() {
                this.cancelCurrentRequest();
                AppState.page = 1;
                AppState.hasMorePages = true;
                $('#songsList').empty();
                Utils.hideError();
                this.loadSongs();
            },

            cancelCurrentRequest() {
                if (AppState.ajaxRequest && AppState.ajaxRequest.readyState !== 4) {
                    AppState.ajaxRequest.abort();
                }
            },

            loadSongs() {
                if (AppState.isLoading || !AppState.hasMorePages) return;

                AppState.isLoading = true;
                $('#loading').show();

                AppState.ajaxRequest = $.ajax({
                    url: '{{ route('user.categories.aliasShow', $category->alias) }}',
                    method: 'GET',
                    data: {
                        page: AppState.page,
                        search: AppState.searchQuery
                    },
                    timeout: 10000, // 10 second timeout
                    success: this.handleSuccess.bind(this),
                    error: this.handleError.bind(this),
                    complete: this.handleComplete.bind(this)
                });
            },

            handleSuccess(response) {
                try {
                    // Validate response structure
                    if (!response || typeof response !== 'object') {
                        throw new Error('Invalid response format');
                    }

                    if (!response.songs || !Array.isArray(response.songs)) {
                        throw new Error('Songs data is missing or invalid');
                    }

                    // Handle empty results for first page
                    if (AppState.page === 1 && response.songs.length === 0) {
                        this.showNoResults();
                        return;
                    }

                    // Process and append songs
                    if (response.songs.length > 0) {
                        this.appendSongs(response.songs);
                        AppState.page++;
                    }

                    // Update pagination state
                    if (response.pagination) {
                        AppState.hasMorePages = response.pagination.has_more_pages || false;
                    } else {
                        AppState.hasMorePages = response.songs.length >= 30; // fallback
                    }

                } catch (error) {
                    console.error('Error processing response:', error);
                    Utils.showError('{{ __('Error processing server response') }}');
                }
            },

            handleError(xhr, status, error) {
                console.error('AJAX Error:', {
                    xhr,
                    status,
                    error
                });

                if (status === 'timeout') {
                    Utils.showError('{{ __('Request timeout. Please try again.') }}');
                } else if (status === 'abort') {
                    // Request was cancelled, don't show error
                    return;
                } else if (xhr.status === 404) {
                    Utils.showError('{{ __('Category not found') }}');
                } else if (xhr.status >= 500) {
                    Utils.showError('{{ __('Server error. Please try again later.') }}');
                } else {
                    Utils.showError('{{ __('Failed to load songs. Please check your connection.') }}');
                }
            },

            handleComplete() {
                AppState.isLoading = false;
                $('#loading').hide();
            },

            showNoResults() {
                const message = AppState.searchQuery ?
                    '{{ __('No results found for your search') }}' :
                    '{{ __('No songs available') }}';

                $('#songsList').html(`
                    <li class="status-message">
                        <i class="fas fa-search"></i>
                        <div>${message}</div>
                    </li>
                `);
            },

            appendSongs(songs) {
                const fragment = document.createDocumentFragment();

                songs.forEach(song => {
                    const li = document.createElement('li');
                    const title = Utils.escapeHtml(song.title || song.title_en || 'Untitled');

                    // Handle pad count
                    let padInfo = '';
                    const currentPad = parseInt(song.current_pad) || 0;
                    const totalPads = parseInt(song.total_pads) || 0;

                    if (totalPads > 0) {
                        padInfo = `<span class="pad-count">${currentPad} / ${totalPads}</span>`;
                    }

                    // Create song URL
                    const songUrl =
                        `{{ route('user.categories.aliasShow', $category->alias) }}/${song.song_code}`;

                    li.innerHTML = `
                        <a href="${songUrl}">
                            ${title}
                            ${padInfo}
                        </a>
                    `;

                    fragment.appendChild(li);
                });

                $('#songsList')[0].appendChild(fragment);
            }
        };

        // Initialize when document is ready
        $(document).ready(function() {
            SongApp.init();
        });

        // Export for debugging (remove in production)
        window.SongApp = SongApp;
        window.AppState = AppState;
    </script>
@endsection
