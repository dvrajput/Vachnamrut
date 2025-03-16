@extends('user.layouts.app')
@section('title', __('Contact'))

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('user.contact.store') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <i class="fa-regular fa-user input-group-text uf-ct-03-input-group-text lh-lg"></i>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="{{ __('Name') }}" autofocus required>
                            </div>

                            <div class="input-group mb-3">
                                <i class="fa-regular fa-envelope input-group-text uf-ct-03-input-group-text lh-lg"></i>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="{{ __('Email') }}" required>
                            </div>

                            <div class="mb-3 kirtan-select">
                                <input type="text" class="form-control"
                                    value="{{ app()->getLocale() == 'gu' ? $song->title_gu : $song->title_en }}" readonly required>
                            </div>
                            <input type="hidden" class="form-control" value="{{ $song->song_code }}" id="song_code"
                                name="song_code" readonly required>
                            <div class="mb-3">
                                <textarea class="form-control" id="message" name="message" rows="3" placeholder="{{ __('Message/Suggestion') }}"
                                    required oninput="autoResize(this)"></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-lg uf-ct-03-btn-primary text-uppercase w-100">
                                    {{ __('Send') }} <i class="fa-regular fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        
        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }

        .card {
            border-radius: 10px;
            border: none;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(215, 134, 27, 0.25);
            border-color: #d7861b;
        }

        .uf-contact-form-03 {
            background-color: #f8f9fa;
        }

        .uf-cf-03-main {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 0.2rem rgba(215, 134, 27, 0.25);
            border-radius: 0.375rem;
        }

        .input-group:focus-within .form-control {
            border-color: var(--primary-color) !important;
            box-shadow: none;
        }

        .input-group:focus-within .uf-ct-03-input-group-text {
            border-color: var(--primary-color) !important;
            color: var(--primary-color);
        }

        /* Remove individual input focus styles when in group */
        .input-group .form-control:focus {
            box-shadow: none;
        }

        /* Keep existing input group styles */
        .uf-ct-03-input-group-text {
            background-color: transparent;
            border-right: none;
            color: var(--primary-color);
            border-color: var(--border-color);
            transition: all 0.2s ease;
        }

        .form-control {
            border-left: none;
            padding: 0.75rem 1rem;
            color: var(--text-color) !important;
            background-color: var(--card-bg) !important;
            border-color: var(--border-color) !important;
        }

        .form-control::placeholder {
            color: var(--text-color);
            opacity: 0.6;
        }

        /* Fix for readonly input in contact form */
        .kirtan-select .form-control {
            border-left: 1px solid var(--border-color) !important;
            border-radius: 0.375rem;
        }

        .kirtan-select .form-control:focus {
            border-color: var(--border-color) !important;
            box-shadow: none;
        }

        /* Input Group Text */
        .uf-ct-03-input-group-text {
            background-color: transparent;
            border-right: none;
            color: var(--primary-color);
            border-color: var(--border-color) !important;
        }

        /* Select2 Theme Support */
        .select2-container .select2-selection--single {
            height: 42px !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.375rem !important;
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
            padding-left: 12px;
            color: var(--text-color) !important;
        }

        .select2-dropdown {
            background-color: var(--card-bg) !important;
            border-color: var(--border-color) !important;
        }

        .select2-search__field {
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
            border-color: var(--border-color) !important;
        }

        .select2-results__option {
            color: var(--text-color) !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
        }

        /* Textarea specific styles */
        textarea.form-control {
            border: 1px solid var(--border-color) !important;
            color: var(--text-color) !important;
            background-color: var(--card-bg) !important;
        }

        /* Focus States */
        .form-control:focus,
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(215, 134, 27, 0.25);
        }

        /* Button Styles */
        .uf-ct-03-btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            transition: all 0.3s ease;
        }

        .uf-ct-03-btn-primary:hover {
            background-color: #c27616;
            transform: translateY(-2px);
        }

        /* Dark theme specific overrides */
        [data-theme="dark"] .select2-container--default .select2-selection--single {
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
        }

        [data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-color) !important;
        }

        [data-theme="dark"] .select2-results__option {
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
        }

        [data-theme="dark"] .select2-search__field {
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
        }

        [data-theme="dark"] .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
        }

        @media (max-width: 768px) {
            .navbar .container{
            transform: translateY(-5px);
            }
            .d-flex.align-items-center.d-lg-none {
                transform: translateX(-10px);
            }            
        }
    </style>
@endsection


@section('script')
    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    </script>
@endsection
