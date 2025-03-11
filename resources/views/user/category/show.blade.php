@extends('user.layouts.app')
@section('title', __('Category') . ' - ' . $subCategory->{'sub_category_' . app()->getLocale()})

@section('style')
<style>
    /* Global variables for theme support */
    :root {
        --primary-color: #d7861b;
        --bg-color: #f5f5f5;
        --card-bg: #ffffff;
        --text-color: #333333;
        --border-color: #d7861b;
        --shadow-color: rgba(0, 0, 0, 0.08);
        --link-color: #333333;
        --hover-bg: rgba(215, 134, 27, 0.1);
    }

    /* Dark theme variables */
    [data-theme="dark"] {
        --bg-color: #212529;
        --card-bg: #2c3034;
        --text-color: #f8f9fa;
        --shadow-color: rgba(0, 0, 0, 0.3);
        --link-color: #f8f9fa;
        --hover-bg: rgba(215, 134, 27, 0.2);
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
        border-radius: 8px;
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
        scrollbar-width: none; /* Firefox */
        background-color: var(--card-bg);
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
        background-color: var(--card-bg);
    }

    .song-list li a {
        text-decoration: none;
        font-weight: 500;
        color: var(--text-color);
        display: block;
    }

    .song-list li:hover {
        background: var(--hover-bg);
    }

    body {
        background-color: var(--bg-color);
    }

    .loading {
        text-align: center;
        padding: 15px;
        display: none;
        color: var(--text-color);
    }

    /* Mobile responsive styles */
    @media (max-width: 768px) {
            .song-container {
                max-width: 100%;
                padding: 15px;
            }
            
            .search-box {
                width: 90%;
            }
            
            .song-list li {
                font-size: 20px;
                padding: 15px;
            }
            .song-list li a {
                font-weight: 500;
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
<div class="song-container">
    <div class="search-container">
        <input type="text" id="search" class="search-box" placeholder="{{ __('Search') }} {{ $subCategory->{'sub_category_' . app()->getLocale()} }}...">
    </div>

    <ul id="songsList" class="song-list"></ul>

    <div id="loading" class="loading">Loading...</div>
</div>
@endsection

@section('script')
<script>
    let page = 1;
    let isLoading = false;
    let searchQuery = '';

    function loadSongs() {
        if (isLoading) return;
        isLoading = true;
        $('#loading').show();

        $.ajax({
            url: '{{ route('user.categories.show', $subCategory->sub_category_code) }}',
            data: {
                page: page,
                search: searchQuery
            },
            success: function(response) {
                if (response.songs.length > 0) {
                    response.songs.forEach(song => {
                        $('#songsList').append(
                            `<li><a href="{{ url('kirtans') }}/${song.song_code}">${song.title}</a></li>`
                        );
                    });
                    page++;
                }
                isLoading = false;
                $('#loading').hide();
            }
        });
    }

    $(document).ready(function() {
        loadSongs(); // Load initial songs

        // Infinite scroll
        $('#songsList').on('scroll', function() {
            if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight - 50) {
                loadSongs();
            }
        });

        // Search functionality
        $('#search').on('keyup', function() {
            searchQuery = $(this).val();
            page = 1;
            $('#songsList').html('');
            loadSongs();
        });
        
        // Reload songs when language changes
        $(document).on('languageChanged', function() {
            page = 1;
            $('#songsList').html('');
            loadSongs();
        });
    });
</script>
@endsection