@php
    $config = App\Models\Configuration::where('key', 'show_export')->first();
    $exportShow = $config->value;
    $contactShow = App\Models\Configuration::where('key', 'show_contact')->first()->value??0;
    $currentUser = Auth::user();
@endphp

<header class="admin-header">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('admin.songs.index') }}">
                <i class="fas fa-scroll"></i>
                {{ __('Vachanamrut Admin') }}
            </a>
            
            <!-- Mobile Controls -->
            <div class="d-flex d-lg-none align-items-center">
                <!-- Theme Toggle Mobile -->
                <button class="nav-btn me-2" id="themeToggleMobile" title="Toggle Theme">
                    <i class="fas fa-moon" id="themeIconMobile"></i>
                </button>
                
                <!-- Mobile Menu Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Main Navigation -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/songs*') ? ' active' : '' }}"
                            href="{{ route('admin.songs.index') }}">
                            <i class="fas fa-scroll"></i>
                            <span>{{ __('Vachanamruts') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/categories*') ? ' active' : '' }}"
                            href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-folder"></i>
                            <span>{{ __('Categories') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/subCategories*') ? ' active' : '' }}"
                            href="{{ route('admin.subCategories.index') }}">
                            <i class="fas fa-folder-open"></i>
                            <span>{{ __('Sub Categories') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/playlists*') ? ' active' : '' }}"
                            href="{{ route('admin.playlists.index') }}">
                            <i class="fas fa-list"></i>
                            <span>{{ __('Playlists') }}</span>
                        </a>
                    </li>
                    @if ($contactShow == '1')
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/contacts*') ? ' active' : '' }}"
                            href="{{ route('admin.contacts.index') }}">
                            <i class="fas fa-envelope"></i>
                            <span>{{ __('Contacts') }}</span>
                        </a>
                    </li>
                    @endif
                    @if ($exportShow == '1')
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/exports*') ? ' active' : '' }}"
                            href="{{ route('admin.exports.index') }}">
                            <i class="fas fa-download"></i>
                            <span>{{ __('Export') }}</span>
                        </a>
                    </li>
                    @endif
                </ul>
                
                <!-- Right Side Controls -->
                <div class="navbar-controls">
                    <!-- Theme Toggle Desktop -->
                    <button class="nav-btn d-none d-lg-inline-flex me-2" id="themeToggleDesktop" title="Toggle Theme">
                        <i class="fas fa-moon" id="themeIconDesktop"></i>
                    </button>
                    
                    <!-- Language Dropdown -->
                    <div class="dropdown me-2">
                        <button class="nav-btn dropdown-toggle" type="button" id="languageDropdown" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-language"></i>
                            <span class="d-none d-md-inline ms-1">
                                {{ app()->getLocale() === 'gu' ? 'ગુજ' : 'EN' }}
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                            <li>
                                <a class="dropdown-item{{ app()->getLocale() === 'en' ? ' active' : '' }}" 
                                   href="{{ route('locale', 'en') }}">
                                    <i class="fas fa-globe me-2"></i>{{ __('English') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item{{ app()->getLocale() === 'gu' ? ' active' : '' }}" 
                                   href="{{ route('locale', 'gu') }}">
                                    <i class="fas fa-font me-2"></i>{{ __('ગુજરાતી') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <button class="user-dropdown dropdown-toggle" type="button" 
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                {{ strtoupper(substr($currentUser->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="d-none d-lg-inline user-name">{{ $currentUser->name ?? 'Admin' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end user-menu" aria-labelledby="userDropdown">
                            <li>
                                <div class="dropdown-item-text user-info">
                                    <div class="user-full-name">{{ $currentUser->name ?? 'Admin' }}</div>
                                    <div class="user-email">{{ $currentUser->email ?? 'admin@ssgd.org' }}</div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item logout-item" href="{{ route('admin.logout') }}">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<style>
/* FIXED: Admin Header Styles - Remove White Borders */
.admin-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background-color: var(--admin-primary);
    z-index: 1030;
    box-shadow: var(--admin-shadow-md);
    border-bottom: none; /* REMOVED border */
}

.admin-header .container-fluid {
    height: 100%;
    max-width: 100%;
    padding: 0 1rem;
}

.admin-header .navbar {
    height: 100%;
    padding: 0;
    align-items: center;
}

/* Brand Styling */
.navbar-brand {
    color: white !important;
    font-weight: 700;
    font-size: 1.3rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0;
    margin: 0;
    transition: all 0.3s ease;
    height: 100%;
}

.navbar-brand:hover {
    color: rgba(255, 255, 255, 0.9) !important;
    transform: scale(1.02);
}

.navbar-brand i {
    font-size: 1.1rem;
}

/* Navigation Links - REMOVED WHITE BORDERS */
.navbar-nav {
    height: 100%;
    align-items: center;
}

.navbar-nav .nav-item {
    height: 100%;
    display: flex;
    align-items: center;
    margin: 0 2px;
}

.navbar-nav .nav-link {
    color: rgba(255, 255, 255, 0.9) !important;
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    font-size: 0.9rem;
    height: 40px;
    background: transparent; /* REMOVED white border background */
    margin: 0 2px;
    border: none; /* REMOVED border completely */
}

.navbar-nav .nav-link:hover {
    background: rgba(255, 255, 255, 0.1); /* Subtle hover effect */
    color: white !important;
    transform: translateY(-1px);
    box-shadow: none; /* REMOVED box shadow */
}

.navbar-nav .nav-link.active {
    background: rgba(255, 255, 255, 0.2); /* Subtle active state */
    color: white !important;
    box-shadow: none; /* REMOVED box shadow */
}

.navbar-nav .nav-link i {
    font-size: 0.85rem;
    width: 16px;
    text-align: center;
}

/* Navigation Controls - REMOVED WHITE BORDERS */
.navbar-controls {
    display: flex;
    align-items: center;
    height: 100%;
    gap: 8px;
}

/* Navigation Buttons - REMOVED WHITE BORDERS */
.nav-btn {
    background: transparent; /* REMOVED white border background */
    border: none; /* REMOVED white border */
    color: white;
    padding: 6px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    min-width: 40px;
    height: 40px;
}

.nav-btn:hover {
    background: rgba(255, 255, 255, 0.1); /* Subtle hover effect */
    transform: translateY(-1px);
    box-shadow: none; /* REMOVED box shadow */
}

.nav-btn.dropdown-toggle::after {
    margin-left: 6px;
    font-size: 0.7rem;
}

/* User Dropdown - REMOVED WHITE BORDERS */
.user-dropdown {
    background: transparent; /* REMOVED white border background */
    border: none; /* REMOVED white border */
    color: white;
    padding: 6px 12px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
    height: 40px;
}

.user-dropdown:hover {
    background: rgba(255, 255, 255, 0.1); /* Subtle hover effect */
    transform: translateY(-1px);
    box-shadow: none; /* REMOVED box shadow */
}

.user-avatar {
    width: 30px;
    height: 30px;
    background: rgba(255, 255, 255, 0.3);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.8rem;
    border: none; /* REMOVED white border */
}

.user-name {
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-weight: 600;
}

/* Dropdown Menus */
.dropdown-menu {
    background-color: var(--admin-bg-secondary);
    border: 1px solid var(--admin-border-color);
    border-radius: 10px;
    box-shadow: var(--admin-shadow-lg);
    padding: 8px 0;
    margin-top: 8px;
    min-width: 180px;
}

.dropdown-item {
    color: var(--admin-text-primary) !important;
    padding: 10px 16px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    text-decoration: none;
}

.dropdown-item:hover,
.dropdown-item:focus {
    background-color: var(--admin-primary-bg);
    color: var(--admin-primary) !important;
}

.dropdown-item.active {
    background-color: var(--admin-primary);
    color: white !important;
}

.dropdown-item i {
    width: 18px;
    text-align: center;
}

/* User Menu Specific */
.user-menu {
    min-width: 220px;
}

.user-info {
    padding: 12px 16px !important;
    border-bottom: 1px solid var(--admin-border-color);
    margin-bottom: 8px;
}

.user-full-name {
    font-weight: 600;
    color: var(--admin-text-primary);
    font-size: 0.95rem;
}

.user-email {
    font-size: 0.8rem;
    color: var(--admin-text-muted);
    margin-top: 4px;
}

.logout-item:hover {
    background-color: rgba(239, 68, 68, 0.1) !important;
    color: var(--admin-error) !important;
}

/* Mobile Toggler - REMOVED WHITE BORDERS */
.navbar-toggler {
    border: none; /* REMOVED white border */
    background: transparent; /* REMOVED white border background */
    padding: 6px 10px;
    border-radius: 8px;
    color: white;
    transition: all 0.3s ease;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.navbar-toggler:hover,
.navbar-toggler:focus {
    background: rgba(255, 255, 255, 0.1); /* Subtle hover effect */
    color: white;
    box-shadow: none;
}

.navbar-toggler i {
    font-size: 1rem;
}

/* Dropdown Divider */
.dropdown-divider {
    border-color: var(--admin-border-color);
    margin: 8px 0;
}

/* Mobile Responsive */
@media (max-width: 991px) {
    .navbar-collapse {
        background-color: var(--admin-primary);
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        margin-top: 0.5rem;
        padding: 1rem 0;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1000;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .navbar-nav {
        margin-bottom: 1rem;
        height: auto;
    }
    
    .navbar-nav .nav-item {
        height: auto;
        margin: 4px 0;
    }
    
    .navbar-nav .nav-link {
        padding: 12px 16px;
        margin: 0;
        border-radius: 8px;
        height: auto;
        background: transparent; /* REMOVED white border */
        border: none; /* REMOVED border */
    }
    
    .navbar-nav .nav-link:hover {
        background: rgba(255, 255, 255, 0.1); /* Subtle hover effect */
    }
    
    .navbar-controls {
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        height: auto;
    }
    
    .user-dropdown {
        width: 100%;
        justify-content: flex-start;
        padding: 12px 16px;
        height: auto;
        background: transparent; /* REMOVED white border */
        border: none; /* REMOVED border */
    }
    
    .dropdown-menu {
        position: static !important;
        transform: none !important;
        width: 100%;
        box-shadow: none;
        border: none;
        background-color: rgba(255, 255, 255, 0.1);
        margin-top: 8px;
        border-radius: 8px;
    }
    
    .dropdown-item {
        color: white !important;
    }
    
    .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: white !important;
    }
}

@media (max-width: 576px) {
    .admin-header .container-fluid {
        padding: 0 0.75rem;
    }
    
    .navbar-brand {
        font-size: 1.1rem;
    }
    
    .nav-btn {
        min-width: 36px;
        height: 36px;
        padding: 4px 8px;
    }
    
    .user-dropdown {
        height: auto;
        padding: 8px 12px;
    }
    
    .user-avatar {
        width: 26px;
        height: 26px;
        font-size: 0.75rem;
    }
}

/* Theme Transition Animations */
.admin-header,
.navbar-brand,
.nav-link,
.nav-btn,
.user-dropdown,
.dropdown-menu,
.dropdown-item {
    transition: all 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Theme toggle functionality for both mobile and desktop
    const themeToggleDesktop = document.getElementById('themeToggleDesktop');
    const themeToggleMobile = document.getElementById('themeToggleMobile');
    const themeIconDesktop = document.getElementById('themeIconDesktop');
    const themeIconMobile = document.getElementById('themeIconMobile');
    const html = document.documentElement;

    // Get current theme
    const currentTheme = html.getAttribute('data-theme') || 'light';
    updateThemeIcons(currentTheme);

    // Desktop theme toggle
    if (themeToggleDesktop) {
        themeToggleDesktop.addEventListener('click', toggleTheme);
    }

    // Mobile theme toggle
    if (themeToggleMobile) {
        themeToggleMobile.addEventListener('click', toggleTheme);
    }

    function toggleTheme() {
        const currentTheme = html.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('admin-theme', newTheme);
        updateThemeIcons(newTheme);
        
        // Trigger custom event for other components
        window.dispatchEvent(new CustomEvent('themeChanged', { detail: newTheme }));
    }

    function updateThemeIcons(theme) {
        const iconClass = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        
        if (themeIconDesktop) {
            themeIconDesktop.className = iconClass;
        }
        if (themeIconMobile) {
            themeIconMobile.className = iconClass;
        }
    }

    // Enhanced mobile menu behavior
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
        // Close mobile menu when clicking on nav links
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    navbarCollapse.classList.remove('show');
                }
            });
        });
    }
});
</script>
