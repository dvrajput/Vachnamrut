<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">

    <!-- Latest Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=format_size" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=g_translate" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Gujarati:wght@100..800&family=Rasa:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">

<style>
    :root {
        /* Light theme variables */
        --bg-color: #f8f9fa;
        --text-color: #212529;
        --card-bg: #ffffff;
        --border-color: #ced4da;
        --primary-color: #d7861b;
        --navbar-bg: #bf7a1f;
        --dropdown-bg: #ffffff;
        --input-bg: #ffffff;
        --input-text: #212529;
        --mobile-font-size: 20px;
        --mobile-padding: 8px;
    }

[data-theme="dark"] {
    /* Dark theme variables */
    --bg-color: #212529;
    --text-color: #f8f9fa;
    --card-bg: #2c3034;
    --border-color: #495057;
    --primary-color: #e69932;
    --navbar-bg: #bf7a1f;
    --dropdown-bg: #343a40;
    --input-bg: #343a40;
    --input-text: #f8f9fa;
}

/* Base Styles */
body {
    padding-top: 56px;
    background-color: var(--bg-color);
    color: var(--text-color);
    font-family: 'rasa', sans-serif;
}

.title{
    font-family: 'Shrikhand', sans-serif;
    font-size: 1.8rem;
}

/* Navbar Styles */
.navbar {
    background-color: var(--navbar-bg);
    position: fixed;
    width: 100%;
    height: 56px;
    top: 0;
    left: 0;
    z-index: 999;
}

.navbar-brand,
.navbar-nav .nav-link,
.navbar .dropdown-toggle,
#themeToggle,
.navbar .nav-link.active {
    color: #ffffff !important;
    height: 100%;
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0 15px;
    font-size: 19px;
}

/* Card and Form Styles */
.card {
    background-color: var(--card-bg);
    border-color: var(--border-color);
}

.form-control, .input-group-text {
    background-color: var(--input-bg) !important;
    color: var(--input-text) !important;
    border-color: var(--border-color);
}

/* Dropdown Styles */
.navbar .dropdown-menu {
    background-color: var(--navbar-bg);
    border: none;
}

.navbar .dropdown-item {
    color: #ffffff !important;
}

.navbar .dropdown-item:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Font Size Controls */
.font-size-popup {
    position: absolute;
    transform: translateY(-25px) translateX(-25px);
    top: 150%;
    background-color: var(--navbar-bg);
    padding: 8px;
    border-radius: 8px;
    z-index: 1000;
    display: flex;
    flex-direction: row;
    gap: 8px;
}

.btn-font {
    background: none;
    border: none;
    color: white;
    padding: 5px 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-font:hover {
    opacity: 0.8;
}

/* Theme Toggle Button */
#themeToggle {
    background: none;
    border: none;
    cursor: pointer;
}

#themeToggle i {
    color: white;
    font-size: 1.3rem;
}

/* Material Icons */
.material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}

/* Language Toggle Button */
.language-toggle-container {
        display: flex;
        align-items: center;
        margin: 10px;
    }
    
    .language-toggle {
        display: flex;
        background-color: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .language-btn {
        padding: 4px 8px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: background-color 0.3s;
    }
    
    .language-btn.active {
        background-color: #d7861b;
        color: white;
    }
    
    .language-btn:hover:not(.active) {
        background-color: rgba(215, 134, 27, 0.2);
    }

/* Desktop dropdown hover styles */
@media (min-width: 992px) {
    .dropdown-submenu {
        position: relative !important;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
    }

    .dropdown-submenu > .dropdown-menu {
        position: absolute;
        top: 0;
        left: 100%;
        margin-top: 0;
        margin-left: 0;
        border-radius: 5px;
    }

    /* Show main dropdown on category hover */
    .nav-item.dropdown:hover > .dropdown-menu {
        display: block !important;
    }

    /* Show submenu on parent hover */
    .dropdown-submenu:hover > .dropdown-menu {
        display: block !important;
    }

    /* Main items styling */
    .dropdown-menu .dropdown-item {
        text-align: left;
        padding: 8px 20px;
        white-space: nowrap;
        position: relative;
        font-size: 17px;
    }

    /* Right arrow for items with submenu */
    .dropdown-submenu > .dropdown-item::after {
        /* content: "›"; */
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%) rotate(270deg) ;
    }

    /* Remove any transforms or transitions that might interfere */
    .dropdown-submenu .dropdown-menu,
    .dropdown-menu {
        transform: none !important;
        transition: none !important;
    }
}

