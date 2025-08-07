<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">

    <!-- Bootstrap 5 -->
    <link href="{{ asset('css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendor/toastr.min.css') }}">
    <link href="{{ asset('css/vendor/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/datatables-buttons.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Theme Variables */
        :root {
            --admin-bg-primary: #f8fafc;
            --admin-bg-secondary: #ffffff;
            --admin-bg-tertiary: #f1f5f9;
            --admin-text-primary: #1e293b;
            --admin-text-secondary: #64748b;
            --admin-text-muted: #94a3b8;
            --admin-border-color: #e2e8f0;
            --admin-primary: #d7861b;
            --admin-primary-dark: #b8721a;
            --admin-primary-light: #f4a83a;
            --admin-primary-bg: rgba(215, 134, 27, 0.1);
            --admin-success: #10b981;
            --admin-warning: #f59e0b;
            --admin-error: #ef4444;
            --admin-shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --admin-shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --admin-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        [data-theme="dark"] {
            --admin-bg-primary: #0f172a;
            --admin-bg-secondary: #1e293b;
            --admin-bg-tertiary: #334155;
            --admin-text-primary: #f8fafc;
            --admin-text-secondary: #cbd5e1;
            --admin-text-muted: #94a3b8;
            --admin-border-color: #374151;
            --admin-primary-bg: rgba(215, 134, 27, 0.2);
            --admin-shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.3);
            --admin-shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.3), 0 2px 4px -2px rgb(0 0 0 / 0.3);
            --admin-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.3), 0 4px 6px -4px rgb(0 0 0 / 0.3);
        }

        /* FIXED: Complete Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            outline: none !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            background-color: var(--admin-bg-primary);
            color: var(--admin-text-primary);
            transition: all 0.3s ease;
        }

        /* FIXED: Page Container */
        .admin-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--admin-bg-primary);
        }

        /* FIXED: Content Area */
        .admin-content {
            flex: 1;
            padding: 20px;
            margin-top: 60px; /* Exact header height */
            background-color: var(--admin-bg-primary);
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }

        /* Form Controls */
        .form-control, .form-select {
            background-color: var(--admin-bg-secondary) !important;
            border: 2px solid var(--admin-border-color) !important;
            color: var(--admin-text-primary) !important;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
            min-height: 48px;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--admin-bg-secondary) !important;
            border-color: var(--admin-primary) !important;
            color: var(--admin-text-primary) !important;
            box-shadow: 0 0 0 3px rgba(215, 134, 27, 0.1) !important;
        }

        textarea.form-control {
            min-height: 120px !important;
            resize: vertical;
            line-height: 1.6;
        }

        textarea[name*="lyrics"], textarea[name*="content"] {
            min-height: 300px !important;
        }

        .form-label {
            color: var(--admin-text-primary) !important;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-text {
            color: var(--admin-text-muted) !important;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 20px;
            font-size: 14px;
            transition: all 0.3s ease;
            border-width: 2px;
        }

        .btn-primary {
            background-color: var(--admin-primary);
            border-color: var(--admin-primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--admin-primary-dark);
            border-color: var(--admin-primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--admin-shadow-md);
        }

        .btn-secondary {
            background-color: var(--admin-bg-tertiary);
            border-color: var(--admin-border-color);
            color: var(--admin-text-primary);
        }

        .btn-secondary:hover {
            background-color: var(--admin-border-color);
            color: var(--admin-text-primary);
        }

        /* Cards */
        .card {
            background-color: var(--admin-bg-secondary) !important;
            border: 1px solid var(--admin-border-color) !important;
            border-radius: 12px;
            box-shadow: var(--admin-shadow-sm);
            transition: all 0.3s ease;
        }

        .card-header {
            background-color: var(--admin-bg-tertiary) !important;
            border-bottom: 1px solid var(--admin-border-color) !important;
            color: var(--admin-text-primary) !important;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }

        .card-body {
            color: var(--admin-text-primary) !important;
            padding: 1.5rem;
        }

        /* Tables */
        .table {
            background-color: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
        }

        .table th {
            background-color: var(--admin-bg-tertiary) !important;
            color: var(--admin-text-primary) !important;
            border-color: var(--admin-border-color) !important;
            font-weight: 600;
            padding: 16px;
        }

        .table td {
            border-color: var(--admin-border-color) !important;
            color: var(--admin-text-primary) !important;
            padding: 16px;
        }

        /* Select2 Integration */
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            background-color: var(--admin-bg-secondary) !important;
            border: 2px solid var(--admin-border-color) !important;
            color: var(--admin-text-primary) !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--admin-primary) !important;
            box-shadow: 0 0 0 3px rgba(215, 134, 27, 0.1) !important;
        }

        [data-theme="dark"] .select2-dropdown {
            background-color: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
        }

        [data-theme="dark"] .select2-results__option {
            background-color: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
        }

        [data-theme="dark"] .select2-results__option--highlighted {
            background-color: var(--admin-primary) !important;
            color: white !important;
        }

        /* Theme Toggle Button */
        .theme-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--admin-primary);
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            box-shadow: var(--admin-shadow-lg);
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background-color: var(--admin-primary-dark);
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-content {
                padding: 10px 15px;
                margin-top: 60px;
            }

            textarea[name*="lyrics"], textarea[name*="content"] {
                min-height: 250px !important;
            }
        }
    </style>

    @yield('style')
</head>

<body>
    <div class="admin-page">
        @include('admin.layouts.header')

        <div class="admin-content">
            @yield('content')
        </div>
    </div>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- Scripts -->
    <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/vendor/select2.min.js') }}"></script>
    <script src="{{ asset('js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('js/vendor/datatables-buttons.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jszip.min.js') }}"></script>
    <script src="{{ asset('js/vendor/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/vendor/toastr.min.js') }}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const html = document.documentElement;

            // Load saved theme
            const savedTheme = localStorage.getItem('admin-theme') || 'light';
            html.setAttribute('data-theme', savedTheme);
            updateThemeIcon(savedTheme);

            themeToggle.addEventListener('click', function() {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('admin-theme', newTheme);
                updateThemeIcon(newTheme);
                
                window.dispatchEvent(new CustomEvent('themeChanged', { detail: newTheme }));
            });

            function updateThemeIcon(theme) {
                if (theme === 'dark') {
                    themeIcon.className = 'fas fa-sun';
                } else {
                    themeIcon.className = 'fas fa-moon';
                }
            }
        });

        // Toastr configuration
        $(document).ready(function() {
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                showDuration: '300',
                hideDuration: '1000',
                timeOut: '5000',
                extendedTimeOut: '1000',
                showEasing: 'swing',
                hideEasing: 'linear',
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut'
            };

            @if (session('success'))
                toastr.success("{{ session('success') }}", "Success");
            @endif
            
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}", "Error");
                @endforeach
            @endif
        });

        // Auto-resize textareas
        function autoResizeTextarea(element) {
            if (element) {
                element.style.height = 'auto';
                element.style.height = (element.scrollHeight) + 'px';
            }
        }

        $(document).ready(function() {
            $('textarea').each(function() {
                autoResizeTextarea(this);
                $(this).on('input', function() {
                    autoResizeTextarea(this);
                });
            });
        });
    </script>

    @yield('script')
</body>
</html>
