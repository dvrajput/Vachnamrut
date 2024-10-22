<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>

    <!-- Latest Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #d7861b;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: white !important;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            display: none;
            z-index: 1000;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        .toast-container {
            z-index: 9999; /* Ensure toast notifications appear above other content */
        }
    </style>
    
    @yield('style')
</head>

<body>
    {{-- @include('user.layouts.header') --}}

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.songs.index') }}">
                {{ __('Kirtanavali') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('songs*') ? ' active' : '' }}"
                            href="{{ route('user.songs.index') }}">{{ __('Songs') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle{{ request()->is('categories*') ? ' active' : '' }}" href="#"
                            id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            {{ __('Category') }}
                        </a>
                        @php
                            $categories = DB::table('categories')->get();
                        @endphp
                        <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                            @foreach ($categories as $category)
                                <div class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">
                                        {{ $category->{'category_' . app()->getLocale()} }}
                                    </a>
                                    @php
                                        $subcategories = DB::table('cate_sub_cate_rels')
                                            ->join('sub_categories', 'sub_categories.sub_category_code', '=', 'cate_sub_cate_rels.sub_category_code')
                                            ->where('cate_sub_cate_rels.category_code', $category->category_code)
                                            ->select('sub_categories.*')
                                            ->get();
                                    @endphp
                                    @if ($subcategories->count() > 0)
                                        <div class="dropdown-menu">
                                            @foreach ($subcategories as $subcategory)
                                                <a class="dropdown-item"
                                                    href="{{ route('user.categories.show', $subcategory->sub_category_code) }}">
                                                    {{ $subcategory->{'sub_category_' . app()->getLocale()} }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ app()->getLocale() === 'gu' ? __('Gujarati') : __('English') }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="languageDropdown">
                            <a class="dropdown-item" href="{{ route('locale', 'en') }}">{{ __('English') }}</a>
                            <a class="dropdown-item" href="{{ route('locale', 'gu') }}">{{ __('Gujarati') }}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Load JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
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

    @yield('script')
</body>

</html>
