@extends('user.layouts.app')
@section('title', __('Contact Us'))

@section('style')
    <style>
        /* Global CSS Variables for Theming */
        :root {
            --primary-color: #d7861b;
            --primary-hover: #c27616;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #212529;
            --border-color: #dee2e6;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --focus-shadow: rgba(215, 134, 27, 0.25);
        }

        /* Dark theme variables */
        [data-theme="dark"] {
            --bg-color: #212529;
            --card-bg: #2c3034;
            --text-color: #f8f9fa;
            --border-color: #495057;
            --shadow-color: rgba(0, 0, 0, 0.3);
        }

        /* Contact Form Container */
        .contact-container {
            background-color: var(--bg-color);
            min-height: calc(100vh - 80px);
            padding: 2rem 0;
        }

        .contact-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px var(--shadow-color);
            background-color: var(--card-bg);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px var(--shadow-color);
        }

        .contact-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .contact-header h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .contact-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .contact-body {
            padding: 2.5rem;
        }

        /* Enhanced Input Groups */
        .input-group {
            margin-bottom: 1.5rem;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 3px var(--focus-shadow);
            border-radius: 8px;
        }

        .uf-ct-03-input-group-text {
            background-color: var(--card-bg);
            border-right: none;
            color: var(--primary-color);
            border-color: var(--border-color);
            transition: all 0.3s ease;
            font-size: 1.1rem;
            width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-group:focus-within .uf-ct-03-input-group-text {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background-color: rgba(215, 134, 27, 0.1);
        }

        .form-control {
            border-left: none;
            padding: 0.875rem 1rem;
            color: var(--text-color);
            background-color: var(--card-bg);
            border-color: var(--border-color);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: none;
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        .form-control::placeholder {
            color: var(--text-color);
            opacity: 0.6;
        }

        /* Enhanced Select2 Styling */
        .kirtan-select {
            margin-bottom: 1.5rem;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 48px !important;
            border: 2px solid var(--border-color) !important;
            border-radius: 8px !important;
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
            transition: all 0.3s ease;
        }

        .select2-container--default .select2-selection--single:focus,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px var(--focus-shadow);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 44px !important;
            padding-left: 15px;
            color: var(--text-color) !important;
            font-size: 1rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px !important;
            right: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: var(--text-color) !important;
            opacity: 0.6;
        }

        /* Select2 Dropdown */
        .select2-dropdown {
            background-color: var(--card-bg) !important;
            border: 2px solid var(--border-color) !important;
            border-radius: 8px !important;
            box-shadow: 0 10px 30px var(--shadow-color);
        }

        .select2-search__field {
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 6px !important;
            padding: 8px 12px !important;
        }

        .select2-results__option {
            color: var(--text-color) !important;
            background-color: var(--card-bg) !important;
            padding: 12px 15px;
            transition: all 0.2s ease;
        }

        .select2-results__option:hover,
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
        }

        .select2-results__option[aria-selected="true"] {
            background-color: rgba(215, 134, 27, 0.1) !important;
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        /* Loading indicator for Select2 */
        .select2-results__option.loading-results {
            text-align: center;
            padding: 20px;
            color: var(--primary-color);
        }

        /* Enhanced Textarea */
        .textarea-container {
            position: relative;
            margin-bottom: 2rem;
        }

        textarea.form-control {
            border: 2px solid var(--border-color) !important;
            border-radius: 8px !important;
            color: var(--text-color) !important;
            background-color: var(--card-bg) !important;
            resize: vertical;
            min-height: 120px;
            padding: 1rem;
            font-size: 1rem;
            line-height: 1.5;
            transition: all 0.3s ease;
        }

        textarea.form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px var(--focus-shadow);
        }

        /* Enhanced Submit Button */
        .submit-container {
            margin-top: 2rem;
        }

        .uf-ct-03-btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(215, 134, 27, 0.3);
        }

        .uf-ct-03-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(215, 134, 27, 0.4);
            background: linear-gradient(135deg, var(--primary-hover), #b86914);
        }

        .uf-ct-03-btn-primary:active {
            transform: translateY(0);
        }

        .uf-ct-03-btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Loading state for submit button */
        .btn-loading {
            pointer-events: none;
        }

        .btn-loading .btn-text {
            opacity: 0;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Error and Success Messages */
        .alert-custom {
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* Character Counter */
        .char-counter {
            font-size: 0.85rem;
            color: var(--text-color);
            opacity: 0.7;
            text-align: right;
            margin-top: 5px;
        }

        /* Form Validation Styles */
        .form-control.is-invalid {
            border-color: #dc3545 !important;
        }

        .form-control.is-valid {
            border-color: #28a745 !important;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .valid-feedback {
            color: #28a745;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .contact-container {
                padding: 1rem 0;
            }

            .contact-header {
                padding: 1.5rem;
            }

            .contact-header h3 {
                font-size: 1.5rem;
            }

            .contact-body {
                padding: 1.5rem;
            }

            .input-group {
                margin-bottom: 1.25rem;
            }

            .navbar .container {
                transform: translateY(-5px);
            }

            .d-flex.align-items-center.d-lg-none {
                transform: translateX(-10px);
            }

            .uf-ct-03-btn-primary {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .contact-header {
                padding: 1rem;
            }

            .contact-body {
                padding: 1rem;
            }

            .contact-header h3 {
                font-size: 1.3rem;
                flex-direction: column;
                gap: 5px;
            }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast-custom {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 15px var(--shadow-color);
            min-width: 300px;
        }
    </style>
@endsection

@section('content')
    <div class="contact-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="contact-card">
                        <div class="contact-header">
                            <h3>
                                <i class="fa-regular fa-envelope"></i>
                                {{ __('Contact Us') }}
                            </h3>
                            <p>{{ __('We\'d love to hear from you. Send us a message!') }}</p>
                        </div>

                        <div class="contact-body">
                            <form id="contactForm" action="{{ route('user.contact.store') }}" method="POST">
                                @csrf

                                <!-- Name Field -->
                                <div class="input-group">
                                    <span class="input-group-text uf-ct-03-input-group-text">
                                        <i class="fa-regular fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="{{ __('Your Full Name') }}"
                                        value="{{ old('name') }}" autofocus required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="input-group">
                                    <span class="input-group-text uf-ct-03-input-group-text">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="{{ __('Your Email Address') }}"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Song Selection -->
                                <div class="kirtan-select">
                                    <select class="form-control select2 @error('song_code') is-invalid @enderror"
                                        id="song_code" name="song_code"
                                        data-placeholder="{{ __('Select Vachanamrut (optional)') }}">
                                        <option></option>
                                        @if (old('song_code'))
                                            <option value="{{ old('song_code') }}" selected>{{ old('song_code') }}
                                            </option>
                                        @endif
                                    </select>
                                    @error('song_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Message Field -->
                                <div class="textarea-container">
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="4"
                                        placeholder="{{ __('Your Message or Suggestion...') }}" required maxlength="1000"
                                        oninput="autoResize(this); updateCharCounter(this)">{{ old('message') }}</textarea>
                                    <div class="char-counter">
                                        <span id="charCount">0</span>/1000 {{ __('characters') }}
                                    </div>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="submit-container">
                                    <div class="d-grid">
                                        <button type="submit" class="btn uf-ct-03-btn-primary" id="submitBtn">
                                            <span class="btn-text">
                                                {{ __('Send Message') }}
                                                <i class="fa-regular fa-paper-plane ms-2"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Configuration
            const config = {
                searchUrl: '{{ route('user.contact.create') }}',
                submitUrl: '{{ route('user.contact.store') }}',
                csrfToken: '{{ csrf_token() }}',
                locale: '{{ app()->getLocale() }}'
            };

            // Enhanced error handling
            function handleAjaxError(xhr, status, error) {
                console.error('AJAX Error:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    error: error,
                    responseText: xhr.responseText
                });

                showNotification('{{ __('Error loading songs. Please try again.') }}', 'error');
            }

            // Show toast notification
            function showNotification(message, type = 'info', duration = 5000) {
                const toastId = 'toast-' + Date.now();
                const iconClass = type === 'error' ? 'fa-circle-exclamation' :
                    type === 'success' ? 'fa-circle-check' : 'fa-circle-info';
                const bgClass = type === 'error' ? 'alert-danger' :
                    type === 'success' ? 'alert-success' : 'alert-info';

                const toast = $(`
            <div id="${toastId}" class="toast-custom alert ${bgClass} alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas ${iconClass} me-2"></i>
                    <div class="flex-grow-1">${message}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        `);

                $('#toastContainer').append(toast);

                // Auto remove after duration
                setTimeout(() => {
                    $(`#${toastId}`).fadeOut(() => {
                        $(`#${toastId}`).remove();
                    });
                }, duration);
            }

            // Initialize enhanced Select2
            $('#song_code').select2({
                placeholder: '{{ __('Search and select Vachanamrut...') }}',
                allowClear: true,
                minimumInputLength: 2,
                ajax: {
                    url: config.searchUrl,
                    dataType: 'json',
                    delay: 300,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    data: function(params) {
                        return {
                            q: params.term,
                            _token: config.csrfToken
                        };
                    },
                    processResults: function(data, params) {
                        // Handle different response formats
                        let results = [];

                        if (data.success === false) {
                            console.error('Search error:', data.error);
                            showNotification(data.error || '{{ __('Error searching songs') }}',
                                'error');
                            return {
                                results: []
                            };
                        }

                        // Handle both old and new response formats
                        const songs = data.results || data;

                        if (Array.isArray(songs)) {
                            results = songs.map(function(song) {
                                const title = config.locale === 'gu' && song.title_gu ?
                                    song.title_gu :
                                    song.title_en || song.text;

                                return {
                                    id: song.id || song.song_code,
                                    text: title || song.song_code || 'Unknown'
                                };
                            });
                        }

                        return {
                            results: results,
                            pagination: {
                                more: (params.page * 20) < (data.total_count || results.length)
                            }
                        };
                    },
                    cache: true,
                    error: handleAjaxError
                },
                language: {
                    inputTooShort: function() {
                        return '{{ __('Please enter 2 or more characters') }}';
                    },
                    noResults: function() {
                        return '{{ __('No Vachanamruts found') }}';
                    },
                    searching: function() {
                        return '{{ __('Searching...') }}';
                    },
                    loadingMore: function() {
                        return '{{ __('Loading more results...') }}';
                    }
                },
                escapeMarkup: function(markup) {
                    return markup; // Allow HTML
                },
                templateResult: function(data) {
                    if (data.loading) {
                        return '<div class="loading-results"><i class="fas fa-spinner fa-spin"></i> {{ __('Loading...') }}</div>';
                    }
                    return data.text;
                }
            });

            // Auto-resize textarea function
            window.autoResize = function(textarea) {
                textarea.style.height = 'auto';
                textarea.style.height = Math.min(textarea.scrollHeight, 200) + 'px';
            };

            // Character counter function
            window.updateCharCounter = function(textarea) {
                const count = textarea.value.length;
                const counter = document.getElementById('charCount');
                if (counter) {
                    counter.textContent = count;
                    counter.style.color = count > 900 ? '#dc3545' : 'var(--text-color)';
                }
            };

            // Initialize character counter
            const messageTextarea = document.getElementById('message');
            if (messageTextarea) {
                updateCharCounter(messageTextarea);
            }

            // Enhanced form submission
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();

                const submitBtn = $('#submitBtn');
                const originalBtnContent = submitBtn.html();

                // Validate form
                if (!this.checkValidity()) {
                    this.reportValidity();
                    return;
                }

                // Show loading state
                submitBtn.addClass('btn-loading').prop('disabled', true);

                // Prepare form data
                const formData = new FormData(this);

                $.ajax({
                    url: config.submitUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    timeout: 30000,
                    success: function(response) {
                        if (response.success) {
                            showNotification(
                                response.message ||
                                '{{ __('Your message has been sent successfully!') }}',
                                'success'
                            );

                            // Reset form
                            $('#contactForm')[0].reset();
                            $('#song_code').val(null).trigger('change');
                            updateCharCounter(messageTextarea);
                            autoResize(messageTextarea);

                        } else {
                            showNotification(
                                response.message ||
                                '{{ __('Error sending message. Please try again.') }}',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Form submission error:', xhr.responseText);

                        let errorMessage =
                            '{{ __('Error sending message. Please try again.') }}';

                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON?.errors;
                            if (errors) {
                                const firstError = Object.values(errors)[0][0];
                                errorMessage = firstError;
                            }
                        } else if (xhr.status === 429) {
                            errorMessage =
                                '{{ __('Too many requests. Please wait a moment.') }}';
                        } else if (xhr.status >= 500) {
                            errorMessage = '{{ __('Server error. Please try again later.') }}';
                        }

                        showNotification(errorMessage, 'error');
                    },
                    complete: function() {
                        // Restore button state
                        submitBtn.removeClass('btn-loading')
                            .prop('disabled', false)
                            .html(originalBtnContent);
                    }
                });
            });

            // Form validation feedback
            $('input, textarea, select').on('blur change', function() {
                const element = $(this);
                element.removeClass('is-invalid is-valid');

                if (this.checkValidity()) {
                    element.addClass('is-valid');
                } else {
                    element.addClass('is-invalid');
                }
            });

            // Theme change handler for Select2
            window.addEventListener('themeChanged', function(e) {
                setTimeout(() => {
                    $('#song_code').select2('destroy').select2({
                        // Re-initialize with same options
                        placeholder: '{{ __('Search and select Vachanamrut...') }}',
                        allowClear: true,
                        minimumInputLength: 2,
                        // ... same options as above
                    });
                }, 100);
            });
        });

        // Disable right-click context menu (if needed)
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    </script>
@endsection
