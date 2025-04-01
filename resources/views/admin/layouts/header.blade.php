@php
    $config = App\Models\Configuration::where('key', 'show_export')->first();
    $exportShow = $config->value;
    $contactShow = App\Models\Configuration::where('key', 'show_contact')->first()->value;
    $currentUser = Auth::user();
@endphp
<header class="bg-white shadow-sm mb-4">
    <div class="container-fluid px-4">
        <nav class="navbar navbar-expand-lg navbar-light py-2">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('admin.songs.index') }}">
                {{ __('Kirtanavali') }}
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/songs*') ? ' active fw-semibold' : '' }}"
                            href="{{ route('admin.songs.index') }}">{{ __('Songs') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/categories*') ? ' active fw-semibold' : '' }}"
                            href="{{ route('admin.categories.index') }}">{{ __('Category') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/subCategories*') ? ' active fw-semibold' : '' }}"
                            href="{{ route('admin.subCategories.index') }}">{{ __('Sub Category') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/playlists*') ? ' active fw-semibold' : '' }}"
                            href="{{ route('admin.playlists.index') }}">{{ __('Playlist') }}</a>
                    </li>
                    @if ($contactShow == '1')
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('admin/contacts*') ? ' active fw-semibold' : '' }}"
                            href="{{ route('admin.contacts.index') }}">{{ __('Contacts') }}</a>
                    </li>
                    @endif
                    @if ($exportShow == '1')
                        <li class="nav-item">
                            <a class="nav-link{{ request()->is('admin/exports*') ? ' active fw-semibold' : '' }}"
                                href="{{ route('admin.exports.index') }}">{{ __('Export') }}</a>
                        </li>
                    @endif
                </ul>
                
                <div class="d-flex align-items-center">
                    <!-- Language Dropdown -->
                    <div class="dropdown me-3">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="languageDropdown" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            {{ app()->getLocale() === 'gu' ? __('Gujarati') : __('English') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="{{ route('locale', 'en') }}">{{ __('English') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('locale', 'gu') }}">{{ __('Gujarati') }}</a></li>
                        </ul>
                    </div>
                    
                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" 
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                 style="width: 32px; height: 32px; font-size: 14px;">
                                {{ strtoupper(substr($currentUser->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ $currentUser->name ?? 'Admin' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <div class="dropdown-item-text">
                                    <div class="fw-bold">{{ $currentUser->name ?? 'Admin' }}</div>
                                    <div class="small text-muted">{{ $currentUser->email ?? 'admin@ssgd.com' }}</div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.logout') }}">
                                <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>