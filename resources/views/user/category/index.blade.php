@extends('user.layouts.app')
@section('title', __('Vachanamrut - Categories'))

@section('style')
<style>
    /* Global variables for theme support */
    :root {
        --primary-color: #d7861b;
        --secondary-color: #f4a83a;
        --bg-color: #f8f9fa;
        --card-bg: #ffffff;
        --text-color: #333;
        --border-color: #ddd;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --hover-shadow: rgba(215, 134, 27, 0.3);
        --gradient-start: rgba(215, 134, 27, 0.05);
        --gradient-end: rgba(244, 168, 58, 0.05);
    }

    /* Dark theme variables */
    [data-theme="dark"] {
        --bg-color: #1a1a1a;
        --card-bg: #2c2c2c;
        --text-color: #f8f9fa;
        --border-color: #404040;
        --shadow-color: rgba(0, 0, 0, 0.4);
        --hover-shadow: rgba(244, 168, 58, 0.4);
        --gradient-start: rgba(215, 134, 27, 0.08);
        --gradient-end: rgba(244, 168, 58, 0.08);
    }

    /* Main container */
    .categories-container {
        max-width: 1200px;
        margin: 0 auto;
        background-color: var(--bg-color);
        padding: 20px;
        min-height: calc(100vh - 60px);
        transition: all 0.3s ease;
    }

    /* Header Section */
    .categories-header {
        text-align: center;
        padding: 2rem 1rem 1.5rem;
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        border-radius: 15px;
        margin: 1.5rem 0 2rem;
        position: relative;
        overflow: hidden;
    }

    .categories-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d7861b' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
        opacity: 0.5;
    }

    .categories-title {
        font-size: 2.5rem;
        color: var(--text-color);
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 2;
        text-shadow: 0 2px 4px var(--shadow-color);
        line-height: 1.3;
    }

    .categories-subtitle {
        font-size: 1.1rem;
        color: var(--primary-color);
        margin: 0.5rem 0 0;
        font-weight: 500;
        position: relative;
        z-index: 2;
        opacity: 0.9;
    }

    /* Categories Grid */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    /* Category Card */
    .category-card {
        background: var(--card-bg);
        border-radius: 15px;
        padding: 1.8rem;
        box-shadow: 0 6px 20px var(--shadow-color);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--text-color);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        display: block;
    }

    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px var(--hover-shadow);
        text-decoration: none;
        color: var(--text-color);
    }

    .category-card:hover::before {
        transform: scaleX(1);
    }

    .category-icon {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
        text-align: center;
        display: block;
    }

    .category-name {
        font-size: 1.4rem;
        font-weight: 600;
        margin: 0 0 0.5rem;
        text-align: center;
        line-height: 1.3;
    }

    .category-description {
        font-size: 0.95rem;
        color: var(--text-color);
        opacity: 0.7;
        text-align: center;
        margin: 0;
        line-height: 1.4;
    }

    /* Loading state */
    .loading-container {
        text-align: center;
        padding: 3rem;
        color: var(--text-color);
    }

    .loading-spinner {
        border: 3px solid var(--border-color);
        border-top: 3px solid var(--primary-color);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-color);
        opacity: 0.7;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .categories-container {
            padding: 15px;
        }

        .categories-header {
            padding: 1.5rem 1rem 1.2rem;
            margin: 1rem 0 1.5rem;
        }

        .categories-title {
            font-size: 2rem;
        }

        .categories-subtitle {
            font-size: 1rem;
        }

        .categories-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .category-card {
            padding: 1.5rem;
        }

        .category-icon {
            font-size: 2rem;
        }

        .category-name {
            font-size: 1.2rem;
        }

        .category-description {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .categories-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .category-card {
            padding: 1.2rem;
        }

        .categories-title {
            font-size: 1.8rem;
        }

        .category-name {
            font-size: 1.1rem;
        }
    }

    /* Print styles */
    @media print {
        .category-card {
            box-shadow: none;
            border: 1px solid #ccc;
            break-inside: avoid;
        }
    }
</style>
@endsection

@section('content')
@include('user.layouts.catbar')

<div class="categories-container">
    <!-- Header Section -->
    <div class="categories-header">
        <h1 class="categories-title">{{ __('Vachanamrut') }}</h1>
        <p class="categories-subtitle">{{ __('Select a Prakaran to explore Vachanamrut') }}</p>
    </div>

    <!-- Categories Grid -->
    <div class="categories-grid" id="categoriesGrid">
        @if(isset($categoriesTransformed) && $categoriesTransformed->count() > 0)
            @foreach($categoriesTransformed as $category)
                <a href="{{ route('user.categories.aliasShow', $category->alias) }}" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="category-name">{{ $category->title }}</h3>
                    <p class="category-description">
                        {{ __('Explore Vachanamrut from this Prakaran') }}
                    </p>
                </a>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-book"></i>
                <h3>{{ __('No Categories Available') }}</h3>
                <p>{{ __('Categories will appear here when they are added') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state for category cards
    const categoryCards = document.querySelectorAll('.category-card');
    
    categoryCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Add a subtle loading effect
            this.style.opacity = '0.7';
            this.style.transform = 'translateY(-2px)';
        });
    });

    // Add keyboard navigation support
    categoryCards.forEach((card, index) => {
        card.setAttribute('tabindex', '0');
        
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
            
            // Arrow key navigation
            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                e.preventDefault();
                const nextCard = categoryCards[index + 1];
                if (nextCard) nextCard.focus();
            }
            
            if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                e.preventDefault();
                const prevCard = categoryCards[index - 1];
                if (prevCard) prevCard.focus();
            }
        });
    });

    // Language change support
    $(document).on('languageChanged', function() {
        // Reload the page to get updated category titles in new language
        window.location.reload();
    });
});
</script>
@endsection
