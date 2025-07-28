@extends('user.layouts.app')
@section('title', __('Vachanamrut') . ' - ' . $song->{'title_' . app()->getLocale()})

@section('style')
<style>
    :root {
        --primary-color: #d7861b;
        --secondary-color: #f4a83a;
        --text-color: #333;
        --bg-color: #f8f9fa;
        --card-bg: #ffffff;
        --border-color: #ddd;
        --abbr-color: #d7861b;
        --abbr-hover-color: #f4a83a;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --light-shadow: rgba(215, 134, 27, 0.2);
        --gradient-start: rgba(215, 134, 27, 0.05);
        --gradient-end: rgba(244, 168, 58, 0.05);
    }

    [data-theme="dark"] {
        --text-color: #f8f9fa;
        --bg-color: #1a1a1a;
        --card-bg: #2c2c2c;
        --border-color: #404040;
        --abbr-color: #f4a83a;
        --abbr-hover-color: #d7861b;
        --shadow-color: rgba(0, 0, 0, 0.4);
        --light-shadow: rgba(244, 168, 58, 0.3);
        --gradient-start: rgba(215, 134, 27, 0.08);
        --gradient-end: rgba(244, 168, 58, 0.08);
    }

    .container-fluid {
        padding: 20px;
        max-width: 900px;
        margin: 0 auto;
        background-color: var(--bg-color);
        min-height: 100vh;
        transition: all 0.3s ease;
    }

    /* Header Section */
    .vachanamrut-header {
        text-align: center;
        padding: 2rem 1rem 1.5rem;
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        border-radius: 15px;
        margin: 1.5rem 0;
        position: relative;
        overflow: hidden;
    }

    .vachanamrut-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d7861b' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
        opacity: 0.5;
    }

    .vachanamrut-title {
        font-size: 2.2rem;
        color: var(--text-color);
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 2;
        text-shadow: 0 2px 4px var(--shadow-color);
        line-height: 1.3;
    }

    .vachanamrut-subtitle {
        font-size: 1rem;
        color: var(--primary-color);
        margin: 0.5rem 0 0;
        font-weight: 500;
        position: relative;
        z-index: 2;
        opacity: 0.9;
    }

    /* Navigation Tabs */
    .vachanamrut-nav {
        display: flex;
        justify-content: center;
        margin: 1.5rem 0;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .nav-tab-btn {
        padding: 10px 20px;
        border-radius: 20px;
        background: var(--card-bg);
        color: var(--text-color);
        border: 2px solid var(--border-color);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 6px var(--shadow-color);
        font-size: 0.9rem;
    }

    .nav-tab-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px var(--light-shadow);
        text-decoration: none;
    }

    .nav-tab-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        box-shadow: 0 4px 10px var(--light-shadow);
    }

    /* Content Section */
    .vachanamrut-content {
        background: var(--card-bg);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 6px 20px var(--shadow-color);
        margin: 1.5rem 0;
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
    }

    .vachanamrut-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }

    /* FIXED TEXT STYLING - NO EXCESSIVE SPACING */
    .vachanamrut-text {
        font-size: 1.2rem;
        line-height: 1.6;
        color: var(--text-color);
        text-align: justify;
        font-weight: 400;
        margin: 0;
        padding: 0;
        white-space: pre-line;
    }

    .vachanamrut-text br {
        line-height: 0;
        margin: 0;
        padding: 0;
    }

    /* Prevent double spacing */
    .vachanamrut-text p + p {
        margin-top: 0.8rem;
    }

    /* Control spacing after line breaks */
    .vachanamrut-text br + br {
        display: none; /* Remove double line breaks */
    }

    /* FIXED: Abbreviation Styling - No underlines, no tooltips */
    .vachanamrut-text abbr {
        color: var(--abbr-color);
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
        border-bottom: none; /* REMOVED: underline */
        /* Title attribute will be removed by JavaScript to prevent tooltips */
    }

    .vachanamrut-text abbr:hover {
        color: var(--abbr-hover-color);
        text-shadow: 0 1px 2px var(--light-shadow);
        /* REMOVED: border-bottom styling */
    }

    /* Bold text styling */
    .vachanamrut-text b {
        font-weight: 700;
    }

    /* Popup Modal for Abbreviations */
    .abbr-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }

    .abbr-modal-content {
        background-color: var(--card-bg);
        margin: 10% auto;
        padding: 1.8rem;
        border-radius: 12px;
        width: 90%;
        max-width: 450px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        position: relative;
        border: 2px solid var(--primary-color);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .abbr-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.8rem;
        border-bottom: 2px solid var(--border-color);
    }

    /* FIXED: Modal title size matches proportionally */
    .abbr-modal-title {
        color: var(--primary-color);
        font-size: 1.3rem; /* Will be updated by JavaScript */
        font-weight: 700;
        margin: 0;
    }

    .abbr-close {
        color: var(--text-color);
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        padding: 4px;
        border-radius: 50%;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
    }

    .abbr-close:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* FIXED: Modal body text size matches Vachanamrut text */
    .abbr-modal-body {
        font-size: 1.2rem; /* Will be updated by JavaScript to match current text size */
        line-height: 1.6; /* Will be updated by JavaScript */
        color: var(--text-color);
    }

    /* FIXED: Modal short form styling */
    .abbr-short-form {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 600;
        margin-right: 8px;
        font-size: 1.1rem; /* Will be updated by JavaScript */
    }

    /* Report Button - Small and Centered */
    .vachanamrut-actions {
        display: flex;
        justify-content: center;
        margin: 1.5rem 0;
    }

    .suggestion-link {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 18px;
        background-color: var(--card-bg);
        color: var(--text-color);
        font-weight: 400;
        text-decoration: none;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        font-size: 13px;
    }

    .suggestion-link:hover {
        background-color: #e74c3c;
        color: white;
        border-color: #e74c3c;
        text-decoration: none;
    }

    [data-theme="dark"] .suggestion-link {
        border-color: var(--border-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 10px;
        }

        .vachanamrut-header {
            padding: 1.5rem 0.8rem 1.2rem;
            margin: 1rem 0;
        }

        .vachanamrut-title {
            font-size: 1.6rem;
        }

        .vachanamrut-subtitle {
            font-size: 0.9rem;
        }

        .vachanamrut-content {
            padding: 1.2rem;
            border-radius: 12px;
        }

        .vachanamrut-text {
            font-size: 1rem;
            line-height: 1.4;
            text-align: left;
        }

        .vachanamrut-text p {
            margin: 0.4rem 0;
        }

        .nav-tab-btn {
            padding: 8px 14px;
            font-size: 13px;
        }

        .abbr-modal-content {
            margin: 15% auto;
            padding: 1.5rem;
            width: 95%;
        }
    }

    @media (max-width: 480px) {
        .vachanamrut-header {
            padding: 1.2rem 0.6rem;
        }

        .vachanamrut-title {
            font-size: 1.4rem;
        }

        .vachanamrut-content {
            padding: 1rem;
        }

        .vachanamrut-text {
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .nav-tab-btn {
            padding: 6px 10px;
            font-size: 12px;
        }
    }

    /* Print Styles */
    @media print {
        .vachanamrut-actions,
        .nav-tab-btn {
            display: none !important;
        }

        .vachanamrut-content {
            box-shadow: none;
            border: 1px solid #ccc;
        }

        .vachanamrut-text abbr {
            color: #333;
            border-bottom: 1px solid #999;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="vachanamrut-header">
        <h1 class="vachanamrut-title">{{ $song->{'title_' . app()->getLocale()} }}</h1>
        <!-- <p class="vachanamrut-subtitle">{{ __('Vachanamrut') }}</p> -->
    </div>

    <!-- Navigation (if you have multiple Vachanamruts) -->
    @if(isset($songsInPlaylists) && $songsInPlaylists->count() > 1)
    <div class="vachanamrut-nav">
        @foreach ($songsInPlaylists as $index => $playlistSong)
            <a href="{{ url('vachanamruts/' . $playlistSong->song_code) }}" 
               class="nav-tab-btn {{ $playlistSong->song_code == $song->song_code ? 'active' : '' }}">
                <i class="fas fa-scroll"></i>
                {{ __('Vachanamrut') }} {{ $index + 1 }}
            </a>
        @endforeach
    </div>
    @endif

    <!-- Main Content -->
    <div class="vachanamrut-content">
        <div class="vachanamrut-text" id="vachanamrutText">
            {!! $song->{'lyrics_' . app()->getLocale()} !!}
        </div>
    </div>

    <!-- Report Button Only -->
    <div class="vachanamrut-actions">
        <a href="{{ route('user.contact.edit', $song->song_code) }}" class="suggestion-link">
            <i class="fas fa-flag"></i> {{ __('suggestion') }}
        </a>
    </div>
</div>

<!-- Abbreviation Modal -->
<div id="abbrModal" class="abbr-modal">
    <div class="abbr-modal-content">
        <div class="abbr-modal-header">
            <h3 class="abbr-modal-title">{{ __('Explanation') }}</h3>
            <span class="abbr-close">&times;</span>
        </div>
        <div class="abbr-modal-body">
            <p><span class="abbr-short-form" id="modalShortForm"></span> {{ __('means') }}:</p>
            <p id="modalFullForm"></p>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const vachanamrutText = document.querySelector('.vachanamrut-text');

    // Font Size Controls
    let currentFontSize = parseInt(localStorage.getItem('vachanamrutFontSize')) || 20;
    const minFontSize = 16;
    const maxFontSize = 28;
    const stepSize = 2;

    // Apply saved font size
    function applyFontSize() {
        if (vachanamrutText) {
            vachanamrutText.style.fontSize = currentFontSize + 'px';
            // Keep tight line height even with font changes
            const lineHeight = currentFontSize <= 18 ? 1.4 : currentFontSize <= 22 ? 1.45 : 1.5;
            vachanamrutText.style.lineHeight = lineHeight;
        }
    }

    // Save font size
    function saveFontSize() {
        localStorage.setItem('vachanamrutFontSize', currentFontSize);
    }

    // FIXED: Function to update modal font size to match Vachanamrut text
    function updateModalFontSize() {
        const modalBody = document.querySelector('.abbr-modal-body');
        const modalTitle = document.querySelector('.abbr-modal-title');
        const shortForm = document.querySelector('.abbr-short-form');
        
        if (modalBody && modalTitle) {
            // Set modal body to match current Vachanamrut text size
            modalBody.style.fontSize = currentFontSize + 'px';
            modalBody.style.lineHeight = currentFontSize <= 18 ? 1.4 : currentFontSize <= 22 ? 1.45 : 1.5;
            
            // Set title proportionally larger
            modalTitle.style.fontSize = (currentFontSize + 2) + 'px';
        }
        
        if (shortForm) {
            // Set short form slightly smaller but not too small
            shortForm.style.fontSize = Math.max(currentFontSize - 2, 14) + 'px';
        }
    }

    // Apply on load
    applyFontSize();

    // Global functions for navbar integration
    window.increaseFontSize = function() {
        if (currentFontSize < maxFontSize) {
            currentFontSize += stepSize;
            applyFontSize();
            updateModalFontSize(); // FIXED: Update modal when font changes
            saveFontSize();
        }
    };

    window.decreaseFontSize = function() {
        if (currentFontSize > minFontSize) {
            currentFontSize -= stepSize;
            applyFontSize();
            updateModalFontSize(); // FIXED: Update modal when font changes
            saveFontSize();
        }
    };

    window.resetFontSize = function() {
        currentFontSize = 20;
        applyFontSize();
        updateModalFontSize(); // FIXED: Update modal when font changes
        saveFontSize();
    };

    // FIXED: Abbreviation Modal Functionality
    const abbrModal = document.getElementById('abbrModal');
    const modalShortForm = document.getElementById('modalShortForm');
    const modalFullForm = document.getElementById('modalFullForm');
    const closeModal = document.querySelector('.abbr-close');

    // FIXED: Handle abbreviation clicks and remove hover tooltips
    document.querySelectorAll('.vachanamrut-text abbr').forEach(abbr => {
        // Store the title content and remove the title attribute to prevent browser tooltip
        const explanation = abbr.getAttribute('title');
        abbr.removeAttribute('title'); // FIXED: Remove title to prevent hover tooltip
        abbr.dataset.explanation = explanation; // Store in data attribute instead
        
        abbr.addEventListener('click', function(e) {
            e.preventDefault();
            const shortForm = this.textContent;
            const fullForm = this.dataset.explanation;
            
            if (fullForm) {
                modalShortForm.textContent = shortForm;
                modalFullForm.textContent = fullForm;
                updateModalFontSize(); // FIXED: Update modal font size before showing
                abbrModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Close modal
    closeModal.addEventListener('click', function() {
        abbrModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    // Close modal when clicking outside
    abbrModal.addEventListener('click', function(e) {
        if (e.target === abbrModal) {
            abbrModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && abbrModal.style.display === 'block') {
            abbrModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // Prevent context menu
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
});
</script>
@endsection