/* Mobile Styles */
@media (max-width: 991px) {
    .dropdown-menu {
        display: none;
        transition: max-height 0.3s ease-out;
        overflow: hidden;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-submenu .dropdown-menu {
        margin-left: 1rem;
        border-left: 2px solid var(--border-color);
    }

    .nav-link.dropdown-toggle::after,
    .dropdown-submenu > .dropdown-item::after {
        transition: transform 0.3s ease;
    }

    .nav-link.dropdown-toggle[aria-expanded="true"]::after,
    .dropdown-submenu > .dropdown-item.show::after {
        transform: rotate(90deg);
    }
}

@media (max-width: 768px) {
    .font-size-popup{
        transform: translateY(-5px) translateX(-25px);
    }
    .container {
        padding-left: 0;
        padding-right: 0;
    }

    /* Navbar brand adjustments */
    .navbar-brand {
        font-size: 1.4rem;
        max-width: 40%;
        padding-left: 20px;
        margin-right: 0;
    }

    /* Top controls container */
    .d-flex.align-items-center.d-lg-none {
        display: flex !important;
        align-items: center !important;
        gap: 8px;
        margin-right: 15px;
        flex: 0 0 auto;
        max-width: 60%;
    }

    /* Individual control buttons */
    #themeToggle,
    #languageDropdownMobile,
    #fontSizeToggleMobile,
    .navbar-toggler {
        padding: 4px !important;
        margin: 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Icons within controls */
    .material-symbols-outlined,
    .translate-icon img,
    .fa-moon,
    .fa-sun {
        font-size: 22px;
    }

    .translate-icon {
        padding:0px !important;
    }

    /* Navbar collapse */
    .navbar-collapse {
        position: fixed;
        top: 56px;
        left: -100%;
        bottom: 0;
        width: 70%;
        height: calc(100vh - 56px);
        transform: translateY(-5px);
        background-color: var(--navbar-bg);
        transition: left 0.3s ease;
        z-index: 998;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    .navbar-collapse.show {
        left: 0;
        padding-left: 15px;
    }

    /* Navigation links */
    .nav-link.dropdown-toggle {
        width: 100%;
        padding: 12px 15px !important;
        font-size: var(--mobile-font-size);
        position: relative;
    }

    /* Category arrow */
    .nav-link.dropdown-toggle::after {
        position: absolute;
        right: 15px;
        content: "›";
        border: none;
        font-size: 1.3em;
        line-height: 1;
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }

    .nav-link.dropdown-toggle[aria-expanded="true"]::after {
        transform: rotate(90deg);
    }

    /* Category dropdown arrows */
    .dropdown-submenu > .dropdown-item {
        position: relative;
    }

    .dropdown-submenu > .dropdown-item::after {
        position: absolute;
        right: 15px;
        content: "›";
        border: none;
        font-size: 1.3em;
        line-height: 1;
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }

    /* Arrow rotation when menu is open */
    .dropdown-submenu > .dropdown-item.show::after {
        transform: rotate(90deg);
    }

    /* Submenu styles */
    .dropdown-submenu > .dropdown-item {
        width: 100%;
        padding: 12px 15px !important;
        font-size: 19px !important;
        position: relative;
        margin: 5px 0;
    }

    .dropdown-submenu .dropdown-menu .dropdown-item {
        font-size: 19px !important;
        padding: 8px 15px 8px 25px !important;
        opacity: 0.9;
    }

    /* Language dropdown */
    .nav-item.dropdown .dropdown-menu {
        min-width: auto;
        width: auto;
        right: 0;
        left: auto;
    }

    /* Submenu container */
    .dropdown-submenu .dropdown-menu {
        margin-left: 0;
        padding-left: 15px;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
        margin: 5px 0;
    }

    /* Backdrop */
    .navbar-backdrop {
        position: fixed;
        top: 56px;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 997;
        display: none;
    }

    .navbar-backdrop.show {
        display: block;
    }

    /* Navbar toggler */
    .navbar-toggler {
        padding: 3px !important;
        font-size: 22px;
        line-height: 1;
        background-color: transparent;
        border: 0 !important;
    }

    .navbar-toggler:focus,
    .navbar-toggler:active {
        outline: none !important;
        box-shadow: none !important;
    }

    /* Remove dropdown arrows */
    #languageDropdownMobile.dropdown-toggle::after,
    #languageDropdown.dropdown-toggle::after,
    .nav-link.dropdown-toggle[id^="language"]::after {
        display: none !important;
    }

    /* Navigation items */
    .navbar-nav {
        width: 100%;
        padding: 0;
    }

    .navbar-nav .nav-item {
        width: 100%;
    }

    .nav-item .nav-link {
        width: 100%;
        padding: 12px 15px !important;
    }

    /* Dropdown menus */
    .dropdown-menu {
        width: 100%;
        padding: 0 !important;
        background-color: transparent;
        border: none;
    }

    /* Contact link */
    .navbar-nav .nav-item .nav-link {
        width: 100%;
        padding: 12px 15px !important;
        font-size: 19px;
    }

    /* Collapse items */
    .navbar-collapse .nav-link,
    .navbar-collapse .dropdown-item {
        width: 100%;
        display: block;
        padding: 12px 15px !important;
        font-size:19px;
    }
}

/* Dark Mode Specific Styles */
[data-theme="dark"] .select2-container--default .select2-selection--single,
[data-theme="dark"] .select2-dropdown,
[data-theme="dark"] .select2-search__field {
    background-color: var(--input-bg);
    color: var(--input-text);
    border-color: var(--border-color);
}

[data-theme="dark"] .select2-results__option--highlighted[aria-selected] {
    background-color: var(--primary-color);
    color: #ffffff;
}

/* DataTables Dark Mode */
[data-theme="dark"] .dataTables_wrapper {
    color: var(--text-color);
}

[data-theme="dark"] table.dataTable tbody tr {
    background-color: var(--card-bg);
    color: var(--text-color);
}

[data-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button {
    background-color: var(--table-bg) !important;
    color: var(--text-color) !important;
    border-color: var(--border-color) !important;
}

/* Modal Dark Mode */
[data-theme="dark"] .modal-content {
    background-color: var(--card-bg);
    color: var(--text-color);
}

[data-theme="dark"] .modal-header,
[data-theme="dark"] .modal-footer {
    border-color: var(--border-color);
}
</style>

    @yield('style')
</head>

<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand title" href="{{ route('user.kirtans.index') }}">
            {{ __('Kirtanavali') }}
        </a>
        <!-- In top mobile controls -->
        <div class="d-flex align-items-center d-lg-none">
            <button id="themeToggle" class="nav-link me-2">
                <i class="fa-solid fa-moon dark-icon"></i>
                <i class="fa-solid fa-sun light-icon d-none"></i>
            </button>
    <!-- Language toggle for mobile -->
    <div class="language-toggle-container me-2">
        <div class="language-toggle">
            <a href="{{ route('locale', 'en') }}" class="language-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
            <a href="{{ route('locale', 'gu') }}" class="language-btn {{ app()->getLocale() == 'gu' ? 'active' : '' }}">ગુજ</a>
        </div>
    </div>
    @if(request()->is('kirtans/*'))
    <div class="position-relative me-2">
        <button id="fontSizeToggleMobile" class="nav-link">
        <span class="translate-icon"><img src="{{ asset('font_size.svg') }}" alt="format size"></span>
        </button>
        <div id="fontSizeControlsMobile" class="font-size-popup d-none">
            <button class="btn-font" id="increaseFontSizeMobile">
                <i class="fas fa-plus"></i>
            </button>
            <button class="btn-font" id="decreaseFontSizeMobile">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    @endif
    <!-- Replace the hamburger icon with vertical 3 dots -->
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-ellipsis-v"></i>
</button>
</div>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @php
    $categories = DB::table('categories')->get();
@endphp

<!-- <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle{{ request()->is('categories*') ? ' active' : '' }}"
        href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{ __('Category') }}
    </a>
    <div class="dropdown-menu" aria-labelledby="categoryDropdown">
        @foreach ($categories as $category)
            @php
                $subcategories = DB::table('cate_sub_cate_rels')
                    ->join('sub_categories', 'sub_categories.sub_category_code', '=', 'cate_sub_cate_rels.sub_category_code')
                    ->where('cate_sub_cate_rels.category_code', $category->category_code)
                    ->select('sub_categories.*')
                    ->get();
            @endphp

            @if ($subcategories->count() == 1)
                {{-- Show the subcategory directly if there's only one --}}
                <a class="dropdown-item"
                    href="{{ route('user.categories.show', $subcategories[0]->sub_category_code) }}">
                    {{ $subcategories[0]->{'sub_category_' . app()->getLocale()} }}
                </a>
            @elseif ($subcategories->count() > 1)
                {{-- Show category as dropdown if it has multiple subcategories --}}
                <div class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">
                        {{ $category->{'category_' . app()->getLocale()} }}
                    </a>
                    <div class="dropdown-menu">
                        @foreach ($subcategories as $subcategory)
                            <a class="dropdown-item"
                                href="{{ route('user.categories.show', $subcategory->sub_category_code) }}">
                                {{ $subcategory->{'sub_category_' . app()->getLocale()} }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</li> -->

            </ul>
            <!-- In navbar-nav (desktop controls) -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link{{ request()->is('contact*') ? ' active' : '' }}"
                        href="{{ route('user.contact.create') }}">{{ __('Contact') }}</a>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <div class="language-toggle-container">
                        <div class="language-toggle">
                            <a href="{{ route('locale', 'en') }}" class="language-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
                            <a href="{{ route('locale', 'gu') }}" class="language-btn {{ app()->getLocale() == 'gu' ? 'active' : '' }}">ગુજ</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <button id="themeToggle" class="nav-link">
                        <i class="fa-solid fa-moon dark-icon"></i>
                        <i class="fa-solid fa-sun light-icon d-none"></i>
                    </button>
                </li>
                @if(request()->is('kirtans/*'))
                <li class="nav-item d-none d-lg-block position-relative">
                    <button id="fontSizeToggleDesktop" class="nav-link">
                    <span class="translate-icon"><img src="{{ asset('font_size.svg') }}" alt="format size"></span>
                    </button>
                    <div id="fontSizeControlsDesktop" class="font-size-popup d-none">
                        <button class="btn-font" id="increaseFontSizeDesktop">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn-font" id="decreaseFontSizeDesktop">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="navbar-backdrop"></div>

    @yield('content')

    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Load Bootstrap and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <!-- Load Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Toastr Notifications
        $(document).ready(function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}", "Success", {
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}", "Error", {
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                @endforeach
            @endif
        });
    </script>
   <script>
$(document).ready(function() {
    function isMobile() {
        return window.innerWidth < 992;
    }

     // Remove data-bs-toggle and data-bs-target from the button
     $('.navbar-toggler').removeAttr('data-bs-toggle data-bs-target');
    
    // Simple toggle function
    $('.navbar-toggler').click(function() {
        // Toggle classes
        $('.navbar-collapse').toggleClass('show');
        $('.navbar-backdrop').toggleClass('show');
        
        // Toggle body scroll
        if ($('.navbar-collapse').hasClass('show')) {
            $('body').css('overflow', 'hidden');
        } else {
            $('body').css('overflow', '');
        }
    });

    // Close menu when clicking backdrop
    $('.navbar-backdrop').click(function() {
        $('.navbar-collapse').removeClass('show');
        $('.navbar-backdrop').removeClass('show');
        $('body').css('overflow', '');
    });

    // Close menu when clicking escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('.navbar-collapse').hasClass('show')) {
            closeMenu();
        }
    });

    // Handle mobile clicks for submenu
    if (isMobile()) {
        $('.dropdown-submenu > .dropdown-item').click(function(e) {
            e.preventDefault();
            e.stopPropagation();

            $(this).next('.dropdown-menu').slideToggle();
            $(this).toggleClass('show');

            // Close other open submenus
            $('.dropdown-submenu > .dropdown-item').not(this).next('.dropdown-menu').slideUp();
            $('.dropdown-submenu > .dropdown-item').not(this).removeClass('show');
        });
    }

    // Handle window resize
    $(window).resize(function() {
        if (!isMobile()) {
            $('.dropdown-menu').removeAttr('style');
            $('.has-submenu').removeClass('show');
            closeMenu();
        }
    });
});
</script>
    <script>
    // Check for saved theme preference
    document.addEventListener('DOMContentLoaded', function() {
    const themeToggles = document.querySelectorAll('#themeToggle, #themeToggleLg');
    
    // Check for saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateIcons(savedTheme);

    // Theme toggle handler
    themeToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcons(newTheme);
        });
    });

    function updateIcons(theme) {
        themeToggles.forEach(toggle => {
            const darkIcon = toggle.querySelector('.dark-icon');
            const lightIcon = toggle.querySelector('.light-icon');
            
            if (theme === 'dark') {
                darkIcon.classList.add('d-none');
                lightIcon.classList.remove('d-none');
            } else {
                darkIcon.classList.remove('d-none');
                lightIcon.classList.add('d-none');
            }
        });
    }
});
</script>


    @yield('script')
</body>

</html>
