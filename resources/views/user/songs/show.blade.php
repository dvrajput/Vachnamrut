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
            font-weight: 500;
            line-height: 1.6; /* Base line height */
            line-height: normal;
            color: var(--text-color);
        }

        .lyrics br {
            line-height: 8px;
            display: block;
            margin-bottom: 12px; /* Add space between paragraphs */
            content: "";
        }

        .lyrics p {
            margin: 0;
            padding: 0;
            line-height: inherit; /* Inherit from parent */
            color: var(--text-color);
        }

        /* Pad navigation arrows for mobile */
        .pad-tabs-container {
            position: relative;
            overflow: hidden;
        }
        
        .pad-scroll-arrow {
            display: none;
            position: absolute;
            top: 50%;
            align-items: center;
            justify-content: center;
            transform: translateY(-65%) translateX(5px);
            background-color: var(--bg-color);
            color: var(--text-color);
            width: 40px;
            height: 60px;
            /* border-radius: 8px; */
            text-align: center;
            line-height: 40px;
            z-index: 10;
            cursor: pointer;
            font-size: 16px;
}
        
        .pad-scroll-left {
            left: 5px;
            transform: translateY(-70%) translateX(-6px);
        }
        
        .pad-scroll-right {
            right: 5px;
            /* transform: translateY(-100%);*/
        }
        /* Desktop styles for horizontal scrolling with many pads */
        @media (min-width: 769px) {
            #songTab.many-pads {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
                justify-content: flex-start;
                padding: 15px 30px;
                gap: 8px;
                scrollbar-width: none; /* Firefox */
                -ms-overflow-style: none; /* IE and Edge */
            }
            
            #songTab.many-pads::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Opera */
            }
            
            .many-pads .pad-scroll-arrow {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
        @media (max-width: 768px) {
            .container-fluid {
                padding: 8px;
            }
            .container{
                transform: translateY(-5px);
            }

            .song-title {
                padding-top: 12px;
                font-size: 24px;
                margin: 10px 0;
                line-height: 50px;
            }

            .lyrics {
                line-height: 28px;
            }
            
            .pad-scroll-arrow {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            #songTab {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
                justify-content: flex-start;
                padding: 10px 30px;
                gap: 8px;
                scrollbar-width: none; /* Firefox */
                -ms-overflow-style: none; /* IE and Edge */
                background-color: transparent;
                border-radius: 0;
            }
            
            #songTab::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Opera */
            }

            .nav-item {
                flex: 0 0 auto;
                margin-right: 5px;
            }
            
            #padBtn {
                padding: 8px 16px;
                min-width: 80px;
                font-size: 14px;
                border-radius: 8px;
                color: var(--text-color);
                transition: all 0.3s ease;
                border: 1px solid var(--border-color);
                background-color: var(--card-bg);
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

        /* Suggestion link styling */
        .suggestion-link {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            background-color: var(--card-bg);
            color: var(--text-color);
            font-weight: 400;
            text-decoration: none;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .suggestion-link:hover {
            background-color: var(--tab-hover);
            color: white;
            border-color: var(--primary-color);
        }

        [data-theme="dark"] .suggestion-link {
            border-color: var(--border-color);
        }
    </style>
@endsection

@section('content')
<div class="container-fluid mb-3">
        <h1 class="song-title">{{ $song->{'title_' . app()->getLocale()} }}</h1>

        <div class="pad-tabs-container">
            <div class="pad-scroll-arrow pad-scroll-left"><i class="fas fa-chevron-left"></i></div>
            <div class="pad-scroll-arrow pad-scroll-right"><i class="fas fa-chevron-right"></i></div>
            <ul class="nav nav-tabs" id="songTab" role="tablist">
                @foreach ($songsInPlaylists as $index => $playlistSong)
                    <li class="nav-item" role="presentation">
                        <a id="padBtn" class="nav-link {{ $playlistSong->song_code == $song->song_code ? 'active' : '' }}"
                            id="tab-{{ $playlistSong->song_code }}" href="{{ url('kirtans/' . $playlistSong->song_code) }}"
                            role="tab" aria-controls="content-{{ $playlistSong->song_code }}"
                            aria-selected="{{ $playlistSong->song_code == $song->song_code ? 'true' : 'false' }}">
                            {{ __('Pad') }} {{ $index + 1 }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <div class="tab-content" id="songTabContent">
            
            @foreach ($songsInPlaylists as $playlistSong)
                <div class="tab-pane fade {{ $playlistSong->song_code == $song->song_code ? 'show active' : '' }}"
                    id="content-{{ $playlistSong->song_code }}" role="tabpanel"
                    aria-labelledby="tab-{{ $playlistSong->song_code }}">

                    <div class="song-content">
                        <!-- <h2 class="song-title">{{ $playlistSong->{'title_' . app()->getLocale()} }}</h2> -->
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
            <br>
            <div class="text-center mt-4 mb-2">
                <a href="{{ route('user.contact.edit', $song->song_code) }}" class="suggestion-link">
                    <i class="fas fa-regular fa-flag"></i> {{ __('suggestion') }}
                </a>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to setup font size controls
    function setupFontSizeControls(toggleId, controlsId, increaseId, decreaseId) {
        const fontSizeToggle = document.getElementById(toggleId);
        const fontSizeControls = document.getElementById(controlsId);
        const increaseFontBtn = document.getElementById(increaseId);
        const decreaseFontBtn = document.getElementById(decreaseId);
        
        if (!fontSizeToggle) return; // Exit if elements don't exist

        const songTitle = document.querySelector('.song-title');
        
        // Get saved font sizes from localStorage or use defaults
        let currentLyricsFontSize = parseInt(localStorage.getItem('lyricsFontSize')) || 24;
        let currentTitleFontSize = parseInt(localStorage.getItem('titleFontSize')) || 32;
        const minFontSize = 16;
        const maxFontSize = 40;
        const stepSize = 2;

        // Function to calculate line height based on font size
        function calculateLineHeight(fontSize) {
            // Adjust these values to get your desired spacing
            if (fontSize <= 20) return 1;
            if (fontSize <= 28) return 1.2;
            if (fontSize <= 34) return 1.4;
            return 1.6; // For largest font sizes
        }

        // Apply saved font sizes on page load
        function applyFontSizes() {
            // Target all lyrics elements, including those in tabs
            const allLyrics = document.querySelectorAll('.lyrics');
            allLyrics.forEach(lyrics => {
                lyrics.style.fontSize = currentLyricsFontSize + 'px';
                
                // Apply appropriate line height
                const lineHeight = calculateLineHeight(currentLyricsFontSize);
                lyrics.style.lineHeight = lineHeight;
            });
            
            songTitle.style.fontSize = currentTitleFontSize + 'px';
            
            // Adjust spacing between paragraphs based on font size
            const brSpacing = Math.max(12, currentLyricsFontSize * 0.5) + 'px';
            const style = document.createElement('style');
            style.textContent = `.lyrics br { margin-bottom: ${brSpacing}; }`;
            document.head.appendChild(style);
        }

        // Apply sizes on load
        applyFontSizes();

        // Function to save font sizes
        function saveFontSizes() {
            localStorage.setItem('lyricsFontSize', currentLyricsFontSize);
            localStorage.setItem('titleFontSize', currentTitleFontSize);
        }

        // Toggle popup
        fontSizeToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            fontSizeControls.classList.toggle('d-none');
        });

        // Increase font size
        increaseFontBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (currentLyricsFontSize < maxFontSize) {
                currentLyricsFontSize += stepSize;
                //currentTitleFontSize += stepSize;  //Disabled font size change for title
                applyFontSizes();
                saveFontSizes();
            }
        });

        // Decrease font size
        decreaseFontBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (currentLyricsFontSize > minFontSize) {
                currentLyricsFontSize -= stepSize;
                //currentTitleFontSize -= stepSize;     //Disabled font size change for title
                applyFontSizes();
                saveFontSizes();
            }
        });

        // Close popup when clicking outside
        document.addEventListener('click', function(e) {
            if (!fontSizeControls.contains(e.target) && !fontSizeToggle.contains(e.target)) {
                fontSizeControls.classList.add('d-none');
            }
        });
    }

    // Scroll to active tab in mobile view
    if (window.innerWidth <= 768) {
        const activeTab = document.querySelector('#songTab .nav-link.active');
        if (activeTab) {
            setTimeout(() => {
                activeTab.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            }, 100);
        }
    }
    // Setup pad scroll functionality for both mobile and desktop
    const tabContainer = document.getElementById('songTab');
    const leftArrow = document.querySelector('.pad-scroll-left');
    const rightArrow = document.querySelector('.pad-scroll-right');
    
    // Add 'many-pads' class if there are more than 8 pads
    const padCount = tabContainer.querySelectorAll('.nav-item').length;
    if (padCount > 8) {
        tabContainer.classList.add('many-pads');
    }
    
    // Scroll to active tab
    const activeTab = document.querySelector('#songTab .nav-link.active');
    if (activeTab) {
        setTimeout(() => {
            activeTab.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }, 100);
    }
    
    // Check if scroll is needed and update arrow visibility
    function checkScrollArrows() {
        if (tabContainer.scrollWidth > tabContainer.clientWidth) {
            leftArrow.style.display = tabContainer.scrollLeft > 0 ? 'flex' : 'none';
            rightArrow.style.display = 
                (tabContainer.scrollWidth - tabContainer.scrollLeft - tabContainer.clientWidth) > 10 ? 'flex' : 'none';
        } else {
            leftArrow.style.display = 'none';
            rightArrow.style.display = 'none';
        }
    }
    
    // Initial check
    checkScrollArrows();
    
    // Scroll left
    leftArrow.addEventListener('click', function() {
        tabContainer.scrollBy({ left: -100, behavior: 'smooth' });
    });
    
    // Scroll right
    rightArrow.addEventListener('click', function() {
        tabContainer.scrollBy({ left: 100, behavior: 'smooth' });
    });
    
    // Update arrows on scroll
    tabContainer.addEventListener('scroll', checkScrollArrows);
    
    // Update arrows on window resize
    window.addEventListener('resize', checkScrollArrows);

    // Add mouse wheel scrolling for desktop
    tabContainer.addEventListener('wheel', function(e) {
        if (tabContainer.classList.contains('many-pads')) {
            e.preventDefault();
            tabContainer.scrollLeft += e.deltaY > 0 ? 60 : -60;
            checkScrollArrows();
        }
    }, { passive: false });

    // Prevent dragging of links
    const links = document.querySelectorAll('a');
    links.forEach(link => {
        link.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });
    });

    // Setup controls for both mobile and desktop
    setupFontSizeControls('fontSizeToggleMobile', 'fontSizeControlsMobile', 'increaseFontSizeMobile', 'decreaseFontSizeMobile');
    setupFontSizeControls('fontSizeToggleDesktop', 'fontSizeControlsDesktop', 'increaseFontSizeDesktop', 'decreaseFontSizeDesktop');

    // Your existing context menu prevention
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
});
</script>
@endsection