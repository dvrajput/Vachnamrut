@php
    $config = App\Models\Configuration::where('key', 'show_export')->first();
    $exportShow = $config->value;
@endphp
<header class="bg-light p-3 mb-3">
    <div class="row justify-content-between d-flex align-items-center">
        <div class="col-auto">
            <a class="navbar-brand" href="{{ route('admin.songs.index') }}">
                {{ __('Kirtanavali') }}
            </a>
        </div>
        <div class="col-auto">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/songs*') ? ' active' : '' }}"
                                    href="{{ route('admin.songs.index') }}">{{ __('Songs') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/categories*') ? ' active' : '' }}"
                                    href="{{ route('admin.categories.index') }}">{{ __('Category') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/subCategories*') ? ' active' : '' }}"
                                    href="{{ route('admin.subCategories.index') }}">{{ __('Sub Category') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/playlists*') ? ' active' : '' }}"
                                    href="{{ route('admin.playlists.index') }}">{{ __('Playlist') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/contacts*') ? ' active' : '' }}"
                                    href="{{ route('admin.contacts.index') }}">{{ __('Contacts') }}</a>
                            </li>
                            @if ($exportShow == '1')
                                <li class="nav-item">
                                    <a class="nav-link{{ request()->is('admin/exports*') ? ' active' : '' }}"
                                        href="{{ route('admin.exports.index') }}">{{ __('Export') }}</a>
                                </li>
                            @endif
                            {{-- <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/about*') ? ' active' : '' }}"
                                    href="{{ route('songs.index') }}">{{ __('About Us') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/contact*') ? ' active' : '' }}"
                                    href="{{ route('songs.index') }}">{{ __('Contact Us') }}</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.logout') }}"><i
                                        class="fas fa-sign-out-alt"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ app()->getLocale() === 'gu' ? __('Gujarati') : __('English') }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="languageDropdown">
                                    <a class="dropdown-item"
                                        href="{{ route('locale', 'en') }}">{{ __('English') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('locale', 'gu') }}">{{ __('Gujarati') }}</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
