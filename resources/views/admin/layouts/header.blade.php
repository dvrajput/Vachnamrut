<header class="bg-light p-3 mb-3">
    <div class="row justify-content-between d-flex align-items-center">
        <div class="col-auto">
            <a class="navbar-brand" href="{{ route('admin.songs.index') }}">
                Kirtanavali
            </a>
        </div>
        <div class="col-auto">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/songs*') ? ' active' : '' }}"
                                    href="{{ route('admin.songs.index') }}">Songs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/categories*') ? ' active' : '' }}"
                                    href="{{ route('admin.categories.index') }}">Category</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/subCategories*') ? ' active' : '' }}"
                                    href="{{ route('admin.subCategories.index') }}">Sub Category</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/playlists*') ? ' active' : '' }}"
                                    href="{{ route('admin.playlists.index') }}">Playlist</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/about*') ? ' active' : '' }}"
                                    href="{{ route('songs.index') }}">{{ __('About Us') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('admin/contact*') ? ' active' : '' }}"
                                    href="{{ route('songs.index') }}">{{ __('Contact Us') }}</a>
                            </li> --}}
                            
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
